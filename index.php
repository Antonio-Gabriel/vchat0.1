<?php

session_start();

ini_set('display_error', 1);
error_reporting(E_ALL);


require_once "./vendor/autoload.php";

require_once "./src/Utils/Redirect.php";
require_once "./src/Utils/ErrorModel.php";

require_once "./envInit.php";

$appRoute = require_once "./src/Routes/AppRoute.php";
$clientRoutes = require_once "./src/Routes/ClientRoutes.php";

use Slim\App;
use Vchat\Entities\User;

$user = new User();

$app = new App([
    "settings" => [
        "displayErrorDetails" => true
    ]
]);

// EntPoints of App
$appRoute($app);
$clientRoutes($app);

$app->run();
?>

<?php if (isset($_SESSION["user_id"])) { ?>

    <div data-userId="<?= $user->getUserID(); ?>" class="us-id d-none">
        <?= $user->getUserID(); ?>
    </div>

    <script>
        var conn = new WebSocket('ws://localhost:8080/webrtc/?token=<?= $user->getSessionId() ?>');
    </script>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/client.js"></script>

<?php } ?>