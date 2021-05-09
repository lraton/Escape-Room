<?php
    session_start();
?>
<!DOCTYPE html>

<html lang="it">

<head>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title> Escape Room </title>
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

    //Prova query
    $sql = "SELECT  id_giornata, data  FROM giornata Group by data ";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result -> fetch_assoc()) {
            
            echo '<form action="prenotazione.php" method="post">';
            echo '<fieldset>';
            echo '<legend> '. $row["data"].'</legend>';

            echo '<label for="nome">Nome:</label>';
            echo '<input type="text" id="nome" name="nome" required><br><br>';

            echo '<label for="cognome">Cognome:</label>';
            echo '<input type="text" id="cognome" name="cognome" required><br><br>';

            echo '<label for="email">Email:</label>';
            echo '<input type="text" id="email" name="email" required><br><br>';

            echo '<label for="data">Data:</label>';
            echo '<input type="text" id="data" name="data" value="'.$row["data"].'" readonly><br><br>';

            //Selcet con gli orari
            echo '<label for="orario">Scegli un orario:</label>';
            echo '<select name="orario" id="orario">';

            $orario = "SELECT  orario, posti_liberi  FROM giornata WHERE data='".$row["data"]."'";
            $resultorario = $mysqli->query($orario);
            if ($resultorario->num_rows > 0) {
                while($row1 = $resultorario -> fetch_assoc()) {
                    if($row1["posti_liberi"]<=0){
                        echo '<option id="orario" name="orario" value="'.$row1["orario"].'" disabled>'.$row1["orario"].' Posti liberi: '.$row1["posti_liberi"].'</option>';
                    }else{
                        echo '<option id="orario" name="orario" value="'.$row1["orario"].'" >'.$row1["orario"].' Posti liberi: '.$row1["posti_liberi"].'</option>';
                    }
                }
            }else{
                echo '<option value="">Nessun risultato</option>';
            }
            echo '</select><br><br>';

            echo '<label for="posti">Clicca continua per poter scegliere Quanti posti prenotare</label><br><br>';

            echo '<input type="submit" value="Continua">';
            echo '</fieldset>';
            echo '</form>';

        }
    } else {
        echo "<h3>Ops qualcosa è andato storto</h3>";
    }

    
?>

</body>

</html>