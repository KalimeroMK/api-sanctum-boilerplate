<?php

namespace Modules\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Modules\User\Http\Requests\CreateRequest;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Models\User;

class AuthController extends Controller
{
    
    /**
     * @param  CreateRequest  $request
     *
     * @return JsonResponse
     */
    public function signup(CreateRequest $request)
    {
        if (User::create(
            [
                'name'     => $request['name'],
                'email'    => $request['email'],
                'password' => bcrypt($request['password']),
            ]
        )) {
            return response()->json([
                'status'  => true,
                'message' => 'User Created Successfully',
            ], 200);
        }
        
        return response()->json(null, 404);
    }
    
    /**
     * @param  LoginRequest  $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if ( ! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        
        return response()->json([
            'user'         => $user,
            'access_token' => $user->createToken($request->email)->plainTextToken,
        ], 200);
    }
    
    /*
     * Revoke token; only remove token that is used to perform logout (i.e. will not revoke all tokens)
    */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(null, 200);
    }
    
    /*
     * Get authenticated user details
    */
    public function getAuthenticatedUser(Request $request)
    {
        return $request->user();
    }
    
    public function sendPasswordResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $status = Password::sendResetLink(
            $request->only('email')
        );
        
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)], 200);
        } else {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));
                
                $user->save();
                
                event(new PasswordReset($user));
            }
        );
        
        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)], 200);
        } else {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }
    }
}
