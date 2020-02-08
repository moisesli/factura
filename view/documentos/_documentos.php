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
}elseif ($f == 'factura_list'){
  echo $documento->facturaList();
}

class documentos
{
  public function facturaList(){
    global $conn, $post;
    $facturasqlList = "select * from docs";
    $facturasqlList = $conn->query($facturasqlList)->fetch_all(MYSQLI_ASSOC);
    foreach ($facturasqlList as $index => $doc){

    }
    return json_encode($facturasqlList);
  }

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

    // Si es nuevo
    if ($post['factura']['id'] == ""){

      // Handles Headers
      $facturaSqlSaveNew = "insert into docs set
                            ruc = '{$post['factura']['ruc']}',
                            tipo = '{$post['factura']['tipo']}',
                            razon = '{$post['factura']['razon']}',
                            direccion = '{$post['factura']['direccion']}',
                            serie = '{$post['factura']['serie']}',
                            fecha_emision = '". date("Y-m-d", strtotime($post['factura']['fecha_emision'])) ."',
                            venta_interna = '{$post['factura']['venta_interna']}',
                            total_gravadas = {$post['factura']['total_gravadas']},
                            total_igv = {$post['factura']['total_igv']},
                            total_total = {$post['factura']['total_total']}
                            ";
      $conn->query($facturaSqlSaveNew);
      $doc_id = $conn->insert_id;

      // Heandles Items
      foreach ($post['factura']['items'] as $item){
        $facturaSqlSaveItems = "insert into docs_items set
                                nombre = '{$item['nombre']}',
                                producto_id = '{$item['producto_id']}',
                                cantidad = {$item['cantidad']},
                                precio_sin_igv = {$item['precio_sin_igv']},
                                precio_con_igv = {$item['precio_con_igv']},
                                igv = {$item['igv']},
                                descuento = {$item['descuento']},
                                subtotal = {$item['subtotal']},
                                tipo_igv = {$item['tipo_igv']},
                                total = {$item['total']},
                                doc_id = $doc_id
                            ";
        $conn->query($facturaSqlSaveItems);
      }

    // Si es editar
    }else{

    }

    return 'ok';
  }
}
