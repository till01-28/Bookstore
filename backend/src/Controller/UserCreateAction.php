<?php

declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Component\User\UserFactory;
use App\Component\User\UserManager;
use App\Entity\User;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserCreateAction extends AbstractController
{
    public function __construct(
        private readonly UserFactory $userFactory,
        private readonly UserManager $userManager,
        private readonly ValidatorInterface $validator
    ) {
    }

    /**
     * @throws \DateMalformedStringException
     */
    #[NoReturn] public function __invoke(User $user): User
    {
        $this->validator->validate($user);

        $user = $this->userFactory->create(
            $user->getGivenName(),
            $user->getFamilyName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getPhone(),
            $user->getBirthDate(),
        );
        $this->userManager->save($user, true);

        return $user;
    }
}
