<?php
function getPostsResponse($sort = 3, $startAt = 0, $perPage = OFFSET, $title = null, $id_category = null)
{
    switch ($sort) {
        case 1:
            $sortField = "p.title";
            $sortOrder = "ASC";
            break;
        case 2:
            $sortField = "p.title";
            $sortOrder = "DESC";
            break;
        case 3:
            $sortField = "p.created_at";
            $sortOrder = "DESC";
            break;
        case 4:
            $sortField = "p.created_at";
            $sortOrder = "ASC";
            break;
        case 5:
            $sortField = "commNum";
            $sortOrder = "DESC";
            break;
        default:
            $sortField = "p.created_at";
            $sortOrder = "DESC";
    }


    $query = "SELECT p.id, p.title, p.created_at, p.content, c.name AS category, u.firstname, u.lastname,u.username, COUNT(com.id) as commNum, i.src,i.alt,i.src_small FROM posts p INNER JOIN categories c ON p.id_category = c.id INNER JOIN users u ON p.created_by = u.id INNER JOIN images i ON i.id_entity = p.id LEFT JOIN comments com ON com.id_post = p.id WHERE is_deleted = 0";
    $startAt = ((int) $startAt) * $perPage;
    $filters = "";

    if ($title !== null) {
        $title = "%" . strtolower($title) . "%";
        $filters .= " AND p.title LIKE '" . $title . "'";
        $query .= $filters;
    }

    if ($id_category !== null && $id_category !== "") {
        $filters .= " AND c.id = $id_category";
        $query .= $filters;
    }

    $count = "SELECT COUNT(p.id) AS totalElements FROM posts p INNER JOIN categories c ON p.id_category = c.id INNER JOIN users u ON p.created_by = u.id INNER JOIN images i ON i.id_entity = p.id WHERE is_deleted = 0" . $filters;
    $query .= " GROUP BY p.id ORDER BY $sortField $sortOrder LIMIT $startAt, $perPage";

    return executeQueryResponse($query, $count, $perPage);
}

function createPost($created_by, $title, $content, $id_category)
{

    $current_date = date('Y-m-d H:i:s');

    $params = [

        'created_by' => $created_by,
        'modified_by' => $created_by,
        'created_at' => $current_date,
        'modified_at' => $current_date,
        'title' => $title,
        'content' => $content,
        'id_category' => $id_category,
        'is_deleted' => 0
    ];

    $query = "INSERT INTO posts (id,created_by, modified_by,created_at, modified_at, title, content, id_category, is_deleted)
         VALUES (null,:created_by,:modified_by,:created_at,:modified_at, :title, :content, :id_category, :is_deleted)";

    executeNonGet($query, $params);
}

function getOne($id)
{
    $query = "SELECT p.id, p.title, p.created_at, p.modified_at, p.content, c.name AS category,c.id AS id_category, u.firstname, u.lastname, u.username,  COUNT(com.id) as commNum, i.src,i.alt,i.src_small FROM posts p INNER JOIN categories c ON p.id_category = c.id INNER JOIN users u ON p.created_by = u.id INNER JOIN images i ON i.id_entity = p.id LEFT JOIN comments com ON com.id_post = p.id WHERE p.id = ? and is_deleted = 0";
    return executeOneRow($query, [$id]);
}

function deletePost($id)
{
    $current_date = date('Y-m-d H:i:s');

    $params = [

        'modified_at' => $current_date,
        'id' => $id
    ];

    $query = "UPDATE posts SET is_deleted = 1, modified_at = :modified_at WHERE id = :id";

    executeNonGet($query, $params);
}

function patchPostTitle($id, $title)
{
    $current_date = date('Y-m-d H:i:s');

    $params = [

        'title' => $title,
        'modified_at' => $current_date,
        'id' => $id
    ];

    $query = "UPDATE posts SET title = :title, modified_at = :modified_at WHERE id = :id";

    executeNonGet($query, $params);
}

function patchPostContent($id, $content)
{
    $current_date = date('Y-m-d H:i:s');

    $params = [

        'content' => $content,
        'modified_at' => $current_date,
        'id' => $id
    ];

    $query = "UPDATE posts SET content = :content, modified_at = :modified_at WHERE id = :id";

    executeNonGet($query, $params);
}

function patchPostCategory($id, $id_category)
{
    $current_date = date('Y-m-d H:i:s');

    $params = [

        'id_category' => $id_category,
        'modified_at' => $current_date,
        'id' => $id
    ];

    $query = "UPDATE posts SET id_category = :id_category, modified_at = :modified_at WHERE id = :id";

    executeNonGet($query, $params);
}

function checkIfPostAlredyLiked($id, $user_id)
{
    $params = ['id_post' => $id, 'id_user' => $user_id];
    $query = "SELECT * FROM post_user WHERE id_post = :id_post AND id_user = :id_user";
    return executeOneRow($query, $params);
}

function likePost($id, $user_id)
{
    $current_date = date('Y-m-d H:i:s');

    $params = [
        'created_at' => $current_date,
        'modified_at' => $current_date,
        'id_post' => $id,
        'id_user' => $user_id
    ];

    $query = "INSERT INTO post_user (created_at, modified_at, id_post, id_user)
    VALUES (:created_at,:modified_at, :id_post, :id_user)";

    executeNonGet($query, $params);
}

function unlikePost($id, $user_id)
{
    $params = ['id_post' => $id, 'id_user' => $user_id];
    $query = "DELETE FROM post_user WHERE id_post = :id_post AND id_user = :id_user";
    executeNonGet($query, $params);
}

function getOneResponse($id)
{
    $query = "SELECT p.id, p.title, p.created_at, p.modified_at, p.content, c.name AS category,c.id AS id_category, u.firstname, u.lastname, u.username,  COUNT(com.id) as commNum, i.src,i.alt,i.src_small FROM posts p INNER JOIN categories c ON p.id_category = c.id INNER JOIN users u ON p.created_by = u.id INNER JOIN images i ON i.id_entity = p.id LEFT JOIN comments com ON com.id_post = p.id WHERE p.id = " . $id . " and is_deleted = 0";
    $usersLikedPost = "SELECT pu.* FROM post_user pu INNER JOIN posts p ON p.id = pu.id_post WHERE p.id = " . $id;
    return executeOneRowResponsePost($query, $usersLikedPost);
}
