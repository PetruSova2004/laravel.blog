<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategory extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() // тут можем написать какие-то правила для того кто будет иметь доступ к данному request
    {
        return true; // Тут у нас будут иметь доступ все кто сюда попал; Тут будет попадать только админ
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() // тут будут правила валидации
    {
        return [
            'title' => 'required',
        ];
    }
}
