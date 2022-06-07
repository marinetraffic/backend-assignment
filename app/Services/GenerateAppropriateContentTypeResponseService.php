<?php

namespace App\Services;

use App\ContentTypes\CsvHandler;
use App\ContentTypes\JsonHandler;
use App\ContentTypes\XmlHandler;
use App\Exceptions\UnsupportedContentType;
use App\Interfaces\GenerateAppropriateContentTypeResponseServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GenerateAppropriateContentTypeResponseService implements GenerateAppropriateContentTypeResponseServiceInterface
{
    protected array $available_content_types = [
        'text/csv' => CsvHandler::class,
        'application/json' => JsonHandler::class,
        'application/xml' => XmlHandler::class,
        'default' => JsonHandler::class,
    ];

    /**
     * @param string $accept_header
     * @param Builder $builder
     * @return Response|JsonResponse|StreamedResponse|Application|ResponseFactory
     * @throws UnsupportedContentType
     */
    public function select_output_handler(string $accept_header, Builder $builder): Response|JsonResponse|StreamedResponse|Application|ResponseFactory
    {
        if (!$accept_header || $accept_header === '*/*') {
            return (new $this->available_content_types['default'])->create_response($this->convertBuilderToArray($builder->get()));
        }

        if (array_key_exists($accept_header, $this->available_content_types)) {
            return (new $this->available_content_types[$accept_header])->create_response($this->convertBuilderToArray($builder->get()));
        }

        throw new UnsupportedContentType($accept_header);
    }

    /**
     * @param string $data
     * @return array
     */
    private function convertBuilderToArray(string $data): array
    {
        return json_decode($data, true);
    }
}
