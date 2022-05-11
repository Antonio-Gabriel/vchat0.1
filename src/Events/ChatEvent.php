<?php

namespace Vchat\Events;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use Vchat\Events\ResponseEvent;
use Vchat\Repositories\UserRepository;

class ChatEvent implements MessageComponentInterface
{
    protected $clients;
    private $userData;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;

        $this->userRepository = new UserRepository();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Get the uri of webRTC service
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $query);

        if ($data = $this->userRepository->getUserBySessionId(
            $query["token"]
        )) {
            $this->userData = $data;
            $conn->userData = $data;

            $conn->send(
                ResponseEvent::sendResponse(
                    "CONNECTION_ESTABLISHED",
                    "Online"
                )
            );

            foreach ($this->clients as $client) {
                // The sender is not the receiver, send to each client connected

                $client->send(
                    ResponseEvent::sendResponse(
                        "NEW_USER_CONNECTION",
                        "Online",
                        (object)[
                            "username" => $data[0]["name"],
                            "userId" => $data[0]["id"]
                        ]
                    )
                );
            }

            $this->clients->attach($conn);

            $this->userRepository->updateConnectionId(
                $conn->resourceId,
                1,
                $data[0]["id"]
            );

            // Store the new connection to send messages to later
            echo "New connection! ({$data[0]['name']})\n";
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $query);

        if ($data = $this->userRepository->getUserBySessionId(
            $query["token"]
        )) {
            $this->userData = $data;
            $conn->userData = $data;
            $conn->send(
                ResponseEvent::sendResponse(
                    "CONNECTION_DISCONNECTED",
                    "Offline"
                )
            );

            foreach ($this->clients as $client) {
                // The sender is not the receiver, send to each client connected

                $client->send(
                    ResponseEvent::sendResponse(
                        "NEW_USER_DISCONNECTED",
                        "Offline",
                        (object)[
                            "username" => $data[0]["name"],
                            "userId" => $data[0]["id"]
                        ]
                    )
                );
            }

            $this->userRepository->updateConnectionId(
                $conn->resourceId,
                1,
                $data[0]["id"]
            );

            // The connection is closed, remove it, as we can no longer send it messages
            $this->clients->detach($conn);

            echo "Connection {$conn->resourceId} has disconnected\n";
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
