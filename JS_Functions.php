<?php

function saveRating($mysqli, $itemId, $rating) {
    // user_id is NULL, dus direct NULL in de query
    $sql = "INSERT INTO dish_info (record_type, dish_id, user_id, date, numberfield) VALUES (?, ?, NULL, NOW(), ?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        return false;
    }

    $record_type = 'R'; 
    // bind_param types: s = string, i = integer
    $stmt->bind_param('sis', $record_type, $itemId, $rating);

    if (!$stmt->execute()) {
        return false;
    }
    return true;
}

function getAverageRating($mysqli, $itemId) {
    $sql = "SELECT AVG(numberfield) AS average 
            FROM dish_info 
            WHERE record_type = ? AND dish_id = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        return null;
    }

    $record_type = 'R';
    $stmt->bind_param('si', $record_type, $itemId);

    if (!$stmt->execute()) {
        return null;
    }

    $result = $stmt->get_result()->fetch_assoc();
    return $result['average'] ?? null;
}

function saveFavorite($mysqli, $itemId) {
    // Check of favoriet al bestaat
    $sql_check = "SELECT COUNT(*) AS count FROM dish_info WHERE record_type = ? AND dish_id = ?";
    $stmt_check = $mysqli->prepare($sql_check);
    if (!$stmt_check) {
        return ['success' => false, 'added' => false];
    }

    $record_type = 'F';
    $stmt_check->bind_param('si', $record_type, $itemId);

    if (!$stmt_check->execute()) {
        return ['success' => false, 'added' => false];
    }

    $result = $stmt_check->get_result()->fetch_assoc();
    $count = $result['count'] ?? 0;

    if ($count > 0) {
        // Favoriet verwijderen
        $sql_delete = "DELETE FROM dish_info WHERE record_type = ? AND dish_id = ?";
        $stmt_delete = $mysqli->prepare($sql_delete);
        if (!$stmt_delete) {
            return ['success' => false, 'added' => false];
        }
        $stmt_delete->bind_param('si', $record_type, $itemId);
        $success = $stmt_delete->execute();

        return ['success' => $success, 'added' => false];
    } else {
        // Favoriet toevoegen
        $sql_insert = "INSERT INTO dish_info (record_type, dish_id, date) VALUES (?, ?, NOW())";
        $stmt_insert = $mysqli->prepare($sql_insert);
        if (!$stmt_insert) {
            return ['success' => false, 'added' => false];
        }
        $stmt_insert->bind_param('si', $record_type, $itemId);
        $success = $stmt_insert->execute();

        return ['success' => $success, 'added' => true];
    }
}

function isFavorite($mysqli, $itemId) {
    $sql = "SELECT COUNT(*) AS count FROM dish_info WHERE record_type = ? AND dish_id = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        return false;
    }

    $record_type = 'F';
    $stmt->bind_param('si', $record_type, $itemId);

    if (!$stmt->execute()) {
        return false;
    }

    $result = $stmt->get_result()->fetch_assoc();
    $count = $result['count'] ?? 0;
    return $count > 0;
}
