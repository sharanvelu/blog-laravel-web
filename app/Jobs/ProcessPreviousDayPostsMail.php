<?php

namespace App\Jobs;

use App\Exports\PostsExport;
use App\Mail\PreviousDayPosts;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProcessPreviousDayPostsMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $posts;
    protected $date;
    protected $files = array();

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $date = today()->subDays(1);
        $this->posts = \App\Post::whereDate('created_at', $date)->get();

        $formatted_date = $date->toFormattedDateString();
        $file_name = 'posts_created_on-' . str_replace(' ', '-', $formatted_date);

        if (!(Storage::exists('files/excel') && Storage::exists('files/pdf'))) {
            Storage::makeDirectory('files/pdf');
            Storage::makeDirectory('files/excel');
        }

        \PDF::loadView('files.pdf.previous_day_posts', [
            'posts' => $this->posts,
            'date' => $formatted_date
        ])->save(storage_path() . '/app/public/files/pdf/' . $file_name . '.pdf');

        Excel::store(new PostsExport($this->posts), 'files/excel/posts_created_on-' .
            str_replace(' ', '-', $formatted_date) . '.xlsx'
        );

        $this->files = [
            asset('storage/files/pdf/' . $file_name . '.pdf') => [
                'as' => $file_name . '.pdf',
                'mime' => 'application/pdf'
            ],
            asset('storage/files/excel/' . $file_name . '.xlsx') => [
                'as' => $file_name . '.xlsx',
                'mime' => 'application/xlsx'
            ]
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger('Execute');
        Mail::to(env('SUPER_ADMIN_MAIL', 'sharanvelu@outlook.com'))
            ->queue(new PreviousDayPosts($this->posts, $this->files));
    }
}
