<?php
//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("./vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("./templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

/******************************/

/// Next step, data ophalen
require_once("lib/database.php");
require_once("lib/dishes.php");

$db = new database();
$connection = $db->getConnection();

$dish = new Dishes($connection);

$dish_id = isset($_GET["dish_id"]) ? $_GET["dish_id"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";

switch($action) {

    case "homepage": {
        //array with all dishes
        $dish_ids = [1, 2, 3, 4];
        $data = $dish->selectRecipeOrMore($dish_ids);
        $template = 'homepage.html.twig';
        $title = "homepage";
        break;
    }

    case "detail": {
        $data = $dish->selectRecipeOrMore($dish_id);
        $template = 'detail.html.twig';
        $title = "detail pagina";
        break;
    }
}

/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);

/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data]);
