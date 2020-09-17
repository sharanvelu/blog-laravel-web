<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\StorePost;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    /**
     * @param $post
     * @param $action
     * @return bool
     */
    private function checkPermission($action, $post = null)
    {
        abort_unless(Auth::check(), 404);
        $auth_user = Auth::user();
        if ($auth_user->hasAnyRole(['SuperAdmin', 'Admin']) or ($post->user_id == $auth_user->id)) {
            return true;
        }
        abort_unless($auth_user->hasPermissionTo($action), 404);
        return true;
    }

    /**
     * Post creation
     * POST Request
     *
     * @param StorePost $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(StorePost $request)
    {
        $this->checkPermission('create-post');
        $post = Post::create([
            'post_title' => $request->PostTitle,
            'post_description' => $request->PostDescription,
            'image' => $request->hasFile('image') ?
                Storage::putFile('images', new File($request->file('image')->getPathname()))
                : "",
            'user_id' => Auth::id()
        ]);

        foreach (explode(',', $request->tags) as $tag) {
            if (!empty($tag)) {
                $tags = Tag::firstOrCreate(['name' => trim($tag)]);
                $post->tags()->attach($tags->id);
            }
        }

        // Event trigger for sending mail
        event(new \App\Events\PostCreated($post));

        //Browser Redirection to post Show page
        return redirect('post/' . $post->user->name . '/' . str_replace(' ', '-', $post->post_title) . '-' . $post->id);
    }

    /**
     *
     * Post deletion through AJAX request
     * POST Request
     *
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $post = Post::find($id);
        $this->checkPermission('delete-post', $post);
        $post->delete();
        Storage::delete($post->image);

        // Event trigger for sending mail
        event(new \App\Events\PostDeleted($post));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogPostCreate()
    {
        $this->checkPermission('create-post');
        return view('post.create');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogHome()
    {
        $posts = Post::orderBy('created_at', 'DESC')
            ->with('user:id,name')
            ->paginate(5);
        return view('blog.home', [
            'posts' => $posts,
        ]);
    }

    /**
     * @param $tag_name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogHomeTag($tag_name)
    {
        $posts = Tag::where('name', $tag_name)
            ->with('posts', 'posts.user')
            ->get()->first()->posts;
        $posts = new Paginator($posts, 5);
        $posts->withPath('\post/tag/' . $tag_name);

        return view('blog.home', [
            'title' => 'Posts with Tag : ' . $tag_name,
            'posts' => $posts
        ]);
    }

    /**
     * @param $username
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogHomeUser($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        $posts = Post::where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->with('user:id,name')
            ->paginate(5);
        return view('blog.home', [
            'title' => 'Posts By User : ' . $username,
            'posts' => $posts,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function BlogHomeByMonth()
    {
        $date = strtotime($_POST['key']);
        $month = Carbon::create(date('Y', $date), date('m', $date), 01);

        $posts = Post::whereMonth('created_at', '=', $month)
            ->orderBy('created_at', 'DESC')
            ->with('user:id,name')
            ->paginate(5);
        return view('blog.home', [
            'title' => 'Posts By month : ' . date('F', $date),
            'posts' => $posts
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
        $post = Post::where('id', end($url_array))
            ->with('user:id,name', 'tags:name', 'comments')
            ->firstOrFail();
        abort_if($username != $post->user->name, 404);
        return view('blog.post', ['post' => $post]);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->checkPermission('edit-post', $post);
        $tags = implode(", ", $post->tags->map(function ($tag) {
            return $tag->name;
        })->toArray());
        return view('post.update', [
            'post' => $post,
            'tags' => $tags
        ]);
    }

    /**
     *
     * Post Update through AJAX request
     * POST Request
     *
     * @param $id
     * @param StorePost $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, StorePost $request)
    {
        $post = Post::findOrFail($id);
        $this->checkPermission('edit-post', $post);
        $post->update([
            'post_title' => $request->PostTitle,
            'post_description' => $request->PostDescription,
            'image' => $request->hasFile('image')
                ? Storage::putFile('images', new File($request->file('image')->getPathname()))
                : ($_POST['img'] ? $_POST['img'] : ""),
        ]);

        $post->tags()->detach($post->tags->map(function ($tag) { return $tag->id; })->toArray());
        foreach (explode(',', $request->tags) as $tag) {
            if (!empty($tag)) {
                $tags = Tag::firstOrCreate(['name' => trim($tag)]);
                $post->tags()->attach($tags->id);
            }
        }

        // Event trigger for sending mail
        event(new \App\Events\PostUpdated($post));

        //Browser Redirection to post Show page
        return redirect('post/' . $post->user->name . '/' .
            str_replace('?', '-', str_replace(' ', '-', $post->post_title)) . '-' . $post->id);
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
