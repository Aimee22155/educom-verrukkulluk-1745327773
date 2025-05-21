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

// Stel een default template in
$template = 'homepage.html.twig';
$title = "Verrukkulluk"; // Een default titel

// functions voor javascript
// Functie om een rating op te slaan (in dish_info tabel)
function saveRating($mysqli, $itemId, $rating) {
    $sql = "INSERT INTO dish_info (record_type, dish_id, user_id, date, numberfield) VALUES ('R', ?, NULL, NOW(), ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $itemId, $rating);
    return $stmt->execute();
}

// Functie om het gemiddelde cijfer op te halen (uit dish_info tabel)
function getAverageRating($mysqli, $itemId) {
    $sql = "SELECT AVG(numberfield) AS average FROM dish_info WHERE record_type = 'R' AND dish_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['average'];
}

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

    case "rating_actions": {
        // Afhandeling van het opslaan van een rating
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST === []) {
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);

            if ($data && isset($data['type']) && $data['type'] === 'rate' && isset($data['item_id']) && isset($data['rating'])) {
                $itemId = (int)$data['item_id'];
                $rating = (int)$data['rating'];

                if (saveRating($connection, $itemId, $rating)) {
                    $average = getAverageRating($connection, $itemId);
                    echo json_encode(['success' => true, 'average' => $average]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Kon de rating niet opslaan.']);
                }
                exit();
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Ongeldige POST data voor raten.']);
                exit();
            }
        }

        // Afhandeling van het ophalen van het gemiddelde (hier is geen user ID nodig)
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['request_type']) && $_GET['request_type'] === 'average' && isset($_GET['item_id'])) {
            $itemId = (int)$_GET['item_id'];
            $average = getAverageRating($connection, $itemId);

            if ($average !== null) {
                echo json_encode(['success' => true, 'average' => $average]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Nog geen ratings voor dit gerecht.']);
            }
            exit();
        }

        // Als geen van de bovenstaande voorwaarden klopt
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Ongeldige rating actie.']);
        exit();
        break;
    }

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

// Alleen de pagina renderen als de actie niet 'rating_actions' is
if ($action !== 'rating_actions') {
    // Laad het juiste Twig-template op basis van de geselecteerde actie
    $template = $twig->load($template);

    // Render de HTML-pagina met de opgehaalde data en titel
    echo $template->render([
        "title" => $title,
        "data" => $data
    ]);
}

//url-detail= http://localhost/educom-verrukkulluk-1745327773/indexF.php?dish_id=4&action=detail
//url-grocery_list= http://localhost/educom-verrukkulluk-1745327773/indexF.php?dish_id=4&action=grocery_list