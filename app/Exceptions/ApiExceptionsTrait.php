<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait ApiExceptionsTrait
{
	public function apiExceptions(Request $request, Exception $exception)
	{
		if($exception instanceof ModelNotFoundException){
            return response()->json([
                'error'=>str_replace("App\\","",$exception->getModel()).' not found'
            ], 404);
        }

        else if($exception instanceof MethodNotAllowedHttpException){
            
            return response()->json([
                'error'=>'Method is not allowed for the requested route'
            ], 405);
        }

        /*
        // Route not found exception is already handled in api route file
        else if($exception instanceof NotFoundHttpException){
            
            return response()->json([
                'error'=>'Incorrect route'
            ], 404);
        }
        */

        else if($exception instanceof ThrottleRequestsException){
            
            return response()->json([
                'error'=>'Max number of requests has been crossed. Please try again'
            ], 429);
        }

        // return response()->json(['error'=>'Unauthenticated'], 401); 

        return parent::render($request, $exception);

	}
}
