<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Requests\OrderTransformRequest;
use Illuminate\Support\Facades\Log;

/**
 * 負責處理訂單請求
 */
class OrderController extends BaseController
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * 訂單幣別轉換處理
     *
     * @param OrderTransformRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function transform(OrderTransformRequest $request)
    {
        try {
            // 檢查必要欄位、型態
            $validated = $request->validated();
            // 貨幣轉換處理
            $order = $this->orderService->transformCurrency($validated);

            // output
            return response($order);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response('The system is busy, please try again later.', 500);
        }
    }
}
