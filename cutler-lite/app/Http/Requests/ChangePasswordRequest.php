<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['required'],
            'new_password' => ['required'],
            'new_password_confirm' => ['same:new_password'],
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => trans('site.password-fill.new_password'),
            'new_password.required' => trans('site.password-fill.new_password'),
            'new_password_confirm.same' => trans('site.password-fill.new_password_same'),

        ];
    }
}
