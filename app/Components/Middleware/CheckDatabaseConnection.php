<?php

namespace App\Components\Middleware;

use App\Components\Response\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Closure;
use Exception;

class CheckDatabaseConnection
{
    use ResponseFactory;

    /**
     * The paths that should not be checked for database connection stability.
     *
     * @var array
     */
    protected $except = [];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->isExceptArray($request)) {
            return $next($request);
        }

        if (!$this->isConnectionStable()) {
            return $this->internalServerError(
                [
                    'message' => 'Database Connection Error.',
                    'status' => 500
                ]
            );
        }

        return $next($request);
    }

    /**
     * Check if database connection is stable.
     *
     * @return bool
     */
    private function isConnectionStable()
    {
        try {
            if (DB::connection()->getPdo()) {
                return true;
            }
        } catch (Exception $exception) {
        }

        return false;
    }

    /**
     * Determine if the request has a URI that should be ignored in check database connection middleware.
     *
     * @param Request $request
     * @return bool
     */
    private function isExceptArray(Request $request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
