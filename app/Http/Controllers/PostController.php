<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('category')->orderBy('id', 'desc')->paginate(2); // Забираем все статьи и категорий к которым привязаны эти статьи
        return view('posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail(); // Если мы не нашли такую запись то получим 404 ошибку
        $post->views += 1;
        $post->update();
        return view('posts.show', compact('post'));
    }

}
