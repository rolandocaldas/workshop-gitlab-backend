<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 29/10/2018
 * Time: 10:22
 */

namespace Application\UseCase;

use Domain\Entity\Character;
use Domain\Entity\CharacterRepository;

class CharacterList
{
    private $repository;

    /**
     * @var Character[]
     */
    private $characters;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $this->characters = $this->repository->recoverAllCharacters();
        $data = [];
        foreach ($this->characters AS $character) {
            $data[] = $character->export();
        }
        return $data;
    }
}