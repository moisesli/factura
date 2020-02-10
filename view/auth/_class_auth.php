<?php

class Auth
{
  public function login($email, $password)
  {
    global $conn;

    $cantidadUsers = "select count(*) cantidad from usuarios where email='$email' and password='$password'";
    $cantidadUsers = $conn->query($cantidadUsers)->fetch_array(MYSQLI_ASSOC);
    $cantidadUsers = $cantidadUsers['cantidad'];
    if ($cantidadUsers == 1) {
      $datosUser = "select * from usuarios
                    INNER JOIN empresas on empresas.id = usuarios.empresa_id
                    where email='$email' and password='$password'";
      $datosUser = $conn->query($datosUser)->fetch_array(MYSQLI_ASSOC);
      session_start();
      $_SESSION['loggedin'] = true;
      $_SESSION['email'] = true;
      $_SESSION['nombres'] = $datosUser['nombres'];
      $_SESSION['apellidos'] = $datosUser['apellidos'];
      $_SESSION['ruc'] = $datosUser['ruc'];
      $_SESSION['razon'] = $datosUser['razon'];
      $_SESSION['empresa_id'] = $datosUser['empresa_id'];

      return 'ok';
      // return $cantidadUsers;

    } else {
      return 'no';
    }


  }

  public function loggedin()
  {
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
      return true;
    } else {
      return false;
    }
  }
}

?>
