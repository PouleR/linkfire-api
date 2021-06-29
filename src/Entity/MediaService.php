<?php declare(strict_types=1);

namespace PouleR\LinkfireAPI\Entity;

/**
 * Class MediaService
 */
class MediaService
{
    private string $id = '';
    private string $buttonType = '';
    private string $name = '';
    private string $description = '';

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
    public function getButtonType(): string
    {
        return $this->buttonType;
    }

    /**
     * @param string $buttonType
     */
    public function setButtonType(string $buttonType): void
    {
        $this->buttonType = $buttonType;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
