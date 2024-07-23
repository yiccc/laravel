## Laravel Project

### Database
##### 1. Query SQL
```sql
SELECT a.bnb_id, b.name AS bnb_name, SUM(a.amount) AS may_amount
FROM orders a 
JOIN bnbs b 
WHERE a.bnb_id = b.id
AND a.create_at >= '2023-05-01 00:00:00' AND a.create_at <= '2023-05-31 23:59:59' 
AND a.currency = 'TWD'
GROUP BY a.bnb_id
ORDER BY may_amount DESC LIMIT 10;
```
##### 2. 優化
加上 explain 執行 SELECT 語法，透過分析結果優化，例如是否有使用到 index。

### API
- SRP：單一職責原則
- OCP：開放封閉原則

#### Classes
- App\Http\Controllers\OrderController```訂單請求處理```
- App\Http\Requests\OrderTransformRequest```請求資料基本檢查```
- App\Services\OrderService```訂單貨幣轉換處理```
- App\Http\Middleware\OrderFormatCheck\NameFormatCheck```訂單的姓名格式檢查```
- App\Http\Middleware\OrderFormatCheck\PriceFormatCheck```訂單的金額格式檢查```
- App\Http\Middleware\OrderFormatCheck\CurrencyFormatCheck```訂單的貨幣格式檢查```
- Tests\Feature\OrderControllerTest```測試程式```
