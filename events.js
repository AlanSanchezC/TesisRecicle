$(document).ready(function() {
  var inicio = ""
  var town = "all"
  var entidades = [];

  /*Me trae el valor a comparar del checkbox*/
  $('#municipio').on('change', function(){
    town = $('#municipio').val()
  })

  /*Evento que se ejecuta al dar click en un botón de algún material en la barra superior*/

  $('#materiales :button').click(function() {
      entidades = [];
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
            for(var e in entidad)
              entidades.push(entidad[e])
    
            mostrarEntidades(entidades)
         });
        }
      }); 
    });

  /*Se genera el filtrado de las entidades*/

  $('#filtrar').click(function() {
    
    /*Resultados de la búsqueda*/
    var entidadFiltrada = entidades;
    
    /* Filtrado por municipio y tipo de servicio */
    if (town != "all")
      entidadFiltrada = entidadFiltrada.filter(function(item){
          return item.Town == town;         
      });
    
    if ($("#check2").prop("checked")){
      entidadFiltrada = entidadFiltrada.filter(function(item){
          return item.ServiceName == 'recoger';         
      });
    }

    if (entidadFiltrada.length > 0) {
      mostrarEntidades(entidadFiltrada)
    } else {
      document.getElementById('resultados').innerHTML = '<p style="color:white;">Sin resultados</p>';
    }
  })


  function mostrarEntidades(json){
    var temp = [];
    var contenido = document.getElementById('resultados');
    contenido.innerHTML = "";

    var templateString = "<div class=\"container\"> <div id=\"accordion\">";

    /* Se eliminan las entidades duplicadas si tienen servicio de "recoger" y "recibir" al mismo tiempo */
    templateString += insertarInformacionEntidades(json.filter(function(item, i){
      if (temp.indexOf(item.Name) < 0) {
        temp.push(item.Name);
        return true;
      }
      return false;
    })) + "</div></div>";

    //Se agregan a la vista con un delay para cada span
    contenido.innerHTML = contenido.innerHTML + templateString;

    $(".card").each(function(index) {
        $(this).delay(200*index).hide().fadeIn();
    });
  }


  function insertarInformacionEntidades(json){
    var i = 0;
    var str = "";
    for(var e in json){
          /*Se muestran los nombres de las entidades como "cards" y el contenido de cada una*/
          str += "<div class=\"card\">"+
            "<div class=\"card-header\" id=\"heading"+ i +"\" data-toggle=\"collapse\" data-target=\"#collapse"+ i +"\">" + 
              "<h5 class=\"mb-0\">"+
                "<label class=\"nombre-ent\" aria-expanded=\"false\" aria-controls=\"collapse"+ i +"\">" +
                      json[e]['Name'] +
                "</label>";

          if (json[e]['Recompensa'] != "0")
            str += "<img src=\"img/bank.png\" class=\"icono\" hspace=\"20px;\">";

          if (json[e]['ServiceName'] != "recibir")
            str += "<img src=\"img/truck.png\" class=\"icono\" ";

          str += "</h5>"+
            "</div>" +

            "<div id=\"collapse"+ i +"\" class=\"collapse\" aria-labelledby=\"heading"+ i +"\" data-parent=\"#accordion\">" +
              "<div class=\"card-body\">"+

                "<label class=\"detalles-ent\"> Direcci&oacute;n: </label> " + 
                (json[e]['Address']) + "<br>" +
                "<label class=\"detalles-ent\"> Municipio: </label> " + 
                (json[e]['Town']) +"<br>" +
                "<label class=\"detalles-ent\"> Tel&eacute;fono: </label> " + 
                (json[e]['Telephone']) + "<br>" +
                "<label class=\"detalles-ent\"> Horario: </label> " + 
                (json[e]['Schedule']) + "<br>" +
                "<label class=\"detalles-ent\"> P&aacute;gina web: </label> " + 
                (json[e]['WebPage']) + "<br>" +
                "<center><div class=\"details-geo\">" + (json[e]['Geolocation']) + "</center></div>" +
              "</div>"+
            "</div><br>";
          i++;              
    }
    return str;
  }

});