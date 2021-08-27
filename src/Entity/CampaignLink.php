<?php declare(strict_types=1);

namespace PouleR\LinkfireAPI\Entity;

use DateTime;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class CampaignLink
 */
class CampaignLink
{
    private string $id = '';
    private string $url = '';
    private string $code = '';
    private array $tags = [];
    private string $boardId = '';
    private ?string $domainId = '';
    private DateTime $created;
    private DateTime $updated;
    private string $status = '';
    private bool $isScanning = false;

    /** @var Locale[] */
    private array $locales = [];

    /** @var Image[] */
    private array $images = [];
    private ?string $audio = '';
    private ?string $video = '';
    private ?string $externalId = '';
    private ?DateTime $releaseDate = null;
    private string $mediaType = '';
    private ?string $subMediaType = '';
    private ?string $title = '';
    private ?string $description = '';
    private string $baseUrl = '';
    private ?string $fallbackUrl = '';
    private ?string $upc = '';
    private ?string $isrc = '';

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return string|null
     */
    public function getDomainId(): ?string
    {
        return $this->domainId;
    }

    /**
     * @param string|null $domainId
     */
    public function setDomainId(?string $domainId): void
    {
        $this->domainId = $domainId;
    }

    /**
     * @return string
     */
    public function getBoardId(): string
    {
        return $this->boardId;
    }

    /**
     * @param string $boardId
     */
    public function setBoardId(string $boardId): void
    {
        $this->boardId = $boardId;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime|string $created
     */
    public function setCreated($created): void
    {
        if (is_string($created)) {
            $created = new DateTime($created);
        }

        $this->created = $created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * @param DateTime|string $updated
     */
    public function setUpdated($updated): void
    {
        if (is_string($updated)) {
            $updated = new DateTime($updated);
        }

        $this->updated = $updated;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function isScanning(): bool
    {
        return $this->isScanning;
    }

    /**
     * @param bool $isScanning
     */
    public function setIsScanning(bool $isScanning): void
    {
        $this->isScanning = $isScanning;
    }

    /**
     * @return Locale[]
     */
    public function getLocales(): array
    {
        return $this->locales;
    }

    /**
     * @param Locale[] $locales
     */
    public function setLocales(array $locales): void
    {
        $normalizer = new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter());

        foreach ($locales as $locale) {
            $this->locales[] = $normalizer->denormalize($locale, Locale::class);
        }
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param Image[] $images
     */
    public function setImages(array $images): void
    {
        $normalizer = new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter());

        foreach ($images as $image) {
            $this->images[] = $normalizer->denormalize($image, Image::class);
        }
    }

    /**
     * @return string|null
     */
    public function getAudio(): ?string
    {
        return $this->audio;
    }

    /**
     * @param string|null $audio
     */
    public function setAudio(?string $audio): void
    {
        $this->audio = $audio;
    }

    /**
     * @return string|null
     */
    public function getVideo(): ?string
    {
        return $this->video;
    }

    /**
     * @param string|null $video
     */
    public function setVideo(?string $video): void
    {
        $this->video = $video;
    }

    /**
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    /**
     * @param string|null $externalId
     */
    public function setExternalId(?string $externalId): void
    {
        $this->externalId = $externalId;
    }

    /**
     * @return DateTime|null
     */
    public function getReleaseDate(): ?DateTime
    {
        return $this->releaseDate;
    }

    /**
     * @param DateTime|string|null $releaseDate
     */
    public function setReleaseDate($releaseDate): void
    {
        if (is_string($releaseDate)) {
            $releaseDate = new DateTime($releaseDate);
        }

        $this->releaseDate = $releaseDate;
    }

    /**
     * @return string
     */
    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    /**
     * @param string $mediaType
     */
    public function setMediaType(string $mediaType): void
    {
        $this->mediaType = $mediaType;
    }

    /**
     * @return string|null
     */
    public function getSubMediaType(): ?string
    {
        return $this->subMediaType;
    }

    /**
     * @param string|null $subMediaType
     */
    public function setSubMediaType(?string $subMediaType): void
    {
        $this->subMediaType = $subMediaType;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string|null
     */
    public function getFallbackUrl(): ?string
    {
        return $this->fallbackUrl;
    }

    /**
     * @param string|null $fallbackUrl
     */
    public function setFallbackUrl(?string $fallbackUrl): void
    {
        $this->fallbackUrl = $fallbackUrl;
    }

    /**
     * @return string|null
     */
    public function getUpc(): ?string
    {
        return $this->upc;
    }

    /**
     * @param string|null $upc
     */
    public function setUpc(?string $upc): void
    {
        $this->upc = $upc;
    }

    /**
     * @return string|null
     */
    public function getIsrc(): ?string
    {
        return $this->isrc;
    }

    /**
     * @param string|null $isrc
     */
    public function setIsrc(?string $isrc): void
    {
        $this->isrc = $isrc;
    }
}
