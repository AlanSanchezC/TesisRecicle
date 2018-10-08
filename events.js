$(document).ready(function() {
  var inicio = ""
  var town = ""

  /*Evento que se ejecuta al dar click en un botón del menú de filtro*/

  $("#menu-lateral :button").click(function(){

      checked = $("input[type=checkbox]:checked").length;

      // if(!checked) {
      //   alert("Debes seleccionar una modalidad.");
      //   return false;
      // }

    var municipio = $("#municipio").val();
    var servicio = "RECIBE-y-RECOGE";
    if ($("#check1").prop("checked") && !$("#check2").prop("checked")){
      s = "RECIBE";
    } else if (!$("#check2").prop("checked") && $("#check2").prop("checked")){
      s = "RECOGE";
    }
  });

   /*Me trae el valor a comparar del checkbox*/
   $('#municipio').on('change', function(){
     town = $('#municipio').val()
   })

  /*Evento que se ejecuta al dar click en un botón de algún material en la barra superior*/

  $('#materiales :button').click(function() {
      
      $("#check1").prop('checked', true);
      $("#check2").prop('checked', true);

      /*Evento cuando se da click en un botón, solo uno esta "activo"*/
      $(this).addClass('active')
      .siblings('[type="button"]')
          .removeClass('active').addClass('btn-smallD');

      /*Búsqueda de entidades por material*/
      $.ajax({
        url: "getdata.php",
        type: "POST",
        data: { "MaterialID": $(this).attr('id')},
        dataType: "json",
        success: function(entidad){ 
          
          /*Muestra el material seleccionado*/
          $('#material-actual').text(entidad[0]['MaterialName'])
              .fadeIn();

          /*Se muestra el menú de filtro*/
          $('.inicio').fadeOut().promise().done(function(){
             $('#menu-lateral').fadeIn(); 
         
          /*Resultados de la búsqueda*/
            var contenido = document.getElementById('resultados');
            contenido.innerHTML = "";

            var templateString = "<div id=\"accordion\">";
            var i = 0;
            console.log(entidad)
            for(var e in entidad){
              /*Se muestran los nombres de las entidades como "cards" y el contenido de cada una*/
              
              templateString += "<div class=\"card\">"+
                      "<div class=\"card-header\" id=\"heading"+ i +"\" data-toggle=\"collapse\" data-target=\"#collapse"+ i +"\">" + 
                        "<h5 class=\"mb-0\">"+
                          "<label class=\"nombre-ent\" aria-expanded=\"false\" aria-controls=\"collapse"+ i +"\">" +
                                entidad[e]['Name'] +
                          "</label>"+
                        "</h5>"+
                      "</div>" +

                      "<div id=\"collapse"+ i +"\" class=\"collapse\" aria-labelledby=\"heading"+ i +"\" data-parent=\"#accordion\">" +
                        "<div class=\"card-body\">"+

                          "<label class=\"detalles-ent\"> Direcci&oacute;n: </label> " + 
                          (entidad[e]['Address']) + "<br>" +
                          "<label class=\"detalles-ent\"> Municipio: </label> " + 
                          (entidad[e]['Town']) +"<br>" +
                          "<label class=\"detalles-ent\"> Tel&eacute;fono: </label> " + 
                          (entidad[e]['Telephone']) + "<br>" +
                          "<label class=\"detalles-ent\"> Horario: </label> " + 
                          (entidad[e]['Schedule']) + "<br>" +
                          "<label class=\"detalles-ent\"> P&aacute;gina web: </label> " + 
                          (entidad[e]['WebPage']) + "<br>" +
                          "<center><div class=\"details-geo\">" + (entidad[e]['Geolocation']) + "</center></div>" +
                        "</div>"+
                    "</div><br>";
              i++;
            }
            templateString += "</div>";
              //Se agregan a la vista con un delay para cada span
              contenido.innerHTML = contenido.innerHTML + templateString;

              $(".card").each(function(index) {
                  $(this).delay(200*index).hide().fadeIn();
              });

              /*Se genera el filtrado de las entidades*/

              let filtrado = $('#filtrar')
              filtrado.on('click', e => {
                contenido.innerHTML = " "
                templateString = " "
                entidad.map(empresa => {
                  if (town === empresa.Town){
                    templateString += "<div class=\"card\">"+
                      "<div class=\"card-header\" id=\"heading"+ i +"\" data-toggle=\"collapse\" data-target=\"#collapse"+ i +"\">" + 
                        "<h5 class=\"mb-0\">"+
                          "<label class=\"nombre-ent\" aria-expanded=\"false\" aria-controls=\"collapse"+ i +"\">" +
                                empresa['Name'] +
                          "</label>"+
                        "</h5>"+
                      "</div>" +

                      "<div id=\"collapse"+ i +"\" class=\"collapse\" aria-labelledby=\"heading"+ i +"\" data-parent=\"#accordion\">" +
                        "<div class=\"card-body\">"+

                          "<label class=\"detalles-ent\"> Direcci&oacute;n: </label> " + 
                          (empresa['Address']) + "<br>" +
                          "<label class=\"detalles-ent\"> Municipio: </label> " + 
                          (empresa['Town']) +"<br>" +
                          "<label class=\"detalles-ent\"> Tel&eacute;fono: </label> " + 
                          (empresa['Telephone']) + "<br>" +
                          "<label class=\"detalles-ent\"> Horario: </label> " + 
                          (empresa['Schedule']) + "<br>" +
                          "<label class=\"detalles-ent\"> P&aacute;gina web: </label> " + 
                          (empresa['WebPage']) + "<br>" +
                          "<center><div class=\"details-geo\">" + (empresa['Geolocation']) + "</center></div>" +
                        "</div>"+
                    "</div><br>";
                    contenido.innerHTML = templateString
                  }else{
                    templateString = `<p align="center" style="color:white;">No hay contenido</p>`
                    contenido.innerHTML = templateString
                  }
                })
              })

         });
        }
      }); 
    });


});