<?php declare(strict_types=1);

namespace PouleR\LinkfireAPI\Entity;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class Locale
 */
class Locale
{
    /** @var MediaServiceLink[] */
    private array $mediaServices = [];

    /**
     * @return MediaServiceLink[]
     */
    public function getMediaServices(): array
    {
        return $this->mediaServices;
    }

    /**
     * @param MediaServiceLink[] $mediaServices
     */
    public function setMediaServices(array $mediaServices): void
    {
        $normalizer = new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter());

        foreach ($mediaServices as $mediaService) {
            $this->mediaServices[] = $normalizer->denormalize($mediaService, MediaServiceLink::class);
        }
    }
}
