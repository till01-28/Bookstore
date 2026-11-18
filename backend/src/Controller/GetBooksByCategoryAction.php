<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BookRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class GetBooksByCategoryAction extends AbstractController
{
    #[NoReturn] public function __invoke(Request $request,BookRepository $bookRepository): array
    {
        # return $bookRepository->find('3');
        /*return $bookRepository->findOneBy([
             'name' => 'Dracula',
             'category' => 3
         ]);*/
        # return $bookRepository->findAll();
        # return $bookRepository->findBy(['category' => 5]);

        $categoryId = (int)$request->get('categoryId');
        return $bookRepository->findBy(['category' => $categoryId]);
    }

}
