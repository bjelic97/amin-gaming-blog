<?php
session_start();
header("Content-Type: application/json");

if (isset($_POST['logUser'])) {

    $errors = [];

    $regPassword = "/^[\w\d]{5,15}$/";

    if (!isset($_POST["password"])) {
        array_push($errors, "Password is required.");
    }

    if (!preg_match($regPassword, $_POST["password"])) {
        array_push($errors, "Password in bad format.");
    }

    if (!isset($_POST["username"])) {
        array_push($errors, "Username is required.");
    }

    if (!preg_match($regPassword, $_POST["username"])) {
        array_push($errors, "Username in bad format.");
    }

    if (count($errors) > 0) {
        log_error($errors, $_SERVER['PHP_SELF']); // LOG FILE
        http_response_code(400);
        echo json_encode($errors);
        log_error($errors, $_SERVER['PHP_SELF']);
    } else {
        require "../../config/connection.php";
        require "../users/functions.php";
        $user = findByUsernameAndPassword($_POST["username"], $_POST["password"]);
        if (!$user) {
            // for the purpose of sending mail for failing login check if user with username exists so i can send him an email
            $user_mailer = findByUsername($_POST["username"]);

            if ($user_mailer) {
                require "../../helpers/functions.php";
                sendEmail($user_mailer);
            }

            array_push($errors, "Invalid username and password combination.");
            http_response_code(400);
            echo json_encode($errors);
            log_error($errors, $_SERVER['PHP_SELF']); // LOG FILE

        } else {
            $_SESSION['user'] = $user;
            try {
                patch_last_activity($user->id);
            } catch (PDOException $ex) {
                array_push($errors, "An error ocurred while updating last activity on user.");
                http_response_code(500);
                echo json_encode($errors);
                log_error($errors, $_SERVER['PHP_SELF']);
            }

            echo json_encode($user);
            http_response_code(200);
            subscribe_logged_user(); // LOGGED USERS .TXT
        }
    }
} else {
    http_response_code(400);
}
