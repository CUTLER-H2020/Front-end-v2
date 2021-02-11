<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePolicyRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'feature' => 'required',
            'goal' => 'required',
            'action' => 'required',
            'impact' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif',
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
            'action.required' => 'Policy Action Required',
            'impact.required' => 'Policy Impact Required',
        ];
    }
}
