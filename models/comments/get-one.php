<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['id'])) {
    require_once '../../config/connection.php';
    require_once "../comments/functions.php";

    $errors = [];
    $id = $_POST['id'];

    try {
        $comment = getComment($id);
        $comment->created_at = date("F j, Y. H:i", strtotime($comment->created_at));
        $comment->modified_at = date("F j, Y. H:i", strtotime($comment->modified_at));
        http_response_code(200);
        echo json_encode($comment);
    } catch (PDOException $ex) {
        array_push($errors, $ex->getMessage());
        log_error($errors, $_SERVER['PHP_SELF']);
        http_response_code(500);
        echo json_encode($errors);
    }
} else {
    http_response_code(400);
}
