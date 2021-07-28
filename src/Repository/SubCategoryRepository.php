<?php

namespace App\Repository;

use App\Entity\SubCategory;
use App\Classe\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubCategory[]    findAll()
 * @method SubCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubCategory::class);
    }

    // /**
    //  * @return SubCategory[] Returns an array of SubCategory objects
    //  */

    public function findWithSearch (Search $search) {
        $query = $this
            ->createQueryBuilder('s')
            ->select('s');

        if (!empty($search->string)) {
            $query = $query
                ->where('s.name LIKE :string')
                ->setParameter('string', "%{$search->string}%");
        }

        return $query->getQuery()->getResult();
    }
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @return SubCategory[] Returns an array of SubCategory objects
     */

    public function findByIds($ids)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findOneByPictogram($pictogram): ?SubCategory
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $pictogram)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
