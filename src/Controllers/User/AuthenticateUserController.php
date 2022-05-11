<?php

namespace Vchat\Controllers\User;

use Vchat\Dtos\UserAuthRequestDto;
use Vchat\System\AuthenticateUserUseCase;
use Vchat\Repositories\UserRepository;

use Psr\Http\Message\ServerRequestInterface;

class AuthenticateUserController
{
    public function handle(ServerRequestInterface $req)
    {
        $handleCreateUser = new AuthenticateUserUseCase(new UserRepository);
        $result = $handleCreateUser->execute(
            new UserAuthRequestDto(
                $req->getParsedBody()["email"],
                $req->getParsedBody()["password"]
            )
        );

        if (!$result) {
            redirect("/auth?status=401");
        }

        redirect("/backoffice");
    }
}
