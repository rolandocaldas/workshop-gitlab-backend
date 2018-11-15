<?php
/**
 * Created by PhpStorm.
 * User: rolando
 * Date: 14/11/18
 * Time: 20:46
 */

namespace App\Tests\Application\Service;


use App\Tests\Mock\CharacterRepository;
use Application\Service\CharacterInfo;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class CharacterInfoTest extends TestCase
{

    private $characterRepository;

    public function setUp()
    {
        $this->characterRepository = new CharacterRepository();
    }

    public function testHandle()
    {
        $applicationService = new CharacterInfo($this->characterRepository);
        $character = $applicationService->handle(1);
        $this->assertEquals($character->getId(), 1);
    }
}