<?php 
header("Content-type: application/json; charset=utf-8");
$servername = "localhost";
$username = "id3122298_acazarez";
$password = "iloverecicle";
$dbname = "id3122298_recicle";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM INSTITUTION";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// output data of each row
	$registros=array();
	$i=0;
	while($row = $result->fetch_assoc()) {
		// echo "nombre: " . $row["nombre"]. " - usuario: " . $row["usuario"]. " y contraseña= " . $row["contrasena"]. "<br>";
		$registros[$i]=$row;
		$i++;
	}
	echo json_encode($registros);
	} else {
	echo "0 results";
}
$conn->close();
?>