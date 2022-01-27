<?php

namespace WebApp;
require_once("vendor/autoload.php");

use InvalidArgumentException;
use Psr\Http\Message;

abstract class WebRequestUtility
{
    // Check user credentials
    // Validate input params match expectedInputParams
    // Sanitize input strings
    protected function processRequestBody(Message\ServerRequestInterface $request, array|null $expectedInputParams, bool $expectNoInput): array|null|object
    {
        $inputParams = $request->getParsedBody();
        if ($expectNoInput) {
            if ($inputParams != null) {
                throw new InvalidArgumentException("Api does not expect any input");
            }
        }
        return $this->sanitizeInput($inputParams, $expectedInputParams);
    }

    private function sanitizeInput(string | object | array | null $input, array $expectedInputParams) : null | string | object | array {
        if ($input == null) {
            return $input;
        } else if (is_array($input)) {
            return $this->sanitizeArray($input);
        } else if (is_string($input)) {
            return $this->sanitizeString($input);
        } else {
            return $this->sanitizeObject($input, $expectedInputParams);
        }
    }

    private function sanitizeArray(array $items): array {
        return array_map(function ($item) {
            $this->sanitizeInput($item);
        }, $items);
    }

    private function sanitizeObject(object $item, array $expectedInputParams) : object {
        foreach ($expectedInputParams as $expectedInputParam) {
            if (empty($inputParams->$expectedInputParam)) {
                throw new InvalidArgumentException("Missing param" . $expectedInputParam);
            } else {
                $inputParams->$expectedInputParam = $this->sanitizeInput($inputParams->$expectedInputParam);
            }
        }
    }

    private function sanitizeString(string $input): string {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

//Methods to check that an input of a type is actually of that type e.g.
    protected function bool($val)
    {
        $val = filter_var($val, FILTER_VALIDATE_BOOLEAN);
        return $val;
    }
}
//methods to validate Urls and emails