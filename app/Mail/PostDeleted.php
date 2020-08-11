<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostDeleted extends Mailable
{
    use Queueable, SerializesModels;

    protected $post;

    /**
     * Create a new message instance.
     *
     * @param $post
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->post->user->email)
            ->subject('Post Deleted Successfully')
            ->markdown('email.post.deleted')
            ->with([
                'name' => $this->post->post_title,
                'link' => 'https://homestead.blog/post/home'
            ]);
    }
}
