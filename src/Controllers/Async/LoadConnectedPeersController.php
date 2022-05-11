<?php

namespace Vchat\Controllers\Async;

use Vchat\Dtos\UserRequestDto;
use Vchat\System\CreateUserUsecase;
use Vchat\Repositories\UserRepository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoadConnectedPeersController
{
    public function handle(
        ServerRequestInterface $req,
        ResponseInterface $res,
        $args
    ) {
        return json_encode(["msg" => "Enabling the route"]);
    }
}
