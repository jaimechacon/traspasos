<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>
<div class="flex-row">
	<div class="row justify-content-sm-center">
	    <div class="col col-lg-8">
		<h2 class="m-3">Lista de Perfiles</h2>
		<br/><br/>
		<div class="col-md-12">
			<a href="#" class="pull-right veinticinco_m_b">
				<svg
				  width="24"
				  height="24"
				  fill="none"
				  stroke="currentColor"
				  stroke-width="2"
				  stroke-linecap="round"
				  stroke-linejoin="round"
				>
				  <use xlink:href="<?php echo base_url();?>node_modules/feather-icons/dist/feather-sprite.svg#plus"/>
				</svg>
				<i data-feather="plus"></i>
				<medium class="cinco_m_l">Agregar Perfil</medium>
			</a>
			<div class="table-responsive-md">
				<table class="table table-sm">
					<thead>
					    <tr>
						    <th scope="col">Nombre perfil</th>
						    <th scope="col">Descripci&oacute;n</th>
						    <th scope="col">Fecha creaci&oacute;n</th>
						    <th scope="col"></th>
					    </tr>
					</thead>
				<?php foreach ($perfiles as $perfil): ?>
					<tr>
						<td>
							<?php if(isset($perfil['id_perfil'])): echo $perfil['id_perfil']; endif; ?>
						</td>
						<td>
							<?php if(isset($perfil['pf_nombre'])): echo $perfil['pf_nombre']; endif; ?>
						</td>
						<td></td>
					</tr>
				<?php endforeach; ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!--
<div class="flex-row">
<h2>Lista de Perfiles</h2>
	<br/>
	<div class="col-xs-12">
		<a href="#" class="pull-right veinticinco_m_b"><span class="glyphicon glyphicon-plus"></span><medium class="cinco_m_l">Agregar Perfil</medium></a>
		<div class="table-responsive">
			<table class="table table-striped">
				<tr>
					<th>
						C&oacute;digo
					</th>
					<th>
						Nombre Perfil
					</th>
					<th>
						Descripci&oacute;n
					</th>
					<th>
						Fecha Creaci&oacute;n
					</th>
					<th>
					</th>
				</tr>
			-->
				<?php 
					//while($perfil = $perfiles)					{
				?>
				<!--<tr>
					<td>-->
						<?php //if(isset($perfil['id_perfil'])): echo $perfil['id_perfil']; endif; ?>
					<!--</td>
					<td>-->
						<?php //if(isset($perfil['pf_nombre'])): echo $perfil['pf_nombre']; endif; ?>
					<!--</td>
					<td>
						
					</td>
					<td>
						<a href="#">
							<span class="glyphicon glyphicon-refresh"></span>
						</a>
						<a href="#" class="cinco_m_l">
							<span class="glyphicon glyphicon-trash"></span>
						</a>
					</td>
				</tr>-->
				<?php
					//}
				?>
			<!--</table>
		</div>
	</div>
</div>
