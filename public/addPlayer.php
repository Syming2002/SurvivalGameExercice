<?php 
require_once __DIR__ . "/../database/database.php";
require_once __DIR__ . "/functions.php";

$message = '';
?>



<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $userName = trim($_POST["player_username"] ?? '');
    

        // Vérification des données

        if (
            $userName !== ''
        ) {
        
            addPlayer($pdo, $userName);
        } else {
            $message = "Enter a valid Username";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
.form-username {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    margin-top: 25px;
    gap: 25px;
}
#username {
    font-family: monocraft;
    src: url("../fonts/Monocraft.ttf");
}
.start-button {
    font-family: monocraft;
    src: url("../fonts/Monocraft.ttf");
    background-color: grey;
    width: calc(200px - 32px);
    height: calc(75px - 24px);
    color: white;
}
</style>
<body>
    
</body>
</html>
<form class="form-username" method="POST">
    <label for="player_username">Choose an Username</label>
    <input type="text" name="player_username" id="player_username" required>
    <button type="submit" class="start-button">
        Add a player
    </button>
</form>