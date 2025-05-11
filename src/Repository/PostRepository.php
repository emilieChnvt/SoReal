<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function countPostsByProfile(): array
    {
        return $this->createQueryBuilder('p')
            ->select('profile.displayName AS displayName', 'COUNT(p.id) AS post_count')
            ->join('p.author', 'profile')
            ->groupBy('profile.id')
            ->orderBy('post_count', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Post[] Returns an array of Post objects
     */
    public function findByFriends($profile): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.author', 'a')  //  jointure avec l'auteur du post
            ->where('a IN (:friends)')  // auteur du post, un ami de l'utilisateur
            ->setParameter('friends', $profile->getFriends())  // passe la liste des amis
            ->orderBy('p.createAt', 'DESC')  // Tri par date de création
            ->getQuery()
            ->getResult();
    }



    //    /**
    //     * @return Post[] Returns an array of Post objects
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

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
