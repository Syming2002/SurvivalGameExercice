<?php

require_once __DIR__ . "/classes/Player.php";
require_once __DIR__ . "/database/database.php";
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/public/functions.php";

// $player = new Player($pdo);

// $playerByName = null;

// $message = '';
// $addPlayer = 0;

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $userName = trim($_POST["player_username"] ?? '');
//     $password = trim($_POST["password"] ?? '');

//     $passwordHash = password_hash($password, PASSWORD_DEFAULT);

//     $player->getPlayerByUsername($userName);

//     if (
//         $userName !== ''
//     ) {
//         $addPlayer = $player->addPlayer($userName, $passwordHash);
//     } else if ($userName === $userName) {
//         $message = "Enter a valid Username";
//     }
// }




// $loader = new Twig\Loader\FilesystemLoader(
//     __DIR__ . "/templates"
// );

// $twig = new Twig\Environment($loader);

// // afficher les templates
// echo $twig->render("header.html.twig", []);

// echo $twig->render("connexion.html.twig", [
//     "players" => $playerByName
// ]);


?>

