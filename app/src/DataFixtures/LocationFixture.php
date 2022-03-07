<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LocationFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i=0; $i<=10; $i++) {
            $location = new Location();
            $location->setDateTime(new \DateTime());
            $location->setScooter($this->getReference('scooter1'));
            $location->setLongitude($faker->longitude);
            $location->setLatitude($faker->latitude);
             $manager->persist($location);
        }


        for ($i=0; $i<=10; $i++) {
            $location = new Location();
            $location->setDateTime(new \DateTime());
            $location->setScooter($this->getReference('scooter2'));
            $location->setLongitude($faker->longitude);
            $location->setLatitude($faker->latitude);
             $manager->persist($location);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ScooterFixture::class
        ];
    }
}
