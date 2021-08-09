<?php

declare(strict_types=1);

namespace PouleR\LinkfireAPI\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PouleR\LinkfireAPI\LinkfireAPI;
use PouleR\LinkfireAPI\LinkfireAPIClient;
use PHPUnit\Framework\TestCase;

/**
 * Class LinkfireAPITest
 */
class LinkfireAPITest extends TestCase
{
    /**
     * @var MockObject|LinkfireAPIClient
     */
    private $apiClient;
    private LinkfireAPI $linkfireAPI;

    /**
     *
     */
    public function setUp(): void
    {
        $this->apiClient = $this->createMock(LinkfireAPIClient::class);
        $this->linkfireAPI = new LinkfireAPI($this->apiClient);
    }

    /**
     *
     */
    public function testAuthenticate(): void
    {
        $response = new \stdClass();
        $response->accessToken = 'accessToken';

        $this->apiClient->expects(self::once())
            ->method('authenticate')
            ->with('id', 'secret')
            ->willReturn($response);

        $token = $this->linkfireAPI->authenticate('id', 'secret');
        self::assertEquals('accessToken', $token->getAccessToken());
    }
}
