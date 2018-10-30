<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 25/10/2018
 * Time: 18:20
 */

namespace Domain\Service\MarvelApiClient;

interface Client
{
    public function getCharacters(?Criteria $criteria) : ? array;
}