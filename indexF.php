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

/// Next step, iets met je data doen. Ophalen of zo
require_once("lib/dishes.php");

require_once("lib/dish_info.php");
require_once("lib/groceries_article.php");
require_once("lib/ingredient.php");
require_once("lib/article.php");
require_once("lib/kitchen_type.php");
require_once("lib/users.php");

$dish = new Dishes();
$data = $dish->selectRecipeOrMore();

/*
URL:
http://localhost/index.php?gerecht_id=4&action=detail
*/

$dish_id = isset($_GET["dish_id"]) ? $_GET["dish_id"] : "";
$user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;
$rating = isset($_GET["rating"]) ? $_GET["rating"] : null;
$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";


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

        case "Grocery_list": {
            $data = $dish->selectRecipeOrMore($dish_id, $user_id);
            $template = //'... .html.twig';
            $title = "Grocery pagina";
            break;
        }

        case "Favorites": {
            $data = $dish->selectRecipeOrMore($dish_id, $user_id);
            $template = //'... .html.twig';
            $title = "detail pagina";
            break;
        }

        case "Rating": {
            $data = $dish->selectRecipeOrMore($dish_id, $rating);
            $template = //'... .html.twig';
            $title = "detail pagina";
            break;
        }

        case "Search_bar": {
            $data = $dish->selectRecipeOrMore($dish_id, $keyword);
            $template = //'... .html.twig';
            $title = "detail pagina";
            break;
        }
}

/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data]);
