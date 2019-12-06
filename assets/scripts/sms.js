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
			var baseurl = window.origin + '/Sms/validarRCOT';
		    jQuery.ajax({
				type: "POST",
				url: baseurl,
				dataType: 'json',
				data: { id_sms: id_sms, tipo: estado },
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
}