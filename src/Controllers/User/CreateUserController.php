<?php

namespace Vchat\Controllers\User;

use Vchat\Dtos\UserRequestDto;
use Vchat\System\CreateUserUsecase;
use Vchat\Repositories\UserRepository;

use Psr\Http\Message\ServerRequestInterface;

class CreateUserController
{
    public function handle(ServerRequestInterface $req)
    {
        $handleCreateUser = new CreateUserUsecase(new UserRepository);
        $result = $handleCreateUser->execute(
            new UserRequestDto(
                $req->getParsedBody()["name"],
                $req->getParsedBody()["email"],
                $req->getParsedBody()["password"]
            )
        );

        $error = $result->errorValue();

        if ($error) {
            redirect("/register?status=400");
        }

        redirect("/register?status=200");
    }
}
