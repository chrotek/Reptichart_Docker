
<?php
ini_set('date.timezone', 'Europe/London');
function getvalue($name, $dbtype, $count){
    $_GET['name']="$name";
    $_GET['dbtype']="$dbtype";
    $_GET['count']="$count";
    require 'get_readings.php';			
}


// Parse configini with sections
$configini_array = parse_ini_file("config.ini", true);
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

    // Alerts & Formatting Section
    $alert_repti_max_temp = "";
    $alert_repti_min_temp = "";
    $alert_repti_max_humi = "";
    $alert_repti_min_humi = "";
    // Time
    $now_time = date('d m Y H:i:s');
    if(substr($repti_time, 0, -4) == substr($now_time, 0, -4))
    {
	    	$alert_repti_time = "";
    } else {
	    	$alert_repti_time = "<span style='color: #8b0000;'>".$repti_name_capi."'s readings are old! <br>".$now_time."</span>";
    }
    // Temp
    $repti_temp_formatted = "<span style='color: #00b200;'>".$repti_temp."</span>";
    // Temp HOT
    if($repti_temp > $reptiles[3])
    {
        $alert_repti_max_temp = "<span style='color: #8b0000;'>Too Hot! Max Temp ".$reptiles[3]."</span><br>";
        $repti_temp_formatted = "<span style='color: #8b0000;'>".$repti_temp."</span>";
    }
    // Temp COLD
    if($repti_temp < $reptiles[2])
    {
   	$alert_repti_min_temp = "<span style='color: #4169e1;'>Too Cold! Min Temp ".$reptiles[2]."</span><br>";
        $repti_temp_formatted = "<span style='color: #4169e1;'>".$repti_temp."</span>";	
    }
    // Humi
    $repti_humi_formatted = "<span style='color: #00b200;'>".$repti_humi."</span>";
    // Humi WET
    if($repti_humi > $reptiles[5])
    {
        $alert_repti_max_humi = "<span style='color: #4169e1;'>Too Humid! Max Humi ".$reptiles[5]."</span><br>";
	$repti_humi_formatted = "<span style='color: #4169e1;'>".$repti_humi."</span>";
    }
    // Humi DRY
    if($repti_humi < $reptiles[4])
    {
        $alert_repti_min_humi = "<span style='color: #b2b200;'>Too Dry! Min Humi ".$reptiles[4]."</span><br>";
	$repti_humi_formatted = "<span style='color: #b2b200;'>".$repti_humi."</span>";
    }

    echo('<div class="vertical-floating-box">');
    echo('<h4>'.$repti_name_capi.'</h4>'); 
    echo('<div class="center-float">');
    echo('<div class="horizontal-floating-box">');
    echo('<p>');
    echo('Last : <br>'.$repti_time.'<br>');
    echo($alert_repti_time);
    echo('</p>');
    echo('</div>');
    echo('<div class="horizontal-floating-box">');
    echo('<p>');
    echo('Temp : <br>'.$repti_temp_formatted.'<br>');
    echo($alert_repti_max_temp);
    echo($alert_repti_min_temp);
    echo('</p>');
    echo('</div>');
    echo('<div class="horizontal-floating-box">');
    echo('<p>');
    echo('Humi : <br>'.$repti_humi_formatted.'<br>');
    echo($alert_repti_min_humi);
    echo($alert_repti_max_humi);
    echo('</p>');
    echo('</div>');
    echo('</div>');
    echo('</div>');  

}

?>
