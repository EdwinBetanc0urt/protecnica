<?php

// inicio de sesión
if (strlen(session_id()) < 1) {
	session_start();
}

//define el separador de rutas en windows \ en basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);


$vsRutaBase = "";
if (is_file("models" . DS . "public" . DS . "cls_LogIn.php")) {
	$vsRutaBase = "";
}
elseif (is_file(".." . DS . "models" . DS . "public" . DS . "cls_LogIn.php")) {
	//$vsRutaBase = ".." . DS;
	$vsRutaBase = "../";
}
else {
	//$vsRutaBase = ".." . DS . ".." . DS;
	$vsRutaBase = "../../";
}

// existe y esta la variable de session
if (isset($_SESSION['sesion'])) {
	//Cambia la condicion a OFFLINE o fuera de linea
	require_once($vsRutaBase . "models" . DS . "public" . DS . "cls_LogIn.php");

	//include_once("../../models/public/cls_LogIn.php");
	$objUsuario = new LogIn();
	$objUsuario->setUsuario($_SESSION['usuario']);
	//$objUsuario->fmFueraDeLinea();
	//$objUsuario->fmBitacoraSalida($_SESSION['id_sesion']); //registra la bitacora de salida
	$objUsuario->faDesconectar();
	unset($objUsuario); //se destruye el objeto

	// libera las variables de session
	unset($_SESSION) ;
	session_unset(); //liera la sesion iniciada
	session_destroy(); // destruye la sesión
	session_write_close(); // cierre de la escritura de sesion

	if (isset($_GET["getMotivoLogOut"])) {
		$_GET["getMotivoLogOut"] = htmlentities(trim(strtolower($_GET["getMotivoLogOut"])));
		header("Location: {$vsRutaBase}?msjAlerta=" . $_GET["getMotivoLogOut"]);
		// direcciona a la pagina de Logueo con el mensaje de respuesta
	}
	else
		header("Location: {$vsRutaBase}?sesion=cerrada"); // direcciona a la pagina de Logueo
	//*/
}

// trata de entrar sin autenticar
else {
	header("Content-Type: text/html; charset=utf-8");
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script type="text/javascript" src="<?= $vsRutaBase; ?>libreria/componentes/sweetalert2/dist/sweetalert2.all.min.js"></script>
	<img src="<?= $vsRutaBase; ?>img/security/login.png" width="400" >
	<script type="text/javascript">
		let lsRutaBase = <?= "\"" . $vsRutaBase . "\""; ?>;
		/*
		if(typeof swal === 'function') {
			swal({
				title: '¡Acceso RESTRINGIDO!',
				text: 'Debe Iniciar Sesión para verificar tus privilegios de acceso',
				type: 'error',
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Ok ',
				showCloseButton: true
			}).then((result) => {
				window.location = "<?= $vsRutaBase; ?>?msjAlerta=accesoprohibido";
			});
		}
		else {
			alert("\t\t\t¡ATENCION: ACCESO RESTRINGIDO! \n Debe Iniciar Sesión para verificar tus privilegios de acceso");
			window.location = "<?= $vsRutaBase; ?>?msjAlerta=accesoprohibido";
		}
		*/
		window.location =  lsRutaBase + "?msjAlerta=accesoprohibido";
	</script>
	<?php
}

exit;

?>
