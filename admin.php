<?php

    //Conenssione database
    require "datiDB.php";
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
                Echo "<h2>Lista prenotazioni</h2>";

                echo '<form action="concluso.php" method="post">';
                $sql1 = "SELECT nome, cognome, email, posti_prenotati, data, orario   FROM prenotazione,giornata WHERE prenotazione.id_giornata=giornata.id_giornata";
                $result1 = $mysqli->query($sql1);
                echo '<table border=1>';
                echo '<tr>';
                echo'<td>Nome</td>';                    
                echo'<td>Cognome</td>';                   
                echo'<td>Email</td>';       
                echo'<td>Posti prenotati</td>'; 
                echo'<td>Data</td>';  
                echo'<td>Ora</td>';                                  
                echo '</tr>';
                if ($result1->num_rows > 0) {
                    while($row1 = $result1 -> fetch_assoc()) {
                    echo '<tr>';
                    echo'<td>'.$row1["nome"].'</td>';                    
                    echo'<td>'.$row1["cognome"].'</td>';                   
                    echo'<td>'.$row1["email"].'</td>';       
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

            }else{
               header("location: admin.html");
                echo "pass errata";
            }
        
    }else{
      header("location: admin.html");
        echo "nome errato";
    }

    

?>