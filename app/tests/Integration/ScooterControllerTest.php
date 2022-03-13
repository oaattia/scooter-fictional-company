<?php

namespace App\Tests\Integration;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Scooter;

class ScooterControllerTest extends ApiTestCase
{
    /** @var \Doctrine\ORM\EntityManager|null  */
    private $em;

    public function setUp(): void
    {
        self::bootKernel();
        $this->em = self::$kernel->getContainer()->get('doctrine.orm.default_entity_manager');
    }

    public function testIfAuthenticationRequired(): void
    {
        static::createClient()->request('GET', '/api/scooters');

        $this->assertResponseStatusCodeSame(401);

        $this->assertJsonContains(['message' => 'Authentication Required']);
    }

    public function testAuthenticationKeyNotValid()
    {
        static::createClient()->request('GET', '/api/scooters', ['headers' => [
            'API-KEY' => 'FAKE',
        ]]);

        self::assertResponseStatusCodeSame(401);
        $this->assertJsonContains(['error' => ['code' => 'E_1003']]);
        $this->assertJsonContains(['error' => ['message' => 'API key not valid!']]);
        $this->assertJsonContains(['success' => false]);
    }


    public function testWeGetRightResponse()
    {
        $response = static::createClient()->request('GET', '/api/scooters', ['headers' => [
            'API-KEY' => 'lcGgHBKfu9SwcCYROJmpo3G9KnGKW8r2b5Y26CtE',
        ]]);

        self::assertResponseIsSuccessful();
        $this->assertJsonContains(['success' => true]);

        $scooterRepo = $this->em->getRepository(Scooter::class);
        $scooters = $scooterRepo->findAll();

        $content = json_decode($response->getContent(), true);
        $this->assertEquals($content['scooters'][0]['uuid'], $scooters[0]->getUuid());
        $this->assertEquals($content['scooters'][0]['status'], $scooters[0]->getStatus());
        $this->assertEquals($content['scooters'][1]['uuid'], $scooters[1]->getUuid());
        $this->assertEquals($content['scooters'][1]['status'], $scooters[1]->getStatus());
    }
}
