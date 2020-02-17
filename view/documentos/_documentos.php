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
}elseif($f == 'boleta_save'){
  echo $documento->boletaSave();
}elseif ($f == 'factura_list'){
  echo $documento->facturaList();
}elseif ($f == 'get_series'){
  echo $documento->getSeries($post['tipo']);
}

class documentos
{

  public function getSeries($tipo){
    global $conn, $post;
    session_start();
    $sql_series = "select * from config_docs_tipos
                            where empresa_id = {$_SESSION['empresa_id']} and config_const_doc_id = {$tipo}";
    $sql_series = $conn->query($sql_series)->fetch_all(MYSQLI_ASSOC);
    return json_encode($sql_series);
  }


  public function facturaList(){
    global $conn, $post;

    // Facturas
    $facturasqlList = "select * from docs";
    $facturasqlList = $conn->query($facturasqlList)->fetch_all(MYSQLI_ASSOC);

    foreach ($facturasqlList as $index => $doc){

      // Items
      $sql_items = "select * from docs_items where doc_id = {$doc['id']}";
      $sql_items = $conn->query($sql_items)->fetch_all(MYSQLI_ASSOC);
      $facturasqlList[$index]['items'] = $sql_items;

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

  public function boletaSave()
  {
    global $conn, $post;

    session_start();

    // Si es nuevo
    if ($post['boleta']['id'] == ""){

      $sql_current_numero = "select (numero+1) numero from config_docs_tipos where empresa_id={$_SESSION['empresa_id']} and serie='{$post['boleta']['serie']}'";
      $sql_current_numero = $conn->query($sql_current_numero)->fetch_array(MYSQLI_ASSOC);
      $sql_current_numero = $sql_current_numero['numero'];

      // Handles Headers
      $facturaSqlSaveNew = "insert into docs set
                            ruc = '{$post['boleta']['ruc']}',
                            numero = {$sql_current_numero},
                            tipo = '{$post['boleta']['tipo']}',
                            razon = '{$post['boleta']['razon']}',
                            direccion = '{$post['boleta']['direccion']}',
                            serie = '{$post['boleta']['serie']}',
                            fecha_emision = '". date("Y-m-d", strtotime($post['boleta']['fecha_emision'])) ."',
                            venta_interna = '{$post['boleta']['venta_interna']}',
                            total_gravadas = {$post['boleta']['total_gravadas']},
                            total_igv = {$post['boleta']['total_igv']},
                            total_total = {$post['boleta']['total_total']}
                            ";
      $conn->query($facturaSqlSaveNew);
      $doc_id = $conn->insert_id;

      // Update Factura Numero
      $sqp_update_numero = "update config_docs_tipos set numero = {$sql_current_numero} where empresa_id={$_SESSION['empresa_id']} and serie='{$post['boleta']['serie']}'";
      $conn->query($sqp_update_numero);

      // Heandles Items
      foreach ($post['boleta']['items'] as $item){
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


    }
    else{ // Si es editar
      $sql_factura_update = "update docs set
                             ruc = '{$post['boleta']['ruc']}',
                             tipo = '{$post['boleta']['tipo']}',
                             razon = '{$post['boleta']['razon']}',
                             direccion = '{$post['boleta']['direccion']}',
                             serie = '{$post['boleta']['serie']}',
                             fecha_emision = '". date("Y-m-d", strtotime($post['boleta']['fecha_emision'])) ."',
                             venta_interna = '{$post['boleta']['venta_interna']}',
                             total_gravadas = {$post['boleta']['total_gravadas']},
                             total_igv = {$post['boleta']['total_igv']},
                             total_total = {$post['boleta']['total_total']}
                             where id = {$post['boleta']['id']}";
      $conn->query($sql_factura_update);

      foreach ($post['boleta']['items'] as $item){
        if ($item['id'] != ''){
          $facturaSqlSaveItems = "update docs_items set
                                  nombre = '{$item['nombre']}',
                                  producto_id = '{$item['producto_id']}',
                                  cantidad = {$item['cantidad']},
                                  precio_sin_igv = {$item['precio_sin_igv']},
                                  precio_con_igv = {$item['precio_con_igv']},
                                  igv = {$item['igv']},
                                  descuento = {$item['descuento']},
                                  subtotal = {$item['subtotal']},
                                  tipo_igv = {$item['tipo_igv']},
                                  total = {$item['total']}
                                  where id = {$item['id']}";
        }else {
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
                                  doc_id = {$post['boleta']['id']}
                            ";
        }
        $conn->query($facturaSqlSaveItems);
      }

    }

    return 'ok';
  }

  public function facturaSaveNew()
  {
    global $conn, $post;

    session_start();

    // Si es nuevo
    if ($post['factura']['id'] == ""){

      $sql_current_numero = "select (numero+1) numero from config_docs_tipos where empresa_id={$_SESSION['empresa_id']} and serie='F001'";
      $sql_current_numero = $conn->query($sql_current_numero)->fetch_array(MYSQLI_ASSOC);
      $sql_current_numero = $sql_current_numero['numero'];

      // Handles Headers
      $facturaSqlSaveNew = "insert into docs set
                            ruc = '{$post['factura']['ruc']}',
                            numero = {$sql_current_numero},
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

      // Update Factura Numero
      $sqp_update_numero = "update config_docs_tipos set numero = {$sql_current_numero} where empresa_id={$_SESSION['empresa_id']} and serie='F001'";
      $conn->query($sqp_update_numero);

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
    }
    else{
      $sql_factura_update = "update docs set
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
                             where id = {$post['factura']['id']}";
      $conn->query($sql_factura_update);

      foreach ($post['factura']['items'] as $item){
        if ($item['id'] != ''){
          $facturaSqlSaveItems = "update docs_items set
                                  nombre = '{$item['nombre']}',
                                  producto_id = '{$item['producto_id']}',
                                  cantidad = {$item['cantidad']},
                                  precio_sin_igv = {$item['precio_sin_igv']},
                                  precio_con_igv = {$item['precio_con_igv']},
                                  igv = {$item['igv']},
                                  descuento = {$item['descuento']},
                                  subtotal = {$item['subtotal']},
                                  tipo_igv = {$item['tipo_igv']},
                                  total = {$item['total']}
                                  where id = {$item['id']}";
        }else {
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
                                doc_id = {$post['factura']['id']}
                            ";
        }
        $conn->query($facturaSqlSaveItems);
      }

    }

    return 'ok';
  }

}
