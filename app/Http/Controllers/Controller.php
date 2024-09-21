<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Caching helper function for controllers.
     * 
     * This function checks if the cache for a given key exists.
     * If it exists, it returns the cached value, otherwise, it will execute
     * the callback function to cache the result for a given time.
     * 
     * @param string $cacheKey
     * @param int $cacheTimeInMinutes
     * @param callable $callback
     * 
     * @return mixed
     */
    protected function cacheData(string $cacheKey, int $cacheTimeInMinutes, callable $callback)
    {
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $result = $callback();
        Cache::put($cacheKey, $result, $cacheTimeInMinutes);
        return $result;
    }

    /**
     * Send a success response.
     *
     * @param string $message
     * @param array $data
     * @param int $statusCode
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendSuccessResponse(string $message, array $data = [], int $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Send an error response.
     *
     * @param string $message
     * @param int $statusCode
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendErrorResponse(string $message, int $statusCode = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }
}
