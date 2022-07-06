
<!DOCTYPE html>

<html lang="it">

<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VTKT9J2Z0Y"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-VTKT9J2Z0Y');
    </script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/style.css">
    <meta charset="UTF-8">
    <title> Escape Room </title>
    
    <link rel="preload" as="script" href="https://cdn.iubenda.com/cs/iubenda_cs.js"/>
    <link rel="preload" as="script" href="https://cdn.iubenda.com/cs/tcf/stub-v2.js"/>
        <script src="https://cdn.iubenda.com/cs/tcf/stub-v2.js"></script>
        <script>
        (_iub=self._iub||[]).csConfiguration={
            cookiePolicyId: 40648314,
            siteId: 2709730,
            localConsentDomain: 'prolocosigillo.altervista.org',
            timeoutLoadConfiguration: 30000,
            lang: 'it',
            enableTcf: true,
            tcfVersion: 2,
            tcfPurposes: {
                "2": "consent_only",
                "3": "consent_only",
                "4": "consent_only",
                "5": "consent_only",
                "6": "consent_only",
                "7": "consent_only",
                "8": "consent_only",
                "9": "consent_only",
                "10": "consent_only"
            },
            invalidateConsentWithoutLog: true,
            googleAdditionalConsentMode: true,
            consentOnContinuedBrowsing: false,
            banner: {
                position: "top",
                acceptButtonDisplay: true,
                customizeButtonDisplay: true,
                closeButtonDisplay: true,
                closeButtonRejects: true,
                fontSizeBody: "14px",
            },
        }
        </script>
    <script async src="https://cdn.iubenda.com/cs/iubenda_cs.js"></script>
</head>

<body>
    <img src="img/scritta2.png" alt="PULP OLD PUB">
    <p id="intro">Il PULP OLD PUB è scenario di un duplice omicidio MAI risolto. </br>
        50 minuti per scovare indizi, recuperare prove ed esaminare la scena del crimine</br>
        RIUSCIRETE A PORTARE ALLA LUCE LA VERITÀ? </br>
    <form action="selezione.php" method="post">
        <table border="5" calss="table-responsive">
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
        $sql = "SELECT data  FROM giornata where 1 group by data order by data";
        $result = $mysqli->query($sql);
        $i=0;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result -> fetch_assoc()) {
                if($i==0){
                    echo '<tr>';
                }
                $datadivisa=explode("-",$row["data"]);
                if($row["data"]>=date("Y-m-d") ){ //&& date("Y-m-d")>='2022-07-04'
                    if($datadivisa[1]==7){
                        echo '<td> <input type="radio" name="date" value="'. $row["data"].'" required >'. $datadivisa[2].'- LUGLIO -'. $datadivisa[0].'</td>';
                    }else{
                        echo '<td> <input type="radio" name="date" value="'. $row["data"].'" required >'. $datadivisa[2].'- AGOSTO -'. $datadivisa[0].'</td>';
                
                    }
                }else{
                    if($datadivisa[1]==7){
                        echo '<td> <input type="radio"  disabled required >'. $datadivisa[2].'- LUGLIO -'. $datadivisa[0].'</td>';
                    }else{
                        echo '<td> <input type="radio"  disabled required >'. $datadivisa[2].'- AGOSTO -'. $datadivisa[0].'</td>';
                
                    }
                }
                $i++;
                if($i==3){
                    echo '</tr>';
                    $i=0;
                }

            }
        } else {
            echo "<h3>Ops qualcosa è andato storto</h3>";
        }
    ?>
       </table>
    <input type="submit" value="Continua">
    </form>

    <h3>Regolamento</h3>
    <p>-Escape room adatta a tutte le persone maggiorenni</br>
        -Il gioco si svolge a squadre da un minimo di 2 e senza un numero massimo</br>
        -La durata del l’escape è di 50 minuti</br>
        -L’obiettivo è quello di risolvere tutti gli enigmi che separano la squadra dalla soluzione del gioco</br>
        -La puntualità è d’obbligo: la squadra dovrà presentarsi nel luogo indicato 10 minuti prima dell’inizio del gioco</br>
        -È severamente vietato fotografare qualsiasi luogo della room escape e danneggiare i relativi meccanismi e oggetti presenti al suo interno</br>
        -Durante in gioco sarete monitorati attraverso delle telecamere</br>
        -Il costo per partecipare è di 60€ fino a 5 giocatori, più di 5 12€ a testa, per i tesserati ProLoco 5€ di sconto (presentare la tessera il giorno del gioco), e la quota dovrà essere versata prima dell’inizio del gioco</br>
        -È consigliato l’utilizzo di mascherine</br>
    </p>
        <h4>ATTENZIONE! SE NON PUOI PARTECIPARE RICORDATI DI AVVISARCI TEMPESTIVAMENTE AI SEGUENTI NUMERI </br>
            334/2326047 Alessandro</h4>
            <script>!function(d,l,e,s,c){e=d.createElement("script");e.src="//ad.altervista.org/js.ad/size=728X90/?ref="+encodeURIComponent(l.hostname+l.pathname)+"&r="+Date.now();s=d.scripts;c=d.currentScript||s[s.length-1];c.parentNode.insertBefore(e,c)}(document,location)</script>
            <a href="https://www.iubenda.com/privacy-policy/40648314" rel="noreferrer nofollow" target="_blank">Privacy Policy</a>
</body>

</html>