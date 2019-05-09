<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        else if($exception instanceof NotFoundHttpException){
            
            return response()->json([
                'error'=>'Incorrect route'
            ], 400);
        }

        
        // return response()->json(['error'=>'Unauthenticated'], 401); 

        return parent::render($request, $exception);

	}
}
