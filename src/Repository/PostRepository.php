<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function todosLosPost() {
        return $this->getEntityManager()
            ->createQuery('SELECT post.id, post.titulo, post.foto, post.fecha_publicacion From App:Post post')
            // ->getResult()
            ;
    }

    public function todosLosPost1() {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'Select id, titulo, foto, fecha_publicacion from post order by id asc';
        $statement = $conn->prepare($sql);
        $statement->execute();
        
        return $statement->fetchAllAssociative();
    }

    public function todosLosPost2() {
         $qb = $this->createQueryBuilder('p')
            ->select('p.id','p.titulo','p.foto','p.fecha_publicacion')
            // ->where('p.id > :id')
            // ->setParameter('id', 1)
            ->orderBy('p.id', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function todosLosPost3() {
        $qb = $this->createQueryBuilder('p')
        ->select('p.id','p.titulo','p.foto','p.fecha_publicacion')
        // ->where('p.id > :id')
        // ->setParameter('id', 1)
        ->orderBy('p.id', 'ASC');

        $query = $qb->getQuery();
        return $query->execute();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
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
    public function findOneBySomeField($value): ?Post
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
