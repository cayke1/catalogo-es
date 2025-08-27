<?php

$routes = [
    "/" => "ProductController@list",
    "/add-product" => "ProductController@create",
    "/edit-product/{id}" => "ProductController@edit",
    "/update-product/{id}" => "ProductController@update",
    "/delete-product/{id}" => "ProductController@delete",
];