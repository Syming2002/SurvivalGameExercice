<?php
    require_once __DIR__ . "/../public/functions.php";
    require_once __DIR__ . "/../inGame.php";
    class Inventory {
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }


        public function getAllResourcesFromInventoryByPlayerId(int $playerId) {
            return getResourceInInventoryByPlayer($this->pdo, $playerId);
        }
    }

?>