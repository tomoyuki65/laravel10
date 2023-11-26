<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ValidationFailedTrait;

class UpdateUserRequest extends FormRequest
{
    use ValidationFailedTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // 認可処理は無効にする
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validate = [];

        $validate += [
            'name' => [
                'string',
                'max:20'
            ]
        ];

        $validate += [
            'email' => [
                'email'
            ]
        ];
    }
}
