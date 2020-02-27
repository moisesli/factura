<?php

include_once "../../plugins/bd/conn.php";
$post = json_decode(file_get_contents("php://input"), true);

$f = $_GET['f'];

$enviar = new Enviar;

if ($f == 'factura') {
  echo $enviar->enviarFactura();
}elseif ($f == 'boleta'){
  echo $enviar->enviarBoleta();
}elseif ($f == 'credito'){
  echo $enviar->enviarCredito();
}elseif ($f == 'debito'){
  echo $enviar->enviarDebito();
}



class Enviar {
  public function enviarFactura(){
    return 'enviar factura';
  }

  public function enviarBoleta(){
    return 'enviar Boleta';
  }

  public function enviarCredito(){
    return 'ok';
  }

  public function enviarDebito(){
    return 'ok';
  }
}
