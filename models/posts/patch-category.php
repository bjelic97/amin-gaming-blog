<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['btnPatchCategory'])) {
    require_once '../../config/connection.php';
    require_once '../posts/functions.php';

    $errors = [];

    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $category = isset($_POST['category']) ? $_POST['category'] : null;

    if ($id === null) {
        array_push($errors, "There is no information about which post is being updated.");
    }

    if ($category === null) {
        array_push($errors, "Category is required.");
    }

    if (count($errors) > 0) {
        http_response_code(400);
        echo json_encode($errors);
        log_error($errors, $_SERVER['PHP_SELF']);
    } else {
        try {
            require_once '../../config/connection.php';
            require_once '../posts/functions.php';
            $result = patchPostCategory($id, $category);
            if ($result === null) {
                http_response_code(204);
            } else {
                array_push($errors, "An error ocurred while trying to update post.");
                echo json_encode($errors);
                http_response_code(500);
                log_error($errors, $_SERVER['PHP_SELF']);
            }
        } catch (PDOException $ex) {
            array_push($errors, $ex->getMessage());
            echo json_encode($errors);
            http_response_code(500);
            log_error($errors, $_SERVER['PHP_SELF']);
        }
    }
} else {
    http_response_code(400);
}
