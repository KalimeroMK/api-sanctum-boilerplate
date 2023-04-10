<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Http\Requests\CreateRequest;
use Modules\Core\Traits\ImageUpload;
use Modules\User\Models\User;

class AuthController extends Controller
{
    use ImageUpload;

    /**
     * @param CreateRequest $request
     *
     * @return JsonResponse
     */
    public function signup(CreateRequest $request)
    {
        if (User::create(
            [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]
        )->assignRole('client')) {
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
            ], 200);
        }

        return response()->json(null, 404);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
                'password' => 'required'
            ]
        );

        if ($validate->fails()) {
            return response()->json([
                'error' => $validate->errors(),
            ], 500);
        }
        $user = User::whereEmail($request['email'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken($request['email'])->plainTextToken,
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
        $request->validate(['email' => 'required|email|exists:users']);

        // Delete all old code that user send before.
        DB::table('password_resets')->where([
            ['email', $request['email']],
        ])->delete();
        $token = Str::random(60);

        DB::table('password_resets')
            ->insert(
                [
                    'email' => $request->all()['email'],
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]
            );

        Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return new JsonResponse(
            [
                'success' => true,
                'message' => 'We have e-mailed your password reset token',
            ],
            200
        );
    }

    /**
     * @throws Exception
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|exists:password_resets',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        try {
            User::whereEmail($request['email'])->update([
                'password' => Hash::make($request['password'])
            ]);
            return new JsonResponse(
                [
                    'success' => true,
                    'message' => 'You password was successfully change',
                ],
                200
            );
        } catch (Exception $exception) {
            throw ($exception);
        }
    }
}
