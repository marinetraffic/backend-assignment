<?php

use App\Kernel;

// const XML_PI_NODE = 6;
// const XML_COMMENT_NODE  = 7;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
