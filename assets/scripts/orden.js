 $(document).ready(function() {
	 	$(".btnEstados").on('click', function(e) {
	 		alert('hola');	 		
		});

		$('#listaTraspasos').dataTable({
	        searching: true,
	        //scrollX : false,
	        //responsive: false,
	        paging:         true,
	        //dom: 'rtip',
	        //"dom": '<rf<t>ip>',
	        ordering:       true,
	        info:           true,
	        columnDefs: [
	          { targets: 'no-sort', orderable: false }
	        ],
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
	});
	window.onload = function () {
		feather.replace()
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
		});
	}