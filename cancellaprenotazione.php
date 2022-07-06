<?php
    session_start();
?>
<!DOCTYPE html>

<html lang="it">

<head>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/style.css">
    <meta charset="UTF-8">
    <title> Escape Room Admin</title>
</head>


<body>
<?php

    //Conenssione database
    require "datiDB.php";
    $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password,$mysql_database);

    // Verifico se è connesso
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }

    if(isset($_POST["id"])){

        $sql = "SELECT giornata.id_giornata, posti_prenotati, posti_liberi  FROM giornata, prenotazione WHERE prenotazione.id_prenotazione='".$_POST["id"]."' AND prenotazione.id_giornata=giornata.id_giornata" ;
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result -> fetch_assoc()) {
                $posti=1;

                $sql1 = "UPDATE giornata SET posti_liberi= '".$posti."' WHERE id_giornata='".$row["id_giornata"]."'";

                if ($mysqli->query($sql1) === TRUE) {
                echo "Record updated successfully </br>";
                    $sql2 = "DELETE FROM prenotazione WHERE id_prenotazione='".$_POST["id"]."'";
                    if ($mysqli->query($sql2) === TRUE) {
                    echo "Record eliminated successfully </br>";
                    } else {
                        echo "Error eliminating record: " . $conn->error;
                    }
                } else {
                echo "Error updating record: " . $conn->error;
                }

            }
        }

        
     header("Refresh: 5; url=http://prolocosigillo.altervista.org/admin.php");

    }else{
        header("location: admin.php");
        
    }

?>
</body>

</html>