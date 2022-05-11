<?php

namespace Vchat\System;

use Vchat\Dtos\UserAuthRequestDto;
use Vchat\Repositories\UserRepository;

class AuthenticateUserUseCase
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $_userRepository)
    {
        $this->userRepository = $_userRepository;
    }

    public function execute(UserAuthRequestDto $request)
    {
        $statement = $this->userRepository->authentication(
            $request->email,
            $request->password
        );

        return $statement;
    }
}
