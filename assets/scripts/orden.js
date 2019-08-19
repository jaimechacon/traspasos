 $(document).ready(function() {
	 	$(".btnEstados").on('click', function(e) {
	 		alert('hola');	 		
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