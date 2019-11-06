<?php

//define el separador de rutas en Windows \ y basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);


if (empty($_GET["view"]) || $_GET["view"] == "") {
	$rutabase = "";
	if (is_file("views" . DS . "intranet" . DS . "dashboard.php")) {
		require_once("views" . DS . "intranet" . DS . "dashboard.php");
	}
	elseif (is_file(DS . "views" . DS . "intranet" . DS . "dashboard.php")) {
		$rutabase = ".." . DS;
		require_once(DS . "views" . DS . "intranet" . DS . "dashboard.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "views" . DS . "intranet" . DS . "dashboard.php");
		$rutabase = ".." . DS . ".." . DS;
	}

	echo "
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src='{$rutabase}libreria/AdminLTE/dist/js/pages/dashboard2.js'></script>";
}


if (isset($_GET["view"])) {
	$vsVista = htmlentities(ucwords($_GET["view"])); //quedara en DESUSO
	$vsComponente = htmlentities(ucwords($_GET["view"]));
	$vsModulo = "";
    $vsScript = "";

	switch($vsVista) {
		//DASHBOARD O PAGINA PRINCIPAL
		default:
		case "":
		case "Reportes": //entra acá para que no de error ya que la vista reporte
		case "Principal_": //entra acá para que no de error ya que la vista reporte
		case "Principal":
			$vsVista = "Principal";
			$vsComponente = "Principal";
			$vsModulo = "_core";
			$vsRutaScript = "libreria/AdminLTE/dist/js/pages/dashboard2.js";
		break;

		//MODULO DE AYUDA
		case "ManualUsuario":
		case "ManualInstalacion":
		case "ManualSistema":
		case "ManualNormas":
		case "ManualPolitica":
		case "Licencia":
			$vsModulo = "_ayuda";
			$vsRutaScript = "";
		break;

		//MODULO DE CONFIGURACION
		case "Boton":
		case "Modulo":
		case "Vista":
		case "Pais":
		case "Estado":
		case "Ciudad":
		case "Municipio":
		case "Parroquia":
			$vsModulo = "configuration";
			$vsScript = "
				<!-- Script Especifico de la Pagina -->
				<script type='text/javascript'>
					var vsVista = '{$vsVista}';
					var vsModulo = '{$vsModulo}';
					var vsComponente = '{$vsComponente}';
				</script>";
			$vsRutaScript = "public/js/{$vsModulo}/" . lcfirst($vsComponente) . ".js";
		break;

		// MODULO de Compras
		case "RequestQuotation":
			$vsModulo = "purchase";
			$vsScript = "
				<!-- Script Especifico de la Pagina -->
				<script type='text/javascript'>
					var vsVista = '{$vsVista}';
					var vsModulo = '{$vsModulo}';
					var vsComponente = '{$vsComponente}';
				</script>";
			$vsRutaScript = "public/js/{$vsModulo}/" . lcfirst($vsComponente) . ".js";
		break;

		// MODULO DE security
		case "RoleAccess":
		case "BitacoraAcceso":
		case "ConfiguracionSistema":
		case "Pregunta":
		case "Role":
		case "User":
			$vsModulo = "security";
			$vsScript = "
				<!-- Script Especifico de la Pagina -->
				<script type='text/javascript'>
					var vsVista = '{$vsVista}';
					var vsModulo = '{$vsModulo}';
					var vsComponente = '{$vsComponente}';
				</script>";
			$vsRutaScript = "public/js/{$vsModulo}/" . lcfirst($vsComponente) . ".js";
		break;
	} // cierre del switch

	//El parámetro GET[v] (versión), al final del src del script representa el
	//código hash (sha256) del archivo para la verificación de que el archivo que
	//se tiene es el original, ademas de mejorar el manejo en el cache cada vez
	//que se realiza un cambio

	//para las vistas que tienen carpetas con su mismo nombre
	//las mayoría de las vistas en general pero con rutas relativas
	if (is_dir(".." . DS . ".." . DS . "views" . DS . $vsModulo . DS . $vsComponente . DS)  AND
		is_file(".." . DS . ".." . DS . "views" . DS . $vsModulo . DS . $vsComponente . DS . "index.php")) {

		include_once($vsRutaB . "views" . DS . $vsModulo . DS . $vsComponente . DS . "index.php");

		$vsScript .= "
			<script async='async' src='{$vsRutaScript}?v=" . @hash_file("sha256", $vsRutaScript) . "' ></script>";
	}

	//para las vistas que no están en una carpeta con su mismo nombre
	//las mayoría de las vistas en general y ACTUALMENTE EN USO
	elseif (is_dir("views" . DS . $vsModulo . DS . $vsComponente . DS)  AND
		is_file("views" . DS . $vsModulo . DS . $vsComponente . DS . "index.php")) {

		include_once("views" . DS . $vsModulo . DS . $vsComponente . DS . "index.php");

		$vsScript .= "
			<script async='async' src='{$vsRutaScript}?v=" . @hash_file("sha256", $vsRutaScript) . "' ></script>";
	}

	//para las vistas que no están en una carpeta con su mismo nombre
	//es decir _core, _ayuda, _error, _info pero con rutas relativas
	elseif (is_dir(".." . DS . ".." . DS . "views" . DS . $vsModulo . DS)  AND
		is_file(".." . DS . ".." . DS . "views" . DS . $vsModulo . DS . "index.php")) {
		$vsRutaB = ".." . DS . ".." . DS;

		include_once(".." . DS . ".." . DS . "views" . DS . $vsModulo . DS . "index.php");

		$vsScript .= "
			<script async='async' src='{$vsRutaScript}?v=" . @hash_file("sha256", $vsRutaScript) . "' ></script>";
	}

	//para las vistas que no están en una carpeta con su mismo nombre
	//es decir _core, _ayuda, _error, _info, y la vista configuración
	elseif (is_dir("views" . DS . $vsModulo . DS)  AND
		is_file("views" . DS . $vsModulo . DS . "index.php")) {

		include_once("views" . DS . $vsModulo . DS . "index.php");
		$vsScript .= "
			<script async='async' src='{$vsRutaScript}?v=" . @hash_file("sha256", $vsRutaScript) . "' ></script>";
	}

	else {
		//NO ENCONRO LA PAGINA
		include_once("views" . DS . "_error" . DS . "error404.php");
	}

	if (isset($vsRutaScript)) {
		unset($vsRutaScript);
	}
} //cierre del condicional si existe la variable view

?>
