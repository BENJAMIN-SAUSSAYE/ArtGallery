<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    public const PICTURE_COUNT = 3;

    public function __construct()
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($u = 1; $u <= UserFixtures::USER_COUNT; $u++) {

            $user = $this->getReference('user_' . $u);

            for ($i = 1; $i <= AlbumFixtures::ALBUM_COUNT; $i++) {

                $album = $this->getReference('user_' . $u . '_album_' . $i);

                $arrayimageRef = $faker->randomElements(
                    [
                        'cormo.jpg',
                        'quepier.jpg',
                        'martin.jpg',
                        'renard.jpg',
                        'spatule.jpg',
                        'vache.jpg',
                    ],
                    self::PICTURE_COUNT,
                    false
                );

                for ($p = 0; $p < self::PICTURE_COUNT; $p++) {
                    $picture = new Picture();
                    $picture->setCreateAt($faker->dateTimeInInterval('1 year', '+10 days'));
                    $pictureFileName = $this->copyImageFixture($arrayimageRef[$p]);

                    $picture->setPictureFile($pictureFileName);
                    $picture->setAlbum($album);
                    $picture->setIsPrivate(false);
                    $picture->setTitle($faker->word());
                    $manager->persist($picture);
                }
            }
        }

        $manager->flush();
    }

    private function copyImageFixture(String $imageName): string
    {
        $pictureFileName = '';

        //copie du jeux de fichier dans le dossier upload pour les tests.
        $from = dirname(__DIR__, 2) . "/data_migration/";
        $to =  dirname(__DIR__, 2) . "/public/uploads/images/";
        $files = array_filter(glob("$from*"), "is_file");
        foreach ($files as $f) {
            if (basename($f) === $imageName) {
                $pictureFileName =  uniqid() . '_' . basename($f);
                copy($f,  $to . $pictureFileName);
            }
        }
        return $pictureFileName;
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            AlbumFixtures::class,
        ];
    }
}
