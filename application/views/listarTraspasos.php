<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>
<div class="row p-3">
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="">
			<table class="table table-sm table-hover" id="listaTraspasos">
			  <thead>
			    <tr>
			      <th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Sucursal</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Rut Afiliado</th>
			      <!--<th scope="col" class="texto-pequenio text-center align-middle registro">Serie</th>-->
			      <!--<th scope="col" class="texto-pequenio text-center align-middle registro">Tipo Documento</th>-->
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Nombres</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Apellido Paterno</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Apellido Materno</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">AFP Origen</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Telefono</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Folio</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Fecha</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Estado Cedula</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Estado Certificaci&oacute;n</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Via ingreso</th>
			    </tr>
			  </thead>
			  <tbody id="tbodyEquipo">

			    <?php
			        if(isset($traspasos))
			        {
				        foreach ($traspasos as $validacion): ?>
				  			<tr>
						        <th scope="row" class="texto-pequenio text-center align-middle registro"><?php echo $validacion['id_sms']; ?></th>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['sucursal']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['u_nombres']." ".$validacion['u_apellidos']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['rut']; ?></td>
						        <!--<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['serie']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['tipo_documento']; ?></td>-->
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['nombres']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['apellido_paterno']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['apellido_materno']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['institucion']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['ani']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['folio']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['fecha']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro font-weight-bold <?php echo ($validacion['rc_resultado'] == "1" ? "text-success" : ($validacion['rc_resultado'] == "2" ? "text-danger" : ($validacion['rc_resultado'] == "3" ? "text-info" : "text-warning"))); ?>"><?php echo $validacion['nombre_resultado_rc']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro font-weight-bold <?php echo ($validacion['id_certificado'] == "1" ? "text-success" : ($validacion['id_certificado'] == "2" ? "text-danger" : "text-warning")); ?>"><?php echo $validacion['certificado']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['via_entrada']; ?></td>
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
	//feather.replace();
    //$('[data-toggle="tooltip"]').tooltip();
	//var codigo = '5939450885303642045:2172193455657819264';
	//var baseurl = 'https://portal.sidiv.registrocivil.cl/usuarios-portal/pages/DocumentRequestStatus.xhtml';
    /*jQuery.ajax({
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
</script>