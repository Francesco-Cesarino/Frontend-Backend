<?php

function getRequest($page, $size)
{
    include_once "connection.php";

    $query = "SELECT * FROM employees LIMIT " . $page * $size . ", " . $size;

    return createJSON($connessione->query($query), $page, $size);
}

function getEmployeeRequest($id)
{
    include_once "connection.php";
    $query = "SELECT * FROM employees WHERE id = $id";
    return createEmployeeJSON($connessione->query($query));
}

function putRequest($data)
{
    include_once "connection.php";
    $query = "UPDATE employees SET birth_date = '$data->birthDate', first_name = '$data->firstName', gender = '$data->gender', hire_date = '$data->hireDate', last_name = '$data->lastName' WHERE id = '$data->id'";
    $connessione->query($query); 
}

function deleteRequest($id){
    include_once "connection.php";
    $query = "DELETE FROM employees WHERE id = $id";
    $connessione->query($query);
}

function postRequest($data){
    include_once "connection.php";
    $query = "INSERT INTO employees VALUES(DEFAULT, '$data->birthDate', '$data->firstName', '$data->lastName', '$data->gender', '$data->hireDate');";
    $connessione->query($query);

}

function createEmployeeJSON($queryResult)
{
    $data = array();

    while ($row = $queryResult->fetch_assoc()) {
        
        $data["birthDate"] = $row["birth_date"];
        $data["firstName"] = $row["first_name"];
        $data["gender"] = $row["gender"];
        $data["hireDate"] = $row["hire_date"];
        $data["id"] = $row["id"];
        $data["lastName"] = $row["last_name"];
    }
    return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

function createJSON($queryResult, $page, $size)
{

    $url = "http://172.17.0.1:8080";
    $totalElements = totalElements();
    $lastPage = ceil($totalElements / $size);
    $nextPage = ($page == $lastPage) ? $page : $page + 1;

    $data = array(
        "_embedded" => array("employees" => array()),
        "_links" => array(
            "first" => array("href" => "{$url}/employees?page=0&size=" . $size),
            "last" => array("href" => "{$url}/employees?page=" . $lastPage . "&size=" . $size),
            "next" => array("href" => "{$url}/employees?page=" . $nextPage . "&size=" . $size),
            "self" => array("href" => "{$url}/employees?page=" . $page . "&size=" . $size)
        ),
        "page" => array(
            "number" => $page,
            "size" => $size,
            "totalElements" => $totalElements,
            "totalPages" => $lastPage
        )
    );

    $employeeNumber = 0;
    while ($row = $queryResult->fetch_assoc()) {
        $data["_embedded"]["employees"][$employeeNumber]["birthDate"] = $row["birth_date"];
        $data["_embedded"]["employees"][$employeeNumber]["firstName"] = $row["first_name"];
        $data["_embedded"]["employees"][$employeeNumber]["gender"] = $row["gender"];
        $data["_embedded"]["employees"][$employeeNumber]["hireDate"] = $row["hire_date"];
        $data["_embedded"]["employees"][$employeeNumber]["id"] = $row["id"];
        $data["_embedded"]["employees"][$employeeNumber]["lastName"] = $row["last_name"];
        $employeeNumber++;
    }

    return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

function totalElements()
{
    require "connection.php";
    $query = "SELECT COUNT(*) FROM employees";
    $result = $connessione->query($query);
    $row = $result->fetch_array();
    return intval($row[0]);
}
