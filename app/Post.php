<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Post extends Model implements Searchable
{
    use SoftDeletes;

    protected $fillable = [
        'post_title',
        'post_description',
        'user_id',
        'image'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    /**
     *
     * Used by Spatie/laravel-searchable to search through DB
     *
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $url= '\post/' . $this->user->name . '/' . str_replace(' ', '-', $this->post_title) . '-' . $this->id;
        return new SearchResult(
            $this,
            $this->post_title,
            $url
        );
    }

}
