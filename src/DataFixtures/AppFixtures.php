<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setName('testuser')
            ->setEmail('test@octopuslabs.com')
            ->setToken('TkpJe8qr9hjbqPwCHi0n');

        $manager->persist($user);

        $manager->flush();
    }
}
