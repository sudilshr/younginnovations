<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 'Off');
	ini_set('html_errors', 'Off');
 
	$afile = fopen('awards.csv', 'r');
	$cfile = fopen('contracts.csv', 'r');
	
	while (($data = fgetcsv($afile, 0, ",")) !== FALSE) {
		$awards[]=$data;
	}
	
	while (($data = fgetcsv($cfile, 0, ",")) !== FALSE) {
			$contracts[]=$data;
	}

	$final = array();
	$keys = array_keys($contracts);
	foreach($keys as $key) {
		$final[] = array_merge($contracts[$key], $awards[$key]);
	}


	for($i=0;$i< count($contracts);$i++)
	{
		if($i==0){
			unset($awards[0][0]);
			$line[$i]=array_merge($contracts[0],$awards[0]);
		}
		else{
			$deadlook=0;
			for($j=0;$j <= count($awards);$j++)
			{
				if($awards[$j][0] == $contracts[$i][0]){
					unset($awards[$j][0]);
					$line[$i]=array_merge($contracts[$i],$awards[$j]);
					$deadlook=1;
				}           
			}
			if($deadlook==0)
				$line[$i]=$contracts[$i];
		}
	}


	$ffile = fopen('final.csv', 'w');//output file set here

	foreach ($line as $fields) {
		fputcsv($ffile, $fields);
	}
	fclose($ffile);
?>
