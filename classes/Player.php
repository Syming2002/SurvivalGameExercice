<?php
    require_once __DIR__ . "/../public/functions.php";
    class Player {
        private PDO $pdo;
        

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function addPlayer(string $userName, string $password): void {
            addPlayer($this->pdo, $userName, $password);
        }

        public function getPlayerHealth(int $playerId): array {
            return getPlayerHealthById($this->pdo, $playerId);
        }

        public function getPlayerEnergy(int $playerId): array {
            return getPlayerEnergyById($this->pdo, $playerId);
        }

        public function getPlayerFood(int $playerId): array {
            return getPlayerFoodById($this->pdo, $playerId);
        }

        public function getAllPlayersAttributById(int $playerId): array {
            return getPlayersAttributById($this->pdo, $playerId);
        }
    }
?>