<?php

require_once '../../vendor/autoload.php';
include "./conn.php";


$conn->query("truncate empresas");

for($i = 1; $i <= 5; $i++){
    $sql = "insert into empresas set ruc='10425162531', razon='Surmotriz'";
    $conn->query($sql);
}

echo "salio";