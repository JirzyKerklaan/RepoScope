<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutFrequentMemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'github_id' => [
                'required',
                'int',
            ],
            'username' => [
                'required',
                'string',
            ],
            'display_name' => [
                'required',
                'string',
            ],
            'avatar' => [
                'string',
                'nullable',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'github_id' => 'Github ID',
            'name' => 'Name',
            'email' => 'Email',
            'avatar' => 'Avatar',
        ];
    }
}
