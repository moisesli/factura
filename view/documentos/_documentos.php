<?php

include_once "../../plugins/bd/conn.php";
$post = json_decode(file_get_contents("php://input"), true);

$f = $_GET['f'];

if ($f == 'searchproductos') {
    $productos = new documentos;
    $searchProductos = $productos->searchProductos();
    echo $searchProductos;
}

class documentos
{
    public function searchProductos()
    {
        global $conn, $post;
        $productos = "select * from productos where nombre like '%" . $post['text'] . "%'";
        $productos = $conn->query($productos)->fetch_all(MYSQLI_ASSOC);

        if (strlen($post['text']) > 2) {
            if (count($productos) == 1) {
                if ($productos[0]['nombre'] == $post['text']) {
                    return 'unoIgual';
                } else {
                    // retorna normal solo hay una coincidencia
                    return json_encode($productos);
                }
            } elseif (count($productos) == 0) {
                // Ninguna Coincidencia
                return 'ceroNinguno';
            } else {
                // Varias coincidencias
                return json_encode($productos);
            }
        }else{
            return 'ceroNinguno';
        }
    }
}
