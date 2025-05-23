<?php

require_once("./vendor/autoload.php");

$loader = new \Twig\Loader\FilesystemLoader("./templates");

$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

// nodige files
    require_once("lib/database.php");
    require_once("lib/dishes.php");
    require_once("lib/dish_info.php");
    require_once("lib/groceries_article.php");
    require_once("lib/ingredient.php");
    require_once("lib/article.php");
    require_once("lib/kitchen_type.php");
    require_once("lib/User.php");
   
$db = new database();
$connection = $db->getConnection();

$dish = new Dishes($connection);

// Lees de URL-parameters in
$dish_id = isset($_GET["dish_id"]) ? $_GET["dish_id"] : "";

// Bepaal de actie die moet worden uitgevoerd op basis van de 'action' parameter
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";

// Stel een default template in
$template = 'homepage.html.twig';
$title = "Verrukkulluk";

// functions voor javascript
function saveRating($mysqli, $itemId, $rating) {
    $itemId = (int)$itemId;
    $rating = (int)$rating;
    $sql = "INSERT INTO dish_info (record_type, dish_id, user_id, date, numberfield) VALUES ('R', " . $itemId . ", NULL, NOW(), " . $rating . ")";
    return $mysqli->query($sql);
}

function getAverageRating($mysqli, $itemId) {
    $itemId = mysqli_real_escape_string($mysqli, $itemId);
    $sql = "SELECT AVG(numberfield) AS average FROM dish_info WHERE record_type = 'R' AND dish_id = '" . $itemId . "'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row['average'];
}

function saveFavorite($mysqli, $itemId) {
    $itemId = mysqli_real_escape_string($mysqli, $itemId);

    $sql_check = "SELECT COUNT(*) FROM dish_info WHERE record_type = 'F' AND dish_id = '" . $itemId . "'";
    $result_check = $mysqli->query($sql_check);
    $row_check = $result_check->fetch_row();

    if ($row_check[0] > 0) {
        $sql_delete = "DELETE FROM dish_info WHERE record_type = 'F' AND dish_id = '" . $itemId . "'";
        $result_delete = $mysqli->query($sql_delete);
        return ['success' => $result_delete, 'added' => false];
    } else {
        $sql_insert = "INSERT INTO dish_info (record_type, dish_id, date) VALUES ('F', '" . $itemId . "', NOW())";
        $result_insert = $mysqli->query($sql_insert);
        return ['success' => $result_insert, 'added' => true];
    }
}

function isFavorite($mysqli, $itemId) {
    $itemId = mysqli_real_escape_string($mysqli, $itemId);

    $sql = "SELECT COUNT(*) FROM dish_info WHERE record_type = 'F' AND dish_id = '" . $itemId . "'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_row();
    return $row[0] > 0;
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
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);

            // Controleer of de benodigde velden aanwezig zijn in de JSON data
            if (isset($data['type']) && $data['type'] === 'rate' && isset($data['item_id']) && isset($data['rating'])) {
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
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Ongeldige POST data.']);
                exit();
            }
        }

        // GEMIDDELDE RATING (VIA GET)
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['request_type']) && $_GET['request_type'] === 'average' && isset($_GET['item_id'])) {
            $itemId = (int)$_GET['item_id'];
            $average = getAverageRating($connection, $itemId);

            // Controleer of er een gemiddelde rating is gevonden
            if ($average !== null) {
                echo json_encode(['success' => true, 'average' => $average]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Nog geen ratings voor dit item.']);
            }
            exit();
        }

        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Ongeldige rating actie.']);
        exit();
        break;
    }

    case "favorites_actions": {
        // OPSLAAN/VERWIJDEREN VAN FAVORIET (VIA POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);

            if (isset($data['type']) && $data['type'] === 'favorite' && isset($data['item_id'])) {
                $itemId = (int)$data['item_id'];
                $result = saveFavorite($connection, $itemId);
                echo json_encode(['success' => $result['success'], 'added' => $result['added']]);
                exit();
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Ongeldige POST data voor favorieten.']);
                exit();
            }
        }
        
        // CHECKEN OF GERECHT FAVORIET IS (VIA GET)
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['request_type']) && $_GET['request_type'] === 'check' && isset($_GET['item_id'])) {
            $itemId = (int)$_GET['item_id'];
            $is_fav = isFavorite($connection, $itemId);
            echo json_encode(['success' => true, 'is_favorite' => $is_fav ? 1 : 0]);
            exit();
        }
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Ongeldige favorieten actie.']);
        exit();
        break;
    }

    case "search": {
        $searchTerm = isset($_GET["query"]) ? $_GET["query"] : "";
        if (!empty($searchTerm)) {
            $data = $dish->searchDishesByIngredient($searchTerm);
            $template = 'home.html.twig';
            $title = "Zoekresultaten voor '" . htmlspecialchars($searchTerm) . "'";
        } else {
            // Als er geen zoekterm is, tonen we de homepage
            $data = $dish->selectRecipeOrMore();
            $template = 'home.html.twig';
            $title = "Verrukkulluk";
        }
        break;
    }
}
// Alleen de pagina renderen als de actie niet 'rating_actions' is
if ($action !== 'rating_actions') {
    $template = $twig->load($template);

    echo $template->render([
        "title" => $title,
        "data" => $data
    ]);
}