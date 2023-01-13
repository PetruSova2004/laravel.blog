<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'slug'];

    public function posts()
    {
        return $this->hasMany(Post::class); // Говорим что у одной Категории может быть много Постов
    }
}
