<?php

namespace Classes\services;

use Classes\Helpers\StringToArrayConverter;

class CurrencyConversionRates
{
    private const FILE_PATH = __DIR__. DIRECTORY_SEPARATOR . '..' .
    DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
    'data' . DIRECTORY_SEPARATOR . 'conversionData.json';

    public static function get($type = ''): array
    {
        return StringToArrayConverter::convert(self::getConversionData() ?? '', $type);
    }

    /**
     * can be implemented for an API call
     * and/or any kind of data format XML/CSV
     */
    private static function getConversionData(): bool|string
    {
        return file_get_contents(self::FILE_PATH);
    }

}