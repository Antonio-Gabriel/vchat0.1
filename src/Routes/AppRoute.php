<?php

use Slim\App;
use Vchat\Settings\View;

use Vchat\Validators\Middleware;
use Vchat\Controllers\User\{
    CreateUserController,
    AuthenticateUserController,
    LogoutUserController
};

use Vchat\Controllers\Async\LoadConnectedPeersController;

return function (App $app) {

    $app->get("/backoffice", function () {
        Middleware::hasAuthenticated();

        $view = new View();
        $view->display("home.html");
    });

    $app->get("/search", function () {
        Middleware::hasAuthenticated();

        $view = new View();
        $view->display("search.html");
    });

    $app->post("/loadconnection/{id}", [new LoadConnectedPeersController, "handle"]);

    $app->post("/create", [new CreateUserController, "handle"]);
    $app->post("/auth", [new AuthenticateUserController, "handle"]);
    $app->get("/logout", [new LogoutUserController, "handle"]);
};
