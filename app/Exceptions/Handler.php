<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

        // A CSRF token mismatch (session expired / stale tab) should never show the
        // raw "419 Page Expired" screen — send the visitor back to where they were
        // (or the right login screen) so a logout / form resubmit just works.
        $this->renderable(function (TokenMismatchException $e, $request) {
            if ($request->expectsJson()) {
                return null;
            }

            $path = $request->path();
            $redirectTo = str_contains($path, 'owner/')
                ? route('owner.login')
                : url()->previous();

            return redirect($redirectTo)
                ->with('error', app()->getLocale() == 'ar'
                    ? 'انتهت صلاحية الجلسة، الرجاء المحاولة مرة أخرى.'
                    : 'Your session has expired, please try again.');
        });
    }
}
