<?php
    session_start();
?>

<!DOCTYPE html>

<html lang="it">

<head>
    
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/style.css">
    <meta charset="UTF-8">
    <title> Escape Room </title>
</head>


<body>
<?php

    if(isset($_POST["nome"])&&isset($_POST["cognome"])&&isset($_POST["email"])&&isset($_POST["data"])&&isset($_POST["orario"])){

        //Conenssione database
        require "datiDB.php";
        $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password,$mysql_database);

        // Verifico se è connesso
        if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
        }

        $_SESSION["nome"] = $_POST["nome"];
        $_SESSION["cognome"] = $_POST["cognome"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["telefono"] = $_POST["telefono"];
        $_SESSION["data"] = $_POST["data"];
        $_SESSION["orario"] = $_POST["orario"];
        $_SESSION["concluso"]=0;

        echo "<h3>Nome: ".$_POST["nome"]."<h3>";
        echo "<h3>Cognome: ".$_POST["cognome"]."<h3>";
        echo "<h3>Email: ".$_POST["email"]."<h3>";
        echo "<h3>Telefono: ".$_POST["telefono"]."<h3>";
        echo "<h3>Giorno: ".$_POST["data"]."<h3>";
        echo "<h3>Orario: ".$_POST["orario"]."<h3>";

        echo '<form action="concluso.php" method="post">';
        echo '<label for="posti">Quanti posti vuoi prenotare?</label> <br><br>';

        echo '<select name="posti" id="posti">';
        for ($i=0; $i<=100; $i++){
            echo '<option value="'.$i.'" required>'.$i.'</option>';
        }
        echo '</select><br><br>';

        //echo '<input type="text" id="posti" name="posti"><br>';

        echo '<input type="submit" value="Prenota">';
        echo '</form>';

        echo 'Costo approsimativo (senza sconti): <a id=\'prezzo\'></a>';
    }else{
        echo "<h3>Ops qualcosa è andato storto</h3>";
    }
?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    $("#posti").bind("change keyup", function(event){
        var a = $(this).val();
        var prezzo=0;
        if(a<=5){
            prezzo = 60;
        }else{
            prezzo = 12*a;
        }
    $('#prezzo').text(prezzo+'€'); 

    });
    </script>
</body>

</html>