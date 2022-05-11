<?php

namespace Vchat\System;

use Vchat\Repositories\UserRepository;

class LogoutUserUseCase
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $_userRepository)
    {
        $this->userRepository = $_userRepository;
    }

    public function execute()
    {
        $statement = $this->userRepository->logout(intval($_SESSION["user_id"]));

        return $statement;
    }
}
