 $(document).ready(function() {

  $("#agregarCampania").validate({
    errorClass:'invalid-feedback',
    errorElement:'span',
    highlight: function(element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("invalid-feedback");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
    rules: {
      inputNombre: {
        required: true,
        minlength: 3,
        maxlength: 50
      },
      inputTitulo: {
        required: true,
        minlength: 1,
        maxlength: 40
      },
      selectTipoCampania: {
        required: true,
        minlength: 1
      },
      inputObservaciones: {
        maxlength: 100
      },
    },
    messages:{
      inputNombre: {
        required: "Se requiere un Nombre de Campa&ntilde;a.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        maxlength: "Se requiere no mas de {0} caracteres."
      },
      inputTitulo: {
        required: "Se requiere un Titulo para la Campa&ntilde;a.",
        minlength: "Se requiere m&iacute;nimo {0} caracteres.",
        maxlength: "Se requiere no mas de {0} caracteres."
      },
      selectTipoCampania: {
        required: "Se requiere seleccionar un Tipo de Campania.",
        minlength: "Se requiere seleccionar un Tipo de Campania.",
      },
      inputObservaciones: {
        maxlength: "Se requiere no mas de {0} caracteres."
      },
    }
  });

  $('#buscarCampania').on('change',function(e){
     filtroCampania = $('#buscarCampania').val();

     if(filtroCampania.length = 0)
        filtroCampania = "";
    listarCampanias(filtroCampania);
  });

  $('#modalEliminarCampania').on('show.bs.modal', function(e) {
    //get data-id attribute of the clicked element
    var idCampania = $(e.relatedTarget).data('id');
    var nombreCampania = $(e.relatedTarget).data('nombre');
    //populate the textbox
    $("#tituloEC").text('Eliminar ' + nombreCampania);
    $("#parrafoEC").text('¿Estás seguro que deseas eliminar "' + nombreCampania + '"?');

    $("#tituloEC").removeData("idcampania");
    $("#tituloEC").attr("data-idcampania", idCampania);
    //$("#tituloEC").removeData("nombrecampania");
    //$("#tituloEC").attr("data-nombreCampania", nombreCampania);
  });

  $('#eliminarCampania').click(function(e){
    idCampania = $('#tituloEC').data('idcampania');
    //var nombreCampania = $('#tituloEC').data('nombrecampania');
    var baseurl = window.origin + '/gestion_calidad/Campania/eliminarCampania';

    jQuery.ajax({
    type: "POST",
    url: baseurl,
    //dataType: 'json',
    data: {idCampania: idCampania},
    success: function(data) {
      if (data)
      {
        if(data == '1')
        {
          $('#tituloME').empty();
          $("#parrafoME").empty();
          $("#tituloME").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
          $("#parrafoME").append('Se ha eliminado exitosamente el Campania.');
          $('#modalEliminarCampania').modal('hide');
          $('#modalMensajeCampania').modal({
            show: true
          });
          listarCampanias('');
        }else{
          $('#tituloME').empty();
          $("#parrafoME").empty();
          $("#tituloME").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
          $("#parrafoME").append('Ha ocurrido un error al intentar eliminar el Campania.');
          $('#modalEliminarCampania').modal('hide');
          $('#modalMensajeCampania').modal({
            show: true
          });
          listarCampanias('');
        }
        feather.replace()
        $('[data-toggle="tooltip"]').tooltip()
      }
    }
    });
  });

  $('#buscarEAC').on('change', function(e){
     filtroEAC = $('#buscarEAC').val();

     if(filtroEAC.length = 0)
        filtroEAC = "";
      listarEAC(filtroEAC);
  });

  function listarCampanias(filtro)
  {
    var baseurl = window.origin + '/gestion_calidad/Campania/buscarCampania';
    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {campania: filtro},
    success: function(data) {
    if (data)
    {
        $("#tbodyCampania").empty();
        for (var i = 0; i < data.length; i++){
          var row = '<tr>';
          row = row.concat('\n<th scope="row" class="text-center align-middle registro">',data[i]['id_campania'],'</th>');
          row = row.concat('\n<td class="text-center align-middle registro">',data[i]['c_nombre'],'</td>');
          row = row.concat('\n<td class="text-center align-middle registro">',data[i]['c_titulo'],'</td>');
          row = row.concat('\n<td class="text-center align-middle registro">',data[i]['c_muestra'],'</td>');
          row = row.concat('\n<td class="text-center align-middle registro">',((data[i]["c_cant_gestiones_ciclo"]) == null? '': (data[i]["c_cant_gestiones_ciclo"])),'</td>');
          row = row.concat('\n<td class="text-center align-middle registro">',data[i]['plantilla'],'</td>');
          row = row.concat('\n<td class="text-center align-middle registro">',data[i]['c_tmo'],'</td>');
          row = row.concat('\n<td class="text-right align-middle registro">');
          row = row.concat('\n<a id="trash_',data[i]['id_campania'],'" class="trash" href="#" data-id="',data[i]['id_campania'],'" data-nombre="',data[i]['c_nombre'],'" data-toggle="modal" data-target="#modalEliminarCampania">');
          row = row.concat('\n<i data-feather="trash-2"  data-toggle="tooltip" data-placement="top" title="eliminar"></i>');
          row = row.concat('\n</a>');
          row = row.concat('\n<a id="edit_',data[i]['id_campania'],'" class="edit" type="link" href="ModificarCampania/?idCampania=',data[i]['id_campania'],'" data-id="',data[i]['id_campania'],'" data-nombre="',data[i]['c_nombre'],'">');
          row = row.concat('\n<i data-feather="edit-3"  data-toggle="tooltip" data-placement="top" title="modificar"></i>');
          row = row.concat('\n</a>');
          row = row.concat('\n</td>');
          row = row.concat('\n<tr>');

        $("#tbodyCampania").append(row);
      }
      feather.replace()
      $('[data-toggle="tooltip"]').tooltip()
    }
    }
    });
  }

  function listarEAC(filtro){
    var eacs = [];
    if(document.getElementById('tablaEAC').dataset.eac.split(',').length > 0 && document.getElementById('tablaEAC').dataset.eac.split(',') != "")
      if(document.getElementById('tablaEAC').dataset.eac.split(',').length == 1)
        eacs = [document.getElementById('tablaEAC').dataset.eac];
      else
        eacs = document.getElementById('tablaEAC').dataset.eac.split(',');

    var baseurl = window.origin + '/gestion_calidad/Campania/buscarEAC';   

    jQuery.ajax({
    type: "POST",
    url: baseurl, //"buscarEAC",
    dataType: 'json',
    data: {eac: filtro},
    success: function(data) {
      if (data)
      {
          $("#tbodyEAC").empty();
          count = 0;
          for (var i = 0; i < data.length; i++){
            count++;
            var clases = "";//((count == 2) ? 'list-group' : '');
            if(count == 15)
              count = 0;
            var row = '';
            row = row.concat('<tr class="',clases,'">');
            row = row.concat('\n<td class="text-center" hidden>',data[i]['id_usuario'],'</td>');
            row = row.concat('\n<th class="text-center" scope="col">',data[i]['cod_eac'],'</td>');
            row = row.concat('\n<td class="text-center" colspan="5">',data[i]['nombres'],'</td>');
            row = row.concat('\n<td class="text-center" colspan="5">',data[i]['apellidos'],'</td>');
            row = row.concat('\n <td class="text-center" >',data[i]['email'],'</td>');
            row = row.concat('\n<td class="text-center " >');
            
            checked = "";
            var indiceEAC = eacs.indexOf(data[i]['id_usuario'].toString());
            if(indiceEAC != -1)
              checked = "checked";

            row = row.concat('\n<input id="check_',data[i]['id_usuario'],'" type="checkbox" class="pauta" data-idUsuario="', data[i]['id_usuario'],'" ', checked, '>');
            row = row.concat('\n</td>');
            row = row.concat('\n<tr>');
          $("#tbodyEAC").append(row);
        }
        //feather.replace()
        //$('[data-toggle="tooltip"]').tooltip()
      }
    }
    });
  }

  $('#tListaEAC').on('click', '.pauta', function(e) {
      idEAC = $(e.currentTarget).data('idusuario');
      checked = null;
      if(idEAC != null)
        checked = ($(this).is(':checked') ? true : false);

      var eacs = [];
      if(document.getElementById('tablaEAC').dataset.eac.split(',').length > 0 && document.getElementById('tablaEAC').dataset.eac.split(',') != "")
        if(document.getElementById('tablaEAC').dataset.eac.split(',').length == 1)
          eacs = [document.getElementById('tablaEAC').dataset.eac];
        else
          eacs = document.getElementById('tablaEAC').dataset.eac.split(',');

      var indiceEAC = eacs.indexOf(idEAC.toString());
      if(indiceEAC != -1)
      {
        if(!checked)
          eacs.splice(indiceEAC, 1);
      }else
        if(checked)
          eacs.push([idEAC]);
      document.getElementById('tablaEAC').dataset.eac = eacs;
  });

  $('#check_todos').on('click', function(e) {

      var tListaEAC = document.getElementById("tListaEAC");
      var r=1;
      var eacs = [];
      cant = 0;
      checked = ($("#check_todos").text() == 'Deseleccionar Todos' ? false : true);
      if(document.getElementById('tablaEAC').dataset.eac.split(',').length > 0 && document.getElementById('tablaEAC').dataset.eac.split(',') != "")
        if(document.getElementById('tablaEAC').dataset.eac.split(',').length == 1)
          eacs = [document.getElementById('tablaEAC').dataset.eac];
        else
          eacs = document.getElementById('tablaEAC').dataset.eac.split(',');
      while(row=tListaEAC.rows[r++])
      {
        if(row.cells.length > 0)
        {
          idEAC = row.cells[0].innerHTML;          
          if(idEAC != null)
          {
            var indiceEAC = eacs.indexOf(idEAC.toString());
            if(indiceEAC != -1)
            {
              if(!checked)
                eacs.splice(indiceEAC, 1);
            }else
              if(checked)
                eacs.push([idEAC]);

            $("#check_"+idEAC).prop("checked", checked);
          }
        }
      }

      document.getElementById('tablaEAC').dataset.eac = eacs;

      if(checked)
        $("#check_todos").text('Deseleccionar Todos');
      else
        $("#check_todos").text('Seleccionar Todos');
  });

  $("#agregarCampania").submit(function(e) {
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    /*$("div.loader").addClass('show');*/
    var validacion = $("#agregarCampania").validate();
    if(validacion.numberOfInvalids() == 0)
    {
      event.preventDefault();
    
      var baseurl = (window.origin + '/gestion_calidad/Campania/guardarCampania');
      var nombreCampania = $('#inputNombre').val();
      var tituloCampania = $('#inputTitulo').val();
      var fechaInicio = $('#inputFechaInicio').val();
      var fechaFin = $('#inputFechaFin').val();
      var cantEAC = $('#inputCantEac').val();
      var cantDiasFase = $('#inputCantDiasFase').val();
      var cantDiasCiclo = $('#inputCantDiasCiclo').val();
      var cantCiclos = $('#inputCantCiclo').val();
      var TMO = $('#inputTMO').val();
      var cantDiasdAntiguedadGab = $('#inputCantDiasAntiguedadGrab').val();
      var cantGestionesCiclo = $('#inputCantGestionesCiclo').val();
      var cantLlamados = $('#inputCantLlamados').val();
      var muestra = $('#inputMuestra').val();
      var codCampania = $('#inputCodCampania').val();
      var observaciones = $('#inputObservaciones').val();
      var idTipoCampania = $('#selectTipoCampania').val();
      var idEmpresa = $('#selectEmpresa').val();
      var idPlantilla = $('#selectPlantilla').val();
      var idCampania = null;
      if($("#inputIdCampania").val())
        idCampania = $('#inputIdCampania').val();

      jQuery.ajax({
      type: "POST",
      url: baseurl,
      dataType: 'json',
      data: { idCampania: idCampania, nombreCampania: nombreCampania, tituloCampania: tituloCampania,
       fechaInicio: fechaInicio, fechaFin: fechaFin, cantEAC: cantEAC, cantDiasFase: cantDiasFase, cantDiasCiclo: cantDiasCiclo,
       cantCiclos: cantCiclos, TMO: TMO, cantDiasdAntiguedadGab: cantDiasdAntiguedadGab, cantGestionesCiclo: cantGestionesCiclo, cantLlamados: cantLlamados,
       muestra: muestra, codCampania: codCampania, observaciones: observaciones, idPlantilla: idPlantilla, idTipoCampania: idTipoCampania, idEmpresa: idEmpresa },
      success: function(data) {
        if (data)
        {
          //data = JSON.parse(data);
          if(data['respuesta'] == '1')
          {
            $('#tituloMC').empty();
            $("#parrafoMC").empty();
            $("#tituloMC").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
            $("#parrafoMC").append(data['mensaje']);
            if(!$("#inputIdCampania").val())
            {
              $("#agregarCampania")[0].reset();
              $("#check_todos").text('Seleccionar Todos');
              $(".pauta").prop("checked", false);
            }
            loader.setAttribute('hidden', '');
            $('#modalMensajeCampania').modal({
              show: true
            });
          }else{
            $('#tituloMC').empty();
            $("#parrafoMC").empty();
            $("#tituloMC").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
            $("#parrafoMC").append(data['mensaje']);
            loader.setAttribute('hidden', '');
            $('#modalMensajeCampania').modal({
              show: true
            });
          }
          feather.replace()
          $('[data-toggle="tooltip"]').tooltip()
        }
      }
      });
    }else
    {
      loader.setAttribute('hidden', '');
    }
  });

  $('#modalMensajeCampania').on('hidden.bs.modal', function (e) {
    
  });

  $('#selectAnalistas').on('change',function(e){
      analista = null;
      campania = null;
      equipo = null;

      if($('#selectAnalistas').val().length > 0 && $('#selectAnalistas').val() != -1)
         analista = $('#selectAnalistas').val(); 

      if($('#selectCampanias').val().length > 0 && $('#selectCampanias').val() != -1)
        campania = $('#selectCampanias').val();

      //if($('#selectEquipos').val().length > 0 && $('#selectEquipos').val() != -1)
        //equipo = $('#selectEquipos').val();

      listarUsuCampEqui(analista, campania, equipo);
  });

  $('#selectCampanias').on('change',function(e){
    analista = null;
    campania = null;
    equipo = null;

    if($('#selectAnalistas').val().length > 0 && $('#selectAnalistas').val() != -1)
       analista = $('#selectAnalistas').val(); 

    if($('#selectCampanias').val().length > 0 && $('#selectCampanias').val() != -1)
      campania = $('#selectCampanias').val();

    //if($('#selectEquipos').val().length > 0 && $('#selectEquipos').val() != -1)
      //equipo = $('#selectEquipos').val();

    listarUsuCampEqui(analista, campania, equipo);
  });

  /*$('#selectEquipos').on('change',function(e){
    analista = null;
    campania = null;
    equipo = null;

    if($('#selectAnalistas').val().length > 0 && $('#selectAnalistas').val() != -1)
       analista = $('#selectAnalistas').val(); 

    if($('#selectCampanias').val().length > 0 && $('#selectCampanias').val() != -1)
      campania = $('#selectCampanias').val();

    if($('#selectEquipos').val().length > 0 && $('#selectEquipos').val() != -1)
      equipo = $('#selectEquipos').val();

    listarUsuCampEqui(analista, campania, null);
  });*/


  function listarUsuCampEqui(analista, campania, equipo)
  {
    var baseurl = window.origin + '/gestion_calidad/Campania/filtrarUsuCampEqui';
    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {analista: analista, campania: campania, equipo: equipo},
    success: function(data) {
    if (data)
    {
      $("#tbodyUsuCampEqui").empty();
      for (var i = 0; i < data["usuCampEqui"].length; i++){
        var row = '<tr>';
        row = row.concat('\n<th scope="row" class="text-center align-middle registro">',data["usuCampEqui"][i]['id_usuario'],'</th>');
        row = row.concat('\n<td class="text-center align-middle registro">',data["usuCampEqui"][i]['nombre_completo'],'</td>');
        row = row.concat('\n<td class="text-center align-middle registro">',data["usuCampEqui"][i]['c_nombre'],'</td>');
        row = row.concat('\n<td class="text-center align-middle registro">',data["usuCampEqui"][i]['eq_nombre'],'</td>');
        row = row.concat('\n<td class="text-right align-middle registro">');
        row = row.concat('\n<a id="view_',data["usuCampEqui"][i]['id_usuario_campania'],'" class="view" href="#" data-id="',data["usuCampEqui"][i]['id_usuario_campania'],'" data-nombreAnalista="',data["usuCampEqui"][i]['nombre_completo'],'" data-nombreCampania="',data["usuCampEqui"][i]['c_nombre'],'" data-nombreEquipo="',data["usuCampEqui"][i]['eq_nombre'],'" data-toggle="modal" data-target="#modalEliminarUsuCampEqui">');
        row = row.concat('\n<i data-feather="trash-2"  data-toggle="tooltip" data-placement="top" title="eliminar"></i>');
        row = row.concat('\n</a>');
        row = row.concat('\n</td>')
        row = row.concat('\n<tr>');
        $("#tbodyUsuCampEqui").append(row);
      }

      if(analista != null && campania != null && data["usuCampEqui"].length == 1)
      {
        var btnAgregar = document.getElementById('btnAgregar');
        btnAgregar.classList.remove('btn-success');
        btnAgregar.classList.add('btn-secondary');
        btnAgregar.innerText = 'Modificar';
        btnAgregar.removeAttribute('data-idusucampequi');
        btnAgregar.removeAttribute('data-idequipo');
        btnAgregar.setAttribute('data-idusucampequi', data["usuCampEqui"][0]['id_usuario_campania']);
        btnAgregar.setAttribute('data-idequipo', data["usuCampEqui"][0]['id_equipo']);
      }else{
        var btnAgregar = document.getElementById('btnAgregar');
        btnAgregar.classList.remove('btn-secondary');
        btnAgregar.classList.add('btn-success');
        btnAgregar.innerText = 'Agregar';
        btnAgregar.removeAttribute('data-idusucampequi');
        btnAgregar.removeAttribute('data-idequipo');
      }

      feather.replace()
      $('[data-toggle="tooltip"]').tooltip()
    }
    }
    });
  }

  $("#btnAgregar").on('click', function(e) {
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');

    analista = null;
    campania = null;
    equipo = null;

    if($('#selectAnalistas').val().length > 0 && $('#selectAnalistas').val() != -1)
       analista = $('#selectAnalistas').val(); 

    if($('#selectCampanias').val().length > 0 && $('#selectCampanias').val() != -1)
      campania = $('#selectCampanias').val();

    if($('#selectEquipos').val().length > 0 && $('#selectEquipos').val() != -1)
      equipo = $('#selectEquipos').val();

    if(analista != null && campania != null)
      {
        var btnAgregar = document.getElementById('btnAgregar');
        var idEquipo = (btnAgregar.getAttribute('data-idequipo').trim() == "" ? null: btnAgregar.getAttribute('data-idequipo').trim());
        
        if(equipo == idEquipo)
        {
          var usuarioAnalista = $("#selectAnalistas option:selected").text();
          var mensaje = '';
          mensaje = mensaje.concat('El Usuario ', usuarioAnalista ,' ya posee la configuraci&oacute;n que desea modificar.');
          $('#tituloMUCE').empty();
          $("#parrafoMUCE").empty();
          $("#tituloMUCE").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
          $("#parrafoMUCE").append(mensaje);
          loader.setAttribute('hidden', '');
          $('#modalMensajeUsuCampEqui').modal({
            show: true
          });          
        }else
        {
           loader.setAttribute('hidden', '');
        }
      }else{
        var mensaje = '';
        if(analista == null)
        {
          mensaje = 'Debe seleccionar un Analista para Agregar la configuraci&oacute;n.';
        }else{
          if(campania == null)
          {
            mensaje = 'Debe seleccionar una Campa&ntilde;a para Agregar la configuraci&oacute;n.';
          }
        }

        $('#tituloMUCE').empty();
        $("#parrafoMUCE").empty();
        $("#tituloMUCE").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
        $("#parrafoMUCE").append(mensaje);
        loader.setAttribute('hidden', '');
        $('#modalMensajeUsuCampEqui').modal({
          show: true
        });
      }
      feather.replace()
      $('[data-toggle="tooltip"]').tooltip()
  });

});