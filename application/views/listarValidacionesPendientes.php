<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row p-3">
	<a target="_blank" class="btn btn-primary" href="https://portal.sidiv.registrocivil.cl/usuarios-portal/pages/DocumentRequestStatus.xhtml">Registro Civil</a>
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="table-responsive">
			<table class="table table-sm table-hover">
			  <thead>
			    <tr>
			      <th scope="col" class="text-center align-middle registro"># ID</th>
			      <th scope="col" class="text-center align-middle registro">Rut</th>
			      <th scope="col" class="text-center align-middle registro">Serie</th>
			      <th scope="col" class="text-center align-middle registro">Tipo Documento</th>
			      <th scope="col" class="text-right align-middle registro"></th>
			    </tr>
			  </thead>
			  <tbody id="tbodyEquipo">

			    <?php
			        if(isset($validacionesPendientes))
			        {
				        foreach ($validacionesPendientes as $validacion): ?>
				  			<tr>
						        <th scope="row" class="text-center align-middle registro"><?php echo $validacion['id_sms']; ?></th>
						        <td class="text-center align-middle registro"><?php echo $validacion['rut']; ?></td>
						        <td class="text-center align-middle registro"><?php echo $validacion['serie']; ?></td>
						        <td class="text-center align-middle registro"><?php echo $validacion['tipo_documento']; ?></td>
						        <td class="text-right align-middle registro">
						        <a id="trash_<?php echo $validacion['id_sms']; ?>" class="trash" href="#" data-id="<?php echo $validacion['id_sms']; ?>" data-rut="<?php echo $validacion['rut']; ?>" data-toggle="modal" data-target="#modalEliminarSms">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>        		
					        	</a>
					        		<a id="edit_<?php echo $validacion['id_sms']; ?>" class="edit" type="link" href="ModificarSms/?idSms=<?php echo $validacion['id_sms']; ?>" data-id="<?php echo $validacion['id_sms']; ?>" data-rut="<?php echo $validacion['rut']; ?>">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>
					        	</td>
					    	</tr>
				  		<?php endforeach;
				  	} ?>
			  </tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalMensajeEquipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloME"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<p id="parrafoME"></p>
      </div>
      <div class="modal-footer">
        <button id="btnCerrarME" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar -->
	<div class="modal fade" id="modalEliminarEquipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<i class="plusTituloError mb-2" data-feather="trash-2"></i>
	        <h5 class="modal-title" id="tituloEE" name="tituloEE" data-idequipo="" data-nombreequipo="" ></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<p id="parrafoEE"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
	        <button id="eliminarEquipo" type="button" class="btn btn-danger">Eliminar</button>
	      </div>
	    </div>
	  </div>
	</div>

<script type="text/javascript">
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
</script>