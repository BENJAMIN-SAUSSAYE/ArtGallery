<?php

namespace App\DataFixtures;

use App\Entity\Picture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use function PHPUnit\Framework\isEmpty;

class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    public const MAX_PICTURE_COUNT = 5;

    public function __construct()
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($u = 1; $u <= UserFixtures::USER_COUNT; $u++) {

            $user = $this->getReference('user_' . $u);

            for ($i = 0; $i <= AlbumFixtures::ALBUM_COUNT; $i++) {

                $album = ($i == 0) ? $mainAlbum = $user->GetAlbums()->first() : $this->getReference('user_' . $u . '_album_' . $i);

                $arrayimageRef = $faker->randomElements(
                    [
                        'cormo.jpg',
                        'guepier.jpg',
                        'martin.jpg',
                        'renard.jpg',
                        'spatule.jpg',
                        'vache.jpg',
                        'canard.jpg',
                        'mouflon.jpg',
                        'bernache.jpg',
                        'chevalier.jpg',
                        'becassine.jpg',
                        'araignee.jpg',
                        'ecureuil.jpg',
                        'papillon.jpg',
                    ],
                    self::MAX_PICTURE_COUNT,
                    false
                );

                $nbrImages = $faker->numberBetween(3, self::MAX_PICTURE_COUNT);

                for ($p = 0; $p < $nbrImages; $p++) {
                    $picture = new Picture();
                    $picture->setCreateAt($faker->dateTimeInInterval('0 day', '-2 months'));
                    $pictureFileName = $this->copyImageFixture($arrayimageRef[$p]);
                    $picture->setPictureFile($pictureFileName);
                    $picture->setAlbum($album);
                    $picture->setTitle($faker->words($nb = 2, true));
                    $manager->persist($picture);
                }
            }
        }

        $manager->flush();
    }

    private function copyImageFixture(String $imageName): string
    {
        //copie du jeux de fichier dans le dossier upload pour les tests.
        $from = dirname(__DIR__, 2) . "/data_migration/";
        $to =  dirname(__DIR__, 2) . "/public/uploads/images/";
        $files = array_filter(glob("$from*"), "is_file");
        foreach ($files as $f) {
            if (basename($f) === $imageName) {
                $pictureFileName =  uniqid() . '_' . basename($f);
                copy($f,  $to . $pictureFileName);
                return $pictureFileName;
            }
        }
        return '';
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            AlbumFixtures::class,
        ];
    }
}
