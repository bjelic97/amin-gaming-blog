<?php
session_start();
header("Content-Type: application/json");

if (isset($_POST['regUser'])) {

    $errors = [];
    $regFirstname = "/^[A-ZŽŠĐĆČ][a-zžšđčć]{3,12}$/";
    $regPassword = "/^[\w\d]{5,15}$/";

    if (!isset($_POST["firstname"])) {
        array_push($errors, "Firstname is required.");
    }

    if (!preg_match($regFirstname, $_POST["firstname"])) {

        array_push($errors, "Firstname not in right format.");
    }


    if (!isset($_POST["lastname"])) {
        array_push($errors, "Lastname is required.");
    }

    if (!preg_match($regFirstname, $_POST["lastname"])) {

        array_push($errors, "Lastname not in right format.");
    }

    if (!isset($_POST["email"])) {
        array_push($errors, "Email is required.");
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email must be valid.");
    }

    if (!isset($_POST["username"])) {
        array_push($errors, "Username is required.");
    }

    if (!preg_match($regPassword, $_POST["username"])) {

        array_push($errors, "Username not in right format.");
    }


    if (!isset($_POST["password"])) {
        array_push($errors, "Password is required.");
    }

    if (!preg_match($regPassword, $_POST["password"])) {

        array_push($errors, "Password not in right format.");
    }

    if (count($errors) > 0) {
        http_response_code(400);
        echo json_encode($errors);
        log_error($errors, $_SERVER['PHP_SELF']);
    } else {

        try {

            require "../../config/connection.php";
            require "../../models/users/functions.php";

            $users = getUsers();

            if (count($users) > 0) {
                foreach ($users as $user) {

                    if ($user->email === $_POST['email']) {
                        array_push($errors, "Email is already in use.");
                    }
                    if ($user->username === $_POST['username']) {
                        array_push($errors, "Username is already in use.");
                    }
                    if ($user->password === $_POST['password']) {
                        array_push($errors, "Password is already in use.");
                    }
                }
            }

            if (count($errors) > 0) {
                http_response_code(500);
                echo json_encode($errors);
                log_error($errors, $_SERVER['PHP_SELF']);
            } else {
                // ukoliko je sve full sada ga dodajem u bazu!
                $result = addUser($_POST["firstname"], $_POST['lastname'], $_POST['email'], $_POST['username'], $_POST['password']);
                echo json_encode($result);
                if ($result === null) {
                    http_response_code(201);
                } else {
                    array_push($errors, "An error ocurred while creating user.");
                    echo json_encode($errors);
                    http_response_code(500);
                    log_error($errors, $_SERVER['PHP_SELF']);
                }
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
