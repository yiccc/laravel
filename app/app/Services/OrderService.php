<?php

namespace App\Services;

/**
 * 訂單商業邏輯
 */
class OrderService
{

    /**
     * 貨幣轉換處理
     *
     * @param $order array 訂單
     * @return array 處理後的訂單
     */
    public function transformCurrency(array $order): array {
        $currency = $order['currency'];
        $price = $order['price'];

        // 當幣別為 USD，則將幣別、金額轉換為 TWD
        if ($currency === 'USD') {
            $order['price'] = strval($price * 31);
            $order['currency'] = 'TWD';
        }

        return $order;
    }
}
