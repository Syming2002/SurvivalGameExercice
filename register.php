<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/vendor/autoload.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once __DIR__ . "/classes/Player.php";
    require_once __DIR__ . "/database/database.php";

    $player = new Player($pdo);

    $userName = trim($_POST["player_username"] ?? '');
    $password = trim($_POST["password"] ?? '');

    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($userName === '' || $password === '') {
        exit("All fields must be filled.");
    }

    if (strlen($password) < 10) {
        exit("Password must contain 10 characters minimum");
    }

    try {
        $player->addPlayer($userName, $hashPassword);
        echo "Player created !";
    } catch (PDOException $exception) {
        if ($exception->getCode() === "23000") {
            echo "this name is already taken";
        } else {
            throw $exception;
        }
    }
}

$loader = new FilesystemLoader(
    __DIR__ . "/templates"
);

$twig = new Environment($loader);

echo $twig->render("register.html.twig", [
]);

?>