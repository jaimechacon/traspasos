<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
	
?>
<div class="row p-3">
	<div id="tDatos" class="col-sm-12 p-3">
		<div class="table-responsive">
			<table class="table table-sm table-hover">
			  <thead>
			    <tr>
			      <th scope="col" class="text-center align-middle registro"># ID</th>
			      <th scope="col" class="text-center align-middle registro">Rut</th>
			      <th scope="col" class="text-center align-middle registro">Descripci&oacute;n</th>
			      <th scope="col" class="text-center align-middle registro">Abreviaci&oacute;n</th>
			      <th scope="col" class="text-center align-middle registro">Cant. Usuarios</th>
			      <th scope="col" class="text-right align-middle registro"></th>
			    </tr>
			  </thead>
			  <tbody id="tbodyEquipo">

			    <?php 
			        if(isset($validacionesPendientes))
			        {
				        foreach ($validacionesPendientes as $validacion): ?>
				  			<tr>
						       <!-- <th scope="row" class="text-center align-middle registro"><?php echo $equipo['id_equipo']; ?></th>
						        <td class="text-center align-middle registro"><?php echo $equipo['nombre']; ?></td>
						        <td class="text-center align-middle registro"><?php echo $equipo['descripcion']; ?></td>
						        <td class="text-center align-middle registro"><?php echo $equipo['abreviacion']; ?></td>
						        <td class="text-center align-middle registro"> 
						        	<span class="badge badge-primary badge-pill"><?php echo $equipo['cant_usu']; ?></span>
						        </td>
						        <td class="text-right align-middle registro">
						        	<a id="trash_<?php echo $equipo['id_equipo']; ?>" class="trash" href="#" data-id="<?php echo $equipo['id_equipo']; ?>" data-nombre="<?php echo $equipo['nombre']; ?>" data-toggle="modal" data-target="#modalEliminarEquipo">
						        		<i data-feather="trash-2" data-toggle="tooltip" data-placement="top" title="eliminar"></i>					        		
					        		</a>
					        		<a id="edit_<?php echo $equipo['id_equipo']; ?>" class="edit" type="link" href="ModificarEquipo/?idEquipo=<?php echo $equipo['id_equipo']; ?>" data-id="<?php echo $equipo['id_equipo']; ?>" data-nombre="<?php echo $equipo['nombre']; ?>">
						        		<i data-feather="edit-3" data-toggle="tooltip" data-placement="top" title="modificar"></i>
					        		</a>-->
					        		<!--<a id="view_<?php echo $equipo['id_equipo']; ?>" class="view" href="#">
						        		<i data-feather="search"  data-toggle="tooltip" data-placement="top" title="ver"></i>
					        		</a>-->
					        	<!--</td>-->
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
