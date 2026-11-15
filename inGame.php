<?php

session_start();

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . "/classes/Player.php";
require_once __DIR__ . "/classes/Action.php";
require_once __DIR__ . "/classes/Resource.php";

require_once __DIR__ . "/database/database.php";
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/public/functions.php";

$player = new Player($pdo);
$actionManager = new Action($pdo);
$resource = new Resource($pdo);

$selectedPlayerId = $_POST["player_id"] ?? $_SESSION["player_id"] ?? null;

$selectedPlayer = null;
$playerResources = [];
$resourceDefinitions = $resource->getAllResources();

if (!isset($_SESSION["day"])) {
    $_SESSION["day"] = 30;
}

if($selectedPlayerId !== null) {
    $playerId = (int) $selectedPlayerId;

    if (!isset($_SESSION["resources_quantity"]) || !is_array($_SESSION["resources_quantity"])) {
        $_SESSION["resources_quantity"] = [];
    }

    if (!isset($_SESSION["resources_quantity"][$playerId]) || !is_array($_SESSION["resources_quantity"][$playerId])) {
        $_SESSION["resources_quantity"][$playerId] = [];
    }

    foreach ($resourceDefinitions as $resourceDefinition) {
        $resourceId = (int) $resourceDefinition["resource_id"];
        if (!isset($_SESSION["resources_quantity"][$playerId][$resourceId])) {
            $_SESSION["resources_quantity"][$playerId][$resourceId] = 0;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["action_name"])) {
        $actionName = $_POST["action_name"];
        $healthChange = 0;
        $energyChange = 0;
        $foodChange = 0;
        switch ($actionName) {

            case 'beat':
                if (rand(0, 1) === 0) {
                    $healthChange = -2;
                }
                break;

            case 'sleep':
                $_SESSION["day"]--;
                $healthChange = 10;
                $energyChange = 10;
                break;

            case 'rest':
                $healthChange = 5;
                $energyChange = 10;
                $foodChange = rand(0, 3);
                break;

            case 'gather':
                if ($_SESSION["energy"] > 0 || $_SESSION["food"] > 0) {
                    $gatheredResource = $resource->addRandomResources();
                    $resourceId = $gatheredResource["resource_id"];
                    $_SESSION["resources_quantity"][$playerId][$resourceId] += $gatheredResource["quantity"];
                    $energyChange = -5;
                }
                break;
            
            case 'build':
                $energyChange = -10;
                $foodChange = -5;
                break;
            default:
                $healthChange = 0;
                $energyChange = 0;
                break;
        }

        $sql = "UPDATE player
                SET health = LEAST(20, GREATEST(0, health + :healthChange))
                WHERE player_id = :player_id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':healthChange' => $healthChange,
            ':player_id' => $selectedPlayerId
            ]);

        $sql = "UPDATE player
                SET energy = LEAST(20, GREATEST(0, energy + :energyChange))
                WHERE player_id = :player_id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':energyChange' => $energyChange,
            ':player_id' => $selectedPlayerId
            ]);

        $sql = "UPDATE player
                SET food = LEAST(20, GREATEST(0, energy + :foodChange))
                WHERE player_id = :player_id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':foodChange' => $foodChange,
            ':player_id' => $selectedPlayerId
            ]);

    }

    $selectedPlayer = $player->getAllPlayersAttributById($playerId);
    $playerHealth = $player->getPlayerHealth($playerId);
    $_SESSION["health"] = (int) $playerHealth["health"];
    $_SESSION["energy"] = (int) $selectedPlayer["energy"];
    $_SESSION["food"] = (int) $selectedPlayer["food"];

    foreach ($resourceDefinitions as $resourceDefinition) {
        $resourceId = (int) $resourceDefinition["resource_id"];
        $playerResources[] = [
            "resource_id" => $resourceId,
            "resource_name" => $resourceDefinition["resource_name"],
            "quantity" => $_SESSION["resources_quantity"][$playerId][$resourceId]
        ];
    }

    if ($_SESSION["day"] === 0) {
        header("Location: victoryScreen.php");
        exit;
    }

    if ($_SESSION["health"] <= 0) {
        header("Location: defeatScreen.php");
        exit;
    }
}   


$loader = new FilesystemLoader(
    __DIR__ . "/templates"
);

$twig = new Environment($loader);

// afficher les templates
echo $twig->render("inGame.html.twig", [
    "selectedPlayer" => $selectedPlayer,
    "actions" => $actionManager -> getAllActions(),
    "day" => $_SESSION["day"],
    "health" => $_SESSION["health"] ?? null,
    "resources" => $playerResources
]);
?>
