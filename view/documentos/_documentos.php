<?php

include_once "../../plugins/bd/conn.php";
$post = json_decode(file_get_contents("php://input"), true);

$f = $_GET['f'];
$documento = new documentos;

if ($f == 'searchproductos') {
  $searchProductos = $documento->searchProductos();
  echo $searchProductos;
}elseif($f == 'factura_save_new'){
  echo $documento->facturaSaveNew();
}

class documentos
{
  public function searchProductos()
  {
    global $conn, $post;
    $productos = "select * from productos where nombre like '%" . $post['text'] . "%'";


    // Solo entra con tres caracteres
    if (strlen($post['text']) > 2) {

      // Ejecutamos la consulta
      $productos = $conn->query($productos)->fetch_all(MYSQLI_ASSOC);

      // Agrega campo lista al array
      foreach ($productos as $index => $sqlite) {
        $productos[$index]['lista'] = '';
      }

      // solo un producto
      if (count($productos) == 1) {

        // ultima replica
        if ($productos[0]['nombre'] == $post['text']) {
          $productos[0]['lista'] = 'unoIgual';
          return json_encode($productos);
        } else {
          // retorna normal solo hay una coincidencia
          return json_encode($productos);
        }

        // ningun producto
      } elseif (count($productos) == 0) {
        // Ninguna Coincidencia
        $productos = array();
        $productos[0]['lista'] = 'ceroNinguno';
        return json_encode($productos);

        // varios productos
      } else {
        return json_encode($productos);
      }
    } else {
      // Si no hay caracteres minimos
      $productos = array();
      $productos[0]['lista'] = 'ceroNinguno';
      return json_encode($productos);
    }
  }

  public function facturaSaveNew()
  {
    global $conn, $post;
    $facturaSqlSaveNew = "insert into docs set
                            ruc = '{$post['factura']['ruc']}',
                            razon = '{$post['factura']['razon']}',
                            direccion = '{$post['factura']['direccion']}',
                            serie = '{$post['factura']['serie']}',
                            fecha_emision = '". date("Y-m-d", strtotime($post['factura']['fecha_emision'])) ."',
                            venta_interna = '{$post['factura']['venta_interna']}'
                            ";
    $conn->query($facturaSqlSaveNew);
    return 'ok';
  }
}
