<?php
    require_once __DIR__ . "/../public/functions.php";

    class Game {
        private PDO $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }


        public function passDay() {
            
        }
    }
?>