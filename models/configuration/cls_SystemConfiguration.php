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


class clsSystemConfiguration extends Connection
{
	//variables de la tabla y clase
	private $atrTabla, $atrId_P;

	/**
	 * constructor de la clase.
	 * @param integer $piPrivilegio que usa el usuario para la conexión al servidor
	 */
	function __construct($piPrivilegio = 3)
	{
		parent::__construct(); //instancia al constructor padre
		$this->atrTabla = "tglo_Sistema"; //tabla principal de la Clase
		$this->atrId_P = "id_sistema"; //clave primaria de la tabla principal de la clase
		$this->atrFormulario = array();
	} //cierre de la función constructor



	//función utilizada al iniciar sesión, para establecer el máximo de intentos
	//erróneos de login antes de bloquear al usuario
	function getMaximumLogInFails()
	{
		$sql = "
			SELECT max_intentos_login
			FROM {$this->atrTabla} 
			ORDER BY {$this->atrId_P} ASC
			LIMIT 1 ;
		";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arrConsulta = parent::getConsultaArreglo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arrConsulta[0]; //por defecto incluido en la bd es 3
		}
		return 4; // return default value
	} //cierre de la función



	//Función utilizada al momento de cambiar clave para evitar repetirla clave
	//dentro del rango que se establece
	function getMaximumPasswordRange()
	{
		$sql = "
			SELECT max_rango_clave
			FROM {$this->atrTabla}
			ORDER BY {$this->atrId_P} ASC
			LIMIT 1 ;
		";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if (parent::faVerificar($tupla)) {
			$arrConsulta = parent::getConsultaArreglo($tupla);
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arrConsulta[0]; //por defecto incluido en la bd es 5
		}
		return 6; // return default value
	} //cierre de la función



	//Función utilizada al momento de cambiar clave para evitar repetir
	//la clave dentro del rango que se establece
	function getExpirationDays()
	{
		$sql = "
			SELECT dias_vence_clave
			FROM {$this->atrTabla}

			ORDER BY {$this->atrId_P} ASC
			LIMIT 1 ;
		";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if (parent::faVerificar($tupla)) {
			$arrConsulta = parent::getConsultaArreglo($tupla);
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arrConsulta[0]; //por defecto incluido en la bd es 90 días o 3 meses
		}
		return 91; // return default value
	} //cierre de la función



} //cierre de la clase

?>
