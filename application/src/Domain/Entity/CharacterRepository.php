<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 25/10/2018
 * Time: 18:10
 */

namespace Domain\Entity;

interface CharacterRepository
{
    public function save(Character $character) : bool;
    public function saveCollection(Character ...$collection) : bool;
    public function recoverErrors(bool $truncate = true) : ?array;
    public function findCharacter(int $id) : ?Character;
    public function findCharactersById(int ... $collection) : array;
    public function recoverAllCharacters() : array;
}