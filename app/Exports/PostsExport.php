<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PostsExport implements FromView, ShouldAutoSize
{

    protected $posts;

    public function __construct($posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('files.excel.previous_day_posts', [
            'posts' => $this->posts
        ]);
    }
}
