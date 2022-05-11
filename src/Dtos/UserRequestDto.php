<?php

namespace Vchat\Dtos;

class UserRequestDto
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $sessionID;
    public string $connectionID;
    public int $connectionStats;

    public function __construct(
        string $name,
        string $email,
        string $password,
        string $sessionID = "",
        string $connectionID = "",
        int $connectionStats = 0
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->sessionID = $sessionID;
        $this->connectionID = $connectionID;
        $this->connectionStats = $connectionStats;
    }
}
