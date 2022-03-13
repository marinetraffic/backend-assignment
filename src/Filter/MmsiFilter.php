<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Elasticsearch\DataProvider\Filter\AbstractSearchFilter;
use DateTime;


class MmsiFilter extends AbstractSearchFilter
{
    protected function getQuery(string $property, array $values, ?string $nestedPath): array
    {
        $values = array_map('trim',explode(',',$values[0]));
        
        if (1 === \count($values)) {
            $termQuery = ['term' => [$property => reset($values)]];
        } else {
            $termQuery = ['terms' => [$property => $values]];
        }

        if (null !== $nestedPath) {
            $termQuery = ['nested' => ['path' => $nestedPath, 'query' => $termQuery]];
        }

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

            if ($hasAssociation || $this->isIdentifier($nestedResourceClass, $nestedProperty)) {
                $values = array_map([$this, 'getIdentifierValue'], $values, array_fill(0, \count($values), $nestedProperty));
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

        foreach ($this->getProperties($resourceClass) as $property) {
            [$type, $hasAssociation] = $this->getMetadata($resourceClass, $property);

            if (!$type) {
                continue;
            }

            foreach ([$property, "${property}[]"] as $filterParameterName) {
                $description[$filterParameterName] = [
                    'property' => $property,
                    'description' => 'A single MMSI to be found',
                    'type' => $hasAssociation ? 'string' : $this->getPhpType($type),
                    'required' => false,
                ];

                if (strpos($filterParameterName,'[') !== false) {
                    $description[$filterParameterName]['type'] = 'string';
                    $description[$filterParameterName]['description'] = 'Multiple MMSI using comma delimiter';
                }
            }
        }

        return $description;
    }
}
