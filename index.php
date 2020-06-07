<?php
session_start();
require_once "config/connection.php";
require_once "models/categories/functions.php";
require_once "models/posts/functions.php";
require_once "models/comments/functions.php";

// require_once 'config/html_to_doc.php';

include "views/fixed/head.php";
include "views/fixed/nav.php";

if (!isset($_GET['page'])) {
    include "views/fixed/slider.php";
    try {
        $response = getPostsResponse();
        $posts = $response['content'];
        foreach ($posts as $post) {
            $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
        }
        include "views/pages/posts/index.php";
    } catch (PDOException $ex) {
        log_error([$ex->getMessage()], $_SERVER['PHP_SELF']);
    }
} else {
    switch ($_GET['page']) {
        case 'posts':
            if (isset($_GET['id'])) {
                if ($_GET['id'] === 'new') {
                    if (isset($_SESSION['user']) && $_SESSION['user']->id_role == 1) {
                        include "views/fixed/breadcrumb.php";
                        include "views/pages/posts/create.php";
                        break;
                    } else {
                        include "views/fixed/slider.php"; // logic for this
                        try {
                            $response = getPostsResponse();
                            $posts = $response['content'];
                            foreach ($posts as $post) {
                                $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
                            }
                            include "views/pages/posts/index.php";
                        } catch (PDOException $ex) {
                            log_error([$ex->getMessage()], $_SERVER['PHP_SELF']);
                        }
                        break;
                    }
                } else {
                    try {
                        $response = getOneResponse($_GET['id']);
                        if ($response['content']->id !== null) {
                            $post = $response['content'];
                            $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
                            $post->modified_at = date("F j, Y. H:i", strtotime($post->modified_at));
                            include "views/pages/posts/show.php";
                            break;
                        } else {
                            header('Location: index.php');
                            break;
                        }
                    } catch (PDOException $ex) {
                        log_error([$ex->getMessage()], $_SERVER['PHP_SELF']);
                        header('Location: index.php');
                        break;
                    }
                }
            } else {
                include "views/fixed/slider.php"; // logic for this
                try {
                    $response = getPostsResponse();
                    $posts = $response['content'];
                    foreach ($posts as $post) {
                        $post->created_at = date("F j, Y. H:i", strtotime($post->created_at));
                    }
                    include "views/pages/posts/index.php";
                } catch (PDOException $ex) {
                    log_error([$ex->getMessage()], $_SERVER['PHP_SELF']);
                }
                break;
            }
        case 'author':
            include "views/fixed/breadcrumb.php";
            include "views/pages/author.php";
            break;
    }
}
include "views/fixed/footer.php";
