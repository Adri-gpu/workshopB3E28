<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>
        <div id="container">
            <!-- zone de connexion -->
            
            <form action="verification.php" method="POST">
                <h1>Inscription</h1>
                
                <label><b>Nom</b></label>
                <input type="text" id="nom" placeholder="Entrer le nom" name="username" required>

                <label><b>Prénom</b></label>
                <input type="text" id="prenom" placeholder="Entrer le prénom" name="username" required>

                <label><b>Adresse Email</b></label>
                <input type="text" id="mail" placeholder="Entrer l'adresse email" name="text" required>

                <label><b>Confirmation Adresse Email</b></label>
                <input type="text" id="mail2" placeholder="Entrer l'adresse email" name="text" required>

                <label><b>Mot de passe</b></label>
                <input type="password" id="mdp" placeholder="Entrer le mot de passe" name="password" required>

                <label><b>Confirmation Mot de passe</b></label>
                <input type="password" id="mdp2" laceholder="Entrer le mot de passe" name="password" required>

                <input type="submit" id='submit' value='LOGIN' >
                <?php
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2)
                        echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
                }
                ?>
            </form>
        </div>
    </body>
</html>
