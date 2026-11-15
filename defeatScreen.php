<?php
session_start();

require_once __DIR__ . "/database/database.php";
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/classes/Player.php";

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$player = new Player($pdo);

$selectedPlayerId = $_SESSION["player_id"] ?? null;

$selectedPlayer = null;

if($selectedPlayerId !== null) {
    $selectedPlayer =  $player->getAllPlayersAttributById((int) $selectedPlayerId);
}
$loader = new FilesystemLoader(
    __DIR__ . "/templates"
);

$twig = new Environment($loader);

// afficher les templates
echo $twig->render("defeatScreen.html.twig", [
    "selectedPlayer" => $selectedPlayer
]);
?>