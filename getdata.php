<?php
header("Content-Type: application/json; charset=utf-8");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "id3122298_recicle";
$connect = new mysqli($servername, $username, $password, $dbname);

// ************  Búsqueda de entidades por material reciclable en tabla Servicio

$query = $connect->query("SELECT SERVICE.*, RECYCLABLE_MATERIAL.MaterialName, INSTITUTION.* " .
              " FROM SERVICE " .
              " INNER JOIN RECYCLABLE_MATERIAL ON SERVICE.MaterialID = RECYCLABLE_MATERIAL.MaterialID " .
              " INNER JOIN INSTITUTION ON SERVICE.InstitutionID = INSTITUTION.InstitutionID " .
              " WHERE SERVICE.MaterialID = ".$_POST["MaterialID"].";");
	
	
	$i = 0;
	$arr = array();
	$entidad = array();


      	while($row = $query->fetch_assoc()) {
    		
    		$arr[] =  array(
				    "Name" => utf8_encode($row["Name"]),
					"Address" => utf8_encode($row["Address"]),
					"Schedule" => utf8_encode($row["Schedule"]),
					"Telephone" => utf8_encode($row["Telephone"]),
					"Town" => utf8_encode($row["Town"]),
					"ServiceName" => utf8_encode($row["ServiceName"]),
					"WebPage" => utf8_encode($row["WebPage"])
    		);
    		//print_r($arr);
    		$i++;
		}
	
	echo json_encode($arr)

?>
