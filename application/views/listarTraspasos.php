<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>
<div class="row p-3">
	<div class="col-sm-12 text-right">
		<button id="btnExportarExcelUsuario" type="button" class="btn btn-link">Exportar a CSV
			<i style="margin-bottom: 5px;" data-feather="download"></i>
		</button>
	</div>

<?php if ($usuario_operacional) { ?>
	<div class="col-sm-12">
		<div class="row">			
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<span class="">Sucursal</span>
					</div>
					<div class="col-sm-9">
						<select id="sucursalCall" class="custom-select custom-select-sm">
						   	<option value="-1">Todos</option>
							<?php 
							if($sucursales)
							{
								foreach ($sucursales as $sucursal) {
									if(isset($idSucursal) && (int)$sucursal['id_sucursal'] == $idSucursal)
                                    {
                                            echo '<option value="'.$sucursal['id_sucursal'].'" selected>'.$sucursal['nombre'].'</option>';
                                    }else
                                    {
                                            echo '<option value="'.$sucursal['id_sucursal'].'">'.$sucursal['nombre'].'</option>';
                                    }
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<span class="">Vendedor</span>
					</div>
					<div class="col-sm-9">
						<select id="vendedorCall" class="custom-select custom-select-sm">
						    <option value="-1">Todos</option>
							<?php 
							if($vendedores)
							{
								foreach ($vendedores as $vendedor) {
									if(isset($idVendedor) && (int)$vendedor['id_usuario'] == $idVendedor)
									{
                                        echo '<option value="'.$vendedor['id_usuario'].'" selected>'.$vendedor['u_rut'].(sizeof(trim($vendedor['u_nombres'])) > 0 ? ' - '.$vendedor['u_nombres'].' '.$vendedor['u_apellidos'] : '').'</option>';
                                    }else
                                    {

                                        echo '<option value="'.$vendedor['id_usuario'].'">'.$vendedor['u_rut'].(sizeof(trim($vendedor['u_nombres'])) > 0 ? ' - '.$vendedor['u_nombres'].' '.$vendedor['u_apellidos'] : '').'</option>';
                                    }
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
	<div class="col-sm-12 mt-3">
		<div class="row">			
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<span class="">Fecha Desde</span>
					</div>
					<div class="col-sm-9">
						<input type="date" id="fechaDesde" name="fechaDesde" class="form-control">
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<span class="">Fecha Hasta</span>
					</div>
					<div class="col-sm-9">
						<input type="date" id="fechaHasta" name="fechaHasta" class="form-control">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12 mt-3">
		<div class="row">			
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<span class="">Estado C&eacute;dula</span>
					</div>
					<div class="col-sm-9">
						<select id="estadoRC" class="custom-select custom-select-sm">
						   	<option value="-1">Todos</option>
						   		<option value="1" <?php echo ((isset($idEstadoRC) && $idEstadoRC == '1') ? 'selected' : '') ?> >VIGENTE</option>
						   		<option value="2" <?php echo ((isset($idEstadoRC) && $idEstadoRC == '2') ? 'selected' : '') ?> >NO VIGENTE</option>
						   		<option value="3" <?php echo ((isset($idEstadoRC) && $idEstadoRC == '3') ? 'selected' : '') ?> >ERROR DE DATOS</option>
						   		<option value="4" <?php echo ((isset($idEstadoRC) && $idEstadoRC == '4') ? 'selected' : '') ?> >NO VALIDADO</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-3">
						<span class="">Estado Certificaci&oacute;n</span>
					</div>
					<div class="col-sm-9">
						<select id="estadoC" class="custom-select custom-select-sm">
						    <option value="-1">Todos</option>
							<?php 
							if($estadosC)
							{
								foreach ($estadosC as $estado_c) {
									if(isset($idEstadoC) && (int)$estado_c['id_certificado'] == $idEstadoC)
									{
                                        echo '<option value="'.$estado_c['id_certificado'].'" selected>'.$estado_c['nombre'].'</option>';
                                    }else
                                    {
                                        echo '<option value="'.$estado_c['id_certificado'].'">'.$estado_c['nombre'].'</option>';
                                    }
								}
							}
							?>
						</select>
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
						<button id="btnBuscarOT" type="button" class="btn btn-primary">Filtrar <i class="mb-1" data-feather="search"></i></button>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div id="tDatos" class="col-sm-12 p-3">
		<div id="tTraspasos">
			<table class="table table-sm table-hover" id="listaTraspasos">
			  <thead>
			    <tr>
			      <th scope="col" class="texto-pequenio text-center align-middle registro"># ID</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Sucursal</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Rut Usuario</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Usuario</th>
			      <th scope="col" class="texto-pequenio text-center align-middle registro">Perfil</th>
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
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['u_rut']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['u_nombres']." ".$validacion['u_apellidos']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['pf_nombre']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['rut']; ?></td>
						        <!--<td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['serie']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['tipo_documento']; ?></td>-->
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['nombres']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['apellido_paterno']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['apellido_materno']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['institucion']; ?></td>
						        <td class="texto-pequenio text-center align-middle registro"><?php echo $validacion['telefono']; ?></td>
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