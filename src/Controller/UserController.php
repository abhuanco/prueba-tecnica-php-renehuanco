<?php

namespace App\Controller {

    use App\DTO\UserRequestDTO;
    use App\UseCase\SaveUserUseCase;

    readonly class UserController
    {
        public function __construct(private SaveUserUseCase $saveUserUseCase)
        {

        }

        public function store(array $data): void
        {
            $userDTO = new UserRequestDTO($data['name'], $data['email'], $data['password']);
            $this->saveUserUseCase->execute($userDTO);
            echo "User created";
        }
    }
}