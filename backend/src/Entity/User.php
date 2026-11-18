<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Component\User\UserInfoDto;
use App\Controller\UserCreateAction;
use App\Controller\UserGetMaxAgeAction;
use App\Controller\UserInfoDtoAction;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')"),
        new GetCollection(
            uriTemplate: 'users/max-age',
            controller: UserGetMaxAgeAction::class,
            name: 'maxAge'
        ),
        new Post(
            uriTemplate: 'users/create',
            controller: UserCreateAction::class,
            validate: false,
            name: 'createUser',
        ),
        new Post(
            uriTemplate: 'users/auth',
            name: 'auth'
        ),
        new Get(),
        new Post(
            uriTemplate: 'users/userInfo',
            controller: UserInfoDtoAction::class,
            input: UserInfoDto::class,
            name: 'userInfo'
        ),
        new Get(
            security: "is_granted('ROLE_ADMIN') || object === user"
        )
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    paginationItemsPerPage: 5

)]
#[UniqueEntity('email', message: 'This email already exists!')]
#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'email' => 'partial',
    'phone' => 'start',
])]
#[ApiFilter(OrderFilter::class, properties: ['id'])]
#[ApiFilter(DateFilter::class, properties:['createdAt'])]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'This field should not be blank.')]
    #[Assert\Length(min: 2, minMessage: 'Given name should be at least {{ limit }} characters long.')]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]{2,}$/',
        message: 'Given name should contain only letters and at least 2 characters long'
    )]
    private ?string $givenName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'This field should not be blank')]
    #[Assert\Length(min: 2, minMessage: 'Family name should be at least {{ limit }} characters long.}}')]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]{2,}$/',
        message: 'Family name should contain only letters and at least 2 characters long'
    )]
    private ?string $familyName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'This field should not be blank')]
    #[Assert\Email(message: 'Invalid email address, please provide a valid email address.')]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\Regex(
        pattern: '/^[^\s@]+@[^\s@]+\.[^\s@]{2,4}$/',
        message: 'Invalid email address, please provide a valid email address.'
    )]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'This field should not be blank')]
    #[Assert\Length(min: 8, minMessage: 'Password should be at least {{ limit }} characters long.')]
    #[Groups(['user:write'])]
    #[Assert\Regex(
        pattern: '/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#(){}[\]^+=._-]).{8,}$/',
        message: 'Password should contain at least one uppercase, one lowercase, one digit, one special character and 8 characters long.'
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'This field should not be blank')]
    #[Assert\Length(min: 12, minMessage: 'Phone number should be at least {{ limit }} characters long.')]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\Regex(
        pattern: '/^\+998\d{9}$/',
        message: 'Phone number should be at least 12 characters long with +998 in the beginning'
    )]
    private ?string $phone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['user:write', 'user:read'])]
    private ?\DateTime $birthDate = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = ["ROLE_USER"];

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ? DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(string $givenName): static
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): static
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTime $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
