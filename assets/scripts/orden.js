 $(document).ready(function() {
		feather.replace()

		$("#agregarOrdenTraspaso").validate({
		    errorClass:'invalid-feedback',
		    errorElement:'span',
		    ignore: ":hidden:not(.selectpicker)",
		    errorPlacement: function( span, element ) {
		      if(element[0].className === "selectpicker invalid") {
		        element.parent().append(span);
		      } else {
		        span.insertAfter(element);
		      }
		    },
		    //ignore: ":hidden:not(.selectpicker)",
		    highlight: function(element, errorClass, validClass) {
		      $(element).addClass("is-invalid").removeClass("invalid-feedback");
		      if(element.className == "selectpicker is-invalid")
		      {
		        $(element.parentElement.children[1]).addClass('form-control');
		        $(element.parentElement.children[1]).addClass('is-invalid');
		        $(element).removeClass("is-invalid");
		        $(element).addClass('invalid');
		      }
		    },
		    unhighlight: function(element, errorClass, validClass) {
		      $(element).removeClass("is-invalid");
		      if(element.className == "selectpicker invalid")
		      {
		        $(element.parentElement.children[1]).removeClass('form-control');
		        $(element.parentElement.children[1]).removeClass('is-invalid');
		      }
		    },
		    rules: {
		      inputRut: {
		        required: true,
		        minlength: 8,
        		maxlength: 9,
        		rut: true
		      },
		      inputSerie: {
		        required: true,
		        minlength: 9,
        		maxlength: 10,
        		serie: true
		      },
		      selectTipoDoc: {
		        required: true,
		        minlength: 1,
        		maxlength: 3
		      },
		      inputTelefono:{
		        required: true,
		        minlength: 9,
        		maxlength: 9
		      },
		      inputFolio:{
		        required: true,
		        minlength: 7,
        		maxlength: 7
		      },
		    },
		    messages:{
		      inputRut: {
		        required: "Ingrese un Rut de Cliente.",
		        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        		maxlength: "Se requiere no mas de {0} caracteres.",
        		rut: "Rut inv&aacute;lido. Ingrese un Rut v&aacute;lido."
		      },
		      inputSerie: {
		        required: "Ingrese la Serie de la c&eacute;dula del Cliente.",
		        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        		maxlength: "Se requiere no mas de {0} caracteres.",
        		serie: "Serie inv&aacute;lida. Ingrese una Serie v&aacute;lida."
		      },
		      selectTipoDoc: {
		        required: "Seleccione un Tipo de Documento v&aacute;lido.",
		        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        		maxlength: "Se requiere no mas de {0} caracteres."
		      },
		      inputTelefono: {
		        required: "Ingrese un tel&eacute;fono del Cliente.",
		        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        		maxlength: "Se requiere no mas de {0} caracteres."
		      },
		      inputFolio: {
		        required: "Ingrese el N&#176; de Folio.",
		        minlength: "Se requieren m&iacute;nimo {0} caracteres.",
        		maxlength: "Se requiere no mas de {0} caracteres."
		      }
		    }     
		});

		$("#agregarOrdenTraspaso").submit(function(e) {
		    var loader = document.getElementById("loader");
		    loader.removeAttribute('hidden');

		    var validacion = $("#agregarOrdenTraspaso").validate();
		    if(validacion.numberOfInvalids() == 0)
		    {
		      e.preventDefault();
		      var f = $(this);
		      var form = document.getElementById("agregarOrdenTraspaso");
		      var formData = new FormData(form);

		      jQuery.ajax({
		      type: form.getAttribute('method'),
		      url: form.getAttribute('action'),
		      dataType: 'json',
		      cache: false,
		      contentType: false,
		      processData: false,
		      data: formData,
		      success: function(data) {
		        if(data['resultado'] == '1')
				{
					$('#tituloME').empty();
					$("#parrafoME").empty();
					$("#tituloME").append('<i class="plusTitulo mb-2" data-feather="check"></i> Exito!!!');
					$("#parrafoME").append(data['mensaje']);
					$("#agregarOrdenTraspaso")[0].reset();
					loader.setAttribute('hidden', '');
					$('#modalMensaje').modal({
					  show: true
					});
					feather.replace()
				}else{
					$('#tituloME').empty();
					$("#parrafoME").empty();
					$("#tituloME").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
					$("#parrafoME").append(data['mensaje']);
					loader.setAttribute('hidden', '');
					$('#modalMensaje').modal({
					  show: true
					});
				}
				feather.replace()
				$('[data-toggle="tooltip"]').tooltip()
		        
		      }
		      });
		    }else
		    {
		      loader.setAttribute('hidden', '');
		    }
	  	});

		$('#listaTraspasos').dataTable({
	        searching: true,
	        //scrollX : false,
	        responsive: true,
	        paging:         true,
	        //dom: 'rtip',
	        //"dom": '<rf<t>ip>',
	        "order":        [[ 0, "desc" ]],
	        info:           true,
	        //columnDefs: [
	          //{ targets: 'no-sort', orderable: false }
	        //],
	        bDestroy:       true,
	         
	        "oLanguage": {
	            "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
	            "sZeroRecords": "No se encontraron registros",
	            "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
	            "sInfoEmpty": "Mostrando 0 de 0 registros",
	            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
	            "sSearch":        "Buscar:",
	            "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
	            "oPaginate": {
	                "sFirst":    "Primero",
	                "sLast":    "Último",
	                "sNext":    "Siguiente",
	                "sPrevious": "Anterior"
	            }
	        },
	        lengthMenu: [[10, 20], [10, 20]]
	    });

	    $("#btnExportarTodoExcel").on('click', function() {
			var loader = document.getElementById("loader");
		    loader.removeAttribute('hidden');
		    institucion = -1;
		    hospital = -1;
		    rut_proveedor = "";
			
			//var url = window.location.href.replace("ListarPagos", "exportarexcel");
		    var urlFinal = window.location.href.replace("listarTraspasosCall", "exportarexcelNeotel");
		    window.location.href = urlFinal;
		    loader.setAttribute('hidden', '');
	  	});

	    $("#btnExportarExcelComercial").on('click', function() {
			var loader = document.getElementById("loader");
		    loader.removeAttribute('hidden');
			
			id_sucursal = $("#sucursalCall").val();
		    id_usuario_vendedor = $("#vendedorCall").val();
			fecha_desde = $("#fechaDesde").val();
			fecha_hasta = $("#fechaHasta").val();
			id_estado_rc = $("#estadoRC").val();
			id_estado_c = $("#estadoC").val();

			//var url = window.location.href.replace("ListarPagos", "exportarexcel");
		    var urlFinal = window.location.href.replace("listarTraspasosCall", (("").concat("exportarFiltroComercial?idsucursal=", id_sucursal, "&idvendedor=", id_usuario_vendedor, "&fechadesde=", fecha_desde, "&fechahasta=", fecha_hasta, "&idestadorc=", id_estado_rc, "&idestadoc=", id_estado_c)));
		    //document.location = urlFinal;
		   	window.location.href = urlFinal;
		    loader.setAttribute('hidden', '');
	  	});

	  	$("#btnExportarExcel").on('click', function() {
			var loader = document.getElementById("loader");
		    loader.removeAttribute('hidden');
			
			id_sucursal = $("#sucursalCall").val();
		    id_usuario_vendedor = $("#vendedorCall").val();
			fecha_desde = $("#fechaDesde").val();
			fecha_hasta = $("#fechaHasta").val();
			id_estado_rc = $("#estadoRC").val();
			id_estado_c = $("#estadoC").val();

			//var url = window.location.href.replace("ListarPagos", "exportarexcel");
		    var urlFinal = window.location.href.replace("listarTraspasosCall", (("").concat("exportarexcelNeotelFiltro?idsucursal=", id_sucursal, "&idvendedor=", id_usuario_vendedor, "&fechadesde=", fecha_desde, "&fechahasta=", fecha_hasta, "&idestadorc=", id_estado_rc, "&idestadoc=", id_estado_c)));
		    window.location.href = urlFinal;
		    loader.setAttribute('hidden', '');
	  	});
	  	
	    $("#btnExportarExcelUsuario").on('click', function() {
			var loader = document.getElementById("loader");
		    loader.removeAttribute('hidden');
			
			id_sucursal = $("#sucursalCall").val();
		    id_usuario_vendedor = $("#vendedorCall").val();
			fecha_desde = $("#fechaDesde").val();
			fecha_hasta = $("#fechaHasta").val();
			id_estado_rc = $("#estadoRC").val();
			id_estado_c = $("#estadoC").val();

			//var url = window.location.href.replace("ListarPagos", "exportarexcel");
		    var urlFinal = window.location.href.replace("listarTraspasos", (("").concat("exportarexcelUsuarioFiltro?idsucursal=", id_sucursal, "&idvendedor=", id_usuario_vendedor, "&fechadesde=", fecha_desde, "&fechahasta=", fecha_hasta, "&idestadorc=", id_estado_rc, "&idestadoc=", id_estado_c)));
		    window.location.href = urlFinal;
		    loader.setAttribute('hidden', '');
	  	});

	  	$("#btnExportarExcelUsuarioSupervisor").on('click', function() {
			var loader = document.getElementById("loader");
		    loader.removeAttribute('hidden');
			
			id_sucursal = $("#sucursalCall").val();
		    id_usuario_vendedor = $("#vendedorCall").val();
			fecha_desde = $("#fechaDesde").val();
			fecha_hasta = $("#fechaHasta").val();
			id_estado_rc = $("#estadoRC").val();
			id_estado_c = $("#estadoC").val();

			//var url = window.location.href.replace("ListarPagos", "exportarexcel");
		    var urlFinal = window.location.href.replace("listarTraspasos", (("").concat("exportarexcelUsuarioFiltroSuper?idsucursal=", id_sucursal, "&idvendedor=", id_usuario_vendedor, "&fechadesde=", fecha_desde, "&fechahasta=", fecha_hasta, "&idestadorc=", id_estado_rc, "&idestadoc=", id_estado_c)));
		    window.location.href = urlFinal;
		    loader.setAttribute('hidden', '');
	  	});	  	

	  	$("#btnBuscar").on('click', function() {
	  		listarTraspasosCall();
	  	});

	  	$("#btnBuscarOT").on('click', function() {
	  		listarTraspasosUsuario();
	  	});



	  	function listarTraspasosCall()
	  	{ 	

	 		var loader = document.getElementById("loader");
		    loader.removeAttribute('hidden');

		    id_sucursal = $("#sucursalCall").val();
		    id_usuario_vendedor = $("#vendedorCall").val();
			fecha_desde = $("#fechaDesde").val();
			fecha_hasta = $("#fechaHasta").val();
			id_estado_rc = $("#estadoRC").val();
			id_estado_c = $("#estadoC").val();
			
		    var baseurl = window.origin + '/Orden/listarTraspasosCall';
		    jQuery.ajax({
			type: "POST",
			url: baseurl,
			dataType: 'json',
			data: {id_sucursal: id_sucursal, id_usuario_vendedor: id_usuario_vendedor, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta, id_estado_rc: id_estado_rc, id_estado_c: id_estado_c},
			success: function(data) {
		        if (data)
		        {
		        	var myJSON = JSON.stringify(data);
	                   		myJSON = JSON.parse(myJSON);

	                   		if(myJSON.resultado == "1")
	                   		{
								$("#tTraspasos").html('');
								var row = '';
					            row = row.concat('\n<table class="table table-sm table-hover" id="listaTraspasos">');
								row = row.concat('\n<thead>');
								row = row.concat('\n<tr>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Sucursal</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Rut Usuario</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Rut Afiliado</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Nombres</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Apellido Paterno</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Apellido Materno</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">AFP Origen</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Telefono</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Folio</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Estado Cedula</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Estado Certificaci&oacute;n</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Via ingreso</th>');
								row = row.concat('\n</tr>');
								row = row.concat('\n</thead>');
								row = row.concat('\n<tbody id="tbodyTraspasos">');
								for (var i = 0; i < myJSON.tabla.length; i++){
						            row = row.concat('<tr>');
						            row = row.concat('\n<th scope="row" class="texto-pequenio text-center align-middle registro">', myJSON.tabla[i]['id_sms'], '</th>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['sucursal']) ? '' : myJSON.tabla[i]['sucursal']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['u_rut']) ? '' : myJSON.tabla[i]['u_rut']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['u_nombres']) ? '' : myJSON.tabla[i]['u_nombres']), (jQuery.isEmptyObject(myJSON.tabla[i]['u_apellidos']) ? '' : ' '.concat(myJSON.tabla[i]['u_apellidos'])), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['rut']) ? '' : myJSON.tabla[i]['rut']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['nombres']) ? '' : myJSON.tabla[i]['nombres']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['apellido_paterno']) ? '' : myJSON.tabla[i]['apellido_paterno']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['apellido_materno']) ? '' : myJSON.tabla[i]['apellido_materno']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['institucion']) ? '' : myJSON.tabla[i]['institucion']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['ani']) ? '' : myJSON.tabla[i]['ani']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['folio']) ? '' : myJSON.tabla[i]['folio']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['fecha']) ? '' : myJSON.tabla[i]['fecha']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro font-weight-bold ', (myJSON.tabla[i]['rc_resultado'] == '1' ? 'text-success' : (myJSON.tabla[i]['rc_resultado'] == '2' ? 'text-danger' : (myJSON.tabla[i]['rc_resultado'] == '3' ? 'text-info' : 'text-warning'))), '">', (jQuery.isEmptyObject(myJSON.tabla[i]['nombre_resultado_rc']) ? '' : myJSON.tabla[i]['nombre_resultado_rc']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro font-weight-bold ', (myJSON.tabla[i]['id_certificado'] == '1' ? 'text-success' : (myJSON.tabla[i]['id_certificado'] == '2' ? 'text-danger' : 'text-warning')), '">', (jQuery.isEmptyObject(myJSON.tabla[i]['certificado']) ? '' : myJSON.tabla[i]['certificado']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['via_entrada']) ? '' : myJSON.tabla[i]['via_entrada']), '</td>');
						            row = row.concat('\n</tr>');
						          //$("#tbodyTraspasos").append(row);
						        }

						        $("#tTraspasos").html(row);

						        $('#listaTraspasos').dataTable({
							        searching: true,
							        //scrollX : false,
							        responsive: true,
							        paging:         true,
							        //dom: 'rtip',
							        //"dom": '<rf<t>ip>',
							        "order":        [[ 0, "desc" ]],
							        info:           true,
							        //columnDefs: [
							          //{ targets: 'no-sort', orderable: false }
							        //],
							        //bDestroy:       true,
							         
							        "oLanguage": {
							            "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
							            "sZeroRecords": "No se encontraron registros",
							            "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
							            "sInfoEmpty": "Mostrando 0 de 0 registros",
							            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
							            "sSearch":        "Buscar:",
							            "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
							            "oPaginate": {
							                "sFirst":    "Primero",
							                "sLast":    "Último",
							                "sNext":    "Siguiente",
							                "sPrevious": "Anterior"
							            }
							        },
							        lengthMenu: [[10, 20], [10, 20]]
							    });

							}else{
	                   			
	                   		}
			        loader.setAttribute('hidden', '');
		        }
	      	}
	    	});
	  	};

	  	function listarTraspasosUsuario()
	  	{ 	

	 		var loader = document.getElementById("loader");
		    loader.removeAttribute('hidden');

		    id_sucursal = $("#sucursalCall").val();
		    id_usuario_vendedor = $("#vendedorCall").val();
			fecha_desde = $("#fechaDesde").val();
			fecha_hasta = $("#fechaHasta").val();
			id_estado_rc = $("#estadoRC").val();
			id_estado_c = $("#estadoC").val();
			
		    var baseurl = window.origin + '/Orden/listarTraspasos';
		    jQuery.ajax({
			type: "POST",
			url: baseurl,
			dataType: 'json',
			data: {id_sucursal: id_sucursal, id_usuario_vendedor: id_usuario_vendedor, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta, id_estado_rc: id_estado_rc, id_estado_c: id_estado_c},
			success: function(data) {
		        if (data)
		        {
		        	var myJSON = JSON.stringify(data);
	                   		myJSON = JSON.parse(myJSON);

	                   		if(myJSON.resultado == "1")
	                   		{
								$("#tTraspasos").html('');
								var row = '';
					            row = row.concat('\n<table class="table table-sm table-hover" id="listaTraspasos">');
								row = row.concat('\n<thead>');
								row = row.concat('\n<tr>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Sucursal</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Rut Usuario</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Perfil</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Rut Afiliado</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Nombres</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Apellido Paterno</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Apellido Materno</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">AFP Origen</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Telefono</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Folio</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Estado Cedula</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Estado Certificaci&oacute;n</th>');
								row = row.concat('\n<th scope="col" class="texto-pequenio text-center align-middle registro">Via ingreso</th>');
								row = row.concat('\n</tr>');
								row = row.concat('\n</thead>');
								row = row.concat('\n<tbody id="tbodyTraspasos">');
								for (var i = 0; i < myJSON.tabla.length; i++){
						            row = row.concat('<tr>');
						            row = row.concat('\n<th scope="row" class="texto-pequenio text-center align-middle registro">', myJSON.tabla[i]['id_sms'], '</th>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['sucursal']) ? '' : myJSON.tabla[i]['sucursal']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['u_rut']) ? '' : myJSON.tabla[i]['u_rut']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['u_nombres']) ? '' : myJSON.tabla[i]['u_nombres']), (jQuery.isEmptyObject(myJSON.tabla[i]['u_apellidos']) ? '' : ' '.concat(myJSON.tabla[i]['u_apellidos'])), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['pf_nombre']) ? '' : myJSON.tabla[i]['pf_nombre']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['rut']) ? '' : myJSON.tabla[i]['rut']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['nombres']) ? '' : myJSON.tabla[i]['nombres']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['apellido_paterno']) ? '' : myJSON.tabla[i]['apellido_paterno']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['apellido_materno']) ? '' : myJSON.tabla[i]['apellido_materno']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['institucion']) ? '' : myJSON.tabla[i]['institucion']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['ani']) ? '' : myJSON.tabla[i]['ani']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['folio']) ? '' : myJSON.tabla[i]['folio']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['fecha']) ? '' : myJSON.tabla[i]['fecha']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro font-weight-bold ', (myJSON.tabla[i]['rc_resultado'] == '1' ? 'text-success' : (myJSON.tabla[i]['rc_resultado'] == '2' ? 'text-danger' : (myJSON.tabla[i]['rc_resultado'] == '3' ? 'text-info' : 'text-warning'))), '">', (jQuery.isEmptyObject(myJSON.tabla[i]['nombre_resultado_rc']) ? '' : myJSON.tabla[i]['nombre_resultado_rc']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro font-weight-bold ', (myJSON.tabla[i]['id_certificado'] == '1' ? 'text-success' : (myJSON.tabla[i]['id_certificado'] == '2' ? 'text-danger' : 'text-warning')), '">', (jQuery.isEmptyObject(myJSON.tabla[i]['certificado']) ? '' : myJSON.tabla[i]['certificado']), '</td>');
							        row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['via_entrada']) ? '' : myJSON.tabla[i]['via_entrada']), '</td>');
						            row = row.concat('\n</tr>');
						          //$("#tbodyTraspasos").append(row);
						        }

						        $("#tTraspasos").html(row);

						        $('#listaTraspasos').dataTable({
							        searching: true,
							        //scrollX : false,
							        responsive: true,
							        paging:         true,
							        //dom: 'rtip',
							        //"dom": '<rf<t>ip>',
							        "order":        [[ 0, "desc" ]],
							        info:           true,
							        //columnDefs: [
							          //{ targets: 'no-sort', orderable: false }
							        //],
							        //bDestroy:       true,
							         
							        "oLanguage": {
							            "sLengthMenu": "_MENU_ Registros por p&aacute;gina",
							            "sZeroRecords": "No se encontraron registros",
							            "sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
							            "sInfoEmpty": "Mostrando 0 de 0 registros",
							            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
							            "sSearch":        "Buscar:",
							            "sProcessing" : '<img src="<?php echo base_url(); ?>images/gif/spin2.svg" height="42" width="42" >',
							            "oPaginate": {
							                "sFirst":    "Primero",
							                "sLast":    "Último",
							                "sNext":    "Siguiente",
							                "sPrevious": "Anterior"
							            }
							        },
							        lengthMenu: [[10, 20], [10, 20]]
							    });

							}else{
	                   			
	                   		}
			        loader.setAttribute('hidden', '');
		        }
	      	}
	    	});
	  	};

	});
	window.onload = function () {
		jQuery.validator.addMethod("rut", function(value, element) { 
		        return this.optional(element) || validaRut(value); 
		}, "RUT con formato incorrecto.");

		jQuery.validator.addMethod("serie", function(value, element) { 
		        return this.optional(element) || validaSerie(value); 
		}, "SERIE con formato incorrecto.");

		function validaRut(campo){
			if ( campo.length == 0 ){ return false; }
			if ( campo.length < 8 ){ return false; }

			campo = campo.replace('-','')
			campo = campo.replace(/\./g,'')

			var suma = 0;
			var caracteres = "1234567890kK";
			var contador = 0;    
			for (var i=0; i < campo.length; i++){
				u = campo.substring(i, i + 1);
				if (caracteres.indexOf(u) != -1)
				contador ++;
			}
			if ( contador==0 ) { return false }
			
			var rut = campo.substring(0,campo.length-1)
			var drut = campo.substring( campo.length-1 )
			var dvr = '0';
			var mul = 2;
			
			for (i= rut.length -1 ; i >= 0; i--) {
				suma = suma + rut.charAt(i) * mul
		                if (mul == 7) 	mul = 2
				        else	mul++
			}
			res = suma % 11
			if (res==1)		dvr = 'k'
		                else if (res==0) dvr = '0'
			else {
				dvi = 11-res
				dvr = dvi + ""
			}
			if ( dvr != drut.toLowerCase() ) { return false; }
			else { return true; }
		}

		function validaSerie(campo){
			campo = campo.trim()
			if ( campo.length == 0 ){ return false; }
			if ( campo.length < 9 ){ return false; }
			if ( campo.length > 10 ){ return false; }

			campo = campo.replace('a','A')
			campo = campo.replace(/\./g,'')

			var suma = 0;
			var caracteres = "1234567890aA";
			var validoCaracteres = 0;    
			for (var i=0; i < campo.length; i++){
				u = campo.substring(i, i + 1);
				if (caracteres.indexOf(u) < 0) { return false; }
			}
			//if ( contador==0 ) { return false }
			
			var largo = campo.length;
			var letra = campo.substring(0, 1)
			

			if (largo == 10) {
				var numerosSerie = campo.substring(1, campo.length)
				if ( letra.toUpperCase() != "A" ){ return false; }
				
				var caracter_numerico = "1234567890";
				for (var i=0; i < numerosSerie.length; i++){
					u = numerosSerie.substring(i, i + 1);
					if (caracter_numerico.indexOf(u) < 0) { return false; }
				}
			}else{
				var numerosSerie = campo;
				var caracter_numerico = "1234567890";
				for (var i=0; i < numerosSerie.length; i++){
					u = numerosSerie.substring(i, i + 1);
					if (caracter_numerico.indexOf(u) < 0) { return false; }
				}
			}
			return true;
		}
	}