<?php

namespace App\DataFixtures;

use App\Entity\Scooter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ScooterFixture extends Fixture
{
    const SCOOTER_1 = 'scooter1';
    const SCOOTER_2 = 'scooter2';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

         $scooter1 = new Scooter();
         $scooter1->setStatus(1);
         $scooter1->setUuid($faker->uuid);

        $scooter2 = new Scooter();
        $scooter2->setStatus(0);
        $scooter2->setUuid($faker->uuid);

        $manager->persist($scooter1);
        $manager->persist($scooter2);

        $manager->flush();

        $this->addReference(self::SCOOTER_1, $scooter1);
        $this->addReference(self::SCOOTER_2, $scooter2);
    }
}
