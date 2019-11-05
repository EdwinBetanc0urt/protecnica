<?php
	/**
	 * Index dieccionador de vistas y paginas, para ocultar las rutas de las
	 * carpetas y archivos, ademas de contener configuración global
	 * @author: Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @license: CC BY-SA, Creative Commons Atribución - CompartirIgual (CC BY-SA) 4.0 Internacional.
	 * @link https://creativecommons.org/licenses/by-sa/4.0/
	 */

	// define el separador de rutas en Windows \ y basados en Unix /
	defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

	// constantes y configuraciones del sistema
	// require_once("_core" . DS . "config_global.php");

	// start session if is empty
	if (strlen(session_id()) < 1) {
		session_start();
	}

	// existe un inicio de sesión
	if (isset($_SESSION["sesion"])) {
		// login con acceso de un usuario
		if ($_SESSION["sesion"] == "sistema") {
			if (isset($_GET["view"]) AND $_GET["view"] == "Reportes" AND
				isset($_POST["moduloReporte"], $_POST["vistaReporte"])) {
				require_once("views" . DS . "reportes" . DS . "index.php");
			}
			else {
				require_once("views" . DS . "intranet" . DS . "index.php");
			}
		}
		// inicio de sesión por primera vez
		if ($_SESSION["sesion"] == "completar") {
			if (isset($_GET["view"]) AND is_dir("views" . DS . "public")  AND
				is_file("views" . DS . "public" . DS . "v_{$_GET['view']}.php")) {
				require_once("views" . DS . "public" . DS . "v_{$_GET['view']}.php");
			}
			else {
				require_once("views" . DS . "public" . DS . "v_CompletarRegistro.php");
			}
		}
	}

	// no hay un inicio de sesión
	else {
		if (isset($_GET["view"]) AND $_GET["view"] != "") {
			if (is_dir("views" . DS . "public")  AND
				is_file("views" . DS . "public" . DS . "{$_GET['view']}.php")) {
				require_once("views" . DS . "public" . DS . "{$_GET['view']}.php");
			}
			else {
				// NO ENCONRO LA PAGINA
				include_once("views" . DS . "_error" . DS . "error404.php");
			}
		}
		else {
			require_once("views" . DS . "public" . DS . "home.php");
		}
	}

	// destruye lo enviado
	if (isset($_POST)) {
		unset($_POST);
	}
	if (isset($_GET)) {
		unset($_GET);
	}
?>
