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
use Application\Service\CharacterInfo;
use Application\Service\CharacterLiked;
use Application\Service\CharacterList;
use Application\Service\ImportCharactersFromMarvel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

        return new JsonResponse();
    }

    public function listElements()
    {
        return new JsonResponse((new CharacterList($this->repository))->handle());
    }

    public function itemInfo(int $id)
    {
        return new JsonResponse((new CharacterInfo($this->repository))->handle($id));
    }

    public function itemEditLiked(int $id, Request $request)
    {
        $data = json_decode($request->getContent());
        if (!property_exists($data, 'liked')) {
            return new JsonResponse('', 404);
        }

        (new CharacterLiked($this->repository))->handle($id, $data->liked);
        return new JsonResponse();
    }
}