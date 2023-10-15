<?php
require("./controllers/ProductController.php");

$request_uri = $_SERVER['REQUEST_URI'];

if ($request_uri === '/Assignment_2/') {
    $productController = new ProductController();
    $productController->index();
} else {
    http_response_code(404);
    echo "404 Not Found";
}
