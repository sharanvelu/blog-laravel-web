<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'PostTitle' => 'required|min:5|max:200',
            'PostDescription' => 'required|min:5|max:5000000',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'image.image' => 'Image file is not a valid Image file type',
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'PostTitle' => 'Post Title',
            'PostDescription' => 'Post Description',
            'image' => 'Image',
        ];
    }
}
