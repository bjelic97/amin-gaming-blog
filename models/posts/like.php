<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['btnLikePost'])) {
    require_once '../../config/connection.php';
    require_once 'functions.php';

    $errors = [];

    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

    if ($id === null) {
        array_push($errors, "There is no information about which post is being liked.");
    }

    if ($user === null) {
        array_push($errors, "There is no logged user.");
    }

    if (count($errors) > 0) {
        http_response_code(400);
        echo json_encode($errors);
        log_error($errors, $_SERVER['PHP_SELF']);
    } else {
        try {
            // toggle like-unlike check 
            $exists = checkIfPostAlredyLiked($id, (int) $user->id);
            if ($exists) {
                $result = unlikePost($id, (int) $user->id);
                if ($result === null) {
                    http_response_code(204);
                    echo json_encode(true);
                }
            } else {
                $result = likePost($id, (int) $user->id);
                if ($result === null) {
                    http_response_code(201);
                    echo json_encode(true);
                }
            }
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
