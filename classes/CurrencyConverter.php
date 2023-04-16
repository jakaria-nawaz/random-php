<?php

namespace Classes;

class CurrencyConverter
{
    public array $conversionRates = [];

    public function __construct(array $conversionRates)
    {
        $this->conversionRates = $conversionRates;
    }

    public function convert(float $amount, string $currency): string
    {
        if (!array_key_exists($currency, $this->conversionRates['exchangeRates'])) {
            return 'Currency Not Available';
        }

        $this->conversionRates['exchangeRates'] = array_map(function ($value) use ($currency, $amount) {
            return ($value / $this->conversionRates['exchangeRates'][$currency]) * $amount;
        }, $this->conversionRates['exchangeRates']);
        $this->conversionRates['baseCurrency'] = $currency;
        return json_encode($this->conversionRates);
    }
}