<?php

namespace QuimiCommerce\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

abstract class IntegrationTestCase extends TestCase
{
    protected function createMockHttpClient(array $responses): MockHttpClient
    {
        return new MockHttpClient($responses);
    }

    protected function createMockResponse(string $content, int $statusCode = 200, array $headers = []): MockResponse
    {
        return new MockResponse($content, [
            'http_code' => $statusCode,
            'response_headers' => $headers,
        ]);
    }
}
