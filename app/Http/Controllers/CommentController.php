<?php

namespace App\Http\Controllers;

use App\DeletedComment;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    /**
     * @param Request $request
     */
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'comment' => 'required|min:5',
            'name' => 'required',
            'email' => 'required|email',
        ]);

        Comment::create([
            'comment' => $_POST['comment'],
            'post_id' => $_POST['post_id'],
            'user_name' => $_POST['name'],
            'user_email' => $_POST['email'],
            'user_website' => $_POST['website'],
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'comment' => 'required|min:5',
            'name' => 'required',
        ]);

        $comment = Comment::find($id);
        $comment->update([
            'comment' => $_POST['comment'],
            'user_name' => $_POST['name'],
        ]);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        Comment::find($id)->delete();
    }

    /**
     * As user types in the email id in comment section
     * This function returns the user name if available through AJAX
     *
     * @return bool
     */
    public function getName()
    {
        $user_name = Comment::where('user_email', $_POST['email'])->first();
        if ($user_name) {
            return $user_name->user_name;
        }
        return false;
    }
}
