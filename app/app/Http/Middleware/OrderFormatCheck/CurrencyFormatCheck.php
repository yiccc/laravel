<?php

namespace App\Http\Middleware\OrderFormatCheck;

use Closure;
use Illuminate\Support\Facades\Log;

class CurrencyFormatCheck
{
    private static $allow_currency = ['USD', 'TWD'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $currency = $request->json('currency');

            if (!in_array($currency, self::$allow_currency)) {
                return response('Currency format is wrong.', 400);
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response('The system is busy, please try again later.', 500);
        }
    }
}
