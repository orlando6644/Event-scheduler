<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
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
    }

    public function render($request, Throwable $exception)
    {
        /**
         * handle validation errors response in order to standardize the response format
         */
        if ($exception instanceof ValidationException) {
            return ApiResponse::error('Validation errors.', $exception->errors(), 422);
        }

        return parent::render($request, $exception);
    }
}
