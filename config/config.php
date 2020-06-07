<?php

// Osnovna podesavanja
define("BASE_URL", "http://localhost/amin");
define("ABSOLUTE_PATH", $_SERVER["DOCUMENT_ROOT"] . "/amin");

// Ostala podesavanja
define("ENV_FILE", ABSOLUTE_PATH . "/config/.env");
define("LOG_FILE", ABSOLUTE_PATH . "/data/log.txt");
define("ACCESS_FILE", ABSOLUTE_PATH . "/data/access.txt");
define("LOGGED_USERS", ABSOLUTE_PATH . "/data/logged_users.txt");

define("SEPARATOR", "\t");
define("IMG_SERVER_PATH", $_SERVER["DOCUMENT_ROOT"] . "/amin/assets/img");
define("IMG_DB_PATH", "assets/img/");
define("IMG_DB_PATH_POSTS", "assets/img/posts/");
define("OFFSET", 4);

// Podesavanja za bazu
define("SERVER", env("SERVER"));
define("DATABASE", env("DBNAME"));
define("USERNAME", env("USERNAME"));
define("PASSWORD", env("PASSWORD"));




function env($naziv)
{
    $open = fopen(ENV_FILE, "r");
    $podaci = file(ENV_FILE);
    $vrednost = "";
    foreach ($podaci as $key => $value) {
        $konfig = explode("=", $value);
        if ($konfig[0] == $naziv) {
            $vrednost = trim($konfig[1]); // trim() zbog \n
        }
    }
    return $vrednost;
}
