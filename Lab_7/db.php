<?php
function db_conn()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "labtask";
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";

    $conn = null;

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // var_dump($conn) ;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $conn;
}

// Responsible for running insert,update,delete
function execute($query, $bindparams = [])
{
    $conn = db_conn();
    $effected_rows = 0;

    if ($conn) {
        try {
            $stmt = $conn->prepare($query);
            $stmt->execute($bindparams);

            $effected_rows = $stmt->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    $conn = null;

    return $effected_rows;
}

// Responsible for running select queires
function get($query, $bindparams = [])
{
    $conn = db_conn();
    $results = array();

    if ($conn) {
        try {
            $stmt = $conn->prepare($query);
            $stmt->execute($bindparams);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    $conn = null;

    return $results;
}
