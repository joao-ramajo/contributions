<?php

declare(strict_types=1);

namespace App\Application\Login;

use App\Domain\Entity\User;
use App\Domain\Exceptions\UserException;
use App\Domain\Interfaces\UserRepository;

class LoginUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function execute(LoginInput $input)
    {
        $user = $this->userRepository->findByEmail($input->email);

        if (!$user) {
            throw new UserException('Senha ou email incorretos.', 400);
        }

        $this->ensureUserExists($user);
        $this->ensurePasswordIsCorrect($input->password, $user->password);

        return new LoginOutput($user->id);
    }

    private function ensurePasswordIsCorrect(string $inputPassword, string $userPassword)
    {
        $isValid = password_verify($inputPassword, $userPassword);

        if ($isValid) {
            return;
        }

        throw new UserException('Email ou senha incorretos.', 400);
    }

    private function ensureUserExists(?User $user): void
    {
        if ($user) {
            return;
        }

        throw new UserException('Senha ou email incorretos.', 400);
    }
}
