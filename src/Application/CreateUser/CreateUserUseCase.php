<?php

declare(strict_types=1);

namespace App\Application\CreateUser;

use App\Domain\Entity\User;
use App\Domain\Exceptions\UserException;
use App\Domain\Interfaces\UserRepository;
use DateTimeImmutable;

class CreateUserUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function execute(CreateUserInput $input): void
    {
        $this->ensurePasswordsIsEqual($input->password, $input->passwordConfirmation);
        $this->ensureEmailIsNotUsed($input->email);

        $user = User::create(
            name: $input->name,
            email: $input->email,
            password: $input->password,
            createdAt: new DateTimeImmutable(),
            isHashed: false
        );

        $this->userRepository->persist($user);
    }

    private function ensurePasswordsIsEqual(string $password, string $passwordConfirmation): void
    {
        if ($password === $passwordConfirmation) {
            return;
        }

        throw new UserException('As senhas devem ser iguais', 400);
    }

    private function ensureEmailIsNotUsed(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            return;
        }

        throw new UserException('O email informado já está em uso', 400);
    }
}
