<?php

include_once ("../../plugins/bd/conn.php");
include_once "./_class_auth.php";
//header('Content-Type: application/json');
$post = json_decode(file_get_contents("php://input"),true);

$f = $_GET['f'];
$Api = new Api;

if ($f == 'register') {

    /* Comprueba */
    $cantidad = "select count(*) cantidad from empresas
            where ruc='{$post['register']['ruc']}'";
    $cantidad = $conn->query($cantidad)->fetch_array(MYSQLI_ASSOC);
    $cantidad = $cantidad['cantidad'];

    $cantidadUsers = "select count(*) cantidad from usuarios
            where email='{$post['register']['email']}' and password='{$post['register']['password']}'";
    $cantidadUsers = $conn->query($cantidadUsers)->fetch_array(MYSQLI_ASSOC);
    $cantidadUsers = $cantidadUsers['cantidad'];

    // Si no hay ningun registro
    if ($cantidad == 0 && $cantidadUsers == 0){
        /* Inser Registro */
        $sql = "insert into empresas set
            ruc='{$post['register']['ruc']}',
            razon='{$post['register']['razon_social']}'";
        $conn->query($sql);
        $sqlInsertUsuario = "insert into usuarios set
            email='{$post['register']['email']}',
            password='{$post['register']['password']}'";
        $conn->query($sqlInsertUsuario);
        echo json_encode('ok');
    }else{
        echo json_encode('no');
    }

}

if ($f == 'login'){
    $auth = new Auth;
    $email = $post['login']['email'];
    $password = $post['login']['password'];
    echo $auth->login($email,$password);
    // $cantidad = $Api->countUsuarios($post['login']['email'], $post['login']['password']);
    // $Api->logear(1);
}

class Api {
    public function countUsuarios($email, $password){
        global $conn;
        $cantidadUsers = "select count(*) cantidad from usuarios where email='$email' and password='$password'";
        $cantidadUsers = $conn->query($cantidadUsers)->fetch_array(MYSQLI_ASSOC);
        $cantidadUsers = $cantidadUsers['cantidad'];
        return $cantidadUsers;
//        echo json_encode($cantidadUsers);
    }

    public function logear ($cantidad){
//        return 'ok';
        if ($cantidad == 1){
            echo 'ok';
        }
    }
}



// class User {
//     protected $loggedIn = false;
//     protected $data = [];

//     public function getData(){
//         return $this->data;
//     }

//     public function setData($data){
//         $this->data = $data;
//     }

//     public function isLoggedIn(){
//         return $this->loggedIn;
//     }
// }

// $rc = new ReflectionClass('User');

// echo '<pre>' . print_r(get_class_methods($rc),true);

//$user = new User;
//
//if ($user->isLoggedIn()){
//    echo 'You are logged';
//}else{
//    echo 'You is not logged';
//}
