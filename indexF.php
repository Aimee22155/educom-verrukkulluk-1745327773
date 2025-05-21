<?php

require_once("./vendor/autoload.php");

$loader = new \Twig\Loader\FilesystemLoader("./templates");

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
$title = "Verrukkulluk";

// functions voor javascript
// Rating op te slaan 
function saveRating($mysqli, $itemId, $rating) {
    $sql = "INSERT INTO dish_info (record_type, dish_id, user_id, date, numberfield) VALUES ('R', ?, NULL, NOW(), ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $itemId, $rating);
    return $stmt->execute();
}

// Gemiddelde cijfer op halen
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
        // OPSLAAN VAN EEN RATING (VIA POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lees de JSON data uit de request body
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);

            // Controleer of de benodigde velden aanwezig zijn in de JSON data
            if (isset($data['type']) && $data['type'] === 'rate' && isset($data['item_id']) && isset($data['rating'])) {
                // Haal de item ID en rating uit de data en cast ze naar integers
                $itemId = (int)$data['item_id'];
                $rating = (int)$data['rating'];

                // Sla de rating op in de database
                if (saveRating($connection, $itemId, $rating)) {
                    $average = getAverageRating($connection, $itemId);
                    echo json_encode(['success' => true, 'average' => $average]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Kon de rating niet opslaan.']);
                }
                exit();
            } else {
                // Als de POST data niet de verwachte structuur heeft, stuur een 400 Bad Request
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Ongeldige POST data.']);
                exit();
            }
        }

        // GEMIDDELDE RATING (VIA GET)
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['request_type']) && $_GET['request_type'] === 'average' && isset($_GET['item_id'])) {
            // Haal het item ID uit de GET parameters en cast het naar een integer
            $itemId = (int)$_GET['item_id'];
            // Haal de gemiddelde rating op
            $average = getAverageRating($connection, $itemId);

            // Controleer of er een gemiddelde rating is gevonden
            if ($average !== null) {
                echo json_encode(['success' => true, 'average' => $average]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Nog geen ratings voor dit item.']);
            }
            exit();
        }

        // ALS GEEN VAN DE BOVENSTAANDE VOORWAARDEN KLOPT
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
    $template = $twig->load($template);

    echo $template->render([
        "title" => $title,
        "data" => $data
    ]);
}
