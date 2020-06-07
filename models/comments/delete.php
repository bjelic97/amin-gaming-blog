<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['btnDeleteComment'])) {
    require_once '../../config/connection.php';
    require_once 'functions.php';

    $errors = [];
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    if ($id === 0) {
        array_push($errors, "There is no information about comment.");
    }

    if (count($errors) > 0) {
        log_error($errors, $_SERVER['PHP_SELF']);
        echo json_encode($errors);
        http_response_code(400);
    } else {
        try {
            $result = deleteComment($id);
            echo json_encode($result);
            if ($result === null) {
                http_response_code(204);
            } else {
                array_push($errors, "An error ocurred while deleting a comment.");
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
    }
} else {
    http_response_code(400);
}
