<?php
include("Calendar.php");
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Calendar</title>
  <link rel="stylesheet" href="calendar.css">
  <script src="script.js"></script>
</head>
<body>

<?php
$year = $_GET['year'] ?? date('Y');
$months = $_GET['months'] ?? date('m');
?>

<form action="" method="$_POST">
  <?php
    $next = strval($months + 1);
    $previous = strval($months - 1);
    if($next == 13)
    {
      $next = 1;
    }
    if($next == 0)
    {
      $next = 12;
    }
  ?>
  <button><a href=<?php echo "\"index.php?months=" . $previous . "&year=" . $year . "\""; ?>>Précèdent</a></button>
  <button><a href=<?php echo "\"index.php?months=" . $next . "&year=" .$year . "\""; ?>>Suivant</a></button>
</form>

<?php

$calendar = new Calendar($year, $months);

?>

</body>
</html>