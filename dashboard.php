<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="dashboard.css" media="screen" type="text/css" />
        <title>Dashboard</title>
    </head>
    <body>
        <div class=container>
            <div class=tile style="background-color: #0078D7;"><!-- Module de recherche de financement de formation -->
              <form action="" method="post">
                <p>Numéro de votre formation : <input type="text" name="num_formation" /></p>
                <p><input type="submit" value="OK"></p>
              </form>
              <?php
                if(isset($_POST["num_formation"])){
                  $curl = curl_init();
                  curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=/partenaire',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'grant_type=client_credentials&client_id=PAR_1c_cb1d7d039427037a6ac45ebc8fc06b0a6fc22485a493fe5d9708a2db8fdc7b4a&client_secret=268272134b9c5985ea8b84562199c96964ddfe82c4c25831619073dbfb1c2ac2&scope=api_simulateurfinancementv1%20application_PAR_1c_cb1d7d039427037a6ac45ebc8fc06b0a6fc22485a493fe5d9708a2db8fdc7b4a',
                    CURLOPT_HTTPHEADER => array(
                      'Content-Type: application/x-www-form-urlencoded',
                      'Cookie: BIGipServerVS_IW_PO002-VIPA-00PX20b_HTTPS.app~POOL_IW_PO002-00PX20b_HTTPS_SO007_SFPSN_13=!ELm9gk7Y5DJuBXYtSoEWKFKmyo2ysvdnKGdOL2uQHmmUtjOLG3pdTAjrNjKSMdYJyFhJe1OwiSJTGKs=; TS0188135e=01b3abf0a2993d481a337867346ccf4499c894dec4e0331566a572e693a2c11e47582a15cd1265343cf8c0ba30aa73ff0d3c87072f'
                    )
                  ));
                  $response = curl_exec($curl);
                  curl_close($curl);
                  $arrtok = (array) json_decode($response);
                  $token = $arrtok["access_token"];
                  $num_f = htmlspecialchars($_POST['num_formation']);
                  $curl = curl_init();
                  curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.emploi-store.fr/partenaire/simulateurfinancement/v1/financement?eligible=true&explain=false',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                      "beneficiaire": {
                          "droit_prive": false,
                          "inscrit_pe": true,
                          "naissance": "2000-10-12"},
                      "formation": {
                          "numero": "'.$num_f.'"}
                    }',
                    CURLOPT_HTTPHEADER => array(
                      'Authorization: Bearer '.$token,
                      'Content-Type: text/plain'
                    )
                  ));
                  $response = curl_exec($curl);
                  curl_close($curl);
                  $jarr = (array) json_decode($response);
                  if ( array_key_exists('financements', $jarr) == true )
                  {
                    $jstr = $jarr['financements'];
                    if ( array_key_exists(0, $jstr) == true )
                    {
                      $jj = (array)$jstr[0];
                      if ( array_key_exists('intitule', $jj) == true )
                      {
                        echo "<h4>Vous êtes éligibles aux financements suivants pour votre formation :</h4>";
                        print_r($jj['intitule']);
                      }
                      else{
                        print_r("Une erreur est survenue");
                      }
                    }
                    else{
                      print_r("Vous n'êtes malheureusement pas éligible à un financement :(");
                    }
                  }
                  else{
                    print_r("Une erreur est survenue");
                  }
                }
              ?>
            </div>
            <div class=tile style="background-color: #8764B8;"><!-- Module d'aide au déplacements -->
              <form action="directions/directions.php" method="post">
                <label for="origin">Adresse ou ville de départ : </label><input type="text" name="origin" required>
                <br>
                <br>
                <label for="destinantion">Adresse ou ville d\'arrivée : </label><input type="text" name="destination" required>
                <br>
                <br>
                <input type="submit" value="Recherche"/>
              </form>
            </div>
            <div class=tile style="background-color: #FFB900;"> <!-- Module de recherche d'emploi Handicap -->
                <form method="POST" action="module_recherche/poleEmploiRecherche.php" style="margin: 15px; line-height: 1.5; text-align: center;">
                    <p >Recherche les offres dont les entreprise sont adaptés aux handicapés et "handi friendly"  : </p>
                    <input type="search" name="motCles" placeholder="Recherche par un mot clé..." />
                    <input type="submit" value="Valider" />
                </form>
            </div>
            <div class=tile style="background-color: #10893E;"></div>
            <div class=tile style="background-color: #FF8C00;"></div>
            <div class=tile style="background-color: #E74856;"></div>
            <div class=tile style="background-color: #E81123;"></div>
            <div class=tile style="background-color: #0063B1;"></div>
            <div class=tile style="background-color: #C239B3;"></div>
            <div class=tile style="background-color: #00CC6A;"></div>
        </div>
    </body>
</html>