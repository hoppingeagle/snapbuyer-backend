<?php namespace Snapbuyer\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class DebugMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $debug = Config::get('app.debug');

        if (!$debug) {
            return redirect('/');
        }

        return $next($request);
    }

}
