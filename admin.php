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

<script>
            function selectChanged(){
                   selezione = document.getElementById("select");
                   if(selezione.value == "0"){//or whatever th unwanted value is
                       document.getElementById("elimina").disabled = true;
                   } else{
                       document.getElementById("elimina").disabled = false; 
                   }
               }          
</script>

<body>
<?php

    //Conenssione database
    require "datiDB.php";
    $_SESSION["login"]=0;
    $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password,$mysql_database);

    // Verifico se è connesso
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }

    if(isset($_POST["pass"])){
        $password=$_POST["pass"];
    }

    $sql = "SELECT password  FROM admin WHERE nome='".$_POST["nome"]."'";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        $row = $result -> fetch_assoc();
            if(password_verify($password,$row["password"])){
                $_SESSION["login"]=1;
                Echo "<h2>Lista prenotazioni</h2>";

                $sql1 = "SELECT id_prenotazione, nome, cognome, email, numero, posti_prenotati, data, orario   FROM prenotazione,giornata WHERE prenotazione.id_giornata=giornata.id_giornata";
                $result1 = $mysqli->query($sql1);
                echo '<table border=1 id="listaprenotazioni">';
                echo '<tr>';
                echo'<td>Numero</td>';     
                echo'<td>Nome</td>';                    
                echo'<td>Cognome</td>';  
                echo'<td>Telefono</td>';       
                echo'<td>Posti prenotati</td>'; 
                echo'<td>Data</td>';
                echo'<td>Ora</td>';                                  
                echo '</tr>';
                if ($result1->num_rows > 0) {
                    while($row1 = $result1 -> fetch_assoc()) {
                    echo '<tr>';
                    echo'<td>'.$row1["id_prenotazione"].'</td>';  
                    echo'<td>'.$row1["nome"].'</td>';                    
                    echo'<td>'.$row1["cognome"].'</td>';  
                    echo'<td>'.$row1["numero"].'</td>';    
                    echo'<td>'.$row1["posti_prenotati"].'</td>'; 
                    echo'<td>'.$row1["data"].'</td>';  
                    echo'<td>'.$row1["orario"].'</td>';                                  
                    echo '</tr>';
                    }
                }else{
                    echo '<tr>';
                    echo'<td>nessun risultato</td>';
                    echo '</tr>';
                }
                echo '</table>';

                
            echo '<form action="cancellaprenotazione.php" method="post">';
            $pronotazioni = "SELECT  id_prenotazione  FROM prenotazione ";
            $resultpronotazioni = $mysqli->query($pronotazioni);
            if ($resultpronotazioni->num_rows > 0) {
                
            echo '<select name="id" id="select" onchange="selectChanged()" onload="selectChanged()">';
                    echo'<option value="0" >Seleziona una prenotazione</option>';
                while($row2 = $resultpronotazioni -> fetch_assoc()) {
                        echo '<option id="id" name="id" value="'.$row2["id_prenotazione"].'">'.$row2["id_prenotazione"].'</option>';
                }
                
            echo '</select><br><br>';
            echo '<input type="submit" id="elimina" value="Eliminina">';
            }else{
                echo '</select><br><br>';
            }
            echo '</form>';
            }else{
               header("location: admin.html");
                echo "pass errata";
                $_SESSION["login"]=0;
            }
        
    }else{
      header("location: admin.html");
        echo "nome errato";
    }

    

?>


</body>

</html>