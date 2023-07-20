<?php

namespace App\Repository;

use App\Entity\Picture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Picture>
 *
 * @method Picture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picture[]    findAll()
 * @method Picture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picture::class);
    }

    public function save(Picture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Picture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getPublicPictures($nbrImagesShow): array
    {
        return $this->createQueryBuilder('i')
            ->innerJoin("i.album", "album")
            ->addSelect('i')
            ->Where("album.isPrivate = false")
            ->andWhere("i.pictureFile != '' ")
            ->orderBy("i.createdAt", "DESC")
            ->setMaxResults($nbrImagesShow)
            ->getQuery()
            ->getResult();
    }
    public function getTopLikedPictures(int $count): array
    {
        $resultQuerryArray = $this->createQueryBuilder('p')
            ->select("p, count(lku) as nbUsers")
            ->innerJoin("p.album", "a")
            ->innerJoin("p.likedUsers", "lku")
            ->Where("a.isPrivate = false")
            ->andWhere("p.pictureFile != '' ")
            ->groupBy("p.id")
            ->orderBy("nbUsers", "DESC")
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($resultQuerryArray as $arrayItem) {
            $result[] = $arrayItem[0];
        }
        return $result;
    }

    /**
     * @return Picture[] Returns an array of pictures objects
     */
    public function findLastPublicPostedImages(int $count = 20): array
    {
        return $this->createQueryBuilder('i')
            ->innerJoin("i.album", "album")
            ->addSelect('i')
            ->Where("album.isPrivate = false")
            ->andWhere("i.pictureFile != '' ")
            ->orderBy("i.createdAt", "DESC")
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Picture[] Returns an array of Picture objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Picture
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
