<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset=utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Reciclar Colima</title>
	<link rel="stylesheet" href="styles.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' />

</head>
<body>

<div class="nav justify-content-center">
  	<h1 class="nav-header"> ReciclarColima </h1>
</div>

<br><br>


<?php 
header('Content-Type: text/html; charset=UTF-8');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "id3122298_recicle";
$conn = new mysqli($servername, $username, $password, $dbname);
?>

<div align="center">

<?
$queryMateriales = $conn->query("SELECT * FROM RECYCLABLE_MATERIAL ORDER BY MaterialName ASC;");

if ($queryMateriales->num_rows > 0) {
	while($row = $queryMateriales->fetch_assoc()) {
?>
	    	<button type="button" 
                class="btn btn-outline-success" 
                id="<?php echo $row["MaterialID"]; ?>"
                onclick="mostrarEntidades(this)"> <?=$row["MaterialName"]?>  
        </button>

<?php
	}
} ?>
</div>
<br>

<div class="row"> 
  <div class="col-2">
    <form class="filtro">
      Municipio <br>
        <select class="custom-select">
          <option selected>Elige uno..</option>
         	<?php
          		$queryMunicipios = $conn->query("SELECT DISTINCT(TOWN) FROM INSTITUTION");
				if ($queryMunicipios->num_rows > 0) {
					while($row = $queryMunicipios->fetch_assoc()) {
          	?>
          <option value="1"> <?=$row["TOWN"]?></option>
          		<?php
					}
				} ?>
        </select>
        <br><br>
      

        <label>¿Recompensa? </label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
          <label class="form-check-label" for="inlineRadio1">Sí</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
          <label class="form-check-label" for="inlineRadio2">No</label>
        </div>
        <br><br>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

  </div>


  
  
  <div class="col">
    <div class="row">
      <div class="col-8" id="datos-ent">
        <label class="nombre-ent"> Recicladora Bruxeco </label><br>
        <label class="detalles-ent"> Materiales: </label> a, b ,c ,d ,e ...  <br>
        <label class="detalles-ent"> Dirección: </label> Dirección 1<br>
        <label class="detalles-ent"> Teléfono: </label> Teléfono 1<br>
        <label class="detalles-ent"> Horario: </label> Horario 1<br>
        <label class="detalles-ent"> Página web: </label> PaginaWeb.com<br>
        <label class="detalles-ent"> Ejemplo: </label> PaginaWeb.com<br>
      </div>
    </div>
    <br>
  </div>

</div>

<script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js"></script>
<script>
  function mostrarEntidades(material) {
      alert(material.id)

  }
</script>

</body>
</html>