<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    </head>
    <body>
        <div class="container">
            <!-- zone de connexion -->
            
            <form action="../login/index.php" method="POST">
                <h1>Inscription</h1>
                
                <label><b>Nom</b></label>
                <input type="text" placeholder="Entrer le nom" name="username" required>

                <label><b>Prénom</b></label>
                <input type="text" placeholder="Entrer le prénom" name="username" required>

                <label><b>Adresse Email</b></label>
                <input type="text" placeholder="Entrer l'adresse email" name="email" required>

                <label><b>Confirmation Adresse Email</b></label>
                <input type="text" placeholder="Entrer l'adresse email" name="email" required>


                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="password" required>

                <label><b>Confirmation Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="password" required>

                <input type="submit" id='submit' value="Inscription" >
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
