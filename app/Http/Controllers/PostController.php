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
        return view('blog.home', [
            'posts' => Post::orderBy('id', 'DESC')->paginate(5),
        ]);
    }

    /**
     * @param $tag_name
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function blogHomeTag($tag_name)
    {
        $posts = Tag::where('name', $tag_name)->firstOrFail()->posts;
        $posts = new Paginator($posts, 5);
        $posts->withPath('\post/tag/' . $tag_name);
        return view('blog.home', [
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
        return view('blog.home', [
            'posts' => Post::where('user_id', $user->id)->paginate(5),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function BlogHomeByMonth()
    {
        $date = strtotime($_POST['key']);
        $from = Carbon::create(date('Y', $date), date('m', $date), 01);
        $to = Carbon::create(date('Y', $date), date('m', $date), date('t'));

        $posts = Post::whereBetween('created_at', [$from, $to])->paginate(5);
        $title = 'Posts By month : ' . date('F', $date);
        return view('blog.home', compact('title', 'posts'));
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
        return view('blog.post', [
            'post' => $post,
            'tags' => $post->tags
        ]);
    }

    public function edit($id)
    {
        abort_unless(Auth::user()->hasPermissionTo('edit-post') or Auth::id() == $id, 404);
        return view('post.update', [
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
            'image' => $request->hasFile('image')
                ? Storage::putFile('images', new File($request->file('image')->getPathname()))
                : ( $_POST['img'] ? $_POST['img'] : "" ) ,
        ]);
        if ($post) { $post = Post::find($id); }

        // Event trigger for sending mail
        event(new \App\Events\PostUpdated($post));

        //Browser Redirection to post Show page
        return redirect('post/' . $post->user->name . '/' .
            str_replace('?','-', str_replace(' ', '-', $post->post_title)). '-' . $post->id);
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
