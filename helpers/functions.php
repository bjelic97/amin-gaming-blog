<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function clearExistingFilesOnServerForEntity($dir_path) // removes files and folders and their subfolders in requested directory
{
    if (file_exists($dir_path) && is_dir($dir_path)) {
        $objects = scandir($dir_path);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir_path . "/" . $object) == "dir")
                    clearExistingFilesOnServerForEntity($dir_path . "/" . $object);
                else unlink($dir_path . "/" . $object);
            }
        }
        reset($objects);
    }
}

function buildDbImagePath($entity_type, $entity_id, $image_name, $is_preview_image = false)
{
    $db_image_path = '';
    switch ($entity_type) {
        case 'posts':
            $db_image_path = $is_preview_image ? $db_image_path = IMG_DB_PATH_POSTS . $entity_id . '/preview_' . $image_name
                : IMG_DB_PATH_POSTS . $entity_id . '/' . $image_name;
            break;
    }
    return $db_image_path;
}

function buildServerImagePath($entity_type, $entity_id, $image_name, $is_preview_image = false)
{
    $db_image_path = '';
    switch ($entity_type) {
        case 'posts':
            $db_image_path = $is_preview_image ? $db_image_path = IMG_SERVER_PATH . '/posts/' . $entity_id . '/preview_' . $image_name
                : IMG_SERVER_PATH . '/posts/' . $entity_id . '/' . $image_name;
            break;
    }
    return $db_image_path;
}

function sendEmail($user)
{
    require "../../config/mail/Exception.php";
    require "../../config/mail/PHPMailer.php";
    require "../../config/mail/SMTP.php";

    $errors = [];
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'auditornephp@gmail.com';
        $mail->Password = 'Sifra123';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->SMTPOptions = [
            'ssl' =>  [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        $mail->setFrom('amin@gmail.com', 'amin-gaming-blog');
        $mail->addAddress($user->email);
        $mail->Subject = 'Login failed';
        $address = $_SERVER['REMOTE_ADDR'];
        $time = date('d-m-Y H:i:s');
        $body = "<h3>Attempt to login failed !</h3>
        <p>User : <strong>$user->username</strong>.</p>
        <p>IP Address : <strong>$address</strong>.</p>
        <p>Occurred at : <strong>$time</strong>.</p>
        <p>Try again with other password.</p>
        ";
        $mail->Body = $body;
        $mail->isHTML(true);
        $mail->send();
    } catch (Exception $e) {
        array_push($errors, "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        log_error($errors, $_SERVER['PHP_SELF']);
    }
}
