<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PreviousDayPosts extends Mailable
{
    use Queueable, SerializesModels;

    protected $posts;
    protected $files;
    public $post_count, $date;

    /**
     * Create a new message instance.
     *
     * @param $posts
     * @param $files
     * @return void
     */
    public function __construct($posts, $files)
    {
        $this->posts = $posts;
        $this->files = $files;
        $this->post_count = $posts->count();
        $this->date = today()->subDays(1)->toFormattedDateString();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->view('email.previous_day')
            ->subject('Posts created Yesterday');
        foreach ($this->files as $file => $options) {
            $mail->attach($file, $options);
        }
        return $mail;
    }
}
