<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 23/10/2018
 * Time: 17:56
 */

namespace App\Controller;


use App\Persistence\Doctrine\Repository\CharacterRepository;
use App\Service\MarvelApiClient;
use Application\UseCase\CharacterInfo;
use Application\UseCase\CharacterLiked;
use Application\UseCase\CharacterList;
use Application\UseCase\ImportCharactersFromMarvel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class CharacterController extends Controller
{
    private $repository;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function importApi(MarvelApiClient $client)
    {
        (new ImportCharactersFromMarvel($client, $this->repository))->handle();
    }

    public function listElements()
    {
        return new JsonResponse((new CharacterList($this->repository))->handle());
    }

    public function itemInfo(int $id)
    {
        return new JsonResponse((new CharacterInfo($this->repository))->handle($id));
    }

    public function itemEditLiked(int $id, bool $liked)
    {
        (new CharacterLiked($this->repository))->handle($id, $liked);
    }
}