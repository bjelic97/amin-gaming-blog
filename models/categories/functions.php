<?php

function getCategories()
{
    return executeQuery("SELECT c.id, c.name, COUNT(p.id) AS numPosts FROM categories c LEFT JOIN posts p ON c.id = p.id_category GROUP BY c.id ORDER BY numPosts DESC");
}

function getCategoriesForExistingPosts()
{
    return executeQuery("SELECT c.id, c.name, COUNT(p.id) AS numPosts FROM categories c INNER JOIN posts p ON c.id = p.id_category WHERE p.is_deleted = 0 GROUP BY c.id ORDER BY numPosts DESC");
}
