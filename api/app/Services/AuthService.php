<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Auth\AuthRepositoryInterface as AuthRepository;
use App\Repositories\User\UserRepositoryInterface as UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Symfony\Component\HttpFoundation\Response;

class AuthService extends Controller
{
    public function __construct(
        AuthRepository $authRepo,
        UserRepository $userRepo
    )
    {
        $this->authRepositry = $authRepo;
        $this->userRepositry = $userRepo;
    }

    public function registerUser(Request $request)
    {
        try {
            DB::beginTransaction();

            // Firebaseにユーザー作成
            $authUser = $this->authRepositry
                             ->createFirebaseUser(
                                 $request->email,
                                 $request->password
                             );
            
            // DBにユーザー作成
            $user = $this->userRepositry->createUser(
                        $authUser->uid,
                        $request->name,
                        $authUser->email
                    );
            $this->userRepositry->saveUser($user);

            DB::commit();
        } catch (\Exception $e) {
            // ロールバック
            DB::rollback();
            // Firebaseユーザーが作成済みの場合は削除処理
            if (!empty($authUser)) {
                $this->authRepositry->deleteFirebaseUser($authUser->uid);
            }
            Log::error("AuthService/registerUserでエラー");
            throw new HttpResponseException(response()->json(['message' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        return response()->json(['message' => 'OK'], Response::HTTP_CREATED);
    }
}