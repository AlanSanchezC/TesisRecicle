<?php
header("Content-Type: application/json; charset=utf-8");

require('config/db.php');

// ************  Búsqueda de entidades por material reciclable en tabla Servicio

$queryTodas = $connect->query("SELECT SERVICE.*, RECYCLABLE_MATERIAL.MaterialName, INSTITUTION.* " .
              " FROM SERVICE " .
              " INNER JOIN RECYCLABLE_MATERIAL ON SERVICE.MaterialID = RECYCLABLE_MATERIAL.MaterialID " .
              " INNER JOIN INSTITUTION ON SERVICE.InstitutionID = INSTITUTION.InstitutionID " .
              " WHERE SERVICE.MaterialID = ".$_POST["MaterialID"].";");

	$arr = array();

      	while($row = $queryTodas->fetch_assoc()) {
    		
    		$arr[] =  array(
    				"InstitutionID" => utf8_encode($row["InstitutionID"]),
				    "Name" => utf8_encode($row["Name"]),
					"Address" => utf8_encode($row["Address"]),
					"Schedule" => utf8_encode($row["Schedule"]),
					"Telephone" => utf8_encode($row["Telephone"]),
					"Town" => utf8_encode($row["Town"]),
					"ServiceName" => utf8_encode($row["ServiceName"]),
					"WebPage" => utf8_encode($row["WebPage"]),
					"MaterialName" => utf8_encode($row["MaterialName"]),
					"Geolocation" => utf8_encode($row["Geolocation"])
    		);
		}
	
	echo json_encode($arr)

?>
