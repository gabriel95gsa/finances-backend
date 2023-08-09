<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function notice(){}

    /**
     * Resend verification e-mail
     *
     * @return JsonResponse
     */
    public function resend(Request $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'User e-mail already verified.'
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'E-mail verification sent.'
        ]);
    }

    /**
     * Verify user e-mail
     *
     * @param EmailVerificationRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function verify(User $id, string $hash): JsonResponse
    {
        $user = $id;

        if (!hash_equals($hash, sha1($user->getEmailForVerification()))) {
            //abort(403);
            return response()->json([
                'message' => 'Invalid Signature'
            ], 403);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));
        }

        return response()->json([
            'message' => 'User e-mail verified.'
        ]);
    }
}
