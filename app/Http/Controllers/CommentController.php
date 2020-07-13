<?php

namespace App\Http\Controllers;

use App\DeletedComment;
use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Auth;

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
//        Comment::where('id', $id)->delete();
    }
}
