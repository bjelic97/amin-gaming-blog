<?php

function getUsers()
{

    return executeQuery("SELECT * FROM users");
}

function addUser($firstName, $lastName, $email, $username, $password)
{
    $current_date = date('Y-m-d H:i:s');


    $params = [
        'firstname' => $firstName,
        'lastname' => $lastName,
        'email' => $email,
        'username' => $username,
        'password' => md5($password),
        'created_at' => $current_date,
        'modified_at' => $current_date,
        'last_activity' => $current_date,
        'id_role' => 2
    ];

    $query = "INSERT INTO users (id,firstname, lastname, email, username, password, created_at, modified_at, last_activity, id_role)
            VALUES (null,:firstname,:lastname,:email,:username, :password, :created_at, :modified_at, :last_activity, :id_role)";

    executeNonGet($query, $params);
}

function findByUsernameAndPassword($username, $password) //mby top 1 in query
{
    $data = executeQuery("SELECT id,firstname,lastname,username,email,created_at,modified_at,id_role,last_activity FROM users where 
        password = '" . md5($password) . "'" . " AND username = '" . $username . "'");

    if (!count($data)) {
        return null;
    }

    return $data[0];
}

function findByUsername($username)
{
    $data = executeQuery("SELECT id,firstname,lastname,username,email,created_at,modified_at,id_role,last_activity FROM users where 
     username = '" . $username . "'");

    if (!count($data)) {
        return null;
    }

    return $data[0];
}

function patch_last_activity($id)
{
    $current_date = date('Y-m-d H:i:s');
    $params = [
        'last_activity' => $current_date,
        'id' => $id
    ];
    $query = "UPDATE users SET last_activity = :last_activity WHERE id = :id";
    executeNonGet($query, $params);
}
