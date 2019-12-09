<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row p-3" id="contenedor">
	<a id="link_rc" name="link_rc" target="_blank" class="btn btn-primary" href="https://portal.sidiv.registrocivil.cl/usuarios-portal/pages/DocumentRequestStatus.xhtml">Registro Civil</a>
	<div id="tDatos" class="col-sm-12 p-3" name="tDatos">
		<div class="table-responsive" id="div_tabla_datos" name="div_tabla_datos">
			<table class="table table-sm table-hover">
			  <thead>
			    <tr>
			      <th id="thId" name="thId" scope="col" class="text-center align-middle registro"># ID</th>
			      <th id="thRut" name="thRut" scope="col" class="text-center align-middle registro">Rut</th>
			      <th id="thSerie" name="thSerie" scope="col" class="text-center align-middle registro">Serie</th>
			      <th id="thTipoDoc" name="thTipoDoc" scope="col" class="text-center align-middle registro">Tipo Documento</th>
			      <th id="thCantRepeticiones" name="thCantRepeticiones" scope="col" class="text-center align-middle registro">Cant. Repeticiones</th>
			      <th id="thSinConexion" name="thSinConexion" scope="col" class="text-center align-middle registro">Sin Conexion</th>
			      <th id="thErrorRC" name="thErrorRC" scope="col" class="text-center align-middle registro">Error RC</th>
			      <th id="thNoVigente" name="thNoVigente" scope="col" class="text-center align-middle registro">No Vigente</th>
			      <th id="thVigente" name="thVigente" scope="col" class="text-center align-middle registro">Vigente</th>
			    </tr>
			  </thead>
			  <tbody id="tbodyEquipo" name="tbodyEquipo">

			    <?php
			        if(isset($validacionesPendientes))
			        {
			        	$fila = 0;
				        foreach ($validacionesPendientes as $validacion): ?>

				  			<tr id="row_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="row_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>">
						        <th id="id_sms_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="id_sms_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" class="text-center align-middle registro"><?php echo $validacion['id_sms']; ?></th>
						        <td id="rut_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="rut_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" class="text-center align-middle registro"><?php (!strpos($validacion['rut'], '-')?
						        	(substr($validacion['rut'], 0, ((strlen($validacion['rut']))-1)).'-'.substr($validacion['rut'], ((strlen($validacion['rut']))-1), 1))
						        	: $validacion['rut']

						    	)
						        ; ?></td>
						        <td id="serie_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="serie_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" class="text-center align-middle registro"><?php echo $validacion['serie']; ?></td>
						        <td id="tipo_documento_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="tipo_documento_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" class="text-center align-middle registro"><?php echo $validacion['tipo_documento']; ?></td>
						        <td id="cant_repeticiones_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="cant_repeticiones_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" class="text-center align-middle registro"><?php echo $validacion['cant_repeticiones']; ?></td>
						        <td id="tdSinConexion_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="tdSinConexion_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" class="text-center align-middle registro">
						        	<button id="btnSinConexion_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="btnSinConexion_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" type="button" class="btn btn-danger btnEstadosRut" data-id="<?php echo $validacion['id_sms']; ?>">Sin Conexion</button>
					        	</td>
					        	 <td id="tdErrorRC_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="tdErrorRC_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" class="text-center align-middle registro">
						        	<button id="btnErrorRC_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="btnErrorRC_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" type="button" class="btn btn-info btnEstadosRut" data-id="<?php echo $validacion['id_sms']; ?>">Error RC</button>
					        	</td>
					        	<td id="tdNoVigente_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="tdNoVigente_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" class="text-center align-middle registro">
						        	<button id="btnNoVigente_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="btnNoVigente_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" type="button" class="btn btn-warning btnEstadosRut" data-id="<?php echo $validacion['id_sms']; ?>">No Vigente</button>
					        	</td>
					        	<td id="tdVigente_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="tdVigente_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" class="text-center align-middle registro">
						        	<button id="btnVigente_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" name="btnVigente_<?php echo ($fila == 0 ? "1": $validacion['id_sms']); ?>" type="button" class="btn btn-success btnEstadosRut" data-id="<?php echo $validacion['id_sms']; ?>">Vigente</button>
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