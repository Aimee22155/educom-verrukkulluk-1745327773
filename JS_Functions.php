<?php

// functions voor javascript
function saveRating($pdo, $itemId, $rating) {
    $sql = "INSERT INTO dish_info 
            (record_type, dish_id, user_id, date, numberfield) 
            VALUES (:record_type, :dish_id, :user_id, NOW(), :numberfield)";
    $stmt = $pdo->prepare($sql);

    $params = [
        ':record_type' => 'R',
        ':dish_id'     => $itemId,
        ':user_id'     => null,
        ':numberfield' => $rating
    ];

    if (!$stmt->execute($params)) {
        $error = $stmt->errorInfo();
        return false;
    }

    return true;
}

function getAverageRating($pdo, $itemId) {
    $sql = "SELECT AVG(numberfield) AS average 
            FROM dish_info 
            WHERE record_type = :record_type AND dish_id = :dish_id";
    $stmt = $pdo->prepare($sql);

    $params = [
        ':record_type' => 'R',
        ':dish_id'     => $itemId
    ];

    if (!$stmt->execute($params)) {
        $error = $stmt->errorInfo();
        return null;
    }

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['average'] ?? null;
}

function saveFavorite($pdo, $itemId) {
    // Check if it's already a favorite
    $sql_check = "SELECT COUNT(*) 
                  FROM dish_info 
                  WHERE record_type = :record_type AND dish_id = :dish_id";
    $stmt_check = $pdo->prepare($sql_check);
    
    $params = [
        ':record_type' => 'F',
        ':dish_id'     => $itemId
    ];

    if (!$stmt_check->execute($params)) {
        return ['success' => false, 'added' => false];
    }

    $count = $stmt_check->fetchColumn();

    if ($count > 0) {
        // Already a favorite — remove it
        $sql_delete = "DELETE 
                       FROM dish_info 
                       WHERE record_type = :record_type AND dish_id = :dish_id";
        $stmt_delete = $pdo->prepare($sql_delete);
        $result_delete = $stmt_delete->execute($params);

        return ['success' => $result_delete, 'added' => false];
    } else {
        // Not a favorite — add it
        $sql_insert = "INSERT INTO dish_info (record_type, dish_id, date) 
                       VALUES (:record_type, :dish_id, NOW())";
        $stmt_insert = $pdo->prepare($sql_insert);
        $result_insert = $stmt_insert->execute($params);

        return ['success' => $result_insert, 'added' => true];
    }
}

function isFavorite($pdo, $itemId) {
    $sql = "SELECT COUNT(*) 
            FROM dish_info 
            WHERE record_type = :record_type AND dish_id = :dish_id";
    $stmt = $pdo->prepare($sql);

    $params = [
        ':record_type' => 'F',
        ':dish_id'     => $itemId
    ];

    if (!$stmt->execute($params)) {
        $error = $stmt->errorInfo();
        return false;
    }

    $count = $stmt->fetchColumn();
    return $count > 0;
}
