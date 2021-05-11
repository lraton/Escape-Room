<?php
    session_start();
?>
<!DOCTYPE html>

<html lang="it">

<head>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
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
        $_SESSION["data"] = $_POST["data"];
        $_SESSION["orario"] = $_POST["orario"];
        $_SESSION["concluso"]=0;

        echo "<h2>Nome: ".$_POST["nome"]."<h2>";
        echo "<h2>Cognome: ".$_POST["cognome"]."<h2>";
        echo "<h2>Email: ".$_POST["email"]."<h2>";
        echo "<h2>Giorno: ".$_POST["data"]."<h2>";
        echo "<h2>Orario: ".$_POST["orario"]."<h2>";

        echo '<form action="concluso.php" method="post">';
        $sql = "SELECT posti_liberi  FROM giornata WHERE data='".$_POST["data"]."' AND orario='".$_POST["orario"]."'";
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result -> fetch_assoc()) {
                echo "<h2>Posti liberi: ".$row["posti_liberi"]."<h2>";
                $postiliberi=$row["posti_liberi"];
            }
        }else{
            echo 'Nessun risultato';
        }


        echo '<label for="posti">Quanti posti vuoi prenotare?</label> <br><br>';
        echo '<select name="posti" id="posti">';
        for ($i=$postiliberi; $i>0; $i--){
            echo '<option id="posti" name="posti" value="'.$i.'" required>'.$i.'</option>';
        }
                
        echo '</select><br><br>';

        echo '<input type="submit" value="Prenota">';
        echo '</form>';
    }else{
        echo "<h3>Ops qualcosa è andato storto</h3>";
    }
?>

</body>

</html>