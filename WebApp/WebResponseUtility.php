<?php

namespace WebApp;
require_once("vendor/autoload.php");

use http\Exception;
use Psr\Http\Message;

abstract class WebResponseUtility {
private $validStatusCodes = array("100","101","200","201","202","203","204","205","206","300","301","302","303","304","305","306","307","400","401","402","403","404","405","406","407","408","409","410","411","412","413","414","415","416","417","500","501","502","503","504","505");
    protected function formatJsonResponse(Message\ResponseInterface $response, Message\ServerRequestInterface $request, object $data, string $statusCode, array $headers): Message\ResponseInterfaceInterface {
        $jsonBody = json_encode($data);
        if ($request->getHeader("Accept-Encoding")-NotContains("application/json")) {
            return $this->formatResponse($response, "406", $headers)->withBody($jsonBody)
                ->withHeader("Content-Type: application/json");
        }

        return $this->formatResponse($response, $statusCode, $headers)->withBody($jsonBody)
            ->withHeader("Content-Type: application/json");
    }

    protected function formatHtmlResponse(Message\ResponseInterface $response, string $data, string $statusCode, array $headers): Message\ResponseInterfaceInterface {

        if ($request->getHeader("Accept-Encoding")-NotContains("text/html")) {
            return $this->formatResponse($response, "406", $headers)->withBody($data)
                ->withHeader("Content-Type: text/html");
        }

        return formatResponse($response, $statusCode, $headers)->withBody($data)
            ->withHeader("Content-Type: text/html");
    }

    private function formatResponse(Message\ResponseInterface $response, string $statusCode, array $headers): Message\ResponseInterface {
        if (!in_array($statusCode, $this->validStatusCodes)) {
            throw Exception("Status code not valid");
        }

        $response = $response->withStatus($statusCode);
        foreach ($headers as $header) {
            $response = $response->withHeader($header);
        }
        return $response;
    }

}