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
				<i class="plusTitulo mb-2" data-feather="plus" ></i> Agregar Orden de Traspasos
			</h3>
		</div>
	</div>
	<div class="col-sm-12">
		<div id="filtros" class="mt-3 mr-3 ml-3">
			<form method="post" accept-charset="utf-8" action="agregarOrdenTraspaso" class="" id="agregarOrdenTraspaso" enctype="multipart/form-data">
			<!--<form id="formAgregarOrdenTraspaso" action="agregarOrdenTraspaso" method="POST">-->
				<div class="row">
					<input type="text" class="form-control form-control-sm" id="inputIdOrdenTraspaso" name="inputIdOrdenTraspaso" hidden>
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="inputRut">Rut Cliente</label>
						<input type="text" class="form-control form-control-sm" id="inputRut" minlength="1" placeholder="Ingrese un Rut de Cliente" name="inputRut" >
						<!--<span>Se requiere un Nombre de Equipo.</span>-->
					</div>
					<div class="form-group col-sm-6">
						<label for="inputSerie">Serie</label>
						<input type="text" class="form-control  form-control-sm" id="inputSerie" name="inputSerie" placeholder="Ingrese la Serie de la c&eacute;dula del Cliente" >
						<!--<span>Se requiere una Abreviaci&oacute;n para el Equipo.</span>-->
					</div>
				</div>



				<div class="row">
					<div class="form-group col-sm-6">
						<label for="selectTipoDoc">Tipo de Documento</label>
						<select id="selectTipoDoc" name="selectTipoDoc" class="custom-select custom-select-sm">
							<option value="" selected>Seleccione un Tipo de Documento</option>
							<option value="1">C&eacute;dula de identidad Chilena</option>
							<option value="2">C&eacute;dula de identidad de Extranjeros</option>
						</select>
					</div>
					<div class="form-group col-sm-6">
						<label for="inputTelefono">Tel&eacute;fono Celular</label>
						<input type="text" class="form-control  form-control-sm" id="inputTelefono" name="inputTelefono" placeholder="Ingrese el tel&eacute;fono celular del Cliente" >
					</div>
					
				</div>
				<div class="row">
					<div class="form-group col-sm-6">
						<label for="inputTelefono">N&#176; Folio</label>
						<input type="number" class="form-control  form-control-sm" id="inputFolio" name="inputFolio" placeholder="Ingrese el N&#176; de Folio" >
					</div>
				</div>
				
				<div id="botones" class="row mt-3">
					<div class="col text-left">
						<a class="btn btn-link"  href="<?php echo base_url();?>Equipo/ListarEquipos">Volver</a>
					</div>
					<div class="col text-right">
					 	<button id="btnAgregarOrdenTraspaso" type="submit" class="btn btn-primary">Agregar Orden Traspaso</button>
					</div>
				</div>
			</form>		
		</div>
	</div>
</div>

<div id="loader" class="loader" hidden></div>

<!-- Modal Mensaje -->
<div class="modal fade" id="modalMensaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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