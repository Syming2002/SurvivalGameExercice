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

    function getActionsName(PDO $pdo): array {
        $sql = "SELECT action_name FROM action";
        $stmt = $pdo -> query($sql);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    function getPlayers(PDO $pdo, string $userName): array {
        $sql = "SELECT player_id, player_username, password FROM player
        WHERE player_username = :userName";

        $stmt = $pdo -> prepare($sql);
        $stmt -> execute([
            "userName" => $userName
        ]);

        $players = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $players;
    }

    function getPlayersAttributById(PDO $pdo, int $playerId): array {
        $sql = "SELECT player_id, player_username, health, energy, food 
                FROM player
                WHERE player_id = :playerId";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(
            ["playerId" => $playerId]
        );
        $player = $stmt -> fetch(PDO::FETCH_ASSOC);
        return $player;
    }

    function addPlayer(PDO $pdo, string $playerUsername, string $password): void {
        $sql = "INSERT INTO player (player_username, health, energy, food, password) 
        VALUES (:player_username, 20, 40, 20, :password)";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(
            [
                "player_username" => $playerUsername, 
                "password" => $password
            ]
        );
    }

    function getPlayerHealthById(PDO $pdo, int $playerId): array {
        $sql = "SELECT player_id, health FROM player
                WHERE player_id = :playerId";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(
            ["playerId" => $playerId]
        );
        $player = $stmt -> fetch(PDO::FETCH_ASSOC);
        return $player;
    }

    function addHealthToPlayer(PDO $pdo, int $playerId, int $amount): array {
        $sql = "UPDATE player SET health = LEAST(20, health + :amount) WHERE player_id = :playerId";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(
            ["playerId" => $playerId,
            "amount" => $amount]
        );
        return getPlayerHealthById($pdo, $playerId);
    }

    function removeHealthToPlayer(PDO $pdo, int $playerId, int $amount): array {
        $sql = "UPDATE player SET health = GREATEST(0, health - :amount) WHERE player_id = :playerId";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(
            ["playerId" => $playerId,
            "amount" => $amount]
        );
        return getPlayerHealthById($pdo, $playerId);
    }

    function getPlayerEnergyById(PDO $pdo, int $playerId): array {
        $sql = "SELECT player_id, energy FROM player
                WHERE player_id = :playerId";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(
            ["playerId" => $playerId]
        );
        $player = $stmt -> fetch(PDO::FETCH_ASSOC);
        return $player;
    }

    function getPlayerFoodById(PDO $pdo, int $playerId): array {
        $sql = "SELECT player_id, food FROM player
                WHERE player_id = :playerId";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(
            ["playerId" => $playerId]
        );
        $player = $stmt -> fetch(PDO::FETCH_ASSOC);
        return $player;
    }
?>
