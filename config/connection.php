<?php
require_once "config.php";

observePageAccess();

try {
    $conn = new PDO("mysql:host=" . SERVER . ";dbname=" . DATABASE . ";charset=utf8", USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

function executeQuery($query)
{
    global $conn;
    return $conn->query($query)->fetchAll();
}

function executeQueryResponse($query, $count, $perPage) // group in one method if time
{
    global $conn;
    $content = $conn->query($query)->fetchAll();
    $total_elements = $conn->query($count)->fetchColumn();
    $pages = ceil($total_elements / $perPage);
    return ["content" => $content, "totalElements" => (int) $total_elements, "totalPages" => $pages, "perPage" => (int) $perPage];
}

function executeQueryResponseComments($query, $count, $perPage, $queryUsers) // group in one method if time
{
    global $conn;
    $content = $conn->query($query)->fetchAll();
    $total_elements = $conn->query($count)->fetchColumn();
    $pages = ceil($total_elements / $perPage);
    $usersLikedCommentsOnPost = $conn->query($queryUsers)->fetchAll();
    return ["content" => $content, "totalElements" => (int) $total_elements, "totalPages" => $pages,  "perPage" => (int) $perPage, "usersWhoLiked" => $usersLikedCommentsOnPost];
}

function executeOneRowResponsePost($query, $queryUsers)
{
    global $conn;
    $content = $conn->query($query)->fetch();
    $usersLikedPost = $conn->query($queryUsers)->fetchAll();
    return ["content" => $content, "usersWhoLiked" => $usersLikedPost];
}

function executeNonGet($query, array $params)
{
    global $conn;
    $prepared = $conn->prepare($query);
    return $prepared->execute($params);
}

function executeOneRow(string $query, array $params)
{
    global $conn;
    $prepared = $conn->prepare($query);
    $prepared->execute($params);
    return $prepared->fetch();
}


function executeList(string $query, array $params)
{
    global $conn;
    $prepared = $conn->prepare($query);
    $prepared->execute($params);
    return $prepared->fetchAll();
}

function insertImage($original_path, $new_path, $entity_type, $id_entity, $alt)
{
    global $conn;
    $insert = $conn->prepare("INSERT INTO images VALUES(NULL, ?, ?, ?, ?, ?)");
    $is_inserted = $insert->execute([$entity_type, $id_entity, $original_path, $alt, $new_path]);
    return $is_inserted;
}

function updateImage($original_path, $new_path, $entity_type, $id_entity, $alt)
{
    global $conn;
    $update = $conn->prepare("UPDATE images SET src = ?, src_small = ?, alt = ? WHERE entity_type = ? AND id_entity = ?");
    $is_updated = $update->execute([$original_path, $new_path, $alt, $entity_type, $id_entity]);
    return $is_updated;
}

function observePageAccess()
{
    $array_addr = explode("/", $_SERVER['PHP_SELF']);
    $latest = end($array_addr);

    $page = $_SERVER['QUERY_STRING'] !== "" ? $_SERVER['QUERY_STRING'] : $latest;

    $time = date('Y-m-d');
    $open = fopen(ACCESS_FILE, "a");
    $user = isset($_SESSION['user']) ? $_SESSION['user']->username : 'visitor';
    if ($open) {
        fwrite($open, "{$user}" . SEPARATOR . "{$_SERVER['REMOTE_ADDR']}"  . SEPARATOR . $page . SEPARATOR . "{$time}\n");
        fclose($open);
    }
}

function subscribe_logged_user()
{
    $time = date('Y-m-d H:i:s');
    $open = fopen(LOGGED_USERS, "a");
    if ($open) {
        fwrite($open, "{$_SESSION['user']->id}" . SEPARATOR . "{$_SESSION['user']->username}" . SEPARATOR . "{$time}\n");
        fclose($open);
    }
}

function unsubscribe_logged_user()
{
    $id = $_SESSION['user']->id;
    $open = fopen(LOGGED_USERS, "r");
    $data = file(LOGGED_USERS);

    fclose($open);

    $string = "";

    foreach ($data as $row) {
        $user_data = explode(SEPARATOR, $row);

        if ($id != $user_data[0]) {
            $string .= $row;
        }
    }

    $open = fopen(LOGGED_USERS, "w");

    fwrite($open, $string);
    fclose($open);
}

function get_attendance_stat()
{
    $date = date('Y-m-d');
    $date_parts = explode('-', $date);

    $year = (int) $date_parts[0];
    $month = (int) $date_parts[1];
    $day = (int) $date_parts[2];

    $open = fopen(ACCESS_FILE, "r");
    $data = file(ACCESS_FILE);
    fclose($open);

    $rows = [];
    foreach ($data as $row) {
        $obj = explode(SEPARATOR, $row);
        array_push($rows, $obj);
    }

    $stat = [];
    $count_index = 0;
    $count_posts = 0;
    $count_register = 0;
    $count_login = 0;
    $count_author = 0;
    $count_post = 0;

    $count_members = 0;

    foreach ($rows as $single) {
        $page = $single[2];

        $obj_date = explode("-", $single[3]);
        $obj_year = (int) $obj_date[0];
        $obj_month = (int) $obj_date[1];
        $obj_day = (int) $obj_date[2];

        if ($obj_year === $year && $obj_month === $month && $obj_day === $day) {
            $count_members++;
            switch ($page) {
                case 'index.php':
                    $count_index++;
                    break;

                    // post routes
                case 'get-all-response.php':
                    $count_posts++;
                    break;

                    // auth routes 
                case 'register.php':
                    $count_register++;
                    break;
                case 'login.php':
                    $count_login++;
                    break;
                case 'page=author':
                    $count_author++;
                    break;
                case strpos($page, 'page=posts&id'):
                    $count_post++;
                    break;
            }
        }
    }

    $index = new \stdClass();
    $index->page = 'home';
    $index->perc = calcPercentageRounded($count_index, $count_members);

    $posts = new \stdClass();
    $posts->page = 'posts ( filtered / paginated )';
    $posts->perc = calcPercentageRounded($count_posts, $count_members);

    $register = new \stdClass();
    $register->page = 'register';
    $register->perc = calcPercentageRounded($count_register, $count_members);

    $login = new \stdClass();
    $login->page = 'login';
    $login->perc = calcPercentageRounded($count_login, $count_members);

    $author = new \stdClass();
    $author->page = 'author';
    $author->perc = calcPercentageRounded($count_author, $count_members);

    $post = new \stdClass();
    $post->page = 'post detail';
    $post->perc = calcPercentageRounded($count_post, $count_members);


    $stat = [$index, $posts, $register, $login, $author, $post];

    usort($stat, function ($a, $b) {
        // return strcmp($b->perc, $a->perc);
        return $a->perc < $b->perc ? 1 : -1;
    });
    return $stat;
}

function calcPercentageRounded($value, $total)
{
    return round((($value / $total) * 100), 2);
}

function log_error($messages, $page)
{
    $open = fopen(LOG_FILE, "a");
    if ($open) {
        $new_content = "";
        $time = date('Y-m-d H:i:s');
        foreach ($messages as $message) {
            $new_content .= "{$page}" . SEPARATOR . "{$message}" . SEPARATOR . "{$time}\n";
        }

        fwrite($open, $new_content);
        fclose($open);
    }
}
