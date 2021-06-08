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
    //Conenssione database
    require "datiDB.php";
    $mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password,$mysql_database);

    // Verifico se è connesso
    if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
    }

    if(isset($_SESSION["nome"])&&isset($_SESSION["cognome"])&&isset($_SESSION["email"])&&isset($_SESSION["data"])&&isset($_SESSION["orario"])&&isset($_POST["posti"])){ 

        if(isset($_SESSION["concluso"]) && $_SESSION["concluso"]==0){

            $sql = "SELECT id_giornata, posti_liberi  FROM giornata WHERE data='".$_SESSION["data"]."' AND orario='".$_SESSION["orario"]."' AND posti_liberi>=".$_POST["posti"];
            $result = $mysqli->query($sql);
            if ($result->num_rows > 0) {
                $row = $result -> fetch_assoc();

                if($row["posti_liberi"]>=$_POST["posti"]){
                    $postiavanzati=$row["posti_liberi"]-$_POST["posti"];

                    //Modifico i posti disponibli
                    $aggiornaposti = "UPDATE giornata SET posti_liberi = ".$postiavanzati." WHERE giornata.id_giornata='".$row["id_giornata"]."'";
                    if ($mysqli->query($aggiornaposti) === TRUE) {
                        //Creo la prenotaizone
                        $prentoazione = "INSERT INTO prenotazione (nome, cognome, email, posti_prenotati, id_giornata)
                        VALUES ('".$_SESSION["nome"]."', '".$_SESSION["cognome"]."', '".$_SESSION["email"]."', '".$_POST["posti"]."', '".$row["id_giornata"]."')";
                        if ($mysqli->query($prentoazione) === TRUE) {
                            echo "<h2>Prenotazione effettuata</h2>";
                            $_SESSION["errore"]="0";
                        } else {
                            echo "Errore nella prenotaizone: " . $sql . "<br>" . $mysqli->error;
                            $_SESSION["errore"]="1";
                        }
                    }else{
                        echo "Errore nella prenotazione" . $mysqli->error;
                        $_SESSION["errore"]="1";
                    }

                    
                }else{
                    echo"<h3>Posti non disponibili</h3>";
                    $_SESSION["errore"]="1";
                }
            }else{
                echo '<h3>Ops qualcosa è andato storto, controlla se i posti prenotabili sono giusti</h3>';
                $_SESSION["errore"]="1";
            }

        }
    
        if($_SESSION["errore"]==0){
            echo "<h2>Riepilogo</h2>";

            echo "<h2>Nome: ".$_SESSION["nome"]."<h2>";
            echo "<h2>Cognome: ".$_SESSION["cognome"]."<h2>";
            echo "<h2>Email: ".$_SESSION["email"]."<h2>";
            echo "<h2>Giorno: ".$_SESSION["data"]."<h2>";
            echo "<h2>Orario: ".$_SESSION["orario"]."<h2>";
            echo "<h2>Posti prenotati: ".$_POST["posti"]."<h2>";

            if($_SESSION["concluso"]==0){
                $to      =  $_SESSION["email"];
                $subject = 'Prenotazione effettuata';
                $message = 'La sua prenotazione per il giorno '.$_SESSION["data"].' alle ore '.$_SESSION["orario"].' per '.$_POST["posti"].' persone e stata effettuata. Non rispondere a questa mail';
                $headers = 'From: escaperoom@sigillo.it' . "\r\n" .
                    'Reply-To:' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);

                $to      = 'notari.filippo@outlook.it';
                $subject = 'Prenotazione effettuata';
                $message = 'E stata effettuata una prenotazione per il giorno '.$_SESSION["data"].' alle ore '.$_SESSION["orario"].' per '.$_POST["posti"].' persone, da parte di '.$_SESSION["nome"].' '.$_SESSION["cognome"].'. Per visualizzare la prenotazione visitare http://escaperoomsigillo.hostinggratis.it/admin.html, Nome: admin Password: admin123 ';
                $headers = 'From: escaperoom@sigillo.it' . "\r\n" .
                    'Reply-To:' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);
                $_SESSION["concluso"]="1";
            }

            echo "<h2>Controlla l'email per verificare la conferma della prenotazione (controllare anche nella cartella spam)</h2>";
        }
    }else{
        echo "<h3>Ops qualcosa è andato storto</h3>";
    }
?>

<a href=index.php>
    <input type="button" value="Home">
</a>

</body>

</html>