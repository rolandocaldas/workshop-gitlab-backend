<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 25/10/2018
 * Time: 16:27
 */

namespace App\Service;

use Domain\Service\MarvelApiClient\Client;
use Domain\Service\MarvelApiClient\Criteria;
use Domain\ValueObject\CharacterApiData;

class MarvelApiClient implements Client
{
    private $privateKey;
    private $publicKey;

    public function __construct(string $privateKey, string $publicKey)
    {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }

    /**
     * @param Criteria|null $criteria
     * @return CharacterApiData[]|null
     * @throws \Exception
     */
    public function getCharacters(?Criteria $criteria) : ?array
    {
        return CharacterApiData::createCollectionFromData($this->sendRequestAndReturnResult('characters', $criteria)['data']['results']);
    }

    private function sendRequestAndReturnResult(string $entity, ?Criteria $criteria)
    {
        $error = false;
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->constructUrlAndReturn($entity, $criteria),
            CURLOPT_HTTPHEADER => ['Content-type: application/json'],
            CURLOPT_RETURNTRANSFER => 1
        ]);

        $result = curl_exec($curl);

        if ($result === false) {
            $error = curl_error($curl);
        }

        curl_close($curl);

        if ($error) {
            throw new \Exception($error);
        }

        return json_decode($result);
    }

    private function constructUrlAndReturn(string $entity, ?Criteria $criteria) : string
    {
        $url = ['http://gateway.marvel.com/v1/public'];

        if (!empty($criteria)) {
            $url[] = $criteria->entity() . '/' . $criteria->id();
        }

        $url[] = urlencode($entity);

        return implode('/', $url) . '?' . $this->generateHashQuery();
    }

    private function generateHashQuery() : string
    {
        $time = time();

        $query = [];
        $query[] = 'ts=' . $time;
        $query[] = 'apikey=' . $this->publicKey;
        $query[] = 'hash=' . md5($time . $this->privateKey . $this->publicKey);

        return implode('&', $query);
    }

}