<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;


class Handler extends ExceptionHandler
{
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */

    use ApiExceptionsTrait;

    public function render($request, Exception $exception)
    {
        if ($request->expectsJson()) {
            
            return $this->apiExceptions($request, $exception);
        }

        else {

            if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException || $exception instanceof MethodNotAllowedHttpException || $exception instanceof QueryException) {
                
                return response()->view('errors.default', ['exceptionMessage' => $exception->getMessage()]);
            }

            if ($exception instanceof AuthenticationException) {
                
                return redirect()->route('admin.login');
            }

            return parent::render($request, $exception);
        }

    }
}
