<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return !auth()->guest() && (auth()->user()->id == $this->route('profile'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => "unique:users,email,{$this->route('profile')},id",
            'name' => 'required|max:255',
            "bio" => 'nullable'
        ];
    }
}
