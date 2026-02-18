<?php

function gcd(int $a, int $b): int
{
    $a = abs($a);
    $b = abs($b);
    while ($b !== 0) {
        $t = $b;
        $b = $a % $b;
        $a = $t;
    }
    return $a;
}

function jsonResponse(
    \Psr\Http\Message\ResponseInterface $response,
    mixed $data,
    int $status = 200
): \Psr\Http\Message\ResponseInterface {
    $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
}
