<html>
    <head>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="detector.css" media="screen" type="text/css" />
    </head>
    <body>
        <div class="container">
            <form action="" method="POST">
                <h1>Evaluation des besoins</h1>
                <label><b>Possédez-vous votre véhicule ?</b></label>
                <div class=inline>                
                    <input type="radio" id="oui" name="vehicle" value="oui">
                    <label for="oui">Oui</label>
                    <input type="radio" id="non" name="vehicle" value="non" checked>
                    <label for="non">Non</label>
                </div>
                <br/>
                <br/>
                <label><b>Etes-vous inscrit à une formation ? (si non, laisser vide)</b></label>
                <input type="text" placeholder="Adresse" name="address" required>
                <br/>
                <br/>
                <label><b>Quel type de handicap ?</b></label>
                <div class=inline>                
                    <input type="radio" id="oui" name="walking" value="oui">
                    <label for="oui">Oui</label>
                    <input type="radio" id="non" name="walking" value="non" checked>
                    <label for="non">Non</label>
                </div>
                <input type="submit" name="forminscription" value='LOGIN' >
            </form>
        </div>
    </body>
</html>
