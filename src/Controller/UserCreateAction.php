<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\User\UserFactory;
use App\Entity\User;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserCreateAction extends AbstractController
{
    public function __construct(private readonly UserFactory $userFactory)
    {

    }

    /**
     * @throws \DateMalformedStringException
     */
    #[NoReturn] public function __invoke(User $user): void
     {
        $this->userFactory->create(
            $user->getGivenName(),
            $user->getFamilyName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getPhone(),
            $user->getBirthDate(),
        );
        print_r($user);
        exit();
     }
}
