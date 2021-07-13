<?php

namespace App\Repository;

use App\Entity\Pictogram;
use App\Classe\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pictogram|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pictogram|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pictogram[]    findAll()
 * @method Pictogram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictogramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pictogram::class);
    }

    public function findWithSearch (Search $search) {
        $query = $this
            ->createQueryBuilder('p')
            ->select('p');

        if (!empty($search->string)) {
            $query = $query
                ->where('p.name LIKE :string')
                ->setParameter('string', "%{$search->string}%");
        }

        return $query->getQuery()->getResult();
    }

//    public function findByQuestion($pictogramsCategory)
//    {
//
//        $entityManager = $this->getEntityManager();
//        /*select p.name from pictogram p inner join question_category qc ON qc.category_id= p.category_id where qc.question_id=6*/
//        $query = $entityManager->createQuery(
//            'SELECT IDENTITY(p.name)
//            FROM App\Entity\Pictogram p
//            INNER JOIN App\Entity\Question q
//                WITH q.question_category.category_id = p.category_id
//            WHERE q.question_category.category_id = :pictogramsCategory'
//        )->setParameter('pictogramsCategory', $pictogramsCategory);
//
//        // returns an array of Product objects
//        return $query->getResult();
//    }
    // /**
    //  * @return Pictogram[] Returns an array of Pictogram objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pictogram
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
