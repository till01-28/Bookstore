<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetBooksAction extends AbstractController
{
    public function __invoke(BookRepository $bookRepository): array
    {
        # return $bookRepository->findBooksField(5);
        return $bookRepository->findAll();
    }

}
