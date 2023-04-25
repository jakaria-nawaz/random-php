<?php

namespace Classes\helpers;

use Classes\SimpleXMLElement;

class StringToArrayConverter
{
    private function jsonToArray(string $json): array
    {
        return json_decode($json, true);
    }

    private function xmlToArray(SimpleXMLElement $xml): array
    {
        $json = json_encode($xml);
        return json_decode($json, true);
    }

    private function csvToArray(string $csv): array
    {
        return array_map('str_getcsv', explode("\n", $csv));
    }

    private function detectType(string $data): string
    {
        if (json_decode($data, true) && json_last_error() === JSON_ERROR_NONE) {
            return 'json';
        }

        if (simplexml_load_string($data) !== false) {
            return 'xml';
        }

        // returning csv if not json or xml
        // csv validation will be required if the data is coming from unreliable sources
        return 'csv';
    }

    public static function convert(string $conversionRates, string $type = ''): array
    {
        if (empty($conversionRates) || (!in_array($type, ['json', 'xml', 'csv', '']))) {
            return [];
        }

        $instance = new self();

        if (empty($type)) {
            $type = $instance->detectType($conversionRates);
        }
        $function = $type . 'ToArray';
        if ($type === 'xml') {
            $conversionRates = simplexml_load_string($conversionRates);
        }

        return $instance->{$function}($conversionRates);
    }
}