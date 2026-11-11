<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once __DIR__ . "/database/database.php";
    require_once __DIR__ . "/classes/Player.php";
    $player = new Player($pdo);

    $userName = trim($_POST["player_username"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if ($userName === '' || $password === '') { 
        exit("All fields must be filled.");
    }

    // rechercher le joueur dans la base de données
    $sql = "SELECT player_id, player_username, password FROM player
        WHERE player_username = :player_username";

    $stmt = $pdo -> prepare($sql);
    $stmt -> execute([
        "player_username" => $userName
    ]);

    $playerAccount = $stmt -> fetch();

    // vérifier si le joueur existe
    if (!$playerAccount) {
        exit("Player not found");
    }

    // vérifier le mot de passe
    if (!password_verify($password, $playerAccount["password"])) {
        exit("Password not correct");
    }

    session_regenerate_id(true);

    $_SESSION["player_id"] = $playerAccount["player_id"];
    $_SESSION["player_username"] = $playerAccount["player_username"];

    header("Location: inGame.php");
    exit;
}

require_once __DIR__ . "/vendor/autoload.php";

$loader = new FilesystemLoader(__DIR__ . "/templates");
$twig = new Environment($loader);

echo $twig->render("connexion.html.twig");

?>