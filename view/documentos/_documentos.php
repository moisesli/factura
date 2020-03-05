<?php

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;

// Vendor Composer
include "../../vendor/autoload.php";

// Autenticacion
$see = require __DIR__.'/config.php';

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
}elseif($f == 'credito_save'){
  echo $documento->creditoSave();
}elseif($f == 'debito_save'){
  echo $documento->debitoSave();
}elseif ($f == 'factura_list'){
  echo $documento->facturaList();
}elseif ($f == 'get_series'){
  echo $documento->getSeries($post['tipo']);
}elseif ($f == 'credito_import_doc'){
  echo $documento->creditoImportDoc();
}elseif ($f == 'debito_import_doc'){
  echo $documento->debitoImportDoc();
}

class documentos
{

  public function debitoImportDoc(){
    global $conn, $post;

    // Cabezera
    $sql_get_doc = $conn->query("select * from docs where numero = '{$post['numero']}'")
      ->fetch_array(MYSQLI_ASSOC);

    // Detalles
    $sql_get_items = $conn->query("select * from docs_items where doc_id = {$sql_get_doc['id']}")
      ->fetch_all(MYSQLI_ASSOC);

    $sql_get_doc['items'] = $sql_get_items;
    return json_encode($sql_get_doc);

  }

  public function creditoImportDoc(){
    global $conn, $post;

    // Cabezera
    $sql_get_doc = $conn->query("select * from docs where numero = '{$post['numero']}'")
                        ->fetch_array(MYSQLI_ASSOC);

    // Detalles
    $sql_get_items = $conn->query("select * from docs_items where doc_id = {$sql_get_doc['id']}")
                        ->fetch_all(MYSQLI_ASSOC);

    $sql_get_doc['items'] = $sql_get_items;
    return json_encode($sql_get_doc);
  }

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
    $facturasqlList = "select * from docs order by id DESC";
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
    global $conn, $post, $see;

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


    // Generar Factura
    // Cliente
    $client = new Client();
    $client->setTipoDoc('6')
      ->setNumDoc('20000000001')
      ->setRznSocial('EMPRESA 1');

    // Emisor
    $address = new Address();
    $address->setUbigueo('150101')
      ->setDepartamento('LIMA')
      ->setProvincia('LIMA')
      ->setDistrito('LIMA')
      ->setUrbanizacion('NONE')
      ->setDireccion('AV LS');

    $company = new Company();
    $company->setRuc('20000000001')
      ->setRazonSocial('EMPRESA SAC')
      ->setNombreComercial('EMPRESA')
      ->setAddress($address);

    // Venta
    $invoice = (new Invoice())
      ->setUblVersion('2.1')
      ->setTipoOperacion('0101') // Catalog. 51
      ->setTipoDoc('01')
      ->setSerie('F001')
      ->setCorrelativo('1')
      ->setFechaEmision(new DateTime())
      ->setTipoMoneda('PEN')
      ->setClient($client)
      ->setMtoOperGravadas(100.00)
      ->setMtoIGV(18.00)
      ->setTotalImpuestos(18.00)
      ->setValorVenta(100.00)
      ->setSubTotal(118.00)
      ->setMtoImpVenta(118.00)
      ->setCompany($company);

    $item = (new SaleDetail())
      ->setCodProducto('P001')
      ->setUnidad('NIU')
      ->setCantidad(2)
      ->setDescripcion('PRODUCTO 1')
      ->setMtoBaseIgv(100)
      ->setPorcentajeIgv(18.00) // 18%
      ->setIgv(18.00)
      ->setTipAfeIgv('10')
      ->setTotalImpuestos(18.00)
      ->setMtoValorVenta(100.00)
      ->setMtoValorUnitario(50.00)
      ->setMtoPrecioUnitario(59.00);

    $legend = (new Legend())
      ->setCode('1000')
      ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

    $invoice->setDetails([$item])
      ->setLegends([$legend]);

    // Enviar el documento
     $result = $see->send($invoice);

    file_put_contents($invoice->getName() . '.xml', $see->getFactory()->getLastXml());
//    if (!$result->isSuccess()) {
//      var_dump($result->getError());
//      exit();
//    }
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


