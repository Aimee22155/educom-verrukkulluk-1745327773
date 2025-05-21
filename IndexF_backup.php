<?php

require_once("./vendor/autoload.php");

$loader = new \Twig\Loader\FilesystemLoader("./templates");

// VOOR PRODUCTIE:
// In productie gebruik je caching voor betere performance
// $twig = new \Twig\Environment($loader, ["cache" => "./cache/cc"]);

// VOOR DEVELOPMENT:
// Debugmodus aanzetten en geen caching om makkelijker te kunnen ontwikkelen
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Laad de benodigde PHP-bestanden voor database en dataklassen
require_once("lib/database.php");
require_once("lib/dishes.php");
require_once("lib/dish_info.php");
require_once("lib/groceries_article.php");
require_once("lib/ingredient.php");
require_once("lib/article.php");
require_once("lib/kitchen_type.php");
require_once("lib/User.php");

// Maak een database-object aan en verkrijg een verbinding
$db = new database();
$connection = $db->getConnection();

// Initialiseert een object van de Dishes-klasse, waarmee je recepten kunt ophalen
$dish = new Dishes($connection);

// Lees de URL-parameters in
$dish_id = isset($_GET["dish_id"]) ? $_GET["dish_id"] : "";

// Bepaal de actie die moet worden uitgevoerd op basis van de 'action' parameter
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";


// Switch statement bepaalt welke pagina er wordt geladen op basis van 'action'
switch($action) {

    case "homepage": {
        $data = $dish->selectRecipeOrMore();
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
    
    case "grocery_list": {
        $data = $dish->selectRecipeOrMore($dish_id);
        $template = 'grocery.html.twig';
        $title = "grocery pagina";
        break;
    }

    // case "rating": {
    //     $data = $dish->selectRecipeOrMore($dish_id, $user_id, $record_type);
    //     $template = 'detail.html.twig';
    //     $title = "detail pagina";
    //     break;
    // }

    // case "favorites": {
    //     $data = $dish->selectRecipeOrMore($dish_id, $user_id, $record_type);
    //     $template = 'main.html.twig';
    //     $title = "main pagina";
    //     break;
    // }

    // case "search_bar": {
    //     $data = $dish->selectRecipeOrMore($dish_id, $keyword);
    //     $template = 'main.html.twig';
    //     $title = "main pagina";
    //     break;
    // }
}

// Laad het juiste Twig-template op basis van de geselecteerde actie
$template = $twig->load($template);

// Render de HTML-pagina met de opgehaalde data en titel
echo $template->render([
    "title" => $title,
    "data" => $data
]);


//url-detail= http://localhost/educom-verrukkulluk-1745327773/indexF.php?dish_id=4&action=detail
//url-grocery_list= http://localhost/educom-verrukkulluk-1745327773/indexF.php?dish_id=4&action=grocery_list