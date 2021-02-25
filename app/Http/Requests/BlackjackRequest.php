<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BlackjackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'playerName' => 'required|string|min:3',
            'delay' => 'required|int|min:10|max:300',
        ];
    }

    public function messages(): array
    {
        return [
            'playerName.required' => trans('validation.required'),
            'playerName.string' =>  trans('validation.string'),
            'playerName.min' =>  trans('validation.min'),
            'delay.required' => trans('validation.required'),
            'delay.int' => trans('validation.integer'),
            'delay.min' => trans('validation.min'),
            'delay.max' =>  trans('validation.max'),
        ];
    }
}
