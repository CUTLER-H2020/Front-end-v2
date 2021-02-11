<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'surname' => 'required',
            'email' => ['required'],
            'group_id' => 'required',
            'password' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'User Name Required',
            'surname.required' => 'User Surname Required',
            'email.required' => 'User E-mail Required',
            'group_id.required' => 'User Group Required',
            'password.required' => 'User Password Required',
        ];
    }
}
