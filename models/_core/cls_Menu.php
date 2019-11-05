<?php

//define el separador de rutas en Windows \ y basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

if (strlen(session_id()) < 1) {
	session_start();
}

if(is_file("models" . DS . "security" . DS . "cls_RoleAccess.php")) {
	require_once("models" . DS . "security" . DS . "cls_RoleAccess.php");
}
elseif(is_file(".." . DS . "models" . DS . "security" . DS . "cls_RoleAccess.php")) {
	require_once(".." . DS . "models" . DS . "security" . DS . "cls_RoleAccess.php");
}
else {
	require_once(".." . DS . ".." . DS . "models" . DS . "security" . DS . "cls_RoleAccess.php");
}


class Menu extends RoleAccess {
	//atributos de la tabla y clase

	public $atrVista;

	/**
	 * constructor de la clase
	 * @param ineger $piPrivilegio que dependiendo el privilegio usa el usuario para la conexión
	 */
	function __construct($piPrivilegio = 2) {
		parent::__construct($piPrivilegio); //instancia al constructor padre
		$this->atrTabla = "tseg_Rol_Acceso"; //tabla principal de la Clase
		$this->atrVista = ""; //tabla principal de la Clase
		// $this->atrId_P = "id_vista_rol"; //clave primaria de la tabla principal de la clase

		$this->atrIdModulo = ""; //atributo Id

		$this->atrId = ""; //atributo Id
		$this->atrOrden = "";
		$this->atrTipoOrden = "";
	}

	function listModules($psBusquedaVista = "") {
		$sql = "
			SELECT
				M.id_modulo, M.nombre_modulo

			FROM
				tconf_vista AS V

			LEFT JOIN  tseg_rol_acceso AR 
				ON AR.id_vista_fk = V.id_vista

			INNER JOIN tconf_modulo AS M
				ON V.id_modulo_fk = M.id_modulo
			

			WHERE
				AR.id_rol_fk = '{$_SESSION["id_rol"]}'
				AND V.nombre_vista LIKE '%{$psBusquedaVista}%'

			GROUP BY id_modulo
			ORDER BY posicion_menu ;
		";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) {
			return $tupla;
		}
		return false;
	}

	function listViews($psBusquedaVista = "") {
		$sql = "
			SELECT
				V.id_vista, V.nombre_vista, V.url_vista
			
			FROM
				tconf_vista AS V

			LEFT JOIN  tseg_rol_acceso AR 
				ON AR.id_vista_fk = V.id_vista

			INNER JOIN tconf_modulo AS M
				ON V.id_modulo_fk = M.id_modulo

			WHERE
				id_rol_fk = '{$_SESSION["id_rol"]}'
				AND id_modulo = '$this->atrIdModulo'
				AND nombre_vista LIKE '%{$psBusquedaVista}%'
				AND estatus_vista = 'activo'

			GROUP BY id_vista
			ORDER BY posicion_modulo ;
		";
	
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) {
			return $tupla;
		}
		return false;
	}

	function viewInMenu($currentView, $psBusquedaVista) {
		$sql = "
			SELECT
				M.id_modulo, M.nombre_modulo

			FROM
				tconf_vista AS V

			LEFT JOIN  tseg_rol_acceso AR 
				ON AR.id_vista_fk = V.id_vista

			INNER JOIN tconf_modulo AS M
				ON V.id_modulo_fk = M.id_modulo
			

			WHERE
				AR.id_rol_fk = '{$_SESSION["id_rol"]}'
				AND V.url_vista = '{$currentView}'
		";
		return parent::faEjecutar($sql); // Ejecuta la sentencia sql
	}


	function fmListarAyuda($pcBusqueda = "") {
		$sql = "
			SELECT 
				id_vista, vista, descripcion_vista, icono_vista, posicion_modulo,
				url_vista
				
			FROM vwsAccesoRol
			
			WHERE
				id_rol = '{$_SESSION["id_rol"]}' AND
				id_modulo = 8
			
			GROUP BY id_vista
			ORDER BY posicion_modulo ";
	
		//echo "<pre>$sql";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) {
			return $tupla;
		}
		return false;
	}


	function fmListarPerfil($pcBusqueda = "") {
		$sql = "
			SELECT 
				id_vista, nombre_vista, descripcion_vista, icono_vista, 
				posicion_modulo, url_vista
			
			FROM vwsAccesoRol

			WHERE
				id_rol = '{$_SESSION["id_rol"]}' AND
				id_modulo = 4

			GROUP BY id_vista
			ORDER BY posicion_modulo ";
		
		//echo "<pre>$sql";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) {
			return $tupla;
		}
		return false;
	}

} // cierre de la clase

?>
