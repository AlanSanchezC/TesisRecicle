<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="iso-8859-1" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Reciclar Colima</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/estilos.css">
  
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

</head>
<body style="background-color:#15162f;">
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

  <div class="col-9">
    <p id="resultados"> </p>
  </div>
</div>

<script type="text/javascript" src="events.js"></script>

<!-- Inicio del footer -->
<footer>
        <div class="footer-container">
            <div class="footer-main">
                <div class="footer-columna">
                    <h3>Direcci&oacute;n</h3>
                    <span class="fa fa-map-marker"><p>Av. Universidad No. 333, Las V&iacute;boras; CP 28040 Colima, Col.</p></span>
                    <span class="fa fa-phone-square"><p>(312) 316 1000</p></span><br>
                    <span class="fa fa-envelope"><p>correo@ucol.mx</p></span>
                </div>
                <div class="footer-columna">
                    <h3>Misi&oacute;n</h3>
                    <p>Contribuir a la transformaci&oacute;n de la sociedad a trav&eacute;s de la formaci&oacute;n integral de bachilleres profesionales, cient&iacute;ficos y creadores de excelencia, y el impulso decidido a la creaci&oacute;n, la aplicaci&oacute;n, la preservaci&oacute;n y la difusi&oacute;n del conocimiento cient&iacute;fico; el desarrollo tecnol&oacute;gico y las manifestaciones del arte y la cultura, en un marco institucional de transparencia y oportuna rendici&oacute;n de cuentas.</p>
                </div>
                
            </div>
        </div>

        <div class="footer-copy-redes">
          <div class="main-copy-redes">
            <div class="footer-copy">
              &copy; 2018, Todos los derechos reservados - | Universidad de Colima |.
            </div>
            <div class="footer-redes">
              <a href="https://www.facebook.com/UdeC.oficial/" target="_blank" new class="fa fa-facebook"></a>
              <a href="https://twitter.com/udec_oficial" target="_blank" class="fa fa-twitter"></a>
              <a href="https://www.youtube.com/channel/UCAb8uVFknu27Per_vLM4tGg" target="_blank" class="fa fa-youtube-play"></a>
              <a href="https://www.instagram.com/udec.oficial/" target="_blank" class="fa fa-instagram"></a>
            </div>
          </div>
        </div>
    </footer>
<!-- Fin del footer -->

</body>
</html>