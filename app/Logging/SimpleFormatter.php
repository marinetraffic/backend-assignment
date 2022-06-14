<?php

namespace App\Logging;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;

class SimpleFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param Logger $logger
     * @return void
     */
    public function __invoke(Logger $logger){
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(
                new LineFormatter("[%datetime%] %message% %context% \n")
            );
        }
    }
}
