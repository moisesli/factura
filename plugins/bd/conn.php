<?php

$conn = new mysqli('localhost', 'root', '', 'factura');

// if ($_SERVER['HTTP_HOST'] == 'monases2.com'){alhost', 'root', 'moiseslinar3s', 'monases');
//// }else {
//   $conn = new mysqli('loc
//   $conn = new mysqli('52.13.229.176', 'root', 'moiseslinar3s', 'monases');
// }

// error de conexion
if ($conn->connect_errno) {
  echo "No se pudo conectar a la Base de Datos";
  exit;
}
