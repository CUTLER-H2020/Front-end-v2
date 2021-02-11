<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserGroupRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'parent_id' => 'nullable',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'User Group Name Already Exist',
        ];
    }
}
