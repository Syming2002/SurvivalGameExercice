<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/classes/Player.php";
require_once __DIR__ . "/database/database.php";
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/public/functions.php";

$player = new Player($pdo);

$actions = getActions($pdo);
$selectedPlayerId = $_GET["player_id"] ?? null;
$selectedPlayer = null;

if($selectedPlayerId !== null) {
    $selectedPlayer =  $player->getPlayerAttribut((int) $selectedPlayerId);
}

$loader = new FilesystemLoader(
    __DIR__ . "/templates"
);

$twig = new Environment($loader);

// afficher les templates
echo $twig->render("inGame.html.twig", [
    "selectedPlayer" => $selectedPlayer,
    "actions" => $actions
]);
?>


