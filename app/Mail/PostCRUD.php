<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostCRUD extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $crud;
    public $link;

    /**
     * Create a new message instance.
     *
     * @param $post
     * @param $crud
     * @return void
     */
    public function __construct($post, $crud)
    {
        $this->post = $post;
        $this->crud = $crud;
        $this->link = 'https://homestead.blog/' . $post->user->name . '/' .
            str_replace('?', '-', str_replace(' ', '-', $post->post_title)) . '-' .
            $post->id;

        if ($crud == 'deleted') {
            $this->link = 'https://homestead.blog/';
        }
    }

    /**
     * Build the message.
     *
     * @return PostCRUD
     */
    public function build()
    {
        return $this->to($this->post->user->email)
            ->subject("Post {$this->crud} Successfully")
            ->view('email.post');
    }
}
