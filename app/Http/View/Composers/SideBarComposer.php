<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Post;
use App\Tag;
use stdClass;
use Illuminate\Support\Facades\Cache;

class SideBarComposer
{

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
        $this->recent_posts = Post::latest()->take(3)->get();
        $this->tag_cloud = Tag::latest()->get();

        $repeated_tags = DB::table('post_tag')
            ->select(DB::raw('count("tag_id") as repetition, tag_id'))
            ->groupBy('tag_id')
            ->orderBy('repetition', 'desc')
            ->get();

        foreach ($repeated_tags as $item) {
            $tag_content = new stdClass();
            $tag_content->{'tag_name'} = $this->tag_cloud->find($item->tag_id)->name;
            $tag_content->{'count'} = $item->repetition;
            array_push($this->popular_tags, $tag_content);
            unset($tag_content);
        }

        Cache::remember('recent_posts', 300, function (){
            return $this->recent_posts;
        });
        Cache::remember('tag_cloud', 300, function () {
            return $this->tag_cloud;
        });
        Cache::remember('popular_tags', 300, function () {
            return $this->popular_tags;
        });
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
            'recent_posts' => Cache::get('recent_posts'),
            'tag_cloud' => Cache::get('tag_cloud'),
            'popular_tags' => Cache::get('popular_tags')
        ]);
    }
}
