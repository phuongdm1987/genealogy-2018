<?php
declare(strict_types=1);

namespace Genealogy\Exceptions;

use Exception;
use Genealogy\Helpers\JsonResponseHandler;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class Handler
 * @package Genealogy\Exceptions
 */
class Handler extends ExceptionHandler
{
    use JsonResponseHandler;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if (!$request->expectsJson()) {

            return parent::render($request, $exception);
        }

        switch ($exception) {
            case ($exception instanceof NotFoundHttpException):
                return $this->notFoundResponse();
            default:
                return parent::render($request, $exception);
        }
    }
}
