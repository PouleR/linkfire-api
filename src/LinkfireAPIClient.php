<?php declare(strict_types=1);

namespace PouleR\LinkfireAPI;

use PouleR\LinkfireAPI\Exception\LinkfireAPIException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class LinkfireAPIClient
  */
class LinkfireAPIClient
{
    private const API_URL = 'https://api.linkfire.com';
    private const AUTH_ENDPOINT = 'https://auth.linkfire.com/identity/connect/token';

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $accessToken = '';

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param string $clientId
     * @param string $clientSecret
     *
     * @return object
     *
     * @throws LinkfireAPIException
     */
    public function authenticate(string $clientId, string $clientSecret)
    {
        $headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded'
        ];

        $loginBody = sprintf('grant_type=client_credentials&client_id=%s&client_secret=%s&scope=public.api', $clientId, $clientSecret);

        try {
            $response = $this->httpClient->request(
                'POST',
                self::AUTH_ENDPOINT,
                [
                    'headers' => $headers,
                    'body' => $loginBody,
                ]
            );

            return json_decode($response->getContent(), true);
        } catch (ServerExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | TransportExceptionInterface | \Exception $exception) {
            throw new LinkfireAPIException(
                'Authenticate: ' . $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    /**
     * @param string                                      $method
     * @param string                                      $service
     * @param array                                       $headers
     * @param array|string|resource|\Traversable|\Closure $body
     *
     * @return object
     *
     * @throws LinkfireAPIException
     */
    public function apiRequest(string $method, string $service, array $headers = [], $body = null)
    {
        $requestUrl = sprintf('%s%s', self::API_URL, $service);

        try {
            $headers = array_merge($headers, $this->getDefaultHeaders());
            $response = $this->httpClient->request($method, $requestUrl, ['headers' => $headers, 'body' => $body]);

            return json_decode($response->getContent(), true);
        } catch (ServerExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | TransportExceptionInterface $exception) {
            throw new LinkfireAPIException(
                'API request: (' . $service . '), ' . $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    /**
     * @return string[]
     */
    private function getDefaultHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Accept' => 'application/json',
            'Api-Version' => 'v1.0',
        ];
    }
}
