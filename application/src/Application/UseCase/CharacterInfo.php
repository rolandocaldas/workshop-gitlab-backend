<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 29/10/2018
 * Time: 10:22
 */

namespace Application\UseCase;

use Domain\Entity\CharacterRepository;

class CharacterInfo
{
    private $repository;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $characterId)
    {
        $character = $this->repository->findCharacter($characterId);
        return json_encode($character->export());
    }
}