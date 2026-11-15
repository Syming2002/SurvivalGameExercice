<?php
    require_once __DIR__ . "/../public/functions.php";
    require_once __DIR__ . "/../inGame.php";
    class Resource {
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        // ajoute les resources de manière aléatoire
        public function addRandomResources(): array {
            $resourceId = rand(1, 7);
            $quantity = 1;

            if ($resourceId === 1) {
                $quantity = rand(0, 2) === 2 ? 5 : 1;
            } else if ($resourceId === 2) {
                $quantity = rand(0, 2) === 2 ? 2 : 1;
            } else if ($resourceId === 3) {
                $quantity = rand(0, 2) === 2 ? 3 : 1;
            } else if ($resourceId === 4) {
                $quantity = rand(0, 2) === 2 ? 5 : 1;
            } else if ($resourceId === 5 || $resourceId === 6) {
                $quantity = rand(0, 2) === 2 ? 3 : 1;
            } else if ($resourceId === 7) {
                $quantity = rand(0, 2) === 2 ? 2 : 1;
            }

            return [
                "resource_id" => $resourceId,
                "quantity" => $quantity
            ];
        }

        // fonction qui récupère toute les resources
        public function getAllResources(): array {
            return getResources($this->pdo);
        }
    }

?>