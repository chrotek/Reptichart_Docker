
<?php

// Parse configini with sections
$configini_array = parse_ini_file("config.ini", true);
foreach ($configini_array["reptiles"] as $value) {
    $reptiles = explode(":",$value);	
    $repti_name_capi = ucfirst($reptiles[0]);   
    echo('<option value="'.$reptiles[0].'">'.$repti_name_capi.'</option>');
}


?>

