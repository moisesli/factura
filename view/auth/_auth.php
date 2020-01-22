<?php

class User {
    protected $loggedIn = false;
    protected $data = [];

    public function getData(){
        return $this->data;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function isLoggedIn(){
        return $this->loggedIn;
    }
}

$rc = new ReflectionClass('User');

echo '<pre>' . print_r(get_class_methods($rc),true);

//$user = new User;
//
//if ($user->isLoggedIn()){
//    echo 'You are logged';
//}else{
//    echo 'You is not logged';
//}