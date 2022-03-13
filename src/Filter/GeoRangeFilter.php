<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Elasticsearch\DataProvider\Filter\AbstractSearchFilter;
use DateTime;


class GeoRangeFilter extends AbstractSearchFilter
{
    protected function getQuery(string $property, array $values, ?string $nestedPath): array
    {
        $values = array_map('trim',explode(',',$values[0]));
        $lat = $values[0] ?? 1;
        $lon = $values[1] ?? 1;
        $radius = $values[2] ?? '10';
        
        $termQuery = [
            'geo_distance' => [
                'distance'=> $radius. "km",
                'geolocation' => [
                    'lat' => $lat ,
                    'lon' => $lon
                ]
        ]];
        
        if (null !== $nestedPath) {
            $termQuery = ['nested' => ['path' => $nestedPath, 'query' => $termQuery]];
        }

        return $termQuery;
    }

    public function apply(array $clauseBody, string $resourceClass, ?string $operationName = null, array $context = []): array
    {
        $searches = [];

        foreach ($context['filters'] ?? [] as $property => $values) {

            $property = null === $this->nameConverter ? $property : $this->nameConverter->normalize($property, $resourceClass, null, $context);
            $nestedPath = $this->getNestedFieldPath($resourceClass, $property);
            $nestedPath = null === $nestedPath || null === $this->nameConverter ? $nestedPath : $this->nameConverter->normalize($nestedPath, $resourceClass, null, $context);

            if ($property !== 'geolocation') {
                continue;
            }

            $searches[] = $this->getQuery($property, [$values], $nestedPath);
        }

        if (!$searches) {
            return $clauseBody;
        }

        return array_merge_recursive($clauseBody, [
            'bool' => [
                'must' => $searches,
            ],
        ]);

      
    }

    public function getDescription(string $resourceClass): array
    {
        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description[$property] = [
                'property' => $property,
                'description' => 'Format: latitude,longitude,radius. <br/>Radius in km. Default radius (10km)',
                'type' => 'object',
                'required' => false,
            ];
        }

        return $description;
    }
}
