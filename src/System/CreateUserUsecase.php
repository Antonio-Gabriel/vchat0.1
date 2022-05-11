<?php

namespace Vchat\System;

use Vchat\Shared\Result;
use Vchat\Dtos\UserRequestDTO;
use Vchat\Repositories\UserRepository;
use Vchat\Validators\{Email, Password};

class CreateUserUsecase
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $_userRepository)
    {
        $this->userRepository = $_userRepository;
    }

    public function execute(UserRequestDTO $request)
    {
        $emailAlreadyExists = $this->userRepository->getUserByEmail($request->email);

        if ($emailAlreadyExists) {
            // User already associate on this email

            return Result::Fail("The user already exist");
        }

        if (!Email::isValid($request->email)) {
            // Validate the email address

            return Result::Fail("Invalid email address!");
        }

        if (!Password::isValid($request->password)) {
            // Encrypt the password

            return Result::Fail("Invalid Password!");
        }

        $request->password = Password::isValid($request->password);

        $statement = $this->userRepository->create($request);

        if ($statement) {

            return Result::Ok($request);
        }
    }
}
