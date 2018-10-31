<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 25/10/2018
 * Time: 16:37
 */

namespace Domain\Service\MarvelApiClient;

class Criteria
{
    const CHARACTERS = 'characters';
    const COMICS = 'comics';
    const CREATORS = 'creators';
    const EVENTS = 'events';
    const SERIES = 'series';
    const STORIES = 'stories';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $entity;

    public function __construct(int $id, string $entity)
    {
        $this->isValidEntityOrFail($entity);
        $this->id = $id;
        $this->entity = $entity;

    }

    private function isValidEntityOrFail(string $entity)
    {
        if (!self::isValidEntityCriteria($entity)) {
            throw new \Exception($entity . " is not a valid entity");
        }
    }

    public function id() : int
    {
        return $this->id;
    }

    public function entity() : string
    {
        return $this->entity;
    }

    public static function isValidEntityCriteria(string $entity) : bool
    {
        return in_array($entity, [self::CHARACTERS, self::COMICS, self::CREATORS, self::EVENTS, self::SERIES, self::STORIES]);
    }
}