<?php 

    function getActions(PDO $pdo): array {
        $sql = "SELECT * FROM action";
        $stmt = $pdo -> query($sql);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    function addAction(PDO $pdo, string $actionName, int $playerId) {
        $sql = "INSERT INTO action (action_name, player_id) 
        VALUES (:action_name, :player_id)";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(
            [
                "action_name" => $actionName,
                "player_id" => $playerId
            ]
        );
    }

    function getPlayersUsername(PDO $pdo): array {
        $sql = "SELECT player_id, player_username FROM player";
        $stmt = $pdo -> query($sql);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    function addPlayer(PDO $pdo, string $playerUsername): int {
        $sql = "INSERT INTO player (player_username, health, energy, food) 
        VALUES (:player_username, 20, 40, 20)";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(
            ["player_username" => $playerUsername]
        );
        return $pdo -> lastInsertId();
    }

    function getPlayerAttributById(PDO $pdo, int $playerId): ?array {
        $sql = "SELECT player_id, player_username, health, energy, food FROM player
                WHERE player_id = :playerId";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(
            ["playerId" => $playerId]
        );
        $player = $stmt -> fetch(PDO::FETCH_ASSOC);
        return $player === false ? null : $player;
    }
?>
