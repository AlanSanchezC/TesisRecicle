<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="iso-8859-1" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Reciclar Colima</title>
	<link rel="stylesheet" href="styles.css" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' />

</head>
<body>
<label class="titulo"> ReciclarColima </label>

<br>


<?php 
header('Content-Type: text/html; charset=iso-8859-1');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "id3122298_recicle";
$conn = new mysqli($servername, $username, $password, $dbname);
?>

<div id="materiales" align="center">

<?php
$queryMateriales = $conn->query("SELECT * FROM RECYCLABLE_MATERIAL ORDER BY MaterialName ASC;");

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

<p id="material-actual"> </p>

<br>

<div class="row"> 
  <div class="col-2.5" id="menu-lateral" style="display: none;">
    <form class="filtro">
      Municipio <br>
        <select class="custom-select" id="municipio">
          <option selected>Elige uno...</option>
         	<?php
          		$queryMunicipios = $conn->query("SELECT DISTINCT(TOWN) FROM INSTITUTION");
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
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="check1" value="recibir">
          <label class="form-check-label" for="check1">Recibir</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="check2" value="recoger">
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



 
<script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js"></script>
<script charset="ISO-8859-1">
$('#menu-lateral :button').click(function(){
  var municipio = $("#municipio").val();
  
});


$('#materiales :button').click(function() {
    $("#check1").prop('checked', true);
    $("#check2").prop('checked', true);

    //Evento cuando se da click en un botón, solo uno esta "activo"
    $(this).addClass('active')
    .siblings('[type="button"]')
        .removeClass('active').addClass('btn-smallD');

    //Búsqueda de entidades por material
    $.ajax({
      url: "getdata.php",
      type: "POST",
      data: { "MaterialID": $(this).attr('id')},
      dataType: "json",
      success: function(entidad){ 
        document.getElementById('menu-lateral').style.display = "block";

        var contenido = document.getElementById('resultados');
        
        document.getElementById('material-actual').innerHTML = entidad[0]['MaterialName'];

        contenido.innerHTML = "";

        for(var i in entidad){
          var s = "<div class=\"datos-ent\">"+
                        "<label class=\"nombre-ent\"> " + (entidad[i]['Name']) + "</label> " +
                        "<table>" +
                          "<tr><td><label class=\"detalles-ent\"> Direcci&oacute;n: </label> </td> <td> <label>" + 
                          (entidad[i]['Address'])+ "</td></tr> "+
                          "<tr><td><label class=\"detalles-ent\"> Municipio: </label></td><td> <label>" + 
                          (entidad[i]['Town']) + "</td><br> "+
                          "<tr><td><label class=\"detalles-ent\"> Tel&eacute;fono: </label></td><td><label>" + 
                          (entidad[i]['Telephone']) + "</td></tr> "+
                          "<tr><td><label class=\"detalles-ent\"> Horario: </label></td><td><label>" + 
                          (entidad[i]['Schedule']) + "</td></tr>"+
                          //" <label class=\"detalles-ent\"> Servicio: </label>" + (entidad[i]['ServiceName']) + "<br> "+
                          "<tr><td><label class=\"detalles-ent\"> P&aacute;gina web: </label> </td><td><label>" + 
                          (entidad[i]['WebPage']) + "</td></tr> "+
                        "</table>" + 
                    "</div>"+
                  " <br>";
          contenido.innerHTML = contenido.innerHTML + s;
          
        }
      }
    }); 


  });
</script>

</body>
</html>