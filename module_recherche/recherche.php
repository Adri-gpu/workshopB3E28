<?php
require 'indeed.php'; // indeed library
$client = new Indeed("Your-Indeed-Publisher-ID");
$params = array(
    "v" => "2",     // API Version
    "q" => "PHP",  //Job Title
    "l" => "Pakistan", // Country Name default 'United States'
    "co" => "PK",      // Country Code defauld US
    "userip" => $_SERVER['REMOTE_ADDR'], // Your IP Address
    "useragent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2)"    // user agent
);
$results = $client->search($params);   // API Call for results

if($results['totalResults'] <=0)
{
    echo "<h3>Nothing Found!!</h3>";
}
else
{
    echo "<h3><b>PHP jobs in Pakistan</b></h3><br>";
}
echo "<table border=1>
<tr>
    <th>Date</th>
    <th>Title</th>
    <th>Location</th>
    <th>Description</th>
<tr>";
for($i=0;$i<count($results['results']);$i++)
{
    echo "
    <tr>
        <td>".$results['results'][$i]['date']."</td>
        <td><a href='?jdetails=".$results['results'][$i]['jobkey']."' target='_blank'>".$results['results'][$i]['jobtitle']."</a></td>
        <td>".$results['results'][$i]['formattedLocation'].", ".$results['results'][$i]['country']."</td>
        <td>".$results['results'][$i]['snippet']."</td>
    </tr>";
}
echo "</table>";
?>