<?php

session_start();

require_once __DIR__ . "/database/database.php";

$selectedPlayerId = $_SESSION["player_id"] ?? null;

if ($selectedPlayerId !== null) {
    $stmt = $pdo->prepare(
        "UPDATE player
         SET health = 20, energy = 40, food = 20
         WHERE player_id = :player_id"
    );
    $stmt->execute([
        ":player_id" => $selectedPlayerId
    ]);

    unset($_SESSION["resources_quantity"][$selectedPlayerId]);
}

$_SESSION["day"] = 30;
unset($_SESSION["health"], $_SESSION["energy"], $_SESSION["food"]);

header("Location: inGame.php");

exit;
?>