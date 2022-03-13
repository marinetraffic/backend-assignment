<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Elasticsearch\DataProvider\Filter\AbstractSearchFilter;
use DateTime;


class DateFilter extends AbstractSearchFilter
{
    protected function getQuery(string $property, array $values, ?string $nestedPath): array
    {
        $timestamp = new DateTime($values[0]);
        $termQuery = ['term' => ['timestamp' => $timestamp->getTimestamp()]];
        return $termQuery;
    }

    public function apply(array $clauseBody, string $resourceClass, ?string $operationName = null, array $context = []): array
    {
        $searches = [];

        foreach ($context['filters'] ?? [] as $property => $values) {
            [$type, $hasAssociation, $nestedResourceClass, $nestedProperty] = $this->getMetadata($resourceClass, $property);

            if (!$type || !$values = (array) $values) {
                continue;
            }

            $property = null === $this->nameConverter ? $property : $this->nameConverter->normalize($property, $resourceClass, null, $context);
            $nestedPath = $this->getNestedFieldPath($resourceClass, $property);
            $nestedPath = null === $nestedPath || null === $this->nameConverter ? $nestedPath : $this->nameConverter->normalize($nestedPath, $resourceClass, null, $context);

            $searches[] = $this->getQuery($property, $values, $nestedPath);
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
                'description' => 'Format: 2013-07-01T17:42:00Z',
                'type' => DateTimeInterface::class,
                'required' => false,
            ];
        }

        return $description;
    }
}
