<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Modules\Auth\Http\Requests\CreateRequest;
use Modules\Core\Traits\ImageUpload;
use Modules\User\Http\Resources\UserResource;
use Modules\User\Models\User;

class AuthController extends Controller
{
    use ImageUpload;

    /**
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function signup(CreateRequest $request): JsonResponse
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
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'errors' => ['email' => ['The provided credentials are incorrect.']]
                ], 422);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Revoke token; only remove the token that is used to perform logout (i.e. will not revoke all tokens)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(null, 200);
    }

    /**
     * Get authenticated user details
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAuthenticatedUser(Request $request)
    {
        return response()->json(new UserResource($request->user()), 200);
    }

    /**
     * Send password reset link email
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendPasswordResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => __($status)
            ], 200);
        } else {
            return response()->json([
                'message' => __($status)
            ], 500);
        }

    }

    /**
     * Reset the user's password
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function resetPassword(Request $request): JsonResponse
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
                    'message' => 'You password was successfully changed',
                ],
                200
            );
        } catch (Exception $exception) {
            throw ($exception);
        }
    }
}
