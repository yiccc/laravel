<?php

namespace App\Http\Middleware\OrderFormatCheck;

use Closure;
use Illuminate\Support\Facades\Log;

class NameFormatCheck
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
            $name = $request->json('name');

            // 必須為英文字母
            $isAlphabet = preg_match('/(^[a-zA-Z ]*$)/', $name);
            if (!$isAlphabet) {
                return response('Name contains non-English characters.',400);
            }

            // 每個單字字首必須為大寫
            $words = explode(' ', $name);
            foreach ($words as $word) {
                if (!preg_match('/^[A-Z].*$/', $word)) {
                    return response('Name is not capitalized.',400);
                }
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response('The system is busy, please try again later.', 500);
        }
    }
}
