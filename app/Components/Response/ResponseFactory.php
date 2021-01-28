<?php

namespace App\Components\Response;

use Illuminate\Http\JsonResponse;

trait ResponseFactory
{
    /**
     * Return OK response with status code 200.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function ok($data, $headers = [], $options = 0)
    {
        return response()->json($data, 200, $headers, $options);
    }

    /**
     * Return CREATED response with status code 201.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function created($data, $headers = [], $options = 0)
    {
        return response()->json($data, 201, $headers, $options);
    }

    /**
     * Return NO CONTENT response with status code 204.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function noContent($data, $headers = [], $options = 0)
    {
        return response()->json($data, 204, $headers, $options);
    }

    /**
     * Return MOVE PERMANENTLY response with status code 301.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function movedPermanently($data, $headers = [], $options = 0)
    {
        return response()->json($data, 301, $headers, $options);
    }

    /**
     * Return MOVE TEMPORARILY response with status code 302.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function movedTemporarily($data, $headers = [], $options = 0)
    {
        return response()->json($data, 302, $headers, $options);
    }

    /**
     * Return BAD REQUEST response with status code 400.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function badRequest($data, $headers = [], $options = 0)
    {
        return response()->json($data, 400, $headers, $options);
    }

    /**
     * Return UNAUTHORIZED response with status code 401.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function unauthorized($data, $headers = [], $options = 0)
    {
        return response()->json($data, 401, $headers, $options);
    }

    /**
     * Return PAYMENT REQUIRED response with status code 402.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function paymentRequired($data, $headers = [], $options = 0)
    {
        return response()->json($data, 402, $headers, $options);
    }

    /**
     * Return FORBIDDEN response with status code 403.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function forbidden($data, $headers = [], $options = 0)
    {
        return response()->json($data, 403, $headers, $options);
    }

    /**
     * Return NOT FOUND response with status code 404.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function notFound($data, $headers = [], $options = 0)
    {
        return response()->json($data, 404, $headers, $options);
    }

    /**
     * Return UNPROCESSABLE ENTITY response with status code 422.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function unprocessableEntity($data, $headers = [], $options = 0)
    {
        return response()->json($data, 422, $headers, $options);
    }

    /**
     * Return TO MANY REQUESTS response with status code 429.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function tooManyRequests($data, $headers = [], $options = 0)
    {
        return response()->json($data, 429, $headers, $options);
    }

    /**
     * Return INTERNAL SERVER ERROR response with status code 500.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function internalServerError($data, $headers = [], $options = 0)
    {
        return response()->json($data, 500, $headers, $options);
    }

    /**
     * Return SERVICE UNAVAILABLE response with status code 503.
     *
     * @param array $data
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    protected function serviceUnavailable($data, $headers = [], $options = 0)
    {
        return response()->json($data, 503, $headers, $options);
    }
}
