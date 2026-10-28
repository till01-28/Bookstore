<?php

declare(strict_types=1);

namespace App\Component\User;

use App\Entity\User;
use DateTime;
use DateTimeZone;
use Symfony\Component\Clock\DatePoint;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserFactory
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \Exception
     */
    public function create(
        string $givenName,
        string $familyName,
        string $email,
        string $password,
        string $phone,
        DateTime $birthDate,
    ): User {

        $user = new User();

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);

        $user->setGivenName($givenName);
        $user->setFamilyName($familyName);
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setPhone($phone);
        $user->setBirthDate($birthDate);
        $user->setCreatedAt(new DatePoint(timezone: new DateTimeZone('Asia/Tashkent')));

        return $user;
    }
}
