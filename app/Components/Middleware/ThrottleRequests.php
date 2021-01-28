<?php

namespace App\Components\Middleware;

use App\Components\Response\ResponseFactory;
use Illuminate\Routing\Middleware\ThrottleRequests as BaseThrottleRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class ThrottleRequests extends BaseThrottleRequests
{
    use ResponseFactory;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param int|string $maxAttempts
     * @param float|int $decayMinutes
     * @param string $prefix
     * @return Response
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        $key = $prefix . $this->resolveRequestSignature($request);

        $maxAttempts = $this->resolveMaxAttempts($request, $maxAttempts);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return $this->buildMiddlewareResponse($key, $maxAttempts);
        }

        $this->limiter->hit($key, $decayMinutes * 60);

        $response = $next($request);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts)
        );
    }

    /**
     * Create a 'too many attempts' json response.
     *
     * @param string $key
     * @param int $maxAttempts
     * @return JsonResponse
     */
    protected function buildMiddlewareResponse($key, $maxAttempts)
    {
        $retryAfter = $this->getTimeUntilNextRetry($key);

        $headers = $this->getHeaders(
            $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );

        return $this->tooManyRequests(['message' => 'To many attempts.', 'status' => 429], $headers);
    }
}
