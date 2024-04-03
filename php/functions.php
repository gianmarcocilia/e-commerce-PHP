<?php
function isValid(array $errors) {
    if(count($errors) > 0){
        echo 'is-invalid';
    }else {
        echo 'is-valid';
    }
}

function errorMessage(array $errors) {
    if(count($errors) > 0){
        echo "<div class='invalid-feedback'>";
        foreach($errors as $error) {
            echo "$error <br>";
        }
        echo "</div>";
    }
}

function setCategoryId($categoryName) {
    $result = match($categoryName) {
        'electronics' => 1,
        'jewelery' => 2,
        "men's clothing" => 3,
        "women's clothing" => 4,
    };
    return $result;
}