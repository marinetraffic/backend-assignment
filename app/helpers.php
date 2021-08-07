<?php

if (!function_exists('array_to_xml')) {
    function array_to_xml(array $data, SimpleXMLElement $childXml = null): string
    {
        $xml = $childXml;

        if ($xml === null) {
            $xml = new SimpleXMLElement('<root/>');
        }

        foreach ($data as $key => $row) {
            if (is_array($row)) {
                array_to_xml($row, $xml->addChild(is_numeric($key) ? 'row' : $key));
            } else {
                $xml->addChild($key, $row);
            }
        }

        return $xml->asXML();
    }
}

if (!function_exists('array_to_csv')) {
    function array_to_csv(array $data): string
    {
        $csv = new \SplTempFileObject();

        // Headers
        $csv->fputcsv(array_keys(current($data)));

        // Data
        foreach ($data as $row) {
            $csv->fputcsv($row);
        }

        $length = $csv->ftell();
        $csv->fseek(0);

        return rtrim($csv->fread($length), "\r\n");
    }
}

if (!function_exists('array_to_hal_json')) {
    function array_to_hal_json(array $data, string $path, string $queryString, array $linkKeys = []): array
    {
        // Inject links to data
        if ($linkKeys) {
            foreach ($data as $key => $entry) {
                $links = [];

                foreach ($linkKeys as $title => $linkKey) {
                    $linkMultiple = [];

                    foreach ($linkKey as $subLinkKey) {
                        $linkMultiple[] = sprintf('%s=%s', $subLinkKey, $entry[$subLinkKey]);
                    }

                    $links[$title] = sprintf('%s?%s', $path, implode('&', $linkMultiple));
                }

                $data[$key] = ['_links' => $links] + $entry;
            }
        }

        return [
            '_links' => [
                'self' => ['href' => sprintf('%s?%s', $path, $queryString)],
            ],
            '_embedded' => [
                'rows' => $data
            ],
        ];
    }
}
