<?php

declare(strict_types=1);

namespace App\Component\User;

use Symfony\Component\Serializer\Annotation\Groups;

class UserInfoDto
{
     public function __construct(
         #[Groups(['user:read','user:write'])]
         private readonly string $familyName,
         #[Groups(['user:read','user:write'])]
         private readonly bool $isMarried
     )
     {

     }

    public function isMarried(): bool
    {
        return $this->isMarried;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }
}
