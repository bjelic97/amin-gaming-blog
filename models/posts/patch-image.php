<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['btnEditPostImage'])) {
    require_once '../../config/connection.php';
    require_once '../posts/functions.php';

    $allowed_formats = ["image/png", "image/jpeg", "image/jpg"];
    $errors = [];

    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $image = isset($_FILES['image']) ? $_FILES['image'] : null;

    if ($id === null) {
        array_push($errors, "There is no information about which post is being updated.");
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
        http_response_code(400);
        echo json_encode($errors);
        log_error($errors, $_SERVER['PHP_SELF']);
    } else {
        try {
            require_once '../posts/functions.php';
            require_once '../../helpers/functions.php';

            $post_img_dir_path = IMG_SERVER_PATH . '/posts/' . $id;
            clearExistingFilesOnServerForEntity($post_img_dir_path);

            $image_tmp = $image['tmp_name'];
            $image_name = $image['name'];
            list($width, $height) = getimagesize($image_tmp);
            $uploaded_img = null;
            switch ($image_type) {
                case 'image/jpeg':
                    $uploaded_img = imagecreatefromjpeg($image_tmp);
                    break;
                case 'image/pngg':
                    $uploaded_img = imagecreatefrompng($image_tmp);
                    break;
            }
            $new_width = 1920;
            $new_height = 780;
            $start_from = 840;
            $fill_width = 1080;
            $fill_height = 780;
            $new_img = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($new_img, $uploaded_img, $start_from, 0, 0, 0, $fill_width, $fill_height, $width, $height);

            // $name = time() . $image_name; => yes with timestamp is more secured but wanted to keep and it user friendly *
            $name = $image_name;
            $new_image_path = buildServerImagePath('posts', $id, $name, true);
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
            $original_path = buildServerImagePath('posts', $id, $name);
            if (move_uploaded_file($image_tmp,  $original_path)) {
                // now update 
                $db_preview_image_path = buildDbImagePath("posts", $id, $name, true);
                $db_original_image_path = buildDbImagePath("posts", $id, $name);
                $updated = updateImage($db_original_image_path, $db_preview_image_path, 'posts', $id, $image_name);
                if (!$updated) {
                    array_push($errors, "An error ocurred while updating images.");
                    echo json_encode($errors);
                    http_response_code(500);
                    log_error($errors, $_SERVER['PHP_SELF']);
                } else {
                    http_response_code(204);
                    echo json_encode($new_image_path);
                }
            } else {
                array_push($errors, "An error ocurred while moving an image.");
                echo json_encode($errors);
                http_response_code(500);
                log_error($errors, $_SERVER['PHP_SELF']);
            }
        } catch (PDOException $ex) {
            array_push($errors, $ex->getMessage());
            echo json_encode($errors);
            http_response_code(500);
            log_error($errors, $_SERVER['PHP_SELF']);
        }
    }
} else {
    http_response_code(400);
}
