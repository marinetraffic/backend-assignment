<?php

namespace App\Interfaces;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface ContentTypeHandlerInterface
{
    public function create_response(array $array_of_data): StreamedResponse|JsonResponse|Application|ResponseFactory|Response;
}
