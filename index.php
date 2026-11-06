<?php

require_once __DIR__ . "/classes/Player.php";
require_once __DIR__ . "/database/database.php";
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/public/functions.php";

$player = new Player($pdo);
$players = $player -> getAllPlayersName();

$message = '';
$addPlayer = 0;


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userName = trim($_POST["player_username"] ?? '');

    if (
        $userName !== ''
    ) {
        $addPlayer = $player->addPlayer($userName);
    } else {
        $message = "Enter a valid Username";
    }
}




$loader = new Twig\Loader\FilesystemLoader(
    __DIR__ . "/templates"
);

$twig = new Twig\Environment($loader);

// afficher les templates
echo $twig->render("header.html.twig", []);

echo $twig->render("addPlayer.html.twig", [
    "addPlayer" => $addPlayer
]);

echo $twig->render("playerSelection.html.twig", [
    "players" => $players
]);


?>

