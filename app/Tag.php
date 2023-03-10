<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['title', 'slug'];

    public function posts()
    {
        return $this->belongsToMany(Post::class); // Тег может принадлежать многим Постам
    }
}
