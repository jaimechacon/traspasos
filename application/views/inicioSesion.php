<?php
	$id_usuario=$this->session->userdata('id_usuario');
	 
	if(!$id_usuario){
	  redirect('Login');
	}
?>

<div class="col-sm-12 mt-3">
	<div class="row">
		<h4>Bienvenido <?php echo $u_nombres.' '.$u_apellidos; ?></h4>
	</div>
	<div class="row mt-3">
		<h4>Usted es un <?php echo $perfil['perfil'];//echo $perfil; ?></h4>
	</div>
</div>
