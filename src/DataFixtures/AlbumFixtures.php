<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use App\Entity\Album;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AlbumFixtures extends Fixture implements DependentFixtureInterface
{
    public const ALBUM_COUNT = 5;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($u = 1; $u <= UserFixtures::USER_COUNT; $u++) {
            $user = $this->getReference('user_' . $u);
            for ($i = 1; $i <= self::ALBUM_COUNT; $i++) {
                $album = new Album();
                $album->setDescription($faker->text());
                $album->setName($faker->sentence(3));
                $album->setIsPrivate($faker->boolean(10));
                $album->setCreatedAt($faker->dateTimeInInterval('0 day', '-2 months'));
                $album->setUser($user);
                $album->setIsMainAlbum(false);
                $manager->persist($album);
                $this->addReference('user_' . $u . '_album_' . $i, $album);
            }
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
