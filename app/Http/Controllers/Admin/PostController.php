<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::with('category', 'tags')->paginate(20); // метод with вытаскивает связи; Тоесть указываем какие связи будем получать при вызове этого метода;Это делается для уменьшений кол-во запросов
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        // pluck вернёт как значение первый аргумент, а второй аргумент будет ключом данного значения
        $categories = Category::pluck('title', 'id')->all(); // ид будет ключем, в title будут данные
        $tags = Tag::pluck('title', 'id')->all(); // получаем все теги
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image',
        ]);

        $request['slug'] = Str::lower($request['slug']);

        $data = $request->all();

        $data['thumbnail'] = Post::uploadImage($request);

        if ($request->hasFile('thumbnail')) {
            $folder = date('Y-m-d');
            $data['thumbnail'] = $request->file('thumbnail')->store("images/{$folder}");
        }

        $post = Post::create($data);
        $post->tags()->sync($request->tags); // в post_tag попадет под ключем post_id - ид статьи; в tag_id - ид тегов которые мы передали при создании данной статьи($request->tags)

        //  Метод sync принимает массив идентификаторов для размещения в промежуточной таблице. Любые идентификаторы, которых нет в данном массиве, будут удалены из промежуточной таблицы. Таким образом, после завершения этой операции в промежуточной таблице будут существовать только идентификаторы из данного массива

        return redirect()->route('posts.index')->with('success', 'Статья добавлена');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        return view('admin.posts.edit', compact('categories', 'tags', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image',
        ]);

        $post = Post::find($id);
        $data = $request->all();

        if ($file = Post::uploadImage($request, $post->thumbnail)) {
            $data['thumbnail'] = $file;
        }

        $post->update($data); // обновляем данные
        $post->tags()->sync($request->tags); // синхронизируем теги

        return redirect()->route('posts.index')->with('success', 'Изменения сохранены');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->sync([]); // все связанные теги будут удаляться потому что мы передали пустой массив; Урок 11, 26:40 минута
        Storage::delete($post->thumbnail);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Статья удалена');
    }
}
