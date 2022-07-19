<?php

namespace App\Responders;

use App\Interfaces\ResponseInterface;

abstract class HttpResponder{

    abstract public function getResponder(): ResponseInterface;
}