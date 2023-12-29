<?php

use Illuminate\Support\Str;
use App\Models\User;

test('ユーザーが新規作成され、ステータス201で正常終了すること', function () {
    // API実行
    $path = "/api/v1/user";
    $uid = Str::random(10);
    $name = "testUser";
    $email = "test@example.com";
    $body = [
        'uid' => $uid,
        'name' => $name,
        'email' => $email
    ];
    $response = $this->post($path, $body);
    
    // 検証
    expect($response->status())->toBe(201);
    $this->assertDatabaseHas(User::class, [
        'uid' => $uid,
        'name' => $name,
        'email' => $email,
    ]);
});

test('対象ユーザーをjson形式で取得し、ステータス200で正常終了すること', function () {
    // 事前にユーザーデータを作成
    $uid = Str::random(10);
    $name = "testUser";
    $email = "test@example.com";
    $this->user = User::create([
                      'uid' => $uid,
                      'name' => $name,
                      'email' => $email
                  ]);

    // API実行
    $path = "/api/v1/user/{$uid}";
    $response = $this->actingAs($this->user, 'api')->get($path);
    
    // 検証
    $res_json = json_encode(User::where('uid', $uid)->first());
    expect($response->status())->toBe(200);
    expect($response->content())->toBeJson();
    expect($response->content())->toBe($res_json);
});

test('未認証の場合は対象ユーザーを取得できず、ステータス400を返すこと', function () {
    // 事前にユーザーデータを作成
    $uid = Str::random(10);
    $name = "testUser";
    $email = "test@example.com";
    $this->user = User::create([
                      'uid' => $uid,
                      'name' => $name,
                      'email' => $email
                  ]);

    // API実行
    $path = "/api/v1/user/{$uid}";
    $response = $this->get($path);
    
    // 検証
    $res_json = json_encode([ "message" => "Bad Request" ]);
    expect($response->status())->toBe(400);
    expect($response->content())->toBe($res_json);
});
