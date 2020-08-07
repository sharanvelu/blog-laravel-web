<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostCreated extends Mailable
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
            ->subject('Post Created Successfully')
            ->markdown('email.post.created')
            ->with([
                'name' => $this->post->post_title,
                'link' => 'https://homestead.blog/post/' . $this->post->user->name . '/' .
                    str_replace('?','-', str_replace(' ', '-', $this->post->post_title)) .
                    '-' . $this->post->id
            ]);
    }
}
