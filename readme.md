### Laravel
#### step1. 請執行下列指令
```
git clone https://github.com/yiccc/laravel.git
cd laravel
docker compose up -d
```
#### step2. 開啟 PostMan，建立一個 POST 連線
- URL```http://127.0.0.1/api/order```
- Request
```
{
    "id": "A0000001",
    "name": "Melody Holiday Inn",
    "address": {
        "city": "taipei-city",
        "district": "da-an-district",
        "street": "fuxing-south-road"
    },
    "price": "2000",
    "currency": "USD"
}
```
- Response
```
{
    "id": "A0000001",
    "name": "Melody Holiday Inn",
    "address": {
        "city": "taipei-city",
        "district": "da-an-district",
        "street": "fuxing-south-road"
    },
    "price": "62000",
    "currency": "TWD"
}
```

#### 其它說明請參閱 [Project's README](https://github.com/yiccc/laravel/tree/master/app#readme)
