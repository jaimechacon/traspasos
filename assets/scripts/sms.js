$(document).ready(function() {

	//setTimeout(refrescar, 20000);

	function refrescar(){
    //Actualiza la página
    	location.reload();
  	}

 	$(".btnEstados").on('click', function(e) {
 		var estado = -1;
 		if(e.currentTarget.className.includes('btn-success', 1))
 		{
 			estado = 1;
 		}else
 		{
 			if(e.currentTarget.className.includes('btn-warning', 1))
			{
				estado = 2;
			}else
	 		{
	 			if(e.currentTarget.className.includes('btn-info', 1))
				{
					estado = 3;
				}else
		 		{
		 			if(e.currentTarget.className.includes('btn-danger', 1))
					{
						estado = 4;
					}
		 		}
	 		}
 		}

 		if(estado > -1){
 			var id_sms = e.currentTarget.dataset.id;
 			var rut = e.currentTarget.dataset.rut;
 			var serie = e.currentTarget.dataset.serie;
 			var tipo_doc = e.currentTarget.dataset.tipo_documento;
			var baseurl = window.origin + '/Sms/validarRCOT';
		    jQuery.ajax({
				type: "POST",
				url: baseurl,
				dataType: 'json',
				data: { id_sms: id_sms, tipo: estado, rut: rut, serie: serie, tipo_doc: tipo_doc },
				success: function(data) {
				    if (data)
				    {
				    	location.reload();
				    }
				}
			});
 		}
	});

 	$(".btnEstadosRut").on('click', function(e) {
 		var estado = -1;
 		if(e.currentTarget.className.includes('btn-success', 1))
 		{
 			estado = 5;
 		}else
 		{
 			if(e.currentTarget.className.includes('btn-warning', 1))
			{
				estado = 6;
			}else
	 		{
	 			if(e.currentTarget.className.includes('btn-info', 1))
				{
					estado = 7;
				}else
		 		{
		 			if(e.currentTarget.className.includes('btn-danger', 1))
					{
						estado = 4;
					}
		 		}
	 		}
 		}

 		if(estado > -1){
 			var id_sms = e.currentTarget.dataset.id;
			var baseurl = window.origin + '/Sms/validarRCOT';
		    jQuery.ajax({
				type: "POST",
				url: baseurl,
				dataType: 'json',
				data: { id_sms: id_sms, tipo: estado, validarRut: 1 },
				success: function(data) {
				    if (data)
				    {
				    	location.reload();
				    }
				}
			});
 		}
	});

	$("#btnBuscarTV").on('click', function() {
  		listarTraspasosValidados();
  	});

  	function listarTraspasosValidados()
	  	{ 	

	 		var loader = document.getElementById("loader");
		    loader.removeAttribute('hidden');
			fecha = $("#fecha").val();
			
		    var baseurl = window.origin + '/Sms/listarTraspasosValidados';
		    jQuery.ajax({
			type: "POST",
			url: baseurl,
			dataType: 'json',
			data: {fecha: fecha},
			success: function(data) {
		        if (data)
		        {
		        	var myJSON = JSON.stringify(data);
	                   		myJSON = JSON.parse(myJSON);

	                   		if(myJSON.resultado == "1")
	                   		{
								$("#tTraspasos").html('');
								var row = '';
					            row = row.concat('\n<table class="table table-sm table-hover table-responsive" id="listaTraspasos" name="listaTraspasos">');
								row = row.concat('\n<thead>');
								row = row.concat('\n<tr>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">id_log_api_cedula</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">tipo_result</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">estado</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">cod_codigo</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">accion</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">aplicación</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">parametros</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">ruta</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">uri</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">cod_estado_respuesta</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">desc_estado_respuesta</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">runPersona_resultado</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">dvPersona_resultado</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">codTipoDocumento_resultado</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">codClaseDocumento_resultado</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">numDocumento_resultado</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">numSerie_resultado</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">indVigencia_resultado</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">fhoVcto_resultado</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">indBloqueo_resultado</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">obs_respuesta</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">error_respuesta</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">tiempo</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">organizacion</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">ip</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">id</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">fecha</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">cod_obs_respuesta</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">descripcion_obs_respuesta</th>');
								row = row.concat('\n<th scope="" col="" class="texto-pequenio text-center align-middle  registro">id_sms</th>');
								row = row.concat('\n</tr>');
								row = row.concat('\n</thead>');
								row = row.concat('\n<tbody id="tbodyEquipo">');
								for (var i = 0; i < myJSON.tabla.length; i++){
						            row = row.concat('<tr>');
							        row = row.concat('\n<th scope="row" class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['id_log_api_cedula']) ? '' : myJSON.tabla[i]['id_log_api_cedula']), '</th>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['tipo_result']) ? '' : myJSON.tabla[i]['tipo_result']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['estado']) ? '' : myJSON.tabla[i]['estado']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['cod_codigo']) ? '' : myJSON.tabla[i]['cod_codigo']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['accion']) ? '' : myJSON.tabla[i]['accion']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['aplicacion']) ? '' : myJSON.tabla[i]['aplicacion']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['parametros']) ? '' : myJSON.tabla[i]['parametros']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['ruta']) ? '' : myJSON.tabla[i]['ruta']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['uri']) ? '' : myJSON.tabla[i]['uri']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['cod_estado_respuesta']) ? '' : myJSON.tabla[i]['cod_estado_respuesta']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['desc_estado_respuesta']) ? '' : myJSON.tabla[i]['desc_estado_respuesta']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['runPersona_resultado']) ? '' : myJSON.tabla[i]['runPersona_resultado']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['dvPersona_resultado']) ? '' : myJSON.tabla[i]['dvPersona_resultado']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['codTipoDocumento_resultado']) ? '' : myJSON.tabla[i]['codTipoDocumento_resultado']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['codClaseDocumento_resultado']) ? '' : myJSON.tabla[i]['codClaseDocumento_resultado']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['numDocumento_resultado']) ? '' : myJSON.tabla[i]['numDocumento_resultado']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['numSerie_resultado']) ? '' : myJSON.tabla[i]['numSerie_resultado']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['indVigencia_resultado']) ? '' : myJSON.tabla[i]['indVigencia_resultado']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['fhoVcto_resultado']) ? '' : myJSON.tabla[i]['fhoVcto_resultado']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['indBloqueo_resultado']) ? '' : myJSON.tabla[i]['indBloqueo_resultado']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['obs_respuesta']) ? '' : myJSON.tabla[i]['obs_respuesta']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['error_respuesta']) ? '' : myJSON.tabla[i]['error_respuesta']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['tiempo']) ? '' : myJSON.tabla[i]['tiempo']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['organizacion']) ? '' : myJSON.tabla[i]['organizacion']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['ip']) ? '' : myJSON.tabla[i]['ip']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['id']) ? '' : myJSON.tabla[i]['id']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['fecha']) ? '' : myJSON.tabla[i]['fecha']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['cod_obs_respuesta']) ? '' : myJSON.tabla[i]['cod_obs_respuesta']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['descripcion_obs_respuesta']) ? '' : myJSON.tabla[i]['descripcion_obs_respuesta']), '</td>');
									row = row.concat('\n<td class="texto-pequenio text-center align-middle registro">', (jQuery.isEmptyObject(myJSON.tabla[i]['id_sms']) ? '' : myJSON.tabla[i]['id_sms']), '</td>');

						        }
						        row = row.concat('\n</tbody>');
						        row = row.concat('\n</table>');

						        $("#tTraspasos").html(row);

						        $(document.getElementById('listaTraspasos')).dataTable({
						        //$("#tTraspasos table").dataTable({
						        //$("#listaTraspasos").dataTable({
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
	                   			$('#tituloME').empty();
								$("#parrafoME").empty();
								$("#tituloME").append('<i class="plusTituloError mb-2" data-feather="x-circle"></i> Error!!!');
								$("#parrafoME").append(data['mensaje']);
								loader.setAttribute('hidden', '');
								$('#modalMensajeEquipo').modal({
								  show: true
								});
								feather.replace()
	                   		}
			        loader.setAttribute('hidden', '');
		        }
	      	}
	    	});
	  	};


	  	$("#btnExportarExcelTV").on('click', function() {
			var loader = document.getElementById("loader");
		    loader.removeAttribute('hidden');
			fecha = $("#fecha").val();
		    var urlFinal = window.location.href.replace("listarTraspasosValidados", (("").concat("exportarexcelTV?fecha=", fecha)));
		    window.location.href = urlFinal;
		    loader.setAttribute('hidden', '');
	  	});


});

window.onload = function () {
	/*feather.replace()
    $('[data-toggle="tooltip"]').tooltip()
	var codigo = '5939450885303642045:2172193455657819264';
	var baseurl = 'https://portal.sidiv.registrocivil.cl/usuarios-portal/pages/DocumentRequestStatus.xhtml';
    jQuery.ajax({
		type: "POST",
		url: baseurl,
		dataType: 'jsonp',
		headers: {"Authorization": localStorage.getItem('5939450885303642045:2172193455657819264')},
		data: {run: '175903267', selectDocType: 'CEDULA', docNumber: '107311071'},
		success: function(data) {
		    if (data)
		    {

		    }
		}
	});*/

	if(window.location.pathname.split('/')[2].toLowerCase() == 'listarTraspasosValidados'.toLowerCase())
    {
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
	}
}