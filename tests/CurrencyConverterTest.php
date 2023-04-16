<?php

namespace Tests;

use Classes\CurrencyConverter;

class CurrencyConverterTest extends \PHPUnit\Framework\TestCase
{
    private array $currencyExchangeRates = [
        'baseCurrency' => 'EUR',
        'exchangeRates' => [
            'EUR' => 1,
            'USD' => 5,
            'CHF' => 0.97,
            'CNY' => 2.3
        ]
    ];

    public static function providerConvert(): array
    {
        return [
            [
                2, 'USD',
                [
                    'USD' => 2, 'EUR' => 0.4, 'CHF' => 0.388, 'CNY' => 0.9199999999999999
                ]
            ],
            [
                3, 'CHF',
                [
                    'USD' => 15.463917525773198, 'EUR' => 3.0927835051546397, 'CHF' => 3, 'CNY' => 7.11340206185567
                ]
            ],
        ];
    }

    /**
     * @dataProvider providerConvert
     */
    public function testConvert(float $multiplyWith, string $fromCurrency, array $expected)
    {
        $currencyConverter = new CurrencyConverter($this->currencyExchangeRates);
        $result = json_decode($currencyConverter->convert($multiplyWith, $fromCurrency), true);

        $this->assertEquals($expected['EUR'], $result['exchangeRates']['EUR']);
        $this->assertEquals($expected['USD'], $result['exchangeRates']['USD']);
        $this->assertEquals($expected['CHF'], $result['exchangeRates']['CHF']);
        $this->assertEquals($expected['CNY'], $result['exchangeRates']['CNY']);
        $this->assertEquals($fromCurrency, $result['baseCurrency']);
        $this->assertCount(4, $result['exchangeRates']);
    }

}