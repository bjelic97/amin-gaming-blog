<?php

function getComments($id_post) // prob not using but for the purpose of showing progress
{
    $query = "SELECT c.id, c.content, c.created_at, c.modified_at, c.created_by, u.username, p.title FROM comments c INNER JOIN users u ON c.created_by = u.id INNER JOIN posts p ON c.id_post = p.id WHERE p.id =" . $id_post . " ORDER BY c.created_at DESC";
    return executeQuery($query);
}

function createComment($created_by_id, $id_post, $content)
{
    $current_date = date('Y-m-d H:i:s');

    $params = [
        'content' => $content,
        'created_at' => $current_date,
        'modified_at' => $current_date,
        'created_by' =>  $created_by_id,
        'modified_by' => $created_by_id,
        'id_post' =>  $id_post
    ];

    $query = "INSERT INTO comments (id,content, created_at, modified_at, created_by, modified_by, id_post)
        VALUES (null,:content,:created_at,:modified_at,:created_by, :modified_by, :id_post)";

    executeNonGet($query, $params);
}

function getCommentsResponse($startAt = 0, $perPage = OFFSET, $id_post)
{
    $startAt = ((int) $startAt) * $perPage;
    $query = "SELECT c.id, c.content, c.created_at, c.modified_at, c.created_by, u.username, p.title, p.id AS post_id, COUNT(cu.id_user) as totalUsersLiked FROM comments c INNER JOIN users u ON c.created_by = u.id INNER JOIN posts p ON c.id_post = p.id LEFT JOIN comment_user cu ON cu.id_comment = c.id WHERE p.id =" . $id_post . " GROUP BY c.id ORDER BY c.created_at DESC LIMIT $startAt, $perPage";
    $count = "SELECT COUNT(c.id) AS totalElements FROM comments c INNER JOIN users u ON c.created_by = u.id INNER JOIN posts p ON c.id_post = p.id WHERE p.id =" . $id_post;
    $usersLikedComments = "SELECT cu.*,c.id_post FROM comment_user cu INNER JOIN comments c ON c.id = cu.id_comment WHERE c.id_post = " . $id_post;
    return executeQueryResponseComments($query, $count, $perPage, $usersLikedComments);
}

function getComment($id)
{
    $query = "SELECT c.id, c.content, c.created_at, c.modified_at, c.created_by, u.username, p.id AS post_id FROM comments c INNER JOIN users u ON c.created_by = u.id INNER JOIN posts p ON c.id_post = p.id WHERE c.id =" . $id . "";
    return executeOneRow($query, [$id]);
}

function deleteComment($id)
{
    $params = ['id' => $id];
    $query = "DELETE FROM comments WHERE id = :id";
    executeNonGet($query, $params);
}

function patchCommentContent($id, $content)
{
    $current_date = date('Y-m-d H:i:s');

    $params = [

        'content' => $content,
        'modified_at' => $current_date,
        'id' => $id
    ];

    $query = "UPDATE comments SET content = :content, modified_at = :modified_at WHERE id = :id";

    executeNonGet($query, $params);
}

function likeComment($id, $user_id)
{
    $current_date = date('Y-m-d H:i:s');

    $params = [
        'created_at' => $current_date,
        'modified_at' => $current_date,
        'id_comment' => $id,
        'id_user' => $user_id
    ];

    $query = "INSERT INTO comment_user (created_at, modified_at, id_comment, id_user)
    VALUES (:created_at,:modified_at, :id_comment, :id_user)";

    executeNonGet($query, $params);
}

function unlikeComment($id, $user_id)
{
    $params = ['id_comment' => $id, 'id_user' => $user_id];
    $query = "DELETE FROM comment_user WHERE id_comment = :id_comment AND id_user = :id_user";
    executeNonGet($query, $params);
}

function checkIfAlredyLiked($id, $user_id)
{
    $params = ['id_comment' => $id, 'id_user' => $user_id];
    $query = "SELECT * FROM comment_user WHERE id_comment = :id_comment AND id_user = :id_user";
    return executeOneRow($query, $params);
}
