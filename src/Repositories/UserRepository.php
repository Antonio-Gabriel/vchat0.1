<?php

namespace Vchat\Repositories;

use Vchat\Sql\Sql;
use Vchat\Dtos\UserRequestDTO;
use Vchat\Validators\Password;

class UserRepository
{
    private Sql $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function create(
        UserRequestDTO $request
    ) {
        $statement = $this->sql->query(
            "INSERT INTO tuser 
                (name, email, password, sessionID, conectionID, connectionStats)
            VALUES (:name, :email, :password, :sessionID, :conectionID, :connectionStats)",
            [
                ":name" => $request->name,
                ":email" => $request->email,
                ":password" => $request->password,
                ":sessionID" => $request->sessionID,
                ":conectionID" => $request->connectionID,
                ":connectionStats" => $request->connectionStats
            ]
        );

        return $statement;
    }

    public function getUserByEmail(string $email)
    {
        return $this->sql->select(
            "SELECT *FROM tuser WHERE email = :email",
            [
                ":email" => $email
            ]
        );
    }

    public function getUserBySessionId(string $sessionId)
    {
        return $this->sql->select(
            "SELECT *FROM tuser WHERE sessionID = :sessionID",
            [
                ":sessionID" => $sessionId
            ]
        );
    }

    private function updateSessinId(int $userId)
    {
        $statement = $this->sql->query(
            "UPDATE tuser SET sessionID = :sessionID WHERE id = :id",
            [
                ":id" => $userId,
                ":sessionID" => session_id()
            ]
        );

        return $statement;
    }

    public function updateConnectionId(string $connectionId, int $status, int $userId)
    {
        $statement = $this->sql->query(
            "UPDATE tuser SET conectionID = :conectionID, connectionStats = :connectionStats WHERE id = :id",
            [
                ":id" => $userId,
                ":conectionID" => $connectionId,
                ":connectionStats" => $status
            ]
        );

        return $statement;
    }

    public function authentication(string $email, string $password)
    {
        $statement = $this->sql->select(
            "SELECT *FROM tuser WHERE email = :email",
            [
                ":email" => $email
            ]
        );

        $userData = (object)$statement[0];

        $isPermited = Password::comparePassword(
            $password,
            $userData->password
        );

        if ($isPermited) {
            session_regenerate_id();

            $this->updateSessinId($userData->id);

            $_SESSION["user_id"] = $userData->id;

            return true;
        }
    }

    public function logout(int $userId)
    {
        $statement = $this->sql->query(
            "UPDATE tuser SET sessionID = :sessionID, connectionStats = :connectionStats WHERE id = :id",
            [
                ":id" => $userId,
                ":sessionID" => "",
                ":connectionStats" => 0
            ]
        );

        return $statement;
    }
}
