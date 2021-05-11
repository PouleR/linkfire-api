<?php declare(strict_types=1);

namespace PouleR\LinkfireAPI;

use PouleR\LinkfireAPI\Entity\AccessToken;
use PouleR\LinkfireAPI\Entity\BoardDomain;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class LinkfireAPI
 */
class LinkfireAPI
{
    /**
     * @var string
     */
    private $clientId = '';

    /**
     * @var string
     */
    private $deviceId = '';

    /**
     * @var LinkfireAPIClient
     */
    protected $client;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ObjectNormalizer
     */
    protected $normalizer;

    /**
     * @param LinkfireAPIClient    $client
     * @param LoggerInterface|null $logger
     */
    public function __construct(LinkfireAPIClient $client, LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->logger = $logger;

        if (!$this->logger) {
            $this->logger = new NullLogger();
        }

        $this->normalizer = new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter());
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->client->setAccessToken($accessToken);
    }

    /**
     * @param string $clientId
     * @param string $clientSecret
     *
     * @return AccessToken|null
     */
    public function authenticate(string $clientId, string $clientSecret): ?AccessToken
    {
        try {
            $response = $this->client->authenticate($clientId, $clientSecret);

            return $this->normalizer->denormalize($response, AccessToken::class);
        } catch (\Exception | \Throwable $exception) {
            $this->logError(__FUNCTION__, $exception);
        }

        return null;
    }

    /**
     * @param string $boardId
     *
     * @return BoardDomain[]
     */
    public function getBoardDomains(string $boardId): array
    {
        $url = sprintf('/settings/boards/%s/domains', $boardId);

        $boardDomains = [];

        try {
            $response = $this->client->apiRequest('GET', $url);

            foreach ($response['data'] as $data) {
                $boardDomains[] = $this->normalizer->denormalize($data, BoardDomain::class);
            }

            return $boardDomains;
        } catch (\Exception | \Throwable $exception) {
            $this->logError(__FUNCTION__, $exception);
        }

        return [];
    }

    /**
     * @param string     $method
     * @param \Exception $exception
     */
    private function logError(string $method, \Exception $exception)
    {
        $this->logger->error('Error during API Request', [
            'method' => $method,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ]);
    }
}
