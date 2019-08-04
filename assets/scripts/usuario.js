 $(document).ready(function() {

  /*$.validator.addMethod(
        "rutInvalido",
         function (value, element) {
          var re = new RegExp('(0?[1-9]{1,2})(?>((\.\d{3}){2,}\-)|((\d{3}){2,}\-)|((\d{3}){2,}))([\dkK])');
          return re.test(value);
        },
        "Ingrese un rut v&aacute;lido."
  );

  $("#agregarUsuario").validate({
    errorClass:'invalid-feedback',
    errorElement:'span',
    highlight: function(element, errorClass, validClass) {
      $(element).addClass("is-invalid").removeClass("invalid-feedback");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
    rules: {
      inputNombres: {
        required: true,
        minlength: 1,
        maxlength: 120
      },
       inputApellidos: {
        required: true,
        minlength: 1,
        maxlength: 120
      },      
      inputRut: {
        required: true,
        rutInvalido: true
      },
      inputEmail: {
        maxlength: 100
      },
    },
    messages:{
      inputNombre: {
        required: "Se requiere un Nombre de Usuario.",
        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        maxlength: "Se requiere no mas de {0} caracteres."
      }
    }
  });*/

  $('#modalEliminarUsuario').on('show.bs.modal', function(e) {
    //get data-id attribute of the clicked element
    var idUsuario = $(e.relatedTarget).data('id');
    var nombreUsuario = $(e.relatedTarget).data('nombre');
    //populate the textbox
    $("#tituloEU").text('Eliminar ' + nombreUsuario);
    $("#parrafoEU").text('¿Estás seguro que deseas eliminar "' + nombreUsuario + '"?');

    $("#tituloEU").removeData("idusuario");
    $("#tituloEU").attr("data-idusuario", idUsuario);

    
    //$("#tituloEE").removeData("nombreequipo");
    //$("#tituloEE").attr("data-nombreEquipo", nombreEquipo);
  });

  $('#eliminarUsuario').click(function(e){
    idUsuario = $('#tituloEU').data('idusuario');
    //var nombreEquipo = $('#tituloEE').data('nombreequipo');
    var baseurl = window.origin + '/gestion_calidad/Usuario/eliminarUsuario';

    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {idUsuario: idUsuario},
    success: function(data) {
      if (data)
      {
        if(data == '1')
        {
          $('#tituloMU').empty();
          $("#parrafoMU").empty();
          $("#tituloMU").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
          $("#parrafoMU").append('Se ha eliminado exitosamente al Usuario.');
          listarUsuarios('');
          $('#modalEliminarUsuario').modal('hide');
          

          $('#modalMensajeUsuario').modal('show');
          $('body').addClass('modal-open');
        }else{
          $('#tituloMU').empty();
          $("#parrafoMU").empty();
          $("#tituloMU").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
          $("#parrafoMU").append('Ha ocurrido un error al intentar al Usuario.');
          $('#modalEliminarUsuario').modal('hide');
          $('#modalMensajeUsuario').show();
          listarUsuarios('');
        }
        feather.replace();
      }
    }
    });
  });

  $('#buscarUsuario').on('change',function(e){
     filtroUsuario = $('#buscarUsuario').val();

     if(filtroUsuario.length = 0)
        filtroUsuario = "";
    listarUsuarios(filtroUsuario);
  });

  $("#agregarUsuario").submit(function(e) {
    var loader = document.getElementById("loader");
    loader.removeAttribute('hidden');
    /*$("div.loader").addClass('show');*/
    //var validacion = $("#agregarUsuario").validate();
    //if(validacion.numberOfInvalids() == 0)
    //{
      event.preventDefault();

      var baseurl = window.origin + '/gestion_calidad/Usuario/guardarUsuario';
      var rut = $('#inputRut').val();
      var idEmpresa = $('#selectEmpresa').val();
      var nombres = $('#inputNombres').val();
      var apellidos = $('#inputApellidos').val();
      var email = $('#inputEmail').val();
      var codUsuario = $('#inputCodUsuario').val();
      var idPerfil = $('#selectPerfil').val();
      var checkContabilizar = document.getElementById('checkContabilizar');
      var contabilizar = checkContabilizar.checked;
      var idUsuario = null;

      if($("#inputIdUsuario").val())
        idUsuario = $('#inputIdUsuario').val();

      jQuery.ajax({
      type: "POST",
      url: baseurl,
      dataType: 'json',
      data: {idUsuario: idUsuario, rut: rut, idEmpresa: idEmpresa, nombres: nombres, apellidos: apellidos, email: email, codUsuario: codUsuario, idPerfil: idPerfil, contabilizar, contabilizar },
      success: function(data) {
        if (data)
        {
          //data = JSON.parse(data);
          if(data['respuesta'] == '1')
          {
            $('#tituloMU').empty();
            $("#parrafoMU").empty();
            $("#tituloMU").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
            $("#parrafoMU").append(data['mensaje']);
            if(!$("#inputIdUsuario").val())
            {
              $("#agregarUsuario")[0].reset();
            }
            loader.setAttribute('hidden', '');
            $('#modalMensajeUsuario').modal({
              show: true
            });
          }else{
            $('#tituloMU').empty();
            $("#parrafoMU").empty();
            $("#tituloMU").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
            $("#parrafoMU").append(data['mensaje']);
            loader.setAttribute('hidden', '');
            $('#modalMensajeEquipo').modal({
              show: true
            });
          }
          feather.replace()
          $('[data-toggle="tooltip"]').tooltip()
        }
      }
      });
    /*}else
    {
      loader.setAttribute('hidden', '');
    }*/
  });

  function listarUsuarios(filtro)
  {
    var baseurl = window.origin + '/gestion_calidad/Usuario/buscarUsuario';
    jQuery.ajax({
    type: "POST",
    url: baseurl,
    dataType: 'json',
    data: {usuario: filtro},
    success: function(data) {
    if (data)
    {
        $("#tbodyUsuario").empty();
        for (var i = 0; i < data.length; i++){
          var row = '<tr>';
          row = row.concat('\n<th scope="row" class="text-center align-middle registro">',data[i]['cod_usuario'],'</th>');
          row = row.concat('\n<td class="text-center align-middle registro">',data[i]['nombres'],'</td>');
          row = row.concat('\n<td class="text-center align-middle registro">',data[i]['apellidos'],'</td>');
          row = row.concat('\n<td class="text-center align-middle registro">',data[i]['rut'],'</td>');
          row = row.concat('\n<td class="text-center align-middle registro">',data[i]['email'],'</td>');
          row = row.concat('\n<td class="text-center align-middle registro">',data[i]['pf_nombre'],'</td>');
          row = row.concat('\n<td class="text-right align-middle registro">');
          row = row.concat('\n<a id="trash_',data[i]['id_usuario'],'" class="trash" href="#" data-id="',data[i]['id_usuario'],'" data-nombre="',data[i]['nombres'], ' ', data[i]['apellidos'],'" data-toggle="modal" data-target="#modalEliminarUsuario">');
          row = row.concat('\n<i data-feather="trash-2"  data-toggle="tooltip" data-placement="top" title="eliminar"></i>');
          row = row.concat('\n</a>');
          row = row.concat('\n<a id="edit_',data[i]['id_usuario'],'" class="edit" type="link" href="ModificarUsuario/?idUsuario=',data[i]['id_usuario'],'" data-id="',data[i]['id_usuario'],'" data-nombre="',data[i]['nombres'],'">');
          row = row.concat('\n<i data-feather="edit-3"  data-toggle="tooltip" data-placement="top" title="modificar"></i>');
          row = row.concat('\n</a>');
          row = row.concat('\n</td>');
          row = row.concat('\n<tr>');

        $("#tbodyUsuario").append(row);
      }
      feather.replace()
      $('[data-toggle="tooltip"]').tooltip()
    }
    }
    });
  }

});