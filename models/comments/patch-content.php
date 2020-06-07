<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['btnPatchCommentContent'])) {
    require_once '../../config/connection.php';
    require_once 'functions.php';

    $errors = [];

    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $content = isset($_POST['content']) ? $_POST['content'] : null;

    if ($id === null) {
        array_push($errors, "There is no information about which post is being updated.");
    }

    if ($content === null || strlen($content) < 3) {
        array_push($errors, "Content is required, must have more then 3 characters.");
    }

    if (count($errors) > 0) {
        http_response_code(400);
        echo json_encode($errors);
        log_error($errors, $_SERVER['PHP_SELF']);
    } else {
        try {

            $result = patchCommentContent($id, $content);
            if ($result === null) {
                http_response_code(204);
            } else {
                array_push($errors, "An error ocurred while trying to update comment.");
                echo json_encode($errors);
                http_response_code(500);
                log_error($errors, $_SERVER['PHP_SELF']);
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
