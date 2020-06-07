<?php

header('Content-Type: application/json');

if (isset($_POST['id'])) {
    require_once '../../config/connection.php';
    require_once '../posts/functions.php';

    $errors = [];
    $id = $_POST['id'];

    try {
        $post = getOne($id);
        $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
        $post->modified_at = date("F j, Y. H:i", strtotime($post->modified_at));
        http_response_code(200);
        echo json_encode($post);
    } catch (PDOException $ex) {
        array_push($errors, $ex->getMessage());
        log_error($errors, $_SERVER['PHP_SELF']);
        http_response_code(500);
        echo json_encode($errors);
    }
} else {
    http_response_code(400);
}
