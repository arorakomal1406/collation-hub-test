<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'author_name',
        'post_id',
        'content',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
