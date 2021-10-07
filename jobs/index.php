<!doctype html>
<html>
    <head>
        <title>Module de recherche des offres d'emploi</title>
    </head>


<?php
include_once("jobs.php");
$apiPoleEploi = new PoleEmploi();
if (isset($_POST["motCles"])) {
    $results = $apiPoleEploi-> getOffres($_POST["motCles"]);
    //print_r($_POST["motCles"]);
  }
 
  // afficher les resultats de recherche d'emploi 
  if(!isset($results))
  {
      echo "<h3>Nothing Found!!</h3>";
  }
  else
  {
    echo "<div style=' border: 2px solid #e66465; width:100%;'>
            <h3 style='margin: 15px; line-height: 1.5; text-align: center;''>
            <b>La liste des offres avec le mot clé [".$_POST["motCles"]."] dont les entreprise sont adaptés aux handicapés et 'handi friendly' : </b></h3><br>
            <table border=1>
                <tr>
                    <th>Intitulé</th>
                    <th>Date de creation</th>
                    <th>Localisation</th>
                    <th>Description</th>
                <tr>";
    //if results is more than 10, show ten first; else show the total
    if (count($results)>= 10) $max=10;
    else $max = count($results);

    for($i=0;$i<$max;$i++)
    {
        echo "
                <tr>
                    <td>".$results[$i]['intitule']."</td>
                    <td>".date('Y-m-d H:i:s',strtotime($results[$i]['dateCreation']))."</td>
                    <td> ".$results[$i]['lieuTravail']['libelle']."</td>
                    <td>".$results[$i]['description']."</td>
                </tr>
            
        ";
    }
    echo "</table></div>";
};
?>

</html>



