<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 25/10/2018
 * Time: 17:22
 */

namespace Application\Service;

use Domain\Entity\Character;
use Domain\Service\MarvelApiClient\Criteria;
use Domain\Service\MarvelApiClient\Client;
use Domain\ValueObject\CharacterApiData;
use Domain\Entity\CharacterRepository;

class ImportCharactersFromMarvel
{
    private $client;
    private $repository;

    /**
     * @var Character[]
     */
    private $entities;

    public function __construct(Client $client, CharacterRepository $repository)
    {
        $this->client = $client;
        $this->repository = $repository;
        $this->entities = [];
    }

    public function handle()
    {
        $data = $this->client->getCharacters(new Criteria(9085, Criteria::SERIES));
        if (empty($data)) {
            return;
        }

        $this->loadExistedEntitiesOfResponse(... array_keys($data));

        $toSave = [];
        foreach ($data AS $item) {
            $toSave[] = $this->updateEntityIfExistsOrCreate($item);
        }

        return $this->repository->saveCollection(... $toSave);
    }

    private function loadExistedEntitiesOfResponse(int ... $id)
    {
        $this->entities = $this->repository->findCharactersById(... $id);
    }

    private function updateEntityIfExistsOrCreate(CharacterApiData $character)
    {
        return array_key_exists($character->id(), $this->entities) ?
            $this->entities[$character->id()]->updateInformation($character) :
            Character::createFromApiData($character);
    }
}