<?php
    require_once __DIR__ . "/../public/functions.php";
    require_once __DIR__ . "/../inGame.php";
    class Action {
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function onBeatClick(int $selectedPlayerId): array {
            if (rand(0, 1) === 0) {
                return removeHealthToPlayer($this->pdo, $selectedPlayerId, 5);
            }
            return removeHealthToPlayer($this->pdo, $selectedPlayerId, 0);
        }

        public function getAllActions(): array {
            return getActions($this->pdo);
        }
    }
?>