<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'PostTitle' => 'required|min:5|max:250',
            'PostDescription' => 'required|min:20|max:150000',
            'image' => 'mimes:jpeg,png,jpg,bmp,gif'
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
            'min' =>'The :attribute should be higher than the minimum limit of :min characters.',
            'max' =>'The :attribute should be lesser than the maximum limit of :max characters.',
            'required' => 'The :attribute field is required and it is missing.',
            'image.mimes' => ':attribute file is not a valid Image file type. Accepted file types are \'jpeg, jpg, png, bmp, gif\'',
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
