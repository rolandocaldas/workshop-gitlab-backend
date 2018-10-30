<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 29/10/2018
 * Time: 10:46
 */

namespace Application\UseCase;


use Domain\Entity\CharacterRepository;

class CharacterLiked
{
    private $repository;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $characterId, bool $liked)
    {
        $character = $this->repository->findCharacter($characterId);
        $character->setLiked($liked);

        return $this->repository->save($character);
    }
}