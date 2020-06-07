<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['btnGetComments'])) {

    $id_post = isset($_POST['id_post']) ? $_POST['id_post'] : 0;
    $page = isset($_POST['page']) ? $_POST['page'] : 0;
    $offset = isset($_POST['offset']) ? $_POST['offset'] : 4;
    $errors = [];

    if ($id_post === 0) {
        array_push($errors, 'No post information sent.');
    }

    if (count($errors) > 0) {
        echo json_encode($errors);
        http_response_code(400);
        require_once '../../config/connection.php';
        log_error($errors, $_SERVER['PHP_SELF']);
    }

    try {
        require_once '../../config/connection.php';
        require_once '../comments/functions.php';

        $comments = getCommentsResponse($page, $offset, $id_post);
        if ($comments['totalElements'] > 0) {
            foreach ($comments['content'] as $comment) {
                $comment->created_at = date("F j, Y. H:i", strtotime($comment->created_at));
            }
        }
        echo json_encode($comments);
        http_response_code(200);
    } catch (PDOException $ex) {
        array_push($errors, $ex->getMessage());
        echo json_encode($errors);
        http_response_code(500);
        log_error($errors, $_SERVER['PHP_SELF']);
    }
} else {
    http_response_code(400);
}
