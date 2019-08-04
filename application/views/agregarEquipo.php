<?php
	$id_usuario=$this->session->userdata('id_usuario');
	
	if(!$id_usuario){
	  redirect('Login');
	}
?>
<div class="row">
	<div class="col-sm-12">
		<div id="titulo" class="mt-3">
			<h3>
				<i class="plusTitulo mb-2" data-feather="<?php echo ($titulo == 'Agregar Equipo' ? 'plus' : 'edit-3'); ?>" ></i><?php echo $titulo; ?>
			</h3>
		</div>
	</div>
	<div class="col-sm-12">
		<div id="filtros" class="mt-3 mr-3 ml-3">
			<form id="agregarEquipo" action="agregarEquipo" method="POST">
				<div class="row">
					<input type="text" class="form-control form-control-sm" id="inputIdEquipo" name="inputIdEquipo" value="<?php if(isset($equipo['id_equipo'])): echo $equipo['id_equipo']; endif; ?>" hidden>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="inputNombre">Nombre</label>
						<input type="text" class="form-control  form-control-sm" id="inputNombre" minlength="1" placeholder="Ingrese nombre Equipo" name="inputNombre" value="<?php if(isset($equipo['nombre'])): echo $equipo['nombre']; endif; ?>">
						<!--<span>Se requiere un Nombre de Equipo.</span>-->
					</div>
					<div class="form-group col-sm-6">
						<label for="inputAbreviacion">Abreviaci&oacute;n</label>
						<input type="text" class="form-control  form-control-sm" id="inputAbreviacion" name="inputAbreviacion" placeholder="Ingrese abreviaci&oacute;n Equipo" value="<?php if(isset($equipo['abreviacion'])): echo $equipo['abreviacion']; endif; ?>">
						<!--<span>Se requiere una Abreviaci&oacute;n para el Equipo.</span>-->
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="inputObservaciones">Observaciones</label>
						<textarea class="form-control form-control-sm block" id="inputObservaciones" name="inputObservaciones" rows="2"><?php if(isset($equipo['descripcion'])): echo $equipo['descripcion']; endif; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<h5>Agregar EAC al Equipo</h5>
				</div>
				<div class="row form-group">
					<label for="colFormLabelSm" class="col-sm-1 col-form-label col-form-label-sm">Buscar</label>
					<div class="col-sm-5">
					  <input id="buscarEAC" type="text" class="form-control form-control-sm" placeholder="Busque por ( C&oacute;digo, Nombres, Apellidos ó Email )">
					</div>
					<div class="row col-sm-6 justify-content-end">
						<button id="check_todos" type="button" class="btn btn-sm btn-outline-dark">Seleccionar Todos</button>
					</div>
				</div>
				<div id="tablaEAC" class="row" data-eac="<?php echo (isset($eacsEquipo) ? implode(",", $eacsEquipo): ''); ?>">
					<div class="col-sm-12">
						<table id="tListaEAC" class="table table-hover table-sm">
							<thead class="thead-dark">
								<tr>
									<th hidden scope="col">Id Usuario</th>
									<th class="thl-radius text-center" scope="col">Cod. EAC</th>
									<th class="text-center" scope="col" colspan="5">Nombres</th>
									<th class="text-center" scope="col" colspan="5">Apellidos</th>
									<th class="text-center" scope="col">Email</th>
									<th class="text-center thr-radius" scope="col">Incluido</th>
								</tr>
							</thead>
							<tbody id="tbodyEAC">

								<?php									
									foreach ($eacs as $eac) {
										echo '<tr>
										<td class="text-center" hidden>'.$eac['id_usuario'].'</td>
										<th class="text-center" scope="col">'.$eac['cod_eac'].'</th>
										<td class="text-center" colspan="5">'.$eac['nombres'].'</td>
										<td class="text-center" colspan="5">'.$eac['apellidos'].'</td>
										<td class="text-center" >'.$eac['email'].'</td>
										<td class="text-center " >
											<input id="check_'.$eac['id_usuario'].'" type="checkbox" class="pauta" data-idUsuario="'.$eac['id_usuario'].'"';

										if (isset($eacsEquipo) && in_array($eac['id_usuario'], $eacsEquipo))
											echo 'checked';
										echo '>
										</td>
										</tr>';
										}
								?>
							</tbody>
						</table>
						<nav aria-label="Page navigation example">
						  <ul class="pagination pagination-sm justify-content-center">
						    <li class="page-item disabled">
						      <a class="page-link" href="javascript:void(0)" tabindex="-1">Previous</a>
						    </li>
						    <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
						    <li class="page-item">
						      <a class="page-link" href="javascript:void(0)">Next</a>
						    </li>
						  </ul>
						</nav>
					</div>
				</div>
				<div id="botones" class="row m-3">
					<div class="col-sm-6 text-left">
						<a class="btn btn-link"  href="<?php echo base_url();?>Equipo/ListarEquipos">Volver</a>
					</div>
					<div  class="col-sm-6 text-right">
					 	<button type="submit" class="btn btn-primary submit"><?php echo $titulo;?></button>
					</div>
				</div>
			</form>		
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