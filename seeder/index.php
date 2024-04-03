<?php
include __DIR__ . '/../php/functions.php';
require_once __DIR__ . '/../php/config.php';


$product = new Product();
$checkProduct = $product->index();
if (count($checkProduct) > 0) {
    header('Location: /e-commerce/public');
    exit;
}

$url_categories = 'https://fakestoreapi.com/products/categories';
$response_categories = file_get_contents($url_categories);

$url_products = 'https://fakestoreapi.com/products/';
$response_products = file_get_contents($url_products);

$categories = json_decode($response_categories, true);
$products = json_decode($response_products, true);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connessione fallita al DB (controllare se i dati del DB sono corretti): " . $conn->connect_error);
}

foreach ($categories as $category) {
    $name = $conn->real_escape_string($category);
    $sql = "INSERT INTO categories (name) VALUES ('$name')";
    $conn->query($sql);
}

foreach ($products as $product) {
    $name = $conn->real_escape_string($product['title']);
    $price = $conn->real_escape_string($product['price']);
    $description = $conn->real_escape_string($product['description']);
    $image = $conn->real_escape_string($product['image']);
    $category = setCategoryId($product['category']);

    $sql = "INSERT INTO products (name, price, description, img, category_id) VALUES ('$name', '$price', '$description', '$image', '$category')";

    $conn->query($sql);
}


$conn->close();
header('Location: /e-commerce/public');
exit;
