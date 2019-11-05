<?php

//define el separador de rutas en Windows \ y basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

if (is_file("models" . DS . "_core" . DS . "cls_Connection.php")) {
	require_once("models" . DS . "_core" . DS . "cls_Connection.php");
}
elseif (is_file(".." . DS . "models" . DS . "_core" . DS . "cls_Connection.php")) {
	require_once(".." . DS . "models" . DS . "_core" . DS . "cls_Connection.php");
}
else {
	require_once(".." . DS . ".." . DS . "models" . DS . "_core" . DS . "cls_Connection.php");
}


class LogIn extends Connection
{
	//variables de la tabla y clase
	private $atrTabla, $atrId_P, $atrClase;
	//atributos principales
	public $atrId, $atrNombre, $atrEstatus;
	//atributos que utiliza
	private $atrClave, $atrRespuesta1, $atrRespuesta2;
	public $atrUsuario, $atrPregunta1, $atrPregunta2, $atrTiempo, $atrRol, $atrUbicacion;


	/**
	 * constructor de la clase
	 * @param integer $piPrivilegio que dependiendo el privilegio usa el usuario para la conexión
	 */
	//CAMBIAR ACCESO A 3 CUANDO CAMBIE EN LA BD ACCESO
	function __construct()
	{
		parent::__construct(); //instancia al constructor padre
		$this->atrTabla = "tseg_Usuario"; //tabla principal de la Clase
		$this->atrId_P = "id_usuario"; //clave primaria de la tabla principal de la clase
		$this->atrId_F = "id_usuario_fk"; //clave foránea de la tabla principal de la clase

		$this->atrId = "";
		$this->atrId_BPartner = "";
		$this->atrUsuario = ""; // alias o login
		$this->atrClave = "";
		$this->atrUbicacion = "";

		$this->atrFormulario = array() ;
	} //cierre de la función constructor


	//función para recibir y sanear los datos del controllers
	//Usado por el controllers del Login
	function setUsuario($pcUsuario)
	{
		$this->atrUsuario = htmlentities(trim(str_replace("_", "", $pcUsuario)));
	} //cierre de la función

	//función para recibir y sanear los datos del controllers
	//Usado por el controllers del Login
	function setClave($pcClave)
	{
		$this->atrClave = htmlentities(trim($pcClave));
	} //cierre de la función

	//función para recibir y sanear los datos del controllers
	function setUbicacion($psUbicacion)
	{
		$this->atrUbicacion = htmlentities(trim(strtolower($psUbicacion)));
	} //cierre de la función



	//función.models.EnLinea
	function fmEnLinea()
	{

		$sql = "
			UPDATE {$this->atrTabla}
			SET
				condicion_usuario = 'ONLINE'
			WHERE nombre_usuario = '{$this->atrUsuario}' ; ";
		$tupla = parent::faEjecutar($sql);
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
		/*
		try {
			$sql = "
				UPDATE {$this->atrTabla}
				SET condicion_usuario = 'ONLINE'
				WHERE nombre_usuario = '{$this->atrUsuario}' ; ";
			$tupla = $this->atrConexion->prepare($psSQL);
			return $tupla->execute([
			])
		}
		catch (Exception $e) {
			console::log("mensaje de la consola del navegador sobre el error: " . $e->getMessage());
		}
		*/
	} //cierre de la función



	//función.models.EnLinea
	function fmFueraDeLinea()
	{
		$sql = "
			UPDATE {$this->atrTabla}
			SET condicion_usuario = 'OFFLINE'
			WHERE nombre_usuario = '{$this->atrUsuario}' ; ";
		$tupla = parent::faEjecutar($sql);
		//echo "$sql";
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	} //cierre de la función



	function fmBitacoraEntrada($piId_Usuario)
	{
		$id = false;
		$objAgente = new clsAgente();
		$arrNavegador = $objAgente->getNavegador();
		$NavegadorWeb = $arrNavegador['navegador_version'];
		$sql = "
			INSERT INTO tseg_BITACORA_ACCESO (
				fecha_entrada, hora_entrada, usuario_fk,
				direccion_ip_v4, direccion_mac,
				ubicacion, so,
				navegador, nombre_host
				)
			VALUES (
				CURDATE(), CURTIME(), {$piId_Usuario},
				'{$objAgente->getIPv4()}', '{$objAgente->getMAC_Address()}',
				'{$this->atrUbicacion}', '{$objAgente->getSistemaOperativo()}',
				'{$NavegadorWeb}', '{$objAgente->getNombreCliente()}'
			) ; ";

		unset($objAgente);

		$id = parent::faUltimoId($sql); //ejecuta la sentencia y obtiene el ID
		//verifica si se ejecuto exitosamente la sentencia
		if ($id > 0)
			return $id; //retorna el id de la sesión
		else
			return false; //*/
	} //cierre de la función



