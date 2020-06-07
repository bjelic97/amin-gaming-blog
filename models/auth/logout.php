<?php
if (isset($_POST['btnLogout'])) {
    session_start();
    session_destroy();
    require_once "../../config/connection.php";
    unsubscribe_logged_user();
    header('Location: ../../index.php');
} else {
    header('Location: ../../index.php');
}
