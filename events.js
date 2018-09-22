var entidades = {};
var clicked = false;
  
$(document).ready(function() {
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

            var s = "<div class=\"datos-ent\" onClick=\"verEntidad(" + i + ", this)\" id=\"ee" + (entidad[i]['InstitutionID'])  + "\" >"+
                          "<label class=\"nombre-ent\"> " + (entidad[i]['Name']) + "</label> " +
                          
                      "</div>"+
                    " <br>";
            contenido.innerHTML = contenido.innerHTML + s;
          }
        }
      }); 

    });


});

///////////////Evento onClick para ver los detalles de una entidad

function verEntidad(idEntidadSeleccionada, divSeleccionado){
    var d = divSeleccionado.id;
    if (!clicked){
      var datos = entidades[idEntidadSeleccionada];
      
      //Se muestran los detalles y el iframe con el mapa
      var s = 
              "<div><table>" +
                "<tr><td><label class=\"detalles-ent\"> Direcci&oacute;n: </label> </td> <td> <label>" + 
                (datos['Address'])+ "</td></tr> "+
                "<tr><td><label class=\"detalles-ent\"> Municipio: </label></td><td> <label>" + 
                (datos['Town']) + "</td><br> "+
                "<tr><td><label class=\"detalles-ent\"> Tel&eacute;fono: </label></td><td><label>" + 
                (datos['Telephone']) + "</td></tr> "+
                "<tr><td><label class=\"detalles-ent\"> Horario: </label></td><td><label>" + 
                (datos['Schedule']) + "</td></tr>"+
                "<tr><td><label class=\"detalles-ent\"> P&aacute;gina web: </label> </td><td><label>" + 
                (datos['WebPage']) + "</td></tr> "+
              "</table></div>" + 
              "<center><div class=\"details-geo\">" + (datos['Geolocation']) + "</center></div>";
      document.getElementById(d).innerHTML += s;
      clicked = true;
    }
    else{
      //Si se vuelve a dar clic, el div seleccionado regresa a su estado sin detalles
      document.getElementById(d).innerHTML = "<label class=\"nombre-ent\">" + entidades[idEntidadSeleccionada]['Name'] + "</label>";
      clicked = false;
    }
}
