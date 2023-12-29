<?php

use Illuminate\Support\Str;
use App\Repositories\Auth\AuthRepositoryInterface as AuthRepository;
use App\Repositories\User\UserRepositoryInterface as UserRepository;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Models\User;

test('サインアップ処理が正常終了し、DBにユーザーが新規作成されること', function () {
    // Firebaseのユーザー作成処理をモック化
    $uid = Str::random(10);
    $name = "testUser";
    $email = "test@example.com";
    $password = Str::random(10);
    $properties = [
        'uid' => $uid,
        'email' => $email
    ];
    $returnObj = (object) $properties;
    $mockAuthRepo = Mockery::mock(AuthRepository::class)->makePartial();
    $mockAuthRepo->shouldReceive('createFirebaseUser')
                 ->once()
                 ->andReturn($returnObj);
    $this->app->instance(AuthRepository::class, $mockAuthRepo);

    // API実行
    $path = "/api/v1/signup";
    $body = [
        'name' => $name,
        'email' => $email,
        'password' => $password
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

test('ユーザー保存処理でエラーの場合、ロールバックされてユーザーが作成されないこと', function () {
    // Firebaseのユーザー作成、削除処理をモック化
    $uid = Str::random(10);
    $name = "testUser";
    $email = "test@example.com";
    $password = Str::random(10);
    $properties = [
        'uid' => $uid,
        'email' => $email
    ];
    $returnObj = (object) $properties;
    $mockAuthRepo = Mockery::mock(AuthRepository::class)->makePartial();
    $mockAuthRepo->shouldReceive('createFirebaseUser')
                 ->once()
                 ->andReturn($returnObj);
    $mockAuthRepo->shouldReceive('deleteFirebaseUser')
                 ->once()
                 ->andReturn();
    $this->app->instance(AuthRepository::class, $mockAuthRepo);

    // ユーザー保存処理をモック化
    $message = 'Internal Server Error';
    $code = 500;
    $mockUserRepo = Mockery::mock(UserRepository::class)->makePartial();
    $mockUserRepo->shouldReceive('saveUser')
                 ->andThrow(new AccessDeniedHttpException($message, null, $code));
    $this->app->instance(UserRepository::class, $mockUserRepo);

    // API実行
    $path = "/api/v1/signup";
    $body = [
        'name' => $name,
        'email' => $email,
        'password' => $password
    ];
    $response = $this->post($path, $body);
    
    // 検証
    $res_json = json_encode([ "message" => $message ]);
    expect($response->status())->toBe(500);
    expect($response->content())->toBe($res_json);
    $this->assertDatabaseMissing(User::class, [
        'uid' => $uid,
        'name' => $name,
        'email' => $email,
    ]);
});