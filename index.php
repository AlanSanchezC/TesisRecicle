<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Reciclar Colima</title>
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/estilos.css">

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

</head>
<body style="background-color:#15162f;">

<!-- Aqui se muestra el icono del logo -->
<div class="titulo">
  <center>
      <img style="width:90px; height:90px;" src="img/logo.png">
      <label class="principal"> Reciclar Colima </label>
  </center>
</div>
<!-- Aqui termina el icono del logo -->

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
<!-- Inicio del filtro -->
<p id="material-actual"></p>

<div class="inicio" style="display: block;">
  <center>
      <label class="principal"> &iquest;Qu&eacute; deseas reciclar? </label>
      <img src="img/inicio-img.png">
  </center>
</div>

<div id="material-actual"></div>

<br>



<div class="row">
    <div class="col-2.5" id="menu-lateral" style="display: none;">
      <form class="filtro">
        <label class="mun"> Municipio </label><br>
          <select class="custom-select" id="municipio">
            <option value="all" selected>Todos</option>
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
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check1" value="option1">
            <label class="form-check-label" for="inlineCheckbox1">Recompensa </label>
          </div>
          <br id="salto">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="check2" value="option2">
            <label class="form-check-label" for="inlineCheckbox2">Servicio a domicilio </label>
          </div>
          <br><br>
          <center><button type="button" id="filtrar" class="btn btn-primary">Filtrar</button></center>
      </form>


    </div>

    <div class="col" id="contenido">
      <div id="resultados"></div>
    </div>
</div>

<p class="espaciado">&nbsp;</p>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="events.js"></script>

<!-- Inicio del footer -->
<footer>
        <div class="footer-container">
            <div class="footer-main">
                <div class="footer-columna">
                    <h3>Direcci&oacute;n</h3>
                    <div class="fa fa-map-marker">&nbsp; Av. Universidad No. 333, Las V&iacute;boras; CP 28040 Colima, Col.</div>
                    <div class="fa fa-phone-square">&nbsp;(312) 316 1000</div><br>
                    <div class="fa fa-envelope">&nbsp;correo@ucol.mx</div>
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