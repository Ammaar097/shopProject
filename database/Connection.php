<?php
function Connection(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "shop_pj";

    /*$servername = "localhost";
    $username = "elnvento_AgrStore";
    $password = "@grSt0re6502";
    $database = "elnvento_AgrStore";*/
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->query("SET NAMES UTF8");
        return $conn;
    } catch (PDOException $e) {
        throw new Exception("Connection failed: " . $e->getMessage());
    }
}

