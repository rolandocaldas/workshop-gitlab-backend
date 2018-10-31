<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 25/10/2018
 * Time: 13:09
 */

namespace Domain\ValueObject;

class CharacterApiData
{
    private $id;
    private $name;
    private $description;
    private $thumbnail;

    public function __construct(int $id, string $name, string $description, Thumbnail $thumbnail)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->thumbnail = $thumbnail;
    }

    public function id() : int
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function description() : string
    {
        return $this->description;
    }

    public function thumbnail() : Thumbnail
    {
        return $this->thumbnail;
    }

    /**
     * @param array $apiData|null
     * @return CharacterApiData[]
     */
    public static function createCollectionFromData(?array $apiData) : array
    {
        if (empty($apiData)) {
            return null;
        }

        $collection = [];
        foreach ($apiData AS $character) {
            $collection[$character->id] = new self(
                $character->id,
                $character->name,
                $character->description,
                new Thumbnail($character->thumbnail->path, $character->thumbnail->extension)
            );
        }

        return $collection;
    }
}