<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Tag extends Model implements Searchable
{
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }

    /**
     *
     * Used by Spatie/laravel-searchable to search through DB
     *
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        $url= '\post/tag/' . $this->name;
        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}
