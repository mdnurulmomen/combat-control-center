<?php

namespace App\Http\Traits;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\RequestWithToken;

trait RetrieveToken
{
	public function retrieveToken($request)
    {
        if (JWTAuth::parseToken()->check()) {

            return JWTAuth::getPayload(JWTAuth::setToken($request->token))->get();
            // return JWTAuth::getPayload(JWTAuth::getToken())->get();
        }
        else{
            return null;
        }
    }

    /*
        $decryptedJWTPayload = openssl_decrypt($postman->payload, 'AES-256-CBC', env('CUSTOM_ENCRYPTION_KEY'), 0, env('CUSTOM_IV_KEY'));
        $this->request = JWTAuth::getPayload(JWTAuth::setToken($decryptedJWTPayload))->get();
        $this->request = new Request($this->request);
    */

    /*
        return JWTAuth::getPayload(JWTAuth::getToken());
        $request = JWTAuth::decode(JWTAuth::getToken())->get();
        return JWTAuth::authenticate(JWTAuth::getToken());

        $decryptedJWTPayload = openssl_decrypt($request->payload, 'AES-256-CBC', env('CUSTOM_ENCRYPTION_KEY'), 0, env('CUSTOM_IV_KEY'));
        $request = JWTAuth::getPayload(JWTAuth::setToken($decryptedJWTPayload))->get();
        $request = new Request($request);
    */
}