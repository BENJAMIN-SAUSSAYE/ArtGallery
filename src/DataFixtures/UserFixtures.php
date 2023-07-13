<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_COUNT = 5;

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création des utilisateurs
        for ($i = 1; $i <= self::USER_COUNT; $i++) {
            $user = new User();
            $user->setEmail('user_' . $i . '@monsite.com');
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeInInterval('1 year', '+10 days')));

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'userpassword'
            );
            $user->setPassword($hashedPassword);
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }

        $manager->flush();


        // Création d'un administrateur
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'adminpassword'
        );
        $admin->setPassword($hashedPassword);
        $admin->setFirstname('Benjamin');
        $admin->setLastname('Saussaye');
        $admin->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeInInterval('1 year', '+10 days')));
        $this->addReference('user_admin', $admin);
        $manager->persist($admin);
        $manager->flush();
    }
}
