<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// Firebaseの認証機能用
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use \Symfony\Component\HttpFoundation\Response;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use App\Models\User;
// ポリシー追加
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Firebaseによる認証
        Auth::viaRequest('firebase', function (Request $request) {
            $idToken = $request->header('Authorization');
            if (empty($idToken)) {
                throw new HttpResponseException(response()->json(['message' => 'Bad Request'], Response::HTTP_BAD_REQUEST));
            }

            $idToken = str_replace('Bearer ', '', $idToken);
            $firebaseAuth = app(FirebaseAuth::class);
            try {
                $verifiedIdToken = $firebaseAuth->verifyIdToken($idToken);
            } catch (\Exception $e) {
                throw new HttpResponseException(response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED));
            }

            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');

            // DBからユーザー情報取得（論理削除データも含む）
            $user = User::withTrashed()->where('uid', $uid)->first();

            if (!empty($user->deleted_at)) {
                throw new HttpResponseException(response()->json(['message' => 'Bad Request'], Response::HTTP_BAD_REQUEST));
            }

            if (empty($user)) {
                $user = new User();
                $user->uid = $uid;
                $user->email = $email;
            }

            return $user;
        });
    }
}
