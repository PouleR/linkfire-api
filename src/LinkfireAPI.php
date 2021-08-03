<?php declare(strict_types=1);

namespace PouleR\LinkfireAPI;

use Exception;
use PouleR\LinkfireAPI\Entity\AccessToken;
use PouleR\LinkfireAPI\Entity\BoardDomain;
use PouleR\LinkfireAPI\Entity\CampaignLink;
use PouleR\LinkfireAPI\Entity\MediaService;
use PouleR\LinkfireAPI\Entity\ScanningStatus;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Throwable;

/**
 * Class LinkfireAPI
 */
class LinkfireAPI
{
    protected LinkfireAPIClient $client;
    protected ?LoggerInterface $logger;
    protected ObjectNormalizer $normalizer;

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
        } catch (Exception | Throwable $exception) {
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
        } catch (Exception | Throwable $exception) {
            $this->logError(__FUNCTION__, $exception);
        }

        return [];
    }

    /**
     * @param string $boardId
     * @param array  $params
     *
     * @return MediaService[]
     */
    public function getBoardMediaServices(string $boardId, array $params = []): array
    {
        $allowedParameters = [
            'page',
            'pageSize',
        ];

        $filteredParameters = $this->filterAllowedParameters($params, $allowedParameters);

        $url = sprintf('/settings/boards/%s/mediaservices', $boardId);
        if (count($filteredParameters)) {
            $url .= sprintf('?%s', http_build_query($filteredParameters));
        }

        $mediaServices = [];

        try {
            $response = $this->client->apiRequest('GET', $url);

            foreach ($response['data'] as $data) {
                $mediaServices[] = $this->normalizer->denormalize($data, MediaService::class);
            }

            return $mediaServices;
        } catch (Exception | Throwable $exception) {
            $this->logError(__FUNCTION__, $exception);
        }

        return [];
    }

    /**
     * @param array $params
     *
     * @return MediaService[]
     */
    public function getAvailableMediaServices(array $params = []): array
    {
        $allowedParameters = [
            'description',
            'name',
            'page',
            'pageSize',
        ];

        $filteredParameters = $this->filterAllowedParameters($params, $allowedParameters);
        $mediaServices = [];

        try {
            $url = sprintf('/settings/mediaservices%s', count($filteredParameters) ? sprintf('?%s', http_build_query($filteredParameters)) : '');
            $response = $this->client->apiRequest('GET', $url);

            foreach ($response['data'] as $data) {
                $mediaServices[] = $this->normalizer->denormalize($data, MediaService::class);
            }

            return $mediaServices;
        } catch (Exception | Throwable $exception) {
            $this->logError(__FUNCTION__, $exception);
        }

        return [];
    }

    /**
     * @param string $boardId
     * @param array  $params
     *
     * @return CampaignLink|null
     */
    public function createCampaignLink(string $boardId, array $params = []): ?CampaignLink
    {
        $allowedParameters = [
            'externalId',
            'artist',
            'artistAlternative',
            'album',
            'albumAlternative',
            'track',
            'trackAlternative',
            'distributor',
            'genre',
            'duration',
            'image',
            'playList',
            'creator',
            'baseUrl',
            'upc',
            'isrc',
            'service',
            'isoCode',
            'mediaType',
            'subMediaType',
            'title',
            'code',
            'tags',
            'domainId',
            'audio',
            'video',
            'skipSearch',
            'skipMetadataSearch',
            'locales',
        ];

        try {
            $filteredParameters = $this->filterAllowedParameters($params, $allowedParameters);
            $response = $this->client->apiRequest('POST', sprintf('/campaigns/boards/%s/links', $boardId), ['Content-Type' => 'application/json'], json_encode($filteredParameters));

            return $this->normalizer->denormalize($response['data'], CampaignLink::class);
        } catch (Exception | Throwable $exception) {
            $this->logError(__FUNCTION__, $exception);
        }

        return null;
    }

    /**
     * @param string $boardId
     * @param array  $params
     *
     * @return CampaignLink[]
     */
    public function getCampaignLinks(string $boardId, array $params = []): array
    {
        $allowedParameters = [
            'artistId',
            'creatorId',
            'domainId',
            'batchId',
            'title',
            'code',
            'tag',
            'createdDate',
            'sort',
            'page',
            'pageSize',
        ];

        $links = [];
        $filteredParameters = $this->filterAllowedParameters($params, $allowedParameters);
        $url = sprintf('/campaigns/boards/%s/links', $boardId);

        if (count($filteredParameters)) {
            $url .= sprintf('?%s', http_build_query($filteredParameters));
        }

        try {
            $response = $this->client->apiRequest('GET', $url);

            foreach ($response['data'] as $data) {
                $links[] = $this->normalizer->denormalize($data, CampaignLink::class);
            }

            return $links;
        } catch (Exception | Throwable $exception) {
            $this->logError(__FUNCTION__, $exception);
        }

        return [];
    }

    /**
     * @param string $boardId
     * @param string $linkId
     *
     * @return CampaignLink
     */
    public function getCampaignLinkById(string $boardId, string $linkId): ?CampaignLink
    {
        try {
            $response = $this->client->apiRequest('GET', sprintf('/campaigns/boards/%s/links/%s', $boardId, $linkId));

            return $this->normalizer->denormalize($response['data'], CampaignLink::class);
        } catch (Exception | Throwable $exception) {
            $this->logError(__FUNCTION__, $exception);
        }

        return null;
    }

    /**
     * @param string $boardId
     * @param string $linkId
     *
     * @return null|ScanningStatus
     */
    public function getScanningStatus(string $boardId, string $linkId): ?ScanningStatus
    {
        $url = sprintf('/campaigns/boards/%s/links/%s/scan/status', $boardId, $linkId);

        try {
            $response = $this->client->apiRequest('GET', $url);

            return $this->normalizer->denormalize($response['data'], ScanningStatus::class);
        } catch (Exception | Throwable $exception) {
            $this->logError(__FUNCTION__, $exception);
        }

        return null;
    }

    /**
     * @param string    $method
     * @param Exception $exception
     */
    private function logError(string $method, Exception $exception)
    {
        $this->logger->error('Error during API Request', [
            'method' => $method,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ]);
    }

    /**
     * @param array $params
     * @param array $allowedParameters
     *
     * @return array
     */
    private function filterAllowedParameters(array $params, array $allowedParameters): array
    {
        return array_filter(
            $params,
            function ($key) use ($allowedParameters) {
                return in_array($key, $allowedParameters);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
