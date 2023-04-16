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

    public static function convert(string $conversionRates, $type = ''): array
    {
        if (empty($conversionRates) || (!in_array($type, ['json', 'xml', 'csv', '']))) {
            return [];
        }

        $instance = new self();

        if (!empty($type)) {
            $function = $type . 'ToArray';
            if ($type === 'xml') {
                $conversionRates = simplexml_load_string($conversionRates);
            }
            return $instance->{$function}($conversionRates);
        }

        $json = json_decode($conversionRates, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $json;
        }

        $xml = simplexml_load_string($conversionRates);
        if ($xml !== false) {
            return $instance->xmlToArray($xml);
        }

        // returning csv if not json or xml
        // csv validation will be required if the data is coming from unreliable sources
        return $instance->csvToArray($conversionRates);
    }
}