<?php

include_once ("../../plugins/bd/conn.php");
//header('Content-Type: application/json');
$post = json_decode(file_get_contents("php://input"),true);

$f = $_GET['f'];

if ($f == 'register') {

    /* Comprueba */
    $cantidad = "select count(*) cantidad from empresas 
            where ruc='{$post['register']['ruc']}'";
    $cantidad = $conn->query($cantidad)->fetch_array(MYSQLI_ASSOC);
    $cantidad = $cantidad['cantidad'];

    // Si no hay ningun registro
    if ($cantidad == 0){
        /* Inser Registro */
        $sql = "insert into empresas set
        ruc='{$post['register']['ruc']}',
        razon='{$post['register']['razon_social']}'";
        $conn->query($sql);
        echo json_encode('ok');
    }else{
        echo json_encode('no');
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