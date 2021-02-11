<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePolicyRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'name' => 'required',
            'feature' => 'required',
            'goal' => 'required',
            'action' => 'required',
            'impact' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Policy Name Required',
            'feature.required' => 'Policy Feature Required',
            'goal.required' => 'Policy Goal Required',
            'impact.required' => 'Policy Impact Required',
        ];
    }
}
