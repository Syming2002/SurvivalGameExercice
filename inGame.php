<?php

session_start();

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/classes/Player.php";
require_once __DIR__ . "/classes/Action.php";
require_once __DIR__ . "/database/database.php";
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/public/functions.php";

$player = new Player($pdo);
$actionManager = new Action($pdo);

$selectedPlayerId = $_POST["player_id"] ?? $_SESSION["player_id"] ?? null;

$selectedPlayer = null;

$_SESSION["day"] = 30;

if($selectedPlayerId !== null) {
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["action_name"])) {
        $actionName = $_POST["action_name"];
        $healthChange = 0;
        switch ($actionName) {

            case 'beat':
                if (rand(0, 1) === 0) {
                    $healthChange = -15;
                }
                break;

            case 'sleep':
                $_SESSION["day"]--;
                $healthChange = 100;
                
                break;

            case 'rest':
                $healthChange = 5;
                break;

            default:
                $healthChange = 0;
                break;
        }

        $sql = "UPDATE player
                SET health = LEAST(100, GREATEST(0, health + :change))
                WHERE player_id = :player_id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':change' => $healthChange,
            ':player_id' => $selectedPlayerId
            ]);

        }

        $selectedPlayer =  $player->getAllPlayersAttributById((int) $selectedPlayerId);
        $_SESSION["health"] = $player->getPlayerHealth((int) $selectedPlayerId);
        $_SESSION["energy"] = $player->getPlayerEnergy((int) $selectedPlayerId);
        $_SESSION["food"] = $player->getPlayerFood((int) $selectedPlayerId);
}



$loader = new FilesystemLoader(
    __DIR__ . "/templates"
);

$twig = new Environment($loader);

// afficher les templates
echo $twig->render("inGame.html.twig", [
    "selectedPlayer" => $selectedPlayer,
    "actions" => $actionManager -> getAllActions(),
    "day" => $_SESSION["day"]
]);
?>
