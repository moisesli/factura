<?php

include_once "../../plugins/bd/conn.php";
$post = json_decode(file_get_contents("php://input"), true);

$f = $_GET['f'];

$enviar = new Enviar;

if ($f == 'enviar_factura') {
  echo $enviar->enviarFactura();
}elseif ($f == 'enviar_boleta'){
  echo $enviar->enviarFactura();
}elseif ($f == 'enviar_credito'){
  echo $enviar->enviarFactura();
}elseif ($f == 'enviar_debito'){
  echo $enviar->enviarFactura();
}



class Enviar {
  public function enviarFactura(){
    return 'enviar factura';
  }

  public function enviarBoleta(){
    return 'enviar Boleta';
  }

  public function enviarCredito(){
    return 'enviar Credito';
  }

  public function enviarDebito(){
    return 'enviar debito';
  }
}