  public function debitoSave()
  {
    global $conn, $post;

    session_start();

    // Si es nuevo
    if ($post['debito']['id'] == ""){

      $sql_current_numero = "select (numero+1) numero from config_docs_tipos where empresa_id={$_SESSION['empresa_id']} and serie='{$post['debito']['serie']}'";
      $sql_current_numero = $conn->query($sql_current_numero)->fetch_array(MYSQLI_ASSOC);
      $sql_current_numero = $sql_current_numero['numero'];

      // Handles Headers
      $facturaSqlSaveNew = "insert into docs set
                            ruc = '{$post['debito']['ruc']}',
                            numero = {$sql_current_numero},
                            tipo = '{$post['debito']['tipo']}',
                            razon = '{$post['debito']['razon']}',
                            direccion = '{$post['debito']['direccion']}',
                            serie = '{$post['debito']['serie']}',
                            fecha_emision = '". date("Y-m-d", strtotime($post['debito']['fecha_emision'])) ."',
                            referencia_numero = '{$post['debito']['referencia_numero']}',
                            referencia_serie = '{$post['debito']['referencia_serie']}',
                            venta_interna = '{$post['debito']['venta_interna']}',
                            total_gravadas = {$post['debito']['total_gravadas']},
                            total_igv = {$post['debito']['total_igv']},
                            total_total = {$post['debito']['total_total']}
                            ";
      $conn->query($facturaSqlSaveNew);
      $doc_id = $conn->insert_id;

      // Update Factura Numero
      $sqp_update_numero = "update config_docs_tipos set numero = {$sql_current_numero} where empresa_id={$_SESSION['empresa_id']} and serie='{$post['debito']['serie']}'";
      $conn->query($sqp_update_numero);

      // Heandles Items
      foreach ($post['debito']['items'] as $item){
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
                             ruc = '{$post['debito']['ruc']}',
                             tipo = '{$post['debito']['tipo']}',
                             razon = '{$post['debito']['razon']}',
                             direccion = '{$post['debito']['direccion']}',
                             serie = '{$post['debito']['serie']}',
                             fecha_emision = '". date("Y-m-d", strtotime($post['debito']['fecha_emision'])) ."',
                             referencia_numero = '{$post['debito']['referencia_numero']}',
                             referencia_serie = '{$post['debito']['referencia_serie']}',
                             venta_interna = '{$post['debito']['venta_interna']}',
                             total_gravadas = {$post['debito']['total_gravadas']},
                             total_igv = {$post['debito']['total_igv']},
                             total_total = {$post['debito']['total_total']}
                             where id = {$post['debito']['id']}";
      $conn->query($sql_factura_update);

      foreach ($post['debito']['items'] as $item){
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
                                  doc_id = {$post['debito']['id']}
                            ";
        }
        $conn->query($facturaSqlSaveItems);
      }

    }
    return 'ok';
  }

  public function creditoSave()
  {
    global $conn, $post;

    session_start();

    // Si es nuevo
    if ($post['credito']['id'] == ""){

      $sql_current_numero = "select (numero+1) numero from config_docs_tipos where empresa_id={$_SESSION['empresa_id']} and serie='{$post['credito']['serie']}'";
      $sql_current_numero = $conn->query($sql_current_numero)->fetch_array(MYSQLI_ASSOC);
      $sql_current_numero = $sql_current_numero['numero'];

      // Handles Headers
      $facturaSqlSaveNew = "insert into docs set
                            ruc = '{$post['credito']['ruc']}',
                            numero = {$sql_current_numero},
                            tipo = '{$post['credito']['tipo']}',
                            razon = '{$post['credito']['razon']}',
                            direccion = '{$post['credito']['direccion']}',
                            serie = '{$post['credito']['serie']}',
                            fecha_emision = '". date("Y-m-d", strtotime($post['credito']['fecha_emision'])) ."',
                            referencia_numero = '{$post['credito']['referencia_numero']}',
                            referencia_serie = '{$post['credito']['referencia_serie']}',
                            venta_interna = '{$post['credito']['venta_interna']}',
                            total_gravadas = {$post['credito']['total_gravadas']},
                            total_igv = {$post['credito']['total_igv']},
                            total_total = {$post['credito']['total_total']}
                            ";
      $conn->query($facturaSqlSaveNew);
      $doc_id = $conn->insert_id;

      // Update Factura Numero
      $sqp_update_numero = "update config_docs_tipos set numero = {$sql_current_numero} where empresa_id={$_SESSION['empresa_id']} and serie='{$post['credito']['serie']}'";
      $conn->query($sqp_update_numero);

      // Heandles Items
      foreach ($post['credito']['items'] as $item){
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
                             ruc = '{$post['credito']['ruc']}',
                             tipo = '{$post['credito']['tipo']}',
                             razon = '{$post['credito']['razon']}',
                             direccion = '{$post['credito']['direccion']}',
                             serie = '{$post['credito']['serie']}',
                             fecha_emision = '". date("Y-m-d", strtotime($post['credito']['fecha_emision'])) ."',
                             referencia_numero = '{$post['credito']['referencia_numero']}',
                             referencia_serie = '{$post['credito']['referencia_serie']}',
                             venta_interna = '{$post['credito']['venta_interna']}',
                             total_gravadas = {$post['credito']['total_gravadas']},
                             total_igv = {$post['credito']['total_igv']},
                             total_total = {$post['credito']['total_total']}
                             where id = {$post['credito']['id']}";
      $conn->query($sql_factura_update);

      foreach ($post['credito']['items'] as $item){
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
                                  doc_id = {$post['credito']['id']}
                            ";
        }
        $conn->query($facturaSqlSaveItems);
      }

    }

    return 'ok';
  }
}
