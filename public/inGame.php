<?php
require_once __DIR__ . "/../database/database.php";
require_once __DIR__ . "/functions.php";

$actions = getActions($pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main>
    <?php foreach($actions as $action) { ?>
        <button><?= htmlspecialchars($action["action_name"]) ?></button>
    <?php } ?>
</main>
</body>
</html>