	function fmBitacoraSalida($piId_Sesion)
	{
		if (strlen(session_id()) < 1) {
			session_start();
		}
		$sql = "
			UPDATE
				tseg_BITACORA_ACCESO
				SET
					fecha_salida = CURDATE(),
					hora_salida = CURTIME()
				WHERE
					id_bitacora_acceso = '{$_SESSION['id_sesion']}' ; ";

		$tupla = parent::faEjecutar($sql); //ejecuta la sentencia
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla))
			return $tupla; //retorna el id de la sesión
		else
			return false;
	} // cierre de la función

	function getUserInfo()
	{
		$sql = "
			SELECT U.*, R.id_rol, R.nombre_rol
			FROM {$this->atrTabla} AS U

			INNER JOIN tseg_Rol AS R
				ON U.id_rol_fk = R.id_rol

			WHERE
				U.nombre_usuario = '{$this->atrUsuario}'
			LIMIT 1 ;
		";
		$tupla = parent::faEjecutar($sql); // Ejecuta la sentencia sql
		// verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arreglo = parent::getConsultaAsociativo($tupla); // convierte el RecordSet en un arreglo
			$this->atrId = $arreglo[$this->atrId_P];
			$this->atrId_BPartner = $arreglo["id_socio_negocio_fk"];
			parent::faLiberarConsulta($tupla); // libera de la memoria el resultado asociado a la consulta
			return $arreglo; // retorna los datos obtenidos de la bd en un arreglo
		}
		return false;
	}

	function getUserPassword()
	{
		$sql = "
			SELECT * FROM tseg_Usuario_Clave
			WHERE
				{$this->atrId_F} = '{$this->atrId}'
			ORDER BY id_usuario_clave DESC
			LIMIT 1 ;
		";
		$tupla = parent::faEjecutar($sql); // Ejecuta la sentencia sql
		// verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arreglo = parent::getConsultaAsociativo($tupla); // convierte el RecordSet en un arreglo
			parent:: faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; // retorna los datos obtenidos de la bd en un arreglo
		}
		return false;
	} // cierre de la funcion


	/**
	 *  busca los datos de una persona
	 */
	function fmConsultarPersona()
	{
		$sql = "
			SELECT *
			FROM vseg_Usuario

			WHERE id_socio_negocio_fk = '{$this->atrId_BPartner}'
			LIMIT 1 ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arreglo = parent::getConsultaAsociativo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		return false;
	} // cierre de la función

	/**
	 * @param integer $piId_Persona, clave foránea en usuario que debe ser igual a la clave principal en persona
	 */
	function fmConsultarTrabajador($piId_Persona)
	{
		/*$sql = "SELECT * FROM tglo_PERSONA_m
				WHERE id_persona = '{$piId_Persona}'
				LIMIT 1 ; ";*/
		$sql = "
			SELECT *
			FROM vwiTrabajador

			WHERE id_socio_negocio_fk = '{$piId_Persona}'
			ORDER BY fecha_nombramiento
			LIMIT 1 ; ";

		$sql = "
			SELECT
				tglo_persona_m.id_persona,
				tglo_persona_m.identificacion,
				tglo_identificacion_m.id_identificacion,
				tglo_identificacion_m.caracter_identificacion,
				tglo_persona_m.pri_nombre,
				tglo_persona_m.seg_nombre,
				tglo_persona_m.pri_apellido,
				tglo_persona_m.seg_apellido,
				tpers_trabajador_m.id_trabajador,
				tpers_trabajador_m.cod_trabajador,
				tpers_trabajador_m.fecha_ingreso,
				tinst_cargo_trabajador_d.id_cargo_trabajador,
				tinst_cargo_trabajador_d.numero_nombramiento,
				tinst_cargo_trabajador_d.fecha_nombramiento,
				tinst_cargo_m.id_cargo,
				tinst_cargo_m.nombre_cargo,
				tinst_cargo_m.cargo_superior_fk,
				tinst_area_m.id_area,
				tinst_area_m.nombre_area,
				tinst_area_m.descripcion_area,
				tinst_area_m.area_superior_fk,
				tinst_departamento_m.id_departamento,
				tinst_departamento_m.nombre_departamento,
				tinst_sede_m.id_sede,
				tinst_sede_m.nombre_sede

			FROM tpers_trabajador_m

			INNER JOIN tglo_persona_m
				ON tpers_trabajador_m.id_socio_negocio_fk = tglo_persona_m.id_persona
			INNER JOIN tglo_identificacion_m
				ON tglo_persona_m.identificacion_fk = tglo_identificacion_m.id_identificacion

			INNER JOIN tinst_cargo_trabajador_d
				ON tinst_cargo_trabajador_d.trabajador_fk = tpers_trabajador_m.id_trabajador

			INNER JOIN tinst_cargo_m
				ON tinst_cargo_trabajador_d.cargo_fk= tinst_cargo_m.id_cargo
			INNER JOIN tinst_area_m
				ON tinst_cargo_m.area_fk = tinst_area_m.id_area
			INNER JOIN tinst_departamento_m
				ON tinst_area_m.departamento_fk = tinst_departamento_m.id_departamento
			INNER JOIN tinst_sede_m
				ON tinst_sede_m.id_sede = tpers_trabajador_m.sede_fk

			WHERE
				tglo_persona_m.id_persona = '{$piId_Persona}'

			ORDER BY id_cargo_trabajador DESC

			LIMIT 1 ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arreglo = parent::getConsultaAsociativo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		return false;
	} //cierre de la función

	//se debe crear un método ya que el usuario de conexión de esta clase no tiene acceso a la tabla de configuración
	function getMaximumLogInFails()
	{
		if (is_file("models" . DS . "configuration" . DS . "cls_SystemConfiguration.php")) {
			require_once("models" . DS . "configuration" . DS . "cls_SystemConfiguration.php");
		}
		elseif (is_file(".." . DS . "models" . DS . "configuration" . DS . "cls_SystemConfiguration.php")) {
			require_once(".." . DS . "models" . DS . "configuration" . DS . "cls_SystemConfiguration.php");
		}
		else {
			require_once(".." . DS . ".." . DS . "models" . DS . "configuration" . DS . "cls_SystemConfiguration.php");
		}
		$configurationInstance = new clsSystemConfiguration();
		$intentos = $configurationInstance->getMaximumLogInFails();
		unset($configurationInstance);
		return $intentos;
	} //cierre de la función

	//se debe crear un método ya que el usuario de conexión de esta clase no tiene acceso a la tabla de configuración
	function getExpirationDays()
	{
		if (is_file("models" . DS . "configuration" . DS . "cls_SystemConfiguration.php")) {
			require_once("models" . DS . "configuration" . DS . "cls_SystemConfiguration.php");
		}
		elseif (is_file(".." . DS . "models" . DS . "configuration" . DS . "cls_SystemConfiguration.php")) {
			require_once(".." . DS . "models" . DS . "configuration" . DS . "cls_SystemConfiguration.php");
		}
		else {
			require_once(".." . DS . ".." . DS . "models" . DS . "configuration" . DS . "cls_SystemConfiguration.php");
		}
		$configurationInstance = new clsSystemConfiguration();
		$intentos = $configurationInstance->getExpirationDays();
		unset($configurationInstance);
		return $intentos;
	} // cierre de la función

	function getFailLogIn()
	{
		$sql = "
			SELECT login_fallidos
			FROM {$this->atrTabla}
			WHERE {$this->atrId_P} = '{$this->atrId}'
			LIMIT 1 ;
		";
		$tupla = parent::faEjecutar($sql);
		if (parent::faVerificar($tupla)) {
			$arrIntento = parent::getConsultaArreglo($tupla);
			parent::faLiberarConsulta($tupla);
			return $arrIntento[0];
		}
		return 3;
	} // cierre de la función

	function incrementFailLogIn()
	{
		$sql = "
			UPDATE
				{$this->atrTabla}
			SET
				login_fallidos = login_fallidos + 1
			WHERE
				{$this->atrId_P} = '{$this->atrId}' ;
		";
		$tupla = parent::faEjecutar($sql);
		if (parent::faVerificar($tupla))
			return $tupla;
		return false;
	} // cierre de la función

	function resetFailLogIn()
	{
		$sql = "
			UPDATE
				{$this->atrTabla}
			SET
				login_fallidos = 0
			WHERE
				{$this->atrId_P} = '{$this->atrId}' ;
		";
		$tupla = parent::faEjecutar($sql);
		if (parent::faVerificar($tupla))
			return $tupla;
		return false;
	} // cierre de la función



	function fmBloqueoUsuario()
	{
		$sql = "
			UPDATE
				{$this->atrTabla}
			SET
				estatus_usuario = 'bloqueado'
			WHERE
				nombre_usuario = '{$this->atrUsuario}' ; ";
		$tupla = parent::faEjecutar($sql);
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	} //cierre de la función


} //cierre de la clase

?>
