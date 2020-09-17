<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Post as PostResource;
use App\Post;
use App\Tag;
use Illuminate\Http\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * @return PostResource|JsonResponse
     */
    public function index()
    {
        return new PostResource(Post::all());
    }

    /**
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function store(PostRequest $request)
    {
        $post = Post::create([
            'post_title' => $request->PostTitle,
            'post_description' => $request->PostDescription,
            'image' => $request->hasFile('image') ?
                Storage::putFile('images', new File($request->file('image')->getPathname()))
                : "",
            'user_id' => auth()->user()->id
        ]);

        foreach (explode(',', $request->tags) as $tag) {
            if (!empty($tag)) {
                $tags = Tag::firstOrCreate(['name' => trim($tag)]);
                $post->tags()->attach($tags);
            }
        }

        return response()->json([
            'message' => 'Your post has been created Successfully',
            'data' => $post->load('tags')
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse|PostResource
     */
    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'message' => 'The post you are requesting for is unavailable.',
                'data' => []
            ], 404);
        } else {
            return new PostResource($post);
        }
    }

    /**
     * @param PostRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'message' => 'The post you are requesting for is unavailable.',
                'data' => []
            ], 404);
        }
        $post->update([
            'post_title' => $request->PostTitle,
            'post_description' => $request->PostDescription,
            'image' => $request->hasFile('image')
                ? Storage::putFile('images', new File($request->file('image')->getPathname()))
                : "",
        ]);

        $post->tags()->detach($post->tags->map(function ($tag) { return $tag->id; })->toArray());
        foreach (explode(',', $request->tags) as $tag) {
            if (!empty($tag)) {
                $tags = Tag::firstOrCreate(['name' => trim($tag)]);
                $post->tags()->attach($tags->id);
            }
        }

        return response()->json([
            'message' => 'Post has been updated Successfully',
            'data' => $post->load('tags', 'comments')
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'message' => 'The post you are requesting for is unavailable.',
                'data' => []
            ], 404);
        }
        $post->delete();
        return response()->json(['message' => 'Post has been deleted Successfully']);
    }
}
