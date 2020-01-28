<?php

require_once '../../vendor/autoload.php';
include "./conn.php";


// $conn->query("truncate empresas");

// for($i = 1; $i <= 5; $i++){
//     $sql = "insert into empresas set ruc='10425162531', razon='Surmotriz'";
//     $conn->query($sql);
// }

// Productos
$conn->query("truncate productos");
$faker = Faker\Factory::create();

for ($i = 0; $i <= 300; $i++) {
    
    $codigo = $faker->regexify('[A-Z0-9]{10}');
    $nombre = $faker->name;
    $precio_con_igv = $faker->randomFloat($nbMaxDecimals = 6, $min = 0, $max = 1000);
    $igv = $precio_con_igv * 0.18;
    $precio_sin_igv = $precio_con_igv - $igv;
    $tipo_igv = $faker->randomElement($array = array ('1','2','3'));    
    // $descripcion = $faker->sentence($nbWords = 5, $variableNbWords = true);
    // $unidad_cantidad = $faker->numberBetween($min = 1, $max = 100);
    $cantidad = $faker->numberBetween($min = 1, $max = 100);
    $subtotal = $precio_sin_igv;
    $total = $precio_con_igv;
    $sql = "insert into productos set 
        codigo='$codigo', 
        nombre='$nombre', 
        cantidad='$cantidad', 
        precio_con_igv='$precio_con_igv', 
        precio_sin_igv='$precio_sin_igv',
        igv = '$igv',
        tipo_igv = '$tipo_igv',
        descuento = 0.000000,
        subtotal = $subtotal,
        total = $precio_con_igv
    ";
    $conn->query($sql);
}

// echo 'codigo : ' . $codigo . '<br>';
// echo 'nombre : ' . $nombre . '<br>';
// echo 'descripcion : ' . $descripcion . '<br>';
// echo 'precio_con_igv : ' . $precio_con_igv . '<br>';
// echo 'igv : ' . $igv . '<br>';
// echo 'precio_sin_igv : ' . $precio_sin_igv . '<br>';
// echo 'cantidad : ' . $cantidad . '<br>';
