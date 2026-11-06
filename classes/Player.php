<?php
    require_once __DIR__ . "/../public/functions.php";
    class Player {
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function addPlayer(string $userName): int {
            return addPlayer($this->pdo, $userName);
        }

        public function getPlayerAttribut(int $playerId): array {
            return getPlayerAttributById($this->pdo, $playerId);
        }

        public function getAllPlayersName(): array {
            return getPlayersUsername($this->pdo);
        }
    }
?>