<?php
    include "queries.php";
    $requestedMethod = $_SERVER['REQUEST_METHOD'];
    $page = isset($_GET['page']) ? $_GET['page'] : 0;
    $size = isset($_GET['size']) ? $_GET['size'] : 20;
    $data = json_decode(file_get_contents('php://input'));
    if ($requestedMethod === "POST") {
        echo postRequest($data);
    } else if ($requestedMethod === "GET" && !isset($_GET['id'])) {
        echo getRequest($page, $size);
    } 
    else if($requestedMethod === "GET" && isset($_GET['id'])){
        echo getEmployeeRequest($_GET['id']);
    } 
    else if ($requestedMethod === "PUT") {
        echo putRequest($data);
    } else if ($requestedMethod === 'DELETE' && isset($_GET['id'])) {
        echo deleteRequest($_GET['id']);
    }
?>