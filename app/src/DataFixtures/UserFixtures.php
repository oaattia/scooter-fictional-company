<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $user1 = new User();
        $user1->setUuid($faker->uuid);
        $user1->setEmail($faker->email);
        $user1->setFirstname($faker->firstName);
        $user1->setLastname($faker->lastName);
        $user1->setUsername($faker->userName);


        $user2 = new User();
        $user2->setUuid($faker->uuid);
        $user2->setEmail($faker->email);
        $user2->setFirstname($faker->firstName);
        $user2->setLastname($faker->lastName);
        $user2->setUsername($faker->userName);


        $manager->persist($user1);
        $manager->persist($user2);

        $manager->flush();
    }
}
