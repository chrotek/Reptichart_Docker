<?php

$db = new SQLite3('/reptichart_readings.db');

$query = 'SELECT* FROM (SELECT * FROM reptichart_'.$_GET['name'].'_'.$_GET['dbtype'].' ORDER BY id desc LIMIT '.$_GET['count'].') ORDER BY id asc';

//echo $query;
$results = $db->query($query);
while ($row = $results->fetchArray()) {
	//var_dump($row);
	$readingString = $row['timedate'] . "|" . $row['temperature']. "|" . $row['humidity']. "|" ;
        echo $readingString;
}
?>

