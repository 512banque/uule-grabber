<?php
ini_set("memory_limit",-1);

function uule($city) {
	$secretkey = array_merge(range('A','Z'), range('a','z'), range('0','9'), array('-', '_'));
	return trim('w+CAIQICI'.$secretkey[strlen($city)%count($secretkey)].base64_encode($city), '=');
}

$final = array();

$row = 1;
if (($handle = fopen("latest.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    	if($row==1)
    		$final[] = array_merge($data, array('Uule parameter'));
    	else
        	$final[] = array_merge($data, array(uule($data[2])));
        echo $row++."\r\n"; flush();
    }
    fclose($handle);
}

$fp = fopen('file.csv', 'w');

foreach ($final as $fields) {
    fputcsv($fp, $fields);
}


fclose($fp);
?>