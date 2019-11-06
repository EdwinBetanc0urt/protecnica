<?php

//define el separador de rutas en windows \ en basados en Unix /
if (! defined("DS")) 
	define("DS", DIRECTORY_SEPARATOR); 

// existe y esta la variable de sesión sistema
if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {

	require_once($vsRutaBase . "models" . DS . "security" . DS . "cls_AccesoRol.php");

	$objAcceso = new RoleAccess;
	$arrVistas = $objAcceso->fmConsultaVista($vsVista) ; //obtiene el código a partir de la URL o $vsVista
	
	if ( $objAcceso->fmConsultaAccesoVista($arrVistas["id_vista"]) ) {
		?>

		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?= ucwords($arrVistas["nombre_vista"]); ?>
				<small> <?= ucfirst($arrVistas["descripcion_vista"]); ?></small>
			</h1>
			<ol class="breadcrumb">
				<li>
					<a href="?view=Principal">
						<i class="fa fa-dashboard"></i>
						Inicio
					</a>
				</li>
				<li>
					<a href="?view=Principal">
						<i class="material-icons"> <?= $arrVistas["icono_modulo"]; ?> </i>
						<?= ucwords($arrVistas["nombre_modulo"]); ?>
					</a>
				</li>
				<li class="active"> <?= ucwords($arrVistas["nombre_vista"]); ?> </li>
			</ol>
		</section>

		<br />
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<div class="box-body">
					<ul class="nav nav-tabs" >
						<li class="active">
							<a data-toggle="tab" href="#pestListado">Listado</a>
						</li>
						<!--
						<li>
							<a data-toggle="tab" href="#pestReporte">Reporte</a>
						</li>
						-->
					</ul>

					<div class="tab-content">
						<br />
						<?php
							include_once("lis_{$_GET["view"]}.php");
							// include_once("rep_{$_GET["view"]}.php");
						?>
					</div>
				</div>
			</div>
		</div>

		<?php

		include_once("mod_{$_GET["view"]}.php");
		
	} //cierra el condicional si tiene acceso a la vista

	// entro pero este no tiene acceso autorizado
	else { 
		?>
		<script type="text/javascript" >
			//función anónima que se activa al cargar la ventana
			window.onload = function() {
				fjSinAcceso();
			}
		</script>
		<?php
	}

	unset($arrVistas);
	unset($objAcceso); //destruye el objeto creado

} //cierra el condicional si existe sesión del sistema

//no esta logueado y trata de entrar sin autenticar
else {
	header("location: {$vsRutaBase}ctr_LogOut.php?getMotivoLogOut=sinlogin");
}

?>
