<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'content', 'category_id', 'thumbnail',];
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps(); // Посты могут принадлежать многим Тегам; withTimestamps заполнит автоматически поля created_at и updated_at текущем временем
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function uploadImage(Request $request, $image = null)
    {
        if ($request->hasFile('thumbnail')) { // проверяем если к нам пришел файл
            if ($image) {
                Storage::delete($image); // удаляем данное изображение из папки public/images/uploads
            }
            $folder = date('Y-m-d');
            return $request->file('thumbnail')->store("images/{$folder}"); // сохраняем данный файл по пути public/uploads/images/{$folder}; public, uploads мы настроили в filesystems.php
        }
        return null;
    }

    public function getImage()
    {
        if (!$this->thumbnail) { // если у модели нет прикрепленного изображения
            return asset("no-image.png");
        }
        return asset("uploads/{$this->thumbnail}");
    }

    public function getPostDate()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d F, Y');
    }

}
