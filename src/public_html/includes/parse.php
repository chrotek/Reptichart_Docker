
<?php

function getvalue($name, $dbtype, $count){
    $_GET['name']="$name";
    $_GET['dbtype']="$dbtype";
    $_GET['count']="$count";
    require 'includes/get_readings.php';			
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * *  * * * * * *  * * * * * * *
 *  * Declare the time, temp , humi variables for each reptile, with latest readings  *
 *   *										   *
 *    * Flo										   *
 *     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// Parse configini with sections
$configini_array = parse_ini_file("includes/config.ini", true);
foreach ($configini_array["reptiles"] as $value) {
    $reptiles = explode(":",$value);	
    ob_start();
    getvalue($reptiles[0], 'detailed', 1);
    $reading=ob_get_contents();
    ob_end_clean();
    $pieces = explode("|", $reading);
    $repti_time = $pieces[0];
    $repti_temp = $pieces[1];
    $repti_humi = $pieces[2];
    $repti_name_capi = ucfirst($reptiles[0]);   
    
    print($reptiles[0]."\n");
    print($repti_time."\n");
    print($repti_temp."\n");
    print($repti_humi."\n");
       
}


?>

