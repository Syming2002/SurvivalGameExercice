<?php 
require_once __DIR__ . "/../database/database.php";
require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/addPlayer.php";

$players = getPlayers($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .choose-player-name {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 25px;
    }
    .player-username-label {
        margin-top: 25px;
    }
    .choose-player-button {
        font-family: monocraft;
        src: url("../fonts/Monocraft.ttf");
        background-color: grey;
        width: calc(200px - 32px);
        height: calc(75px - 24px);
        color: white;
    }
</style>
<body>
    <form class="choose-player-name" action="/public/inGame.php" method="GET">
        <label class="player-username-label" for="player_username">Choose a player</label>
        <?php if (!empty($players)) { ?>
            <select name="player_username" id="player_username">
                <?php foreach ($players as $player) { ?>
                    <option value="<?= htmlspecialchars($player["player_username"], ENT_QUOTES, "UTF-8") ?>">
                        <?= htmlspecialchars($player["player_username"], ENT_QUOTES, "UTF-8") ?>
                    </option>
                <?php } ?>
            </select>
            <button type="submit" class="choose-player-button">Choose player</button>
        <?php } else { ?>
            <p>No player found</p>
        <?php } ?>
</form>
</body>
</html>
