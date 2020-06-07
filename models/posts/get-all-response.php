<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['btnGetPosts'])) {

    $id_category = isset($_POST['id_category']) ? $_POST['id_category'] : 0;
    $title = isset($_POST['title']) ? $_POST['title'] : null;
    $sort = isset($_POST['sort']) ? $_POST['sort'] : 3;
    $page = isset($_POST['page']) ? $_POST['page'] : 0;
    $offset = isset($_POST['offset']) ? $_POST['offset'] : 4;
    $errors = [];

    try {
        require_once '../../config/connection.php';
        require_once '../posts/functions.php';

        $posts = getPostsResponse($sort, $page, $offset, $title, $id_category);
        if ($posts['totalElements'] > 0) {
            foreach ($posts['content'] as $post) {
                $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
            }
        }
        echo json_encode($posts);
        http_response_code(200);
    } catch (PDOException $ex) {
        array_push($errors, $ex->getMessage());
        log_error($errors, $_SERVER['PHP_SELF']);
        echo json_encode($errors);
        http_response_code(500);
    }
} else {
    http_response_code(400);
}
