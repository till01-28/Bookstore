<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

   /**
   * @return Book[] Returns an array of Book objects
    */
    public function findBooksField(int $userId): array
    {
        return $this->createQueryBuilder('b')
            ->select(
                'b.id',
                'b.name',
                'bc.name as categoryName',
                'bi.id as imageId',
                'u.email',
                'u.phone'
            )
            ->leftJoin('b.category', 'bc')
            ->innerJoin('b.image','bi')
            ->join(User::class,'u')
            ->andWhere('u.id = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('b.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBookByText($bookText): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.text like :bookText')
            ->setParameter('bookText','%'. $bookText . '%')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
