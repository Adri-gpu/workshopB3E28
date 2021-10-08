<?php
  session_start(); 
  $bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', ''); 
  if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style.css" media="screen" type="text/css" />
        <link rel="stylesheet" href="dashboard/dashboard.css" media="screen" type="text/css" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="dashboard/profile.js"></script>
        <title>Dashboard</title>
    </head>
    <body>  
        <div class=container-wide>
            <div class=tile style="background-color: #0078D7;"><!-- Module de recherche de financement de formation -->
              <form action="" method="post">
                <label for="num_formation">Numéro de votre formation : </label>
                <input type="text" name="num_formation" placeholder="ex : 15_583966" required>
                <input type="submit" value="Rechercher">  
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
              <form action="../directions/" method="post">
                <label for="origin">Adresse ou ville de départ : </label>
                <input type="text" name="origin" placeholder="ex : Montpellier" required>
                <label for="destinantion">Adresse ou ville d\'arrivée : </label>
                <input type="text" name="destination" placeholder="ex : Nîmes" required>
                <input type="submit" value="Rechercher"/>
              </form>
            </div>
            <div class=tile style="background-color: #FFB900;"><!-- Module de recherche d'emploi Handicap -->
              <form method="POST" action="../jobs/">
                <label for="motCles">Recherche d'emplois "handifriendly" :</label>
                <input type="text" name="motCles" placeholder="Bâtiment, Informatique, Energie..." />
                <input type="submit" value="Rechercher" />
              </form>
            </div>
            <div class=tile style="background-color: #10893E;"><h1>Work In Progress</h1></div>
            <div class=tile style="background-color: #FF8C00;"><h1>Work In Progress</h1></div>
            <div id=profile class=tile style="background-color: #E74856;"><!-- Module de profil d'utilisateur -->
            <?php
              //fix posts names in js innerhtml
              if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $user['pseudo']) {
                $newnom = htmlspecialchars($_POST['newnom']);
                $insertpseudo = $bdd->prepare("UPDATE membres SET nom = ? WHERE id = ?");
                $insertpseudo->execute(array($newnom, $_SESSION['id']));
                header('Location: dashboard?id='.$_SESSION['id']);
              }
              if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $user['pseudo']) {
                $newprenom = htmlspecialchars($_POST['newprenom']);
                $insertpseudo = $bdd->prepare("UPDATE membres SET nom = ? WHERE id = ?");
                $insertpseudo->execute(array($newprenom, $_SESSION['id']));
                header('Location: dashboard?id='.$_SESSION['id']);
              }
              if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
                $newmail = htmlspecialchars($_POST['newmail']);
                $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
                $insertmail->execute(array($newmail, $_SESSION['id']));
                header('Location: dashboard?id='.$_SESSION['id']);
              }
              if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
                $mdp1 = sha1($_POST['newmdp1']);
                $mdp2 = sha1($_POST['newmdp2']);
                if($mdp1 == $mdp2) {
                $insertmdp = $bdd->prepare("UPDATE membres SET motdepasse = ? WHERE id = ?");
                $insertmdp->execute(array($mdp1, $_SESSION['id']));
                header('Location: dashboard?id='.$_SESSION['id']);
                } else {
                $msg = "Vos deux mdp ne correspondent pas !";
                }
              }
            ?>  
            <h2>Profil de <?php echo $userinfo['prenom']; ?></h2>
              <label> Nom = <?php echo $userinfo['prenom'];?></label><br/>
              <label>Prénom = <?php echo $userinfo['nom']; ?></label><br/>
              <label>Mail = <?php echo $userinfo['mail']; ?></label><br/>
              <?php if(isset($userinfo['num'])){
                echo "<label>Numero =".$userinfo['num']."</label>";
              }
              ?>    
              
               <?php if(isset($msg)) { echo $msg; } ?>          
              <input type=button onclick=showEditor(<?php echo ("\"".$userinfo['prenom']."\"") ?>,<?php echo ("\"".$userinfo['nom']."\"") ?>,<?php echo ("\"".$userinfo['mail']."\"") ?>) value="Editer mon profil"><!-- onclick trigger ajax UI swap -->               
              <input type=button onclick="window.location.href='../'" value="Se déconnecter"><!-- call self -->    
            </div>
            <div class=tile style="background-color: #E3008C;"><h1>Work In Progress</h1></div>
            <div class=tile style="background-color: #0063B1;"><h1>Work In Progress</h1></div>
            <div class=tile style="background-color: #C239B3;"><h1>Work In Progress</h1></div>
            <div class=tile style="background-color: #00CC6A;"><h1>Work In Progress</h1></div>
        </div>
    </body>
</html>
<?php
  }else{
    echo "<h1>Accès refusé</h1>";
  }
?>