<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 25/10/2018
 * Time: 14:05
 */

namespace App\Persistence\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Domain\Entity\Character;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CharacterRepository extends ServiceEntityRepository implements \Domain\Entity\CharacterRepository
{
    /**
     * @var \Exception[]
     */
    private $errors;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Character::class);
    }

    /**
     * @param Character $character
     * @return bool
     */
    public function save(Character $character) : bool
    {
        $result = true;

        try {
            $this->_em->persist($character);
            $this->_em->flush();
        } catch(\Exception $exception) {
            if ($this->errors === null) {
                $this->errors = [];
            }
            $errors[] = $exception;
            $result = false;
        }

        return $result;
    }

    /**
     * @param Character ...$collection
     * @return bool
    */
    public function saveCollection(Character ...$collection) : bool
    {
        $result = true;

        try {
            $this->_em->transactional(function () use ($collection) {
                foreach ($collection as $character) {
                    $this->_em->persist($character);
                }
            });
        } catch (\Throwable $exception) {
            if ($this->errors === null) {
                $this->errors = [];
            }
            $errors[] = $exception;
            $result = false;
        }

        return $result;
    }

    /**
     * @param bool $truncate
     * @return \Exception[]|null
     */
    public function recoverErrors(bool $truncate = true) : ?array
    {
        $return = $this->errors;

        if ($truncate) {
            $this->errors = [];
        }

        return $return;
    }

    /**
     * @param int ...$collection
     * @return Character[]
     */
    public function findCharactersById(int ... $collection) : array {

        $return = [];

        $data = $this->createQueryBuilder('v')
            ->select('c')
            ->andWhere('c.id IN (:ids)')
            ->setParameter('ids', $collection)
            ->getQuery()->getResult();


        foreach ($data AS $item) {
            $return[$item->getId()] = $item;
        }

        return $return;
    }

    public function findCharacter(int $id): ?Character
    {
        // TODO: Implement findCharacter() method.
    }

    public function recoverAllCharacters(): array
    {
        // TODO: Implement recoverAllCharacters() method.
    }
}