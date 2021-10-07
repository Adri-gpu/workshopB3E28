<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="index.css" media="screen" type="text/css" />
        <title>WorkshopB3E28</title>
    </head>
    <body>
        <div class=container>
            <div class=tile></div>
            <div class=tile></div>
            <div class=tile></div>
            <div class=tile></div>
        </div>
        <br/>
        <!-- Module de recherche d'emploi Handicap -->
        <div style="float:left;     border: 2px solid #e66465; width:60%;">
            <form method="POST" action=" /module_recherche/poleEmploiRecherche.php" style="margin: 15px; line-height: 1.5; text-align: center;">
                <p >Recherche les offres dont les entreprise sont adaptés aux handicapés et "handi friendly"  : </p>
                <input type="search" name="motCles" placeholder="Recherche par un mot clé..." />
                <input type="submit" value="Valider" />
            </form>
        </div>
    </body>
</html>