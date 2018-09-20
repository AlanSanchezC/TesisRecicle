<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="iso-8859-1" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Reciclar Colima</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

</head>
<body>
<label class="titulo"> ReciclarColima </label>

<br>

<?php 
header('Content-Type: text/html; charset=iso-8859-1');
require_once('config/db.php')
?>

<div id="materiales" align="center">

<?php
$queryMateriales = $connect->query("SELECT * FROM RECYCLABLE_MATERIAL ORDER BY MaterialName ASC;");

if ($queryMateriales->num_rows > 0) {
	while($row = $queryMateriales->fetch_assoc()) {
?>
	    	<button type="button" class="btn btn-success" 
                id="<?php echo $row["MaterialID"]; ?>"> <?=$row["MaterialName"]?>  
        </button>
<?php
	}
} ?>

</div>
<br>
<p id="material-actual"></p>
<br>
<div class="row"> 
  <div class="col-2.5" id="menu-lateral" style="display: none;">
    <form class="filtro">
      Municipio <br>
        <select class="custom-select" id="municipio">
          <option selected>Elige uno...</option>
         	<?php
          		$queryMunicipios = $connect->query("SELECT DISTINCT(TOWN) FROM INSTITUTION");
				if ($queryMunicipios->num_rows > 0) {
					while($row = $queryMunicipios->fetch_assoc()) {
          	?>
          <option value="<?=$row["TOWN"]?>"> <?=$row["TOWN"]?></option>
          		<?php
					}
				} ?>
        </select>
        <br><br>
      

        <label> Modalidad </label><br>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="check1" name="checkbox_name[]" required>
          <label class="form-check-label" for="check1">Recibir</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="check2" name="checkbox_name[]" required>
          <label class="form-check-label" for="check2">Recoger</label>
        </div>
        <br><br>
        <button type="button" class="btn btn-primary">Filtrar</button>
    </form>
  </div>

  <div class="col-8">
    <p id="resultados"> </p>
  </div>
</div>

<script type="text/javascript" src="events.js"></script>
</body>
</html>