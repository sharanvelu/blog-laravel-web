<?php

namespace App\Http\View\Composers;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Post;
use App\Tag;
use stdClass;

class SideBarComposer
{

    protected $users;
    protected $recent_posts;
    protected $tag_cloud;
    protected $popular_tags = array();

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->users = User::get();
        $this->recent_posts = Post::latest()->take(5)->get();
        $this->tag_cloud = Tag::latest()->get();

        $repeated_tags = DB::table('post_tag')
            ->select(DB::raw('count("tag_id") as repetition, tag_id'))
            ->groupBy('tag_id')
            ->orderBy('repetition', 'desc')
            ->take(5)
            ->get();

        foreach ($repeated_tags as $item) {
            $tag_content = new stdClass();
            $tag_content->{'tag_name'} = $this->tag_cloud->find($item->tag_id)->name;
            $tag_content->{'count'} = $item->repetition;
            array_push($this->popular_tags, $tag_content);
            unset($tag_content);
        }
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'users' => $this->users,
            'recent_posts' => $this->recent_posts,
            'tag_cloud' => $this->tag_cloud,
            'popular_tags' => $this->popular_tags
        ]);
    }
}
