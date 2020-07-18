<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\StorePost;
use App\Tag;
use App\User;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * @return bool
     */
    private function checkPermission($action)
    {
        abort_unless(Auth::check(), 404);
        abort_unless(Auth::user()->hasPermissionTo($action), 404);
        return true;
    }

    /**
     * Post creation
     * POST Method
     *
     * @param StorePost $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(StorePost $request)
    {
        $post = Post::create([
            'post_title' => $request->PostTitle,
            'post_description' => $request->PostDescription,
            'image' => $request->hasFile('image') ?
                Storage::putFile('images', new File($request->file('image')
                    ->getPathname()))
                : "",
            'user_id' => Auth::id()
        ]);

        foreach (explode(',', $request->tags) as $tag) {
            if (!empty($tag)) {
                $tags = Tag::firstOrCreate(['name' => trim($tag)]);
                $post->tags()->attach($tags->id);
            }
        }
        //Browser Redirection to post Show page
        return redirect('post/' . $post->user->name . '/' . str_replace(' ', '-', $post->post_title) . '-' . $post->id);
    }

    /**
     *
     * Post deletion through AJAX request
     * POST Method
     *
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $this->checkPermission('delete-post');
        $post = Post::find($id);
        $post->delete();
        Storage::delete($post->image);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogPostCreate()
    {
        $this->checkPermission('create-post');
        return view('createPost');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogHome()
    {
        return view('blog.home', [
            'posts' => Post::all(),
        ]);
    }

    /**
     * @param $tag_name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogHomeTag($tag_name)
    {
        return view('blog.home', [
            'posts' => Tag::where('name', $tag_name)->firstOrFail()->posts
        ]);
    }

    /**
     * @param $username
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogHomeUser($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return view('blog.home', [
            'posts' => $user->posts,
        ]);
    }

    /**
     * @param $username
     * @param $post_url
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogPost($username, $post_url)
    {
        $url_array = explode('-', $post_url);
        $user = User::where('name', $username)->firstOrFail();
        $post = Post::findOrFail(end($url_array));
        abort_if($user->id != $post->user_id, 404);
        return view('blog.post', ['post' => $post]);
    }

    public function edit($id)
    {
        abort_unless(Auth::user()->hasPermissionTo('edit-post') or Auth::id() == $id, 404);
        return view('update_post', [
            'post' => Post::findOrFail($id)
        ]);
    }

    /**
     *
     * Post Update through AJAX request
     * POST Method
     *
     * @param $id
     * @param StorePost $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, StorePost $request)
    {
        $post = Post::find($id)->update([
            'post_title' => $request->PostTitle,
            'post_description' => $request->PostDescription,
            'image' => $request->hasFile('image') ?
                Storage::putFile('images', new File($request->file('image')
                    ->getPathname()))
                : $_POST['img'] ? $_POST['img'] : "" ,
        ]);
        if ($post) { $post = Post::find($id); }
        //Browser Redirection to post Show page
        return redirect('post/' . $post->user->name . '/' . str_replace(' ', '-', $post->post_title) . '-' . $post->id);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function index()
    {
        return Datatables::of(Post::query())->make(true);
    }

}
