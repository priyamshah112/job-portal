<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use InfyOm\Generator\Utils\ResponseUtil;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="SRM Backend APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendValidationError($error, $code = 422)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendAccessDenied($error, $code = 403)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message,
        ], 200);
    }

    public function sendExpired($error, $code = 410)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendErrorWithCode($error, $code)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }
}