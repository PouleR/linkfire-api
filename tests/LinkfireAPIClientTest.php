<?php

declare(strict_types=1);

namespace PouleR\LinkfireAPI\Tests;

use PouleR\LinkfireAPI\Exception\LinkfireAPIException;
use PouleR\LinkfireAPI\LinkfireAPIClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * Class LinkfireAPIClientTest
 */
class LinkfireAPIClientTest extends TestCase
{
    /**
     * @throws LinkfireAPIException
     */
    public function testApiRequest()
    {
        $response = new MockResponse(json_encode(['apiData']));
        $httpClient = new MockHttpClient([$response]);
        $client = new LinkfireAPIClient($httpClient);

        $client->setAccessToken('access.token.123');
        $apiResponse = $client->apiRequest('POST', '/testing123', ['header1' => 'test'], 'bodyData');

        self::assertEquals(['apiData'], $apiResponse);
        self::assertEquals('POST', $response->getRequestMethod());
        self::assertEquals('https://api.linkfire.com/testing123', $response->getRequestUrl());

        $requestOptions = $response->getRequestOptions();
        self::assertEquals('bodyData', $requestOptions['body']);
        self::assertContains('header1: test', $requestOptions['headers']);
        self::assertContains('Authorization: Bearer access.token.123', $requestOptions['headers']);
        self::assertContains('Accept: application/json', $requestOptions['headers']);
        self::assertContains('Api-Version: v1.0', $requestOptions['headers']);
    }

    /**
     * @throws LinkfireAPIException
     */
    public function testApiRequestException()
    {
        $callback = function () {
            throw new TransportException('Something is going wrong..', 501);
        };

        $httpClient = new MockHttpClient($callback);
        $apiClient = new LinkfireAPIClient($httpClient);

        $this->expectException(LinkfireAPIException::class);
        $this->expectExceptionMessage('API request: (/unittest), Something is going wrong..');
        $this->expectExceptionCode(501);

        $apiClient->apiRequest('GET', '/unittest');
    }

    /**
     * @throws LinkfireAPIException
     */
    public function testAuthenticate()
    {
        $response = new MockResponse(json_encode(['authenticated']));
        $httpClient = new MockHttpClient([$response]);
        $client = new LinkfireAPIClient($httpClient);

        $authenticated = $client->authenticate('client.id', 'client.secret');

        self::assertEquals(['authenticated'], $authenticated);
        self::assertEquals('https://auth.linkfire.com/identity/connect/token', $response->getRequestUrl());
        self::assertEquals('POST', $response->getRequestMethod());

        $requestOptions = $response->getRequestOptions();
        self::assertEquals('grant_type=client_credentials&client_id=client.id&client_secret=client.secret&scope=public.api', $requestOptions['body']);
        self::assertContains('cache-control: no-cache', $requestOptions['headers']);
        self::assertContains('content-type: application/x-www-form-urlencoded', $requestOptions['headers']);
        self::assertContains('Accept: */*', $requestOptions['headers']);
    }

    /**
     * @throws LinkfireAPIException
     */
    public function testAuthenticateException(): void
    {
        $callback = function () {
            throw new TransportException('Error!', 500);
        };

        $httpClient = new MockHttpClient($callback);
        $apiClient = new LinkfireAPIClient($httpClient);

        $this->expectException(LinkfireAPIException::class);
        $this->expectExceptionMessage('Authenticate: Error!');
        $this->expectExceptionCode(500);

        $apiClient->authenticate('unit', 'test');
    }
}
