<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'comment',
        'user_name',
        'user_email',
        'user_website',
        'post_id',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
