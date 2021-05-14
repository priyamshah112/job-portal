<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'first_name'     => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'type'     => 'required|in:student,instructor'
        ];
    }
    public function messages()
    {
        return [
            'first_name.required'=>'first name of user is required',
            'last_name.required' => 'last name of user is required',
            'email.required' => 'email of user is required',
            'password.required'=> 'password of user is required',
            'type'=> 'user type is required'
        ];
    }
}