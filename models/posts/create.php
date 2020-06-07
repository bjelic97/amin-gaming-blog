<?php
session_start();
header("Content-Type: application/json");

if (isset($_POST['btnCreatePost'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = isset($_POST['category']) ? $_POST['category'] : 0;
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;

    $errors = [];
    $allowed_formats = ["image/png", "image/jpeg", "image/jpg"];

    if (!isset($title) || strlen($title) < 3) {
        array_push($errors, "Title is required and must have more then 3 characters.");
    }

    if (!isset($content) || strlen($content) < 3) {
        array_push($errors, "Content is required and must have more then 3 characters.");
    }

    if ($category === 0) {
        array_push($errors, "Category is required.");
    }

    if ($image === null) {
        array_push($errors, "Image is required.");
    }

    $image_type = $image['type'];
    if (!in_array($image_type, $allowed_formats)) {
        array_push($errors, "Image is not in right format.");
    }

    $image_size = $image['size'];
    if ($image_size > 5000000) {
        array_push($errors, "Image size must not be greater then 5MB.");
    }

    if (count($errors) > 0) {
        require "../../config/connection.php";
        http_response_code(400);
        log_error($errors, $_SERVER['PHP_SELF']);
        echo json_encode($errors);
    } else {
        // svi podaci poslati kako treba 
        // now insert post
        try {
            require "../../config/connection.php";
            require "../posts/functions.php";
            require "../../helpers/functions.php";
            $conn->beginTransaction();

            $result = createPost((int) $_SESSION['user']->id, $title, $content, (int) $category);
            if ($result === null) {
                $post_id = $conn->lastInsertId();
                if ($post_id) {
                    http_response_code(201);

                    // sada radim upload i insert u tabelu images
                    $image_tmp = $image['tmp_name'];
                    $image_name = $image['name'];
                    list($width, $height) = getimagesize($image_tmp);
                    $uploaded_img = null;
                    switch ($image_type) {
                        case 'image/jpeg':
                            $uploaded_img = imagecreatefromjpeg($image_tmp);
                            break;
                        case 'image/png':
                            $uploaded_img = imagecreatefrompng($image_tmp);
                            break;
                    }
                    $new_width = 1920;
                    $new_height = 780;
                    $start_from = 840;
                    $fill_width = 1080;
                    $fill_height = 780;
                    $new_img = imagecreatetruecolor($new_width, $new_height);
                    imagecopyresampled($new_img, $uploaded_img, $start_from, 0, 0, 0, $fill_width, $fill_height, $width, $height); // check

                    // $name = time() . $image_name; => yes with timestamp is more secured but wanted to keep and it user friendly *
                    $name = $image_name;

                    $new_image_path = buildServerImagePath('posts', $post_id, $name, true);
                    mkdir(IMG_SERVER_PATH . '/posts/' . $post_id);
                    switch ($image_type) {
                        case 'image/jpeg':
                            imagejpeg($new_img, $new_image_path, 75);
                            break;
                        case 'image/jpg':
                            imagejpeg($new_img, $new_image_path, 75);
                            break;
                        case 'image/png':
                            imagepng($new_img, $new_image_path);
                            break;
                    }
                    $original_path = buildServerImagePath('posts', $post_id, $name);
                    if (move_uploaded_file($image_tmp,  $original_path)) {
                        // sada idem insert u tabelu images !
                        $db_preview_image_path = buildDbImagePath("posts", $post_id, $name, true);
                        $db_original_image_path = buildDbImagePath("posts", $post_id, $name);
                        $inserted = insertImage($db_original_image_path, $db_preview_image_path, 'posts', $post_id, $image_name);
                        if (!$inserted) {
                            array_push($errors, "An error ocurred while inserting into images.");
                            echo json_encode($errors);
                            http_response_code(500);
                            log_error($errors, $_SERVER['PHP_SELF']);
                            $conn->rollBack();
                        } else {
                            $conn->commit();
                            http_response_code(201);
                            echo json_encode($post_id);
                        }
                    } else {
                        array_push($errors, "An error ocurred while uploading image.");
                        $conn->rollBack();
                        echo json_encode($errors);
                        http_response_code(500);
                        log_error($errors, $_SERVER['PHP_SELF']);
                    }
                }
            }
        } catch (PDOException $ex) {
            array_push($errors, $ex->getMessage());
            echo json_encode($errors);
            http_response_code(500);
            log_error($errors, $_SERVER['PHP_SELF']); // into log file
            $conn->rollBack();
        }
    }
} else {
    http_response_code(400);
}
