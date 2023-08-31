<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('api/app/*')) {
                return response()->json([
                    'message' =>
                        'This action is unauthorized. User does not have permission to manage this resource.'
                ], Response::HTTP_FORBIDDEN);
            }
        });

//        $this->renderable(function (HttpException $e, $request) {
//            if ($request->is('api/app/*')) {
//                return response()->json([
//                    'message' => $e->getMessage()
//                ], 403);
//            }
//        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/app/*')) {
                return response()->json([
                    'message' => 'Resource not found.'
                ], Response::HTTP_NOT_FOUND);
            }
        });

        $this->renderable(function (TokenInvalidException $e, $request) {
            return response()->json([
                'message' =>
                    'Could not decode token. Token invalid.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }
}
