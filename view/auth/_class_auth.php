<?php 
    class Auth {
        public function login($email,$password){
            global $conn;
            
            $cantidadUsers = "select count(*) cantidad from usuarios where email='$email' and password='$password'";
            $cantidadUsers = $conn->query($cantidadUsers)->fetch_array(MYSQLI_ASSOC);
            $cantidadUsers = $cantidadUsers['cantidad'];
            if ($cantidadUsers == 1){
                $datosUser = "select * from usuarios 
                    INNER JOIN empresas on empresas.id = usuarios.empresa_id 
                    where email='$email' and password='$password'";
                $datosUser = $conn->query($datosUser)->fetch_array(MYSQLI_ASSOC);
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = true;
                $_SESSION['nombre'] = $datosUser['nombres'];
                $_SESSION['apellidos'] = $datosUser['nombres'];
                $_SESSION['ruc'] = $datosUser['ruc'];
                $_SESSION['razon'] = $datosUser['razon'];
                return 'ok';
                // return $cantidadUsers;
                
            }else {
                return 'no';
            }
            
            
        }
        public function loggeid(){
            session_start();
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                return true;
              } else {
                  return false;
              }
        }
    }
?>