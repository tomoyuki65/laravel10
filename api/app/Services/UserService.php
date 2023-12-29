<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface as UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Symfony\Component\HttpFoundation\Response;

class UserService extends Controller
{
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepositry = $userRepo;
    }

    public function createUser(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepositry->createUser(
                        $request->uid,
                        $request->name,
                        $request->email
                    );

            $this->userRepositry->saveUser($user);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("UserService/createUserでエラー");
            throw new HttpResponseException(response()->json(['message' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        return response()->json(['message' => 'OK'], Response::HTTP_CREATED);
    }

    public function getUsers(Request $request)
    {
        try {

            $users = $this->userRepositry->getAllUserWithTrashed();
 
        } catch (\Exception $e) {
            Log::error("UserService/getUsersでエラー");
            throw new HttpResponseException(response()->json(['message' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        return $this->jsonResponse($users);
    }

    public function getUser(Request $request, string $uid)
    {
        try {

            $user = $this->userRepositry->getUserFromUid($uid);
 
        } catch (\Exception $e) {
            Log::error("UserService/getUserでエラー");
            throw new HttpResponseException(response()->json(['message' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR));
        }
        
        return $this->jsonResponse($user);
    }

    public function updateUser(Request $request, string $uid)
    {
        try {
            DB::beginTransaction();
    
            $user = $this->userRepositry->getUserFromUid($uid);

            // 認可処理
            if ($request->user()->cannot('update', $user)) {
                return response()->json(['message' => 'Bad Request'], Response::HTTP_BAD_REQUEST);
            }

            if (!is_null($request->name)) {
                $user->name = $request->name;
            }

            if (!is_null($request->email)) {
                $user->email = $request->email;
            }

            $this->userRepositry->saveUser($user);
 
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("UserService/updateUserでエラー");
            throw new HttpResponseException(response()->json(['message' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        return response()->json(['message' => 'OK']);
    }

    public function destroyUser(Request $request, string $uid)
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepositry->getUserFromUid($uid);

            // 認可処理
            if ($request->user()->cannot('delete', $user)) {
                return response()->json(['message' => 'Bad Request'], Response::HTTP_BAD_REQUEST);
            }

            $this->userRepositry->deleteUser($user);
 
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("UserService/destroyUserでエラー");
            throw new HttpResponseException(response()->json(['message' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR));
        }

        return response()->json(['message' => 'OK']);
    }
}