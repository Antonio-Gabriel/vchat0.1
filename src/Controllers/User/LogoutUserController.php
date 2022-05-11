<?php

namespace Vchat\Controllers\User;

use Vchat\System\LogoutUserUseCase;
use Vchat\Repositories\UserRepository;

class LogoutUserController
{
    public function handle()
    {
        $handleCreateUser = new LogoutUserUseCase(new UserRepository);
        $result = $handleCreateUser->execute();

        if ($result) {
            session_unset();
            session_destroy();
            session_write_close();
            setcookie(session_name(), '', 0, '/');
            session_regenerate_id(true);

            unset($_SESSION);

            redirect("/auth");
        }
    }
}
