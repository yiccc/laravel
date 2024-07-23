<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    private $header = [
        'X-Requested-With' => 'XMLHttpRequest',
        'Content-Type' => 'application/json',
    ];

    /**
     * 情境-成功，但不需要轉換貨幣
     *
     * @return void
     */
    public function testTransformTWD()
    {
        $fakeData = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road',
            ],
            'price' => '2000',
            'currency' => 'TWD',
        ];
        $response = $this->withHeaders($this->header)->postJson(Route('order'), $fakeData);
        $response->assertOk();
    }

    /**
     * 情境-成功，需要轉換貨幣
     *
     * @return void
     */
    public function testTransformUSD()
    {
        $fakeData = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road',
            ],
            'price' => '2000',
            'currency' => 'USD',
        ];
        $response = $this->withHeaders($this->header)->postJson(Route('order'), $fakeData);
        $response->assertOk();
        $response->assertJson(['price' => '62000', 'currency' => 'TWD']);
    }

    /**
     * 情境-Name包含非英文字母情境
     *
     * @return void
     */
    public function testTransformNameContainsNonEnglishChar()
    {
        $fakeData = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn12345',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road',
            ],
            'price' => '2000',
            'currency' => 'USD',
        ];
        $response = $this->withHeaders($this->header)->postJson(Route('order'), $fakeData);
        $response->assertStatus(400);
        $response->assertSeeText('Name contains non-English characters.');
    }

    /**
     * 情境-Name每個單字的字首非大寫
     *
     * @return void
     */
    public function testTransformNameIsNotCapitalized()
    {
        $fakeData = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road',
            ],
            'price' => '2000',
            'currency' => 'USD',
        ];
        $response = $this->withHeaders($this->header)->postJson(Route('order'), $fakeData);
        $response->assertStatus(400);
        $response->assertSeeText('Name is not capitalized.');
    }

    /**
     * 情境-訂單金額超過2000
     *
     * @return void
     */
    public function testTransformAmountOver2000()
    {
        $fakeData = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road',
            ],
            'price' => '2001',
            'currency' => 'USD',
        ];
        $response = $this->withHeaders($this->header)->postJson(Route('order'), $fakeData);
        $response->assertStatus(400);
        $response->assertSeeText('Price is over 2000.');
    }

    /**
     * 情境-貨幣非TWD,USD
     *
     * @return void
     */
    public function testTransformCurrencyIsWrong()
    {
        $fakeData = [
            'id' => 'A0000001',
            'name' => 'Melody Holiday Inn',
            'address' => [
                'city' => 'taipei-city',
                'district' => 'da-an-district',
                'street' => 'fuxing-south-road',
            ],
            'price' => '2000',
            'currency' => 'JPD',
        ];
        $response = $this->withHeaders($this->header)->postJson(Route('order'), $fakeData);
        $response->assertStatus(400);
        $response->assertSeeText('Currency format is wrong.');
    }
}
