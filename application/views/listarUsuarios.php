<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}	
?>
<div class="row mt-3">
	<div id="filtros" class="col-sm-6">
		<div class="mt-1 ml-1 row">
			<label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm">Buscar</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control form-control-sm" id="buscarUsuario" placeholder="Busque por ( C&oacute;digo, Nombres, Apellidos, Rut, Email, Empresa )">
			</div>
		</div>

	</div>
	<div id="agregarUsuario" class="col-sm-6 text-right">
		<a href="AgregarUsuario" class="btn btn-link"><i stop-color data-feather="plus"></i>Agregar Usuario</a>
	</div>
</div>
<div class="row p-3">
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="table-responsive">
			<table class="table table-sm table-hover ">
			  <thead>
			    <tr>
			      <th scope="col" class="text-center align-middle registro"># Cod. Usuario</th>
			      <th scope="col" class="text-center align-middle registro">Nombres</th>
			      <th scope="col" class="text-center align-middle registro">Apellidos</th>
			      <th scope="col" class="text-center align-middle registro">Rut</th>
			      <th scope="col" class="text-center align-middle registro">Email</th>
			      <th scope="col" class="text-center align-middle registro">Perfil</th>
			      <th scope="col" class="text-right align-middle registro"></th>
			    </tr>
			  </thead>
			  <tbody id="tbodyUsuario">
			        <?php foreach ($usuarios as $usuario): ?>
			  			<tr>
					        <th scope="row" class="text-center align-middle"><?php echo $usuario['cod_usuario']; ?></th>
					        <td class="text-center align-middle registro"><?php echo $usuario['nombres']; ?></td>
					        <td class="text-center align-middle registro"><?php echo $usuario['apellidos']; ?></td>
					        <td class="text-center align-middle registro"><?php echo $usuario['rut']; ?></td>
					        <td class="text-center align-middle registro"><?php echo $usuario['email']; ?></td>
					        <td class="text-center align-middle registro"><?php echo $usuario['pf_nombre']; ?></td>
					        <td class="text-right align-middle registro">
								<button id="trash_<?php echo $usuario['id_usuario']; ?>" class="btn btn-link btn-sm trash" type="link" data-id="<?php echo $usuario['id_usuario']; ?>" data-nombre="<?php echo $usuario['nombres'].' '.$usuario['apellidos']; ?>" data-toggle="modal" data-target="#modalEliminarUsuario">
									<i class="trash" data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar" ></i>
								</button>
				        		<a id="edit_<?php echo $usuario['id_usuario']; ?>" class="edit" type="link" href="ModificarUsuario/?idUsuario=<?php echo $usuario['id_usuario']; ?>" data-id="<?php echo $usuario['id_usuario']; ?>" data-nombre="<?php echo $usuario['nombres']; ?>">
					        		<i class="edit" data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
				        		</a>
				        	</td>
				    	</tr>
			  		<?php endforeach ?>
			  </tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalMensajeUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMU"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<p id="parrafoMU"></p>
      </div>
      <div class="modal-footer">
        <button id="btnCerrarMU" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Mensaje -->

<div class="modal fade" id="modalMensajeUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloMU"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<p id="parrafoMU"></p>
      </div>
      <div class="modal-footer">
        <button id="btnCerrarMU" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar -->
	<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<i class="plusTituloError mb-2" data-feather="trash-2"></i>
	        <h5 class="modal-title" id="tituloEU" name="tituloEU" data-idusuario="" data-nombreusuario="" ></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<p id="parrafoEU"></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
	        <button id="eliminarUsuario" type="button" class="btn btn-danger">Eliminar</button>
	      </div>
	    </div>
	  </div>
	</div>
