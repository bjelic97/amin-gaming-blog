<?php
session_start();
header("Content-Type: application/json");

if (isset($_POST['btnCreateComment'])) {

    $content = isset($_POST['content']) ? $_POST['content'] : null;
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
    $postId = isset($_POST['postId']) ? $_POST['postId'] : null;

    $errors = [];

    ($user === null) ? array_push($errors, "User not logged in.") : $userId = $_SESSION['user']->id;

    if ($postId === null) {
        array_push($errors, "Missing information about post.");
    }

    if ($content === null) {
        array_push($errors, "Content is required.");
    }

    if (count($errors) > 0) {
        require "../../config/connection.php";
        http_response_code(400);
        log_error($errors, $_SERVER['PHP_SELF']);
        echo json_encode($errors);
    } else {

        try {
            require "../../config/connection.php";
            require "functions.php";

            $result = createComment((int) $_SESSION['user']->id, $postId, $content);
            if ($result === null) {
                http_response_code(201);
                echo json_encode($postId);
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
