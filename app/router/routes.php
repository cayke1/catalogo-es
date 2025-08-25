<?php

$routes = [
    "/" => "ProductController@list",
    "/add-product" => "ProductController@create",
    "/product/{id}" => "ProductController@show",
    
];