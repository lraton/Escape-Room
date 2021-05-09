<?php

if(isset($_POST["pass"])){
    $password=$_POST["pass"];
}
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;

if(isset($_POST["nome"])){
    $decifra=$_POST["nome"];
}

if(password_verify($password,$decifra)){
    Echo "Password giusta";
}

?>