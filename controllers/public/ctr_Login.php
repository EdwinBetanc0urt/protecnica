<?php

//define el separador de rutas en Windows \ y basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

if (strlen(session_id()) < 1) {
	session_start();
}
$relativePath = "";
$relativePathFront = "";
if (is_file("models" . DS . "public" . DS . "cls_LogIn.php")) {
	$relativePath = "";
	$relativePathFront = "";
}
elseif (is_file(".." . DS . "models" . DS . "public" . DS . "cls_LogIn.php")) {
	$relativePath = ".." . DS;
	$relativePathFront = "../";
}
else {
	$relativePath = ".." . DS . ".." . DS;
	$relativePathFront = "../../";
}

if (isset($_POST) AND isset($_POST["userName"]) AND isset($_POST["userPassword"])) {

	require_once($relativePath . "models" . DS . "public" . DS . "cls_LogIn.php");


	$logInInstance = new LogIn();
	$logInInstance->setUsuario($_POST["userName"]); // pasa el dato de usuario al objetoUsuario
	$arrUsuario = $logInInstance->getUserInfo(); // consulta en la tabla de usuario utilizando el usuario

	if (isset($_POST["loginLocation"])) {
		$logInInstance->setUbicacion($_POST["loginLocation"]);
	}

	// se tiene un arreglo, encontro el usuario
	if ($arrUsuario) {
		//consulta en la tabla de tsClave utilizando el usuario
		$arrClave = $logInInstance->getUserPassword();

		//la clave enviada es igual a la clave almacenada
		if (clsCifrado::getCifrar($_POST['userPassword'], $logInInstance::privateKey()) == $arrClave["usuario_clave"]) {
			$logInInstance->resetFailLogIn(); // sel login fails to 0
			$arrDatos = $logInInstance->fmConsultarPersona(); // se busca los datos en la tabla persona

			if ($arrUsuario["estatus_usuario"] == "activo" AND
				$arrUsuario["condicion_usuario"] != "completar" AND
				$arrDatos["condicion_socio_negocio"] != "completar") {

				if ($arrClave["estatus_usuario_clave"] == "activo" OR
					$arrClave["estatus_usuario_clave"] == "temporal" OR
					$arrClave["estatus_usuario_clave"] == "ilimitado" OR
					$arrClave["condicion_usuario_clave"] == "ilimitado") {
					$objFechaInicio = new DateTime($arrClave["fecha_creacion"]);
					$objFechaActual = new DateTime("now");
					$vsDiferencia = $objFechaInicio->diff($objFechaActual);

					if ($logInInstance->getExpirationDays() >= $vsDiferencia->d AND $arrClave["estatus_usuario_clave"] != "ilimitado") {
						/*
						$arrTrabajador = $logInInstance->fmConsultarTrabajador($arrUsuario['id_socio_negocio_fk']);
						if ($arrTrabajador) {
							$arrSede = array(
								"id_departamento" => $arrTrabajador["id_departamento"],
								"departamento" => $arrTrabajador["nombre_departamento"],
								"id_area" => $arrTrabajador["id_area"],
								"area" => $arrTrabajador["nombre_area"],
								"id_cargo" => $arrTrabajador["id_cargo"],
								"cargo" => $arrTrabajador["nombre_cargo"],
								"id_trabajador" => $arrTrabajador["id_trabajador"],
								"cod_trabajador" => $arrTrabajador["cod_trabajador"],
								"fecha_ingreso2" => $arrTrabajador["fecha_ingreso"],
								"fecha_ingreso" => $logInInstance->faFechaFormato(
									$arrTrabajador["fecha_ingreso"]
								)
							);
						}
						else {
							$arrSede = array(
								"id_departamento" => "",
								"departamento" => "",
								"id_area" => "",
								"area" => "",
								"id_cargo" => "",
								"cargo" => "",
								"cargo_superior_fk" => "",
								"id_trabajador" => "",
								"cod_trabajador" => "",
								"fecha_ingreso" => "",
								"fecha_ingreso2" => ""
							);
						}
						unset($arrTrabajador);
						*/
						$_SESSION = array(
							"sesion" => "sistema",
							"id_sesion" => $logInInstance->fmBitacoraEntrada(
								$arrUsuario["id_usuario"]
							),
							"InactivoMaximo" => $arrUsuario["tiempo_sesion"],
							"HoraEntrada" => date("Y-n-j H:i:s"),

							"id_socio_negocio" => $arrUsuario["id_socio_negocio_fk"],
							"caracter_identificacion" => $arrDatos["caracter_identificacion"],
							"identificacion" => $arrDatos["identificacion"],
							"id_usuario" => $arrUsuario["id_usuario"],
							"usuario" => $arrUsuario["nombre_usuario"],

							"nombre_completo" => $arrDatos['primer_nombre'] . " " . $arrDatos['primer_apellido'],
							"nombres_completos" => $arrDatos['primer_nombre'] . " " .
								$arrDatos['segundo_nombre'] . " " . $arrDatos['primer_apellido'] .
								" " . $arrDatos['segundo_apellido'],
							'nombres' => array(
								'0' => $arrDatos['primer_nombre'],
								'primer_nombre' => $arrDatos['primer_nombre'],
								'1' => $arrDatos['segundo_nombre'],
								'segundo_nombre' => $arrDatos['segundo_nombre'],
								'2' => $arrDatos['primer_apellido'],
								'primer_apellido' => $arrDatos['primer_apellido'],
								'3' => $arrDatos['segundo_apellido'],
								'segundo_apellido' => $arrDatos['segundo_apellido'],
							),

							"rol" => $arrUsuario["nombre_rol"],
							"nombre_rol" => $arrUsuario["nombre_rol"],
							"id_rol" => $arrUsuario["id_rol"]
							// "sede" => $arrSede
						);

						$arrRetorno = array(
							"value" => "welcome",
							"isPredefined" => true,
							"isRealod" => true
						);
						// header("Location: {$relativePath}?view=Principal");
					}
					else {
						header("Location: {$relativePath}?msjAlerta=cambiarclave");
					}
				}
				elseif ($arrClave["estatus_usuario_clave"] == "caducada") {
					$_SESSION = array(
						"sesion" => "temporal",
						"id_temporal" => $arrUsuario['nombre_usuario'],
						"id_usuario" => $arrUsuario['id_usuario']
					);
					header("Location: {$relativePath}?msjAlerta=clavetemporal");
				}
			} //cierre de si el usuario esta activo

			elseif ($arrUsuario["estatus_usuario"] == "activo" AND
				($arrUsuario["condicion_usuario"] == "completar" OR
				$arrDatos["condicion_socio_negocio"] == "completar")) {

				$_SESSION = array(
					"sesion" => "completar",
					"usuario" => $arrUsuario["nombre_usuario"],
					"id_usuario" => $arrUsuario['id_usuario'],

					"id_socio_negocio" => $arrUsuario["id_socio_negocio_fk"],
					"id_identificacion" => $arrDatos["id_identificacion_fk"],
					"identificacion" => $arrDatos["identificacion"],
					"id_usuario" => $arrUsuario["id_usuario"],

					"nombre_completo" => $arrDatos['primer_nombre'] . " " . $arrDatos['primer_apellido'],
					'nombres' => array(
						'0' => $arrDatos['primer_nombre'],
						'primer_nombre' => $arrDatos['primer_nombre'],
						'1' => $arrDatos['segundo_nombre'],
						'segundo_nombre' => $arrDatos['segundo_nombre'],
						'2' => $arrDatos['primer_apellido'],
						'primer_apellido' => $arrDatos['primer_apellido'],
						'3' => $arrDatos['segundo_apellido'],
						'segundo_apellido' => $arrDatos['segundo_apellido']
					),

					"rol" => $arrUsuario["nombre_rol"],
					"nombre_rol" => $arrUsuario["nombre_rol"],
					"id_rol" => $arrUsuario["id_rol"]
				);

				//$_SESSION["id_sesion"] = $logInInstance->fmBitacoraEntrada($arrUsuario['id_usuario']);
				$arrRetorno = array(
					"value" => "completadatos",
					"isPredefined" => true,
					"isRealod" => true
				);
			}

			elseif ($arrUsuario["estatus_usuario"] == "bloqueado") {
				$arrRetorno = array(
					"value" => "bloqueo_intentos",
					"isPredefined" => true
				);
			}
			unset($arrDatos);
		}
		// clave y usuario no corresponden
		else {
			$logInInstance->incrementFailLogIn(); //cada intento fallido aumenta a 1 mas
			//consulta los intentos que lleva el usuario y el maximo permitido que especifica la configuration
			if ($logInInstance->getFailLogIn() >= $logInInstance->getMaximumLogInFails()) {
				//si los intentos llegan al maximo establecido bloquea al usuario
				$logInInstance->fmBloqueoUsuario();
				$arrRetorno = array(
					"value" => "bloqueo_intentos",
					"isPredefined" => true
				);
			}

			else {
				$arrRetorno = array(
					"value" => "claveousaurio",
					"isPredefined" => true
				);
			}
		}

		unset($arrClave, $arrUsuario);
	}
	// userName is missing
	else {
		$arrRetorno = array(
			"value" => "nousuario",
			"isPredefined" => true
		);
	} // end condition if userName is missing

	$logInInstance->faDesconectar(); //cierra la conexión
	unset($logInInstance); //destruye el objeto
}
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 2000 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($arrRetorno);

//destruye lo enviado
if (isset($_POST))
	unset($_POST);

if (isset($_GET))
	unset($_GET);

exit;

?>
