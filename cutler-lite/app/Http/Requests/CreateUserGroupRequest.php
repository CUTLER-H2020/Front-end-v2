<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserGroupRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:user_groups'],
            'parent_id' => 'nullable',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'User Group Name Required',
            'name.unique' => 'User Group Name Already Exist',
        ];
    }
}
