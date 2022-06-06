<?php

namespace App\Interfaces;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface GenerateAppropriateContentTypeResponseServiceInterface
{
    public function select_output_handler(string $accept_header, Builder $builder): Response|JsonResponse|StreamedResponse|Application|ResponseFactory;
}
