<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>
<div class="row p-3">

	<div class="col-sm-12 text-right">
		<button id="btnExportarExcelTV" type="button" class="btn btn-link">Exportar a CSV
			<i style="margin-bottom: 5px;" data-feather="download"></i>
		</button>
	</div>
	
	<div class="col-sm-12 mt-3">
		<div class="row">			
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<span class="">Mes - A&ntilde;o</span>
					</div>
					<div class="col-sm-9">
						<input type="month" id="fecha" name="fecha" class="form-control" value="<?php echo (!is_null($anio_defecto) ? $anio_defecto.'-'.$mes_defecto : ''); ?>">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<span class="cant_total">Total OT Validadas:</span>
					</div>
					<div class="col-sm-9">
						<label class="cant_total_r" id="cant_total"><?php echo (!is_null($traspasos) ? sizeof($traspasos) : ""); ?></label>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-12 mt-3">
		<div class="row">			
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-12 text-right">
						<button id="btnBuscarTV" type="button" class="btn btn-primary">Filtrar <i class="mb-1" data-feather="search"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div id="tDatos" class="col-sm-12 p-3">
		<div id="tTraspasos">
			<table class="table table-sm table-hover table-responsive" id="listaTraspasos">
			  <thead>
			    <tr>
			      <th scope="" col="" class="texto-pequenio text-center align-middle  registro">id_log_api_cedula</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">tipo_result</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">estado</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">cod_codigo</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">accion</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">aplicación</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">parametros</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">ruta</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">uri</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">cod_estado_respuesta</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">desc_estado_respuesta</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">runPersona_resultado</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">dvPersona_resultado</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">codTipoDocumento_resultado</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">codClaseDocumento_resultado</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">numDocumento_resultado</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">numSerie_resultado</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">indVigencia_resultado</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">fhoVcto_resultado</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">indBloqueo_resultado</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">obs_respuesta</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">error_respuesta</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">tiempo</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">organizacion</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">ip</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">id</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">fecha</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">cod_obs_respuesta</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">descripcion_obs_respuesta</th>
			    	<th scope="" col="" class="texto-pequenio text-center align-middle  registro">id_sms</th>
			    </tr>
			  </thead>
			  <tbody id="tbodyEquipo">

			    <?php
			        if(isset($traspasos))
			        {
				        foreach ($traspasos as $validacion): ?>
				  			<tr>
						        <th scope="row" class="texto-pequenio text-center align-middle registro"><?php echo $validacion['id_log_api_cedula']; ?></th>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['tipo_result']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['estado']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['cod_codigo']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['accion']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['aplicacion']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['parametros']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['ruta']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['uri']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['cod_estado_respuesta']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['desc_estado_respuesta']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['runPersona_resultado']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['dvPersona_resultado']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['codTipoDocumento_resultado']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['codClaseDocumento_resultado']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['numDocumento_resultado']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['numSerie_resultado']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['indVigencia_resultado']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['fhoVcto_resultado']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['indBloqueo_resultado']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['obs_respuesta']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['error_respuesta']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['tiempo']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['organizacion']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['ip']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['id']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['fecha']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['cod_obs_respuesta']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['descripcion_obs_respuesta']; ?></td>
										<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['id_sms']; ?></td>
					    	</tr>
				  		<?php endforeach;
				  	} ?>
			  </tbody>
			</table>
		</div>
	</div>
</div>
<div id="loader" class="loader" hidden></div>
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