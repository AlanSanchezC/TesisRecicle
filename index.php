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



 
<script charset="ISO-8859-1">
var entidades = {};

///////////////Evento onClick para ver los detalles de una entidad
function verEntidad(idEntidadSeleccionada){
  var datos = entidades[idEntidadSeleccionada];
  console.log(JSON.stringify(datos, null, 2))
  var myWindow = window.open("", "_blank");

  var s = "<html><head><title>" + unescape(datos["Name"]) + "</title><link rel=\"stylesheet\" href=\"styles.css\" /></head>"; 

  s += "<body><label class=\"titulo\">"+ datos["Name"] + "</label> <br><br>" +
  "<table class=\"detalles-de-entidad\">" +
    "<tr><td><label class=\"detalles-ent\"> Direcci&oacute;n: </label> <label>" + 
    (datos['Address'])+ "</td></tr> "+
    "<tr><td><label class=\"detalles-ent\"> Municipio: </label> <label>" + 
    (datos['Town']) + "</td><br> "+
    "<tr><td><label class=\"detalles-ent\"> Tel&eacute;fono: </label><label>" + 
    (datos['Telephone']) + "</td></tr> "+
    "<tr><td><label class=\"detalles-ent\"> Horario: </label><label>" + 
    (datos['Schedule']) + "</td></tr>"+
    //" <label class=\"detalles-ent\"> Servicio: </label>" + (datos['ServiceName']) + "<br> "+
    "<tr><td><label class=\"detalles-ent\"> P&aacute;gina web :</label> <label>" + 
    (datos['WebPage']) + "</td></tr> "+
  "</table>" ;


//////////Aqui se va a agregar el mapa


  myWindow.document.write(s);


}


///////////////Evento que se ejecuta al dar click en un botón del menú de filtro

$("#menu-lateral :button").click(function(){

    checked = $("input[type=checkbox]:checked").length;

    if(!checked) {
      alert("Debes seleccionar una modalidad.");
      return false;
    }

  var municipio = $("#municipio").val();
  var servicio = "RECIBE-y-RECOGE";
  if ($("#check1").prop("checked") && !$("#check2").prop("checked")){
    s = "RECIBE";
  } else if (!$("#check2").prop("checked") && $("#check2").prop("checked")){
    s = "RECOGE";
  }
});



///////////////Evento que se ejecuta al dar click en un botón de algún material en la barra superior

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
        //Se guarda el resultado de la query por material
        entidades = entidad;

        //Se muestra el menú de filtro y el material seleccionado
        document.getElementById('menu-lateral').style.display = "block"; 
        document.getElementById('material-actual').innerHTML = entidad[0]['MaterialName'];

        //Resultados de la búsqueda
        var contenido = document.getElementById('resultados');
        contenido.innerHTML = "";

        for(var i in entidad){

          var s = "<div class=\"datos-ent\" onClick=\"verEntidad(" + i + ")\" id=\"" + (entidad[i]['InstitutionID'])  + "\" >"+
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