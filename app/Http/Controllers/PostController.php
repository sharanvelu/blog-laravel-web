<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\StorePost;
use App\Tag;
use App\User;
use Illuminate\Support\Facades\Auth;
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
            'image' => $request->hasFile('image') ? $request->file('image')->store('images') : "",
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
     * Post Update through AJAX request
     * POST Method
     *
     * @param $id
     * @param StorePost $request
     * @return void
     */
    public function update($id, StorePost $request)
    {
        $desc = $request->PostDescription;

        Post::where('id', $id)->update([
            'post_title' => $_POST['PostTitle'],
            'post_description' => $desc,
            'image' => $request->hasFile('image') ? $request->file('image')->store('images') : ""
        ]);
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
        Post::where('id', $id)->delete();
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
        if (User::where('name', $username)->firstOrFail()) {
            return view('blog.home', [
                'posts' => User::where('name', $username)->first()->posts,
            ]);
        } else abort(404);
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
        $post = Post::find($url_array[count($url_array) - 1]);
        if ($user->id != $post->user_id) abort(404);
        return view('blog.post', ['post' => $post]);
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