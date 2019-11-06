<?php

if (! defined("DS"))
	define("DS", DIRECTORY_SEPARATOR); //define ell separador de rutas en windows \ en basados en Unix /

// existe y esta la variable de sesión sistema
if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {

	if (is_file("models" . DS . "security" . DS . "cls_AccesoRol.php")) {
		require_once("models" . DS . "security" . DS . "cls_AccesoRol.php");
	}
	elseif (is_file(".." . DS . "models" . DS . "security" . DS . "cls_AccesoRol.php")) {
		require_once(".." . DS . "models" . DS . "security" . DS . "cls_AccesoRol.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "models" . DS . "security" . DS . "cls_AccesoRol.php");
	}

	$objAcceso = new RoleAccess;
	$arrVistas = $objAcceso->fmConsultaVista($vsVista) ; //otiene el codigo a partir de la url o $vsVista

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
						<li>
							<a data-toggle="tab" href="#pestReporte">Reporte</a>
						</li>
					</ul>

					<div class="tab-content">
						<br />
						<?php
							include_once("lis_{$_GET["view"]}.php");
							include_once("rep_{$_GET["view"]}.php");
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
			//funcion anonima que se activa al cargar la ventana
			window.onload = function() {
				fjSinAcceso();
			}
		</script>
		<?php
	}

	unset($arrVistas);
	unset($objAcceso); //destruye el objeto creado

} //cierra el condicional de sesión rol (isset($_SESSION['rol']))

//no esta logueado y trata de entrar sin autenticar
else {
	if (is_file("controllers" . DS . "_core" . DS . "ctr_LogOut.php?getMotivoLogOut=sinlogin")) {
		$locacion = "controllers" . DS . "_core" . DS . "ctr_LogOut.php?getMotivoLogOut=sinlogin";
	}
	elseif (is_file(".." . DS . "controllers" . DS . "_core" . DS . "ctr_LogOut.php?getMotivoLogOut=sinlogin")) {
		$locacion = ".." . DS . "controllers" . DS . "_core" . DS . "ctr_LogOut.php?getMotivoLogOut=sinlogin";
	}
	else {
		$locacion = ".." . DS . ".." . DS . "controllers" . DS . "_core" . DS . "ctr_LogOut.php?getMotivoLogOut=sinlogin";
	}
	header("location: {$location}");
}


?>
