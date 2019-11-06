
<?php

//define el separador de rutas en Windows \ en basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);


if (isset($_POST["vvOpcion"]))
	$gsOpcion = htmlentities(strtolower($_POST["vvOpcion"]));
elseif (isset($_POST["setOpcion"]))
	$gsOpcion = htmlentities(strtolower($_POST["setOpcion"]));
else
	$gsOpcion = "principal";

fcSeleccionMenu($gsOpcion);



function fcSeleccionMenu($piOpcion) {
	switch($piOpcion) {
		//case NULL: //en caso de ser nulo se esta abriendo por URL y se debe sacar del sistema
		//	header("Location: ../../controllers/_core/ctr_LogOut.php?getMotivoLogOut=indevido"); //cierra la sesion
		//	break;
		case "1":
		case "principal":
			mainMenu();
			break;
		case "perfil":
		case "2":
			fcMenuPerfil();
			break;
		case "3":
			fcMenuAyuda();
			break;
	}
} // cierre de la funcion de seleccion menu



function mainMenu() {
	// inicio de sesión
	if (strlen(session_id()) < 1) {
		session_start();
	}
	if (is_file("models" . DS . "_core" . DS . "cls_Menu.php")) {
		$gsRutaBase = "";
		$rutabase = "";
	}
	elseif (is_file(".." . DS . "models" . DS . "_core" . DS . "cls_Menu.php")) {
		$rutabase = "../";
		$gsRutaBase = ".." . DS;
	}
	else {
		$gsRutaBase = ".." . DS . ".." . DS;
		$rutabase = "../../";
	}

	if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {
		$vsBusqueda = "";
		if (isset($_POST['setBusqueda'])) {
			$vsBusqueda = htmlentities(addslashes(trim($_POST["setBusqueda"])));
		}

		$currentView = "";
		if (isset($_POST['currentView'])) {
			$currentView = htmlentities(addslashes(trim($_POST["currentView"])));
		}

		require_once($gsRutaBase . "models" . DS . "_core" . DS . "cls_Menu.php");

		$objeto = new Menu;
		$rstModulo = $objeto->listModules($vsBusqueda);

		if ($rstModulo) {
			while ($arrModulo = $objeto->getConsultaArreglo($rstModulo)) {
				$objeto->atrIdModulo = $arrModulo["id_modulo"];
				$rstVista = $objeto->listViews($vsBusqueda);
				?>
				<li class="treeview" id="list<?= ucwords($arrModulo["nombre_modulo"]); ?>">
					<a>
						<i class='<?= $arrModulo["icono_modulo"]; ?>'></i>
						<span> <?= $arrModulo["nombre_modulo"]; ?></span>
						<span class="pull-right-container black-text">
							<i class="fa fa-angle-left pull-right black-text"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<?php
						if ($rstVista) {
							while ($arrVista = $objeto->getConsultaArreglo($rstVista)) {
								$active = $_GET["view"];
								if ($arrVista["url_vista"] == $currentView) {
									$active = "class='active selected-menu'";
								}

								?>
								<li <?= $active ?> >
									<a href='?view=<?= $arrVista["url_vista"]; ?>' >
										<i class="fa fa-circle-o black-text"></i>
										<?= $arrVista["nombre_vista"]; ?>
									</a>
								</li>
								<?php
							}

							$objeto->faLiberarConsulta($rstVista);
						}
						?>
					</ul>
				</li>
				<?php
			} // cierre del while

			$objeto->faLiberarConsulta($rstModulo);
		}
		else {
			?>
			<li class="treeview">
				<a >
					<i class='fa fa-close'></i>
					<span> Sin ningún resultado <br /> o Accesos en el menú </span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
			</li>
			<?php
		} // cierre del condicional si no existen accesos asignados
	} // cierra el condicional de sesion

	//no esta logueado trata de entrar sin autenticar
	else {
		header("Content-Type: text/html; charset=utf-8");

		//NO SE CREAR LA ESTRUCTURA COMPLETA DE HTML
		//CON BODY Y HEAD, YA QUE NO, MUESTRA LA IMAGEN
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="<?= $rutabase; ?>estilo/sty_Librerias.css" rel="StyleSheet" type="text/css">
		<link href="<?= $rutabase; ?>estilo/sty_Elementos.css" rel="StyleSheet" type="text/css">
		<script type="text/javascript" src="<?= $rutabase; ?>libreria/componentes/sweetalert2/dist/sweetalert2.all.min.js" charset="UTF-8"></script>

		<div class="divRestringido"></div>
		<script type="text/javascript" charset="UTF-8">
			if (typeof swal === 'function') {
				swal({
					title: '¡Acceso RESTRINGIDO!',
					text: 'Tienes que Iniciar Sesión para verificar tus privilegios de acceso' ,
					type: 'error',
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Ok ',
					showCloseButton: true,
				}).then((result) => {
					window.location = "<?= $rutabase; ?>controllerslers/_core/ctr_LogOut.php?getMotivoLogOut=accesoprohibido".trim();
				});
			}
			else {
				alert("\t\t\t¡ATENCION: ACCESO RESTRINGIDO! \n Tienes que Iniciar Sesión para verificar tus privilegios de acceso");
				window.location = "controllerslers/_core/ctr_LogOut.php?getMotivoLogOut=accesoprohibido";
			}
		</script>
		<?php
	}
} //cierre del menu principal



