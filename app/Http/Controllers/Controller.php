<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\ApiMessage;
use App\ApiCode;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function respond($data, $message = null, $http_code = 200)
    {
        return ResponseBuilder::asSuccess(200)
            ->withData($data)
            ->withMessage($message)
            ->withHttpCode($http_code)
            ->build();
    }

    public function respondWithMessage($message, $http_code = 200)
    {
        return ResponseBuilder::asSuccess(200)
            ->withMessage($message)
            ->withHttpCode($http_code)
            ->build();
    }

    public function respondWithError($api_code, $message = null)
    {
        return ResponseBuilder::asError($api_code)
        ->withMessage($message)
        ->withHttpCode($api_code)->build();
    }

    public function respondBadRequest()
    {
        return $this->respondWithError(400, ApiMessage::respondBadRequest);
    }

    public function respondFailedDependency()
    {
        return $this->respondWithError(424, ApiMessage::FAILED_DEPENDENCY);
    }

    public function respondNotHaveAccessData()
    {
        return $this->respondWithError(424, ApiMessage::WRONG_DATA);
    }

    public function respondUnAuthenticated()
    {
        return $this->respondWithError(400, 401);
    }

    public function respondNotFound()
    {
        return $this->respondWithError(404, 404);
    }
}
