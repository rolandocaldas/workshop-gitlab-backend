<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 25/10/2018
 * Time: 10:50
 */

namespace Domain\Entity;

use Domain\ValueObject\CharacterApiData;
use Domain\ValueObject\Thumbnail;

class Character implements Exportable
{
    private $id;
    private $name;
    private $description;
    private $thumbnail;
    private $liked;

    /**
     * Character constructor.
     * @param int $id
     * @param string $name
     * @param string $description
     * @param Thumbnail $thumbnail
     * @param bool $liked
     */
    private function __construct(int $id, string $name, string $description, Thumbnail $thumbnail, bool $liked = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->thumbnail = $thumbnail;
        $this->liked = $liked;
    }

    public function __toString()
    {
        return "[" . $this->id . "] " . $this->name;
    }

    public function export(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'thumbnail' => $this->getThumbnail(),
            'liked' => $this->getLiked()
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Character
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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
     * @return Character
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
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
     * @return Character
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Thumbnail
     */
    public function getThumbnail(): Thumbnail
    {
        return $this->thumbnail;
    }

    /**
     * @param Thumbnail $thumbnail
     * @return Character
     */
    public function setThumbnail(Thumbnail $thumbnail): self
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * @return bool
     */
    public function getLiked() : bool
    {
        return $this->liked;
    }

    /**
     * @param bool $liked
     * @return Character
     */
    public function setLiked(bool $liked) : self
    {
        $this->liked = $liked;
        return $this;
    }

    /**
     * @param CharacterApiData $character
     * @return Character
     * @throws \Exception
     */
    public function updateInformation(CharacterApiData $character) : self
    {
        $this->isValidUpdateOrFail($character);

        $this
            ->setName($character->name())
            ->setDescription($character->description())
            ->setThumbnail($character->thumbnail());

        return $this;
    }

    private function isValidUpdateOrFail(CharacterApiData $data)
    {
        if ($data->id() !== $this->id) {
            throw new \Exception("Trying to update the character "
                . $this . " with the character "
                . $data->id());
        }
    }

    /**
     * @param CharacterApiData $character
     * @return Character
     */
    public static function createFromApiData(CharacterApiData $character) : self
    {
        return (new self(
            $character->id(),
            $character->name(),
            $character->description(),
            $character->thumbnail(),
            false
        ));
    }
}