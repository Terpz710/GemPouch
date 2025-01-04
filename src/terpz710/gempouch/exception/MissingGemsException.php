<?php

declare(strict_types=1);

namespace terpz710\gempouch\exception;

use RuntimeException;

final class MissingGemsException extends RuntimeException {

    public function __construct(string $gems, int $code = 0, \Throwable $previous = null) {
        $message = "The required plugin '" . $gems . "' is missing, Download the plugin via Poggit or GitHub!";
        parent::__construct($message, $code, $previous);
    }
}