function fcMenuPerfil() {
	// inicio de sesión
	if (strlen(session_id()) < 1) {
		session_start();
	}
	include_once("models/_core/cls_Menu.php");
	$objeto = new Menu;
	$objeto->atrIdRol = $_SESSION['rol'];

	$rstPerfil = $objeto->fmListarPerfil();

	if ($rstPerfil) {
		$arrPerfil = $objeto->getConsultaArreglo($rstPerfil);
		do {
			//var_dump($arrVista);
			?>
			<div class="col-xs-2 text-center">
				<a href='?view=<?= $arrPerfil["url_vista"]; ?>' data-toggle="tooltip" data-placement="bottom" title='<?= ucwords($arrPerfil["vista"]); ?>' >
					<span class="white-text">
						<i class="white-text tiny material-icons"><?= $arrPerfil["icono_vista"]; ?></i>
					</span>
				</a>
			</div>
			<?php
		}
		while ($arrPerfil = $objeto->getConsultaArreglo($rstPerfil));
		$objeto->faLiberarConsulta($rstPerfil);

	}
	else {
		?>
		<div class="col-xs-3 text-center">
			<a data-toggle="tooltip" data-placement="bottom" title="Cerrar Sesion y Salir">
				<span class="white-text">
					No se le han asignados permisos para modificar su perfil
				</span>
			</a>
		</div>
		<?php
	}
}



function fcMenuAyuda() {
	// inicio de sesión
	if (strlen(session_id()) < 1) {
		session_start();
	}
	include_once("models/_core/cls_Menu.php");
	$objeto = new Menu;
	$objeto->atrIdRol = $_SESSION['rol'];

	$rstAyuda = $objeto->fmListarAyuda();

	if ($rstAyuda) {
		$arrAyuda = $objeto->getConsultaArreglo($rstAyuda);
		do {

			?>
			<a class='ayuda btn btn-primary blue darken-4' target="_blank" href='?view=<?= $arrAyuda["url_vista"]; ?>' data-toggle="tooltip" data-placement="bottom" title='<?= ucwords($arrAyuda["vista"]); ?>' >
				<i class="white-text material-icons"> <?= $arrAyuda["icono_vista"]; ?> </i>
			</a>
			<?php
			/*echo "<pre>";
			var_dump($arrAyuda);
			echo "</pre>";*/
		}
		while ($arrAyuda = $objeto->getConsultaArreglo($rstAyuda));
		$objeto->faLiberarConsulta($rstAyuda);

	}
	else {
		?>
		<!--
		<div class="col-xs-3 text-center">
			<a data-toggle="tooltip" data-placement="bottom" title="Cerrar Sesion y Salir">
				<span class="white-text">
					No se le han asignados permisos para modificar su perfil
				</span>
			</a>
		</div>
		-->
		<?php
	}
	unset($objeto);
}



?>
