<!doctype html>
<html>
    <head>
        <title>WorkshopB3E28</title>
        <link rel="stylesheet" href="index.css">
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
        <div style="float:left; border: 2px solid #e66465; width:60%;">
            <form method="POST" action=" /module_recherche/poleEmploiRecherche.php" style="margin: 15px; line-height: 1.5; text-align: center;">
                <p >Recherche les offres dont les entreprise sont adaptés aux handicapés et "handi friendly"  : </p>
                <input type="search" name="motCles" placeholder="Recherche par un mot clé..." />
                <input type="submit" value="Valider" />
            </form>
        </div>
    </body>
</html>