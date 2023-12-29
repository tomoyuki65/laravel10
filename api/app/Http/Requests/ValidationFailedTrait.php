<?php

namespace App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationFailedTrait
{
    /**
     * エラーメッセージを出力
     * 
     * @return viod
     */
    protected function failedValidation(Validator $validator)
    {
        $response['errors'] = $validator->errors()->toArray();

        $controller = new Controller();

        throw new HttpResponseException(
            $controller->jsonResponse($response, 422)
        );
    }

    /**
     * 共通エラーメッセージ
     */
    public function messages()
    {
        return [
            'required' => ':attributeは必須項目です。',
            'string' => ':attributeは文字列で入力して下さい。',
            'email' => ':attributeは有効なメールアドレス形式で入力して下さい。',
            'max' => [
                'string' => ':attributeは:max文字以内で入力して下さい。',
            ],
            'min' => [
                'string' => ':attributeは:min文字以上で入力して下さい。',
            ],
        ];
    }

    /**
     * 共通エラー文言
     */
    public function attributes()
    {
        return [
            'uid' => 'uid',
            'name' => '名前',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }
}