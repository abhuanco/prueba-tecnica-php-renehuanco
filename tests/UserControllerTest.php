<?php

namespace Tests {

    use App\Controller\UserController;
    use App\DTO\UserRequestDTO;
    use App\UseCase\SaveUserUseCase;
    use PHPUnit\Framework\TestCase;

    class UserControllerTest extends TestCase
    {
        public function testStore()
        {
            $saveUserUseCaseMock = $this->createMock(SaveUserUseCase::class);

            $saveUserUseCaseMock
                ->expects($this->once())
                ->method('execute')
                ->with($this->isInstanceOf(UserRequestDTO::class));

            $userController = new UserController($saveUserUseCaseMock);

            $data = [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => 'password123',
            ];

            ob_start();
            $userController->store($data);
            $output = ob_get_clean();

            $this->assertEquals('User created', $output);
        }
    }
}