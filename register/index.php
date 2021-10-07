<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');
 
if(isset($_POST['forminscription'])) {
   $nom = htmlspecialchars($_POST['nom']);
   $prenom = htmlspecialchars($_POST['prenom']);
   $mail = htmlspecialchars($_POST['mail']);
   $mail2 = htmlspecialchars($_POST['mail2']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $nomlength = strlen($nom);
      if($nomlength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {
                     $insertmbr = $bdd->prepare("INSERT INTO membres(nom, prenom, mail, motdepasse) VALUES(?, ?, ?, ?)");
                     $insertmbr->execute(array($nom, $prenom, $mail, $mdp));
                     $erreur = "Votre compte a bien été créé ! <a href=\"../\">Me connecter</a>";
                  } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreur = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreur = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreur = "Votre nom ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>

<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>
        <div class="container">
            <!-- zone de connexion -->
            
            <form action="" method="POST">
                <h1>Inscription</h1>
                
                <label><b>Nom</b></label>
                <input type="text" id="nom" placeholder="Entrer le nom" name="nom" required>

                <label><b>prenom</b></label>
                <input type="text" id="prenom" placeholder="Entrer le prenom" name="prenom" required>

                <label><b>Adresse Email</b></label>
                <input type="text" id="mail2" placeholder="Entrer l'adresse email" name="mail" required>

                <label><b>Confirmation Adresse Email</b></label>
                <input type="text" id="mail2" placeholder="Entrer l'adresse email" name="mail2" required>


                <label><b>Mot de passe</b></label>
                <input type="password" id="mdp" placeholder="Entrer le mot de passe" name="mdp" required>

                <label><b>Confirmation Mot de passe</b></label>
                <input type="password" id="mdp2" laceholder="Entrer le mot de passe" name="mdp2" required>
                <?php
                  if(isset($erreur)){
                     echo $erreur;
                  }                          
                ?>
                <input type="submit" name="forminscription" value='Inscription' >
            </form>
        </div>
    </body>
</html>
