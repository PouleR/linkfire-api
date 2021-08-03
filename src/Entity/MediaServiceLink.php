<?php declare(strict_types=1);

namespace PouleR\LinkfireAPI\Entity;

/**
 * Class MediaServiceLink
 */
class MediaServiceLink
{
    private string $mediaServiceTitle = '';
    private string $mediaServiceName = '';
    private string $mediaServiceId = '';
    private int $matchScore = 0;
    private ?string $url = '';
    private string $status = '';
    private bool $enabled = false;

    /**
     * @return string
     */
    public function getMediaServiceTitle(): string
    {
        return $this->mediaServiceTitle;
    }

    /**
     * @param string $mediaServiceTitle
     */
    public function setMediaServiceTitle(string $mediaServiceTitle): void
    {
        $this->mediaServiceTitle = $mediaServiceTitle;
    }

    /**
     * @return string
     */
    public function getMediaServiceName(): string
    {
        return $this->mediaServiceName;
    }

    /**
     * @param string $mediaServiceName
     */
    public function setMediaServiceName(string $mediaServiceName): void
    {
        $this->mediaServiceName = $mediaServiceName;
    }

    /**
     * @return string
     */
    public function getMediaServiceId(): string
    {
        return $this->mediaServiceId;
    }

    /**
     * @param string $mediaServiceId
     */
    public function setMediaServiceId(string $mediaServiceId): void
    {
        $this->mediaServiceId = $mediaServiceId;
    }

    /**
     * @return int
     */
    public function getMatchScore(): int
    {
        return $this->matchScore;
    }

    /**
     * @param int $matchScore
     */
    public function setMatchScore(int $matchScore): void
    {
        $this->matchScore = $matchScore;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
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
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }
}
