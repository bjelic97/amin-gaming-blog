<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['id'])) {
    require_once '../../config/connection.php';
    require_once '../posts/functions.php';

    $errors = [];
    $id = $_POST['id'];

    try {
        // SOFT DELETE

        $result = deletePost($id);
        echo json_encode($result);
        if ($result === null) {
            http_response_code(204);
        } else {
            array_push($errors, "An error ocurred while deleting a post.");
            log_error($errors, $_SERVER['PHP_SELF']);
            echo json_encode($errors);
            http_response_code(500);
        }
    } catch (PDOException $ex) {
        array_push($errors, $ex->getMessage());
        log_error($errors, $_SERVER['PHP_SELF']);
        echo json_encode($errors);
        http_response_code(500);
    }

    // mora try catch u funkcijama !
} else {
    http_response_code(400);
}
