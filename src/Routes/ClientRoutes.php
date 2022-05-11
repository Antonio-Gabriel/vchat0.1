<?php

use Slim\App;
use Vchat\Settings\View;

use Vchat\Validators\Middleware;

return function (App $app) {
    $app->get("/", function () {
        $view = new View();
        $view->render("index.html", [
            "isAuth" => $_SESSION["user_id"] ?? 0
        ]);
    });

    $app->get("/auth", function ($req) {
        Middleware::checkAuthentication();

        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;

        $view = new View();
        $view->render("login.html",  [
            "status" => $statusCode,
            "message" => errorModel()[$statusCode]
        ]);
    });

    $app->get("/register", function ($req) {
        Middleware::checkAuthentication();

        $statusCode = intval($req->getQueryParams()["status"]) ?? 0;

        $view = new View();
        $view->render("register.html", [
            "status" => $statusCode,
            "message" => errorModel()[$statusCode]
        ]);
    });
};
