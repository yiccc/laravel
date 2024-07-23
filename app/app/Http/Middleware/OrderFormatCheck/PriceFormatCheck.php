<?php

namespace App\Http\Middleware\OrderFormatCheck;

use Closure;
use Illuminate\Support\Facades\Log;

class PriceFormatCheck
{
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
            $price = $request->json('price');

            if ($price > 2000) {
                return response('Price is over 2000.', 400);
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response('The system is busy, please try again later.', 500);
        }
    }
}
