<?php

namespace App\Libs\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResponseJSON {
    /**
     * 200 OK Response without data object
     * @param string $msg
    */
    public static function success ($msg) : JsonResponse {
        return response()->json([
            'code_status' => Response::HTTP_OK,
            'msg_status' => $msg,
        ], Response::HTTP_OK);
    }

    /**
     * 200 OK Response with data
     * @param string $msg
     * @param array $data
    */
    public static function successWithData ($msg, $data) : JsonResponse {
        return response()->json([
            'code_status' => Response::HTTP_OK,
            'msg_status' => $msg,
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * 400 Bad Request Response
     * @param string $msg
    */
    public static function badRequest ($msg) : JsonResponse {
        return response()->json([
            'code_status' => Response::HTTP_BAD_REQUEST,
            'msg_status' => $msg,
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * 401 Unauthorized Response
     * @param string $msg
    */
    public static function unauthorized ($msg) : JsonResponse {
        return response()->json([
            'code_status' => Response::HTTP_UNAUTHORIZED,
            'msg_status' => $msg,
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * 403 Forbidden Response
     * @param string $msg
    */
    public static function forbidden ($msg) : JsonResponse {
        return response()->json([
            'code_status' => Response::HTTP_FORBIDDEN,
            'msg_status' => $msg,
        ], Response::HTTP_FORBIDDEN);
    }

    /**
     * 404 Not Found Response
     * @param string $msg
    */
    public static function notFound ($msg) : JsonResponse {
        return response()->json([
            'code_status' => Response::HTTP_NOT_FOUND,
            'msg_status' => $msg,
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * 422 Unprocessable Entity Response
     * @param string $msg
    */
    public static function unprocessableEntity ($msg) : JsonResponse {
        return response()->json([
            'code_status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'msg_status' => $msg,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * 500 Internal Server Error Response
     * @param string $msg
    */
    public static function internalServerError ($msg) : JsonResponse {
        return response()->json([
            'code_status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'msg_status' => $msg,
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
