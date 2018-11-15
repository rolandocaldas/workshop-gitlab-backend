<?php
/**
 * Created by PhpStorm.
 * User: rolando
 * Date: 14/11/18
 * Time: 20:53
 */

namespace App\Tests\Mock;


use Domain\Entity\Character;
use Domain\ValueObject\CharacterApiData;
use Domain\ValueObject\Thumbnail;

class CharacterRepository implements \Domain\Entity\CharacterRepository
{
    private $characters;

    public function __construct()
    {
        $this->characters = [
            1 => Character::createFromApiData(new CharacterApiData(
                1,
                'Character 1',
                'Character 1 description',
                new Thumbnail('file-path', 'jpg'))),
        ];
    }

    public function save(Character $character): bool
    {
        $this->characters[$character->getId()] = $character;
        return true;
    }

    public function saveCollection(Character ...$collection): bool
    {
        foreach ($collection AS $item) {
            $this->save($item);
        }
        return true;
    }

    public function recoverErrors(bool $truncate): ?array
    {
        return null;
    }

    public function findCharacter(int $id): ?Character
    {
        return array_key_exists($id, $this->characters) ? $this->characters[$id] : null;
    }

    public function findCharactersById(int ...$collection): array
    {
        $return = [];
        foreach ($collection AS $id) {
            if (array_key_exists($id, $this->characters)) {
                $return[] = $this->characters[$id];
            }
        }
        return $return;
    }

    public function recoverAllCharacters(): array
    {
        return $this->characters;
    }

}