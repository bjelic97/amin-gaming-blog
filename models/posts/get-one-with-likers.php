<?php
session_start(); // for the purpose ov attendance file that notes logged user
header('Content-Type: application/json');

if (isset($_POST['btnGetPost'])) {
    require_once '../../config/connection.php';
    require_once 'functions.php';

    $errors = [];
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($id === null) {
        array_push($errors, "There is no information about which post to get.");
    }

    if (count($errors) > 0) {
        http_response_code(400);
        echo json_encode($errors);
        log_error($errors, $_SERVER['PHP_SELF']);
    } else {
        try {
            $response = getOneResponse($id);
            http_response_code(200);
            echo json_encode($response); // mora try catch u funkcijama !
        } catch (PDOException $ex) {
            array_push($errors, $ex->getMessage());
            log_error($errors, $_SERVER['PHP_SELF']);
            http_response_code(500);
            echo json_encode($errors);
        }
    }
} else {
    http_response_code(400);
}
