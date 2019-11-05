<?php

//define el separador de rutas en Windows \ en basados en Unix /
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

class RoleAccess extends Connection
{
	//atributos de la tabla y clase
	protected $atrTabla, $atrClase;

	//campos de la tabla
	public $atrId_P, $atrId_F, $atrNombre, $atrEstatus, $atrCondicion, $atrDescripcion;


	/**
	 * constructor de la clase
	 * @param integer $piPrivilegio que dependiendo el privilegio usa el usuario para la conexión
	 */
	function __construct($piPrivilegio = 2)
	{
		parent::__construct($piPrivilegio); //instancia al constructor padre

		$this->atrClase = "rol_acceso";
		$this->atrTabla = "tseg_" . strtoupper($this->atrClase); //tabla principal de la Clase
		$this->atrId_P = "id_" . $this->atrClase; //clave primaria de esta tabla
		$this->atrId_F = $this->atrClase . "_fk"; //clave foránea en otras tablas
		$this->atrNombre = $this->atrClase ;
		$this->atrEstatus = "estatus_" . $this->atrClase ;
		$this->atrCondicion = "condicion_" . $this->atrClase  . "_rol";

		$this->atrTablasRelacionadas = array(
			array(
				"tabla" => "tseg_ACCESO_d",
				"id" => "id_acceso",
				"estatus" => "estatus_acceso"
			),
			array(
				"tabla" => "tconf_BOTON_VISTA_d",
				"id" => "id_det_vista_boton",
				"estatus" => "estatus_det_vista_boton"
			)
		); //id dependiente o padre

		$this->atrId_Superior = "" ; //id dependiente o padre
		$this->atrId_Recursivo = "" ; //id dependiente o padre en su misma tabla

		$this->atrFormulario = array();
	}



	/**
	 * Función models CuentaUsados, registros en otras tablas relacionadas que han usado este registro
	 * @return array $arreglo cantidad de registros en un entero
	 */
	//función.models.Insertar
	function fmInsertar3()
	{
		parent::faTransaccionInicio();
		$tam = count($this->atrFormulario["chkBoton"]);
		$liCont = 0; //contador de errores

		$sql = "
			INSERT INTO {$this->atrTabla}
				(id_rol_fk, id_vista_fk, id_vista_fk)
			VALUES ";

		foreach ($this->atrFormulario["chkBoton"] as $key => $liValor) {
			$liCont++;

			$sql .= " ('{$this->atrFormulario["numRol"]}', '{$liValor}', '{$this->atrFormulario["numId"]}') ";

			if ($liCont < $tam) {
				$sql .= ", ";
			}
		}
		echo "$sql";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if (parent::faVerificar($tupla)) {
			parent::faTransaccionFin();
			return true;
		}
		else {
			parent::faTransaccionDeshace();
			return false;
		}

	} //cierre de la función insertar



	/**
	 * Función models CuentaUsados, registros en otras tablas relacionadas que han usado este registro
	 * @return array $arreglo cantidad de registros en un entero
	 */
	function fmInsertarX()
	{
		//$this->atrConexion->beginTransaction();

		$sql = "
			INSERT INTO {$this->atrTabla}
				(id_rol_fk, id_vista_fk, id_vista_fk)
			VALUES
				(?, ?, ?);";
		//$sentencia = $this->atrConexion->prepare($psSQL);
		/*
		$sentencia->bindParam(1, $this->atrFormulario["numRol"], PDO::PARAM_INT);
		$sentencia->bindParam(2, $this->atrFormulario["numId"], PDO::PARAM_INT);
		$sentencia->bindParam(3, $this->atrFormulario["chkBoton"], PDO::PARAM_INT);
		*/
		$error = 0;
		foreach ($this->atrFormulario["chkBoton"] as $key) {
			//$sentencia->execute();
			try {
				/*
				$sentencia->bindParam(1, $this->atrFormulario["numRol"], PDO::PARAM_INT);
				$sentencia->bindParam(2, $this->atrFormulario["numId"], PDO::PARAM_INT);
				$sentencia->bindParam(3, $this->atrFormulario["chkBoton"][$key], PDO::PARAM_INT);
				*/
				/*
				$sentencia->execute([
					$this->atrFormulario["numRol"],
					$this->atrFormulario["numId"],
					$this->atrFormulario["chkBoton"][$key]
				]);
				*/
				$tupla = parent::ejecutar(
					$sql,
					[
						$this->atrFormulario["numRol"],
						$this->atrFormulario["numId"],
						$this->atrFormulario["chkBoton"][$key]

					]
				);
				if ($tupla) {
					$error = $error + 1;
				}
			}
			catch (Exception $e) {
				console::log("mensaje de la consola del navegador sobre el error: " . $e->getMessage());
				//$this->atrConexion->rollBack();
				//return false;
			}

			if ($error > 0) {
				return true;
			}
			return false;
		}

		//$this->atrConexion->commit();
		//return true;
	} //cierre de la función insertar

	/**
	 * Funcion models CuentaUsados, registros en otras tablas relacionadas que han usado este registro
	 * @return array $arreglo cantidad de registros en un entero
	 */
	//funcion.models.Insertar
	function fmInsertar()
	{
		parent::faTransaccionInicio();
		$tam = count($this->atrFormulario["chkBoton"]);
		$liCont = 0; //contador de errores

		$sql = "
			INSERT INTO {$this->atrTabla}
				(id_rol_fk, id_boton_fk, id_vista_fk)
			VALUES ";

		foreach ($this->atrFormulario["chkBoton"] as $key => $liValor) {
			$liCont++;

			$sql .= " ('{$this->atrFormulario["numRol"]}', '{$liValor}', '{$this->atrFormulario["numId"]}') ";

			if ($liCont < $tam) {
				$sql .= ", ";
			}
		}
		$sql .= ";";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if (parent::faVerificar($tupla)) {
			parent::faTransaccionFin();
			return true;
		}
		parent::faTransaccionDeshace();
		return false;
	} //cierre de la funcion insertar


	//función.models.Insertar
	function fmImportarAccesos()
	{
		//parent::faTransaccionInicio();
		$sql = "
			INSERT INTO {$this->atrTabla}
				(id_rol_fk, id_vista_fk, id_vista_fk)

			SELECT
				'{$this->atrFormulario["numRol"]}', id_vista_fk,id_vista_fk
				FROM tseg_acceso_d
				WHERE
					id_rol_fk = '{$this->atrFormulario["numRol2"]}'  ";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto bien
		if (parent::faVerificar($tupla)) {
			//parent::faTransaccionFin();
			$tupla;
		}
		//parent::faTransaccionFin();
		return false;
	}



	//función.models.Eliminar
	function fmEliminar()
	{
		$lsForm = $this->atrFormulario;
		$sql = "
			DELETE
		 		FROM {$this->atrTabla}
		 		WHERE
					id_vista_fk = '{$lsForm["numId"]}' AND
					id_rol_fk = '{$lsForm["numRol"]}' ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) //verifica si se ejecuto bien
			return $tupla; //envía el arreglo
		else
			return false;
		//echo "$sql <hr>";
	}



	//función.models.Eliminar
	function fmEliminarModulo()
	{
		$sql = "
			DELETE A.*

			FROM tseg_acceso_d AS A

			INNER JOIN tconf_VISTA AS V
				ON A.id_vista_fk = V.id_vista

			INNER JOIN tconf_MODULO AS M
				ON M.id_modulo = V.id_modulo_fk

			WHERE
				M.id_modulo = '{$this->atrFormulario["cmbModulo"]}' AND
				A.nombre_id_rol_fk = '{$this->atrFormulario["cmbTipo_Usuario"]}';";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) //verifica si se ejecuto bien
			return $tupla; //envía el arreglo
		else
			return false;
		//echo "$sql <hr>";
	}



	//función.models.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function fmListarConAcceso($pcBusqueda = "")
	{

		/*$sql = "SELECT V.*, A.id_rol_acceso
				FROM  tcvista  AS V, tsAcceso_rol AS A
				WHERE
					(id_rol_fk = '$this->atrIdRol' AND
					A.id_vista_fk = V.id_vista) AND
					(V.vista LIKE '%%')
				GROUP BY V.id_vista " ; */
		//var_dump($this->atrIdRol);
		$sql = "
			SELECT *
				FROM vseg_RolAcceso
			WHERE
				id_rol = '{$this->atrIdRol}'
				AND	nombre_vista LIKE '%{$pcBusqueda}%'
			GROUP BY id_vista";

		if ($this->atrOrden != "")
			$sql .= " ORDER BY $this->atrOrden $this->atrTipoOrden ";

		$this->atrTotalRegistros = parent::getNumeroFilas(parent::faEjecutar($sql));
		$this->atrPaginaFinal = ceil($this->atrTotalRegistros / $this->atrItems);

		//concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio}, {$this->atrItems} ; ";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	}



	//función.models.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function fmListarSinAcceso($pcBusqueda = "")
	{
		/*
		$sql = "SELECT V.*
				FROM tconf_VISTA AS V
				WHERE
					V.id_vista NOT IN (
						SELECT A.id_vista_fk
						FROM tseg_ACCESO_d AS A) AND
					V.id_vista NOT IN (
						SELECT A.id_vista_fk
						FROM tsAcceso_rol AS A
						WHERE
							A.nombre_id_rol_fk = '$this->atrIdRol'
					) AND
					V.vista LIKE '%$pcBusqueda%' " ;
		//*/

		$sql = "
			SELECT V.*, M.id_modulo, M.nombre_modulo
				FROM tconf_VISTA AS V

			INNER JOIN tconf_MODULO AS M
				ON M.id_modulo = V.id_modulo_fk

			WHERE
				V.id_vista NOT IN (
					SELECT A.id_vista
					FROM vseg_RolAcceso AS A
					WHERE
						A.id_rol = '{$this->atrIdRol}'
				)
				AND
				(V.nombre_vista LIKE '%{$pcBusqueda}%' OR
				V.descripcion_vista LIKE '%{$pcBusqueda}%')" ; //*/

		if ($this->atrOrden != "")
			$sql .= " ORDER BY {$this->atrOrden} {$this->atrTipoOrden} ";

		$piTotalRegistros = parent::getNumeroFilas(parent::faEjecutar($sql));
		$this->atrPaginaFinal = ceil($piTotalRegistros / $this->atrItems);

		//concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio}, {$this->atrItems} ; ";
		//echo "$sql";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	}

	function fmListarBotonSi()
	{
		$sql = "
			SELECT
				V.*, B.id_boton, A.id_rol_acceso, B.nombre_boton, B.descripcion_boton

			FROM tseg_rol_acceso AS A

			LEFT JOIN tconf_VISTA as V
				ON A.id_vista_fk = V.id_vista

			LEFT JOIN tconf_BOTON AS B
				ON A.id_boton_fk = B.id_boton

			WHERE
				V.id_vista = '{$this->atrVista}' AND
				A.id_rol_fk = '{$this->atrIdRol}'
		";
		$tupla = parent::faEjecutar($sql); // Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) {
			return $tupla;
		}
		return false;
	}

	//función.models.Listar Parámetros
	//parámetro.control Termino de búsqueda
	function fmListarBotonNo($pcBusqueda = "")
	{
		$sql = "SELECT * FROM tconf_BOTON; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	}



	/**
	 * @param string $psVista Nombre o URL de la vista
	 * @return integer $arrVista[0] del código según el nombre de la vista
	 * @deprecated FUNCION QUE SE DEJARA DE UTILIZAR POR fmConsultaVista
	 */
	function fmConsultaCodigoVista($psVista)
	{
		$sql = "
			SELECT id_vista
			FROM tconf_VISTA
			WHERE
				url_vista = '{$psVista}'
			LIMIT 1 ";
				//selecciona el contenido de la tabla
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arrVista = parent::getConsultaArreglo($tupla);
			parent::faLiberarConsulta($tupla); //libera de la memoria la consulta obtenida
			return $arrVista["id_vista"];
		}
		else
			return false;
	}



	/**
	 * @param string $psVista Nombre o URL de la vista
	 * @return array $arrVista datos de la vista y el modulo
	 */
	function fmConsultaVista($psVista)
	{
		$sql = "
			SELECT V.*, M.id_modulo, M.nombre_modulo, M.icono_modulo

			FROM tconf_vista AS V

			INNER JOIN tconf_MODULO AS M
				ON M.id_modulo = V.id_modulo_fk

			WHERE
				V.url_vista = '{$psVista}'
			LIMIT 1;
		";
		// selecciona el contenido de la tabla
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		// verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arrVista = parent::getConsultaAsociativo($tupla);
			parent::faLiberarConsulta($tupla); //libera de la memoria la consulta obtenida
			return $arrVista;
		}
		return false;
	}



	/**
	 * @param integer $piRol el código del rol que se le consulta el acceso
	 * @param integer $piVista el código de la vista que se le consulta el acceso
	 * @return bool Si consiguió o no dentro de los registros accesos consultados
	 */
	function fmConsultaAccesoVista($piVista)
	{
		$sql = "
			SELECT V.id_vista

			FROM
				tconf_vista AS V

			LEFT JOIN  tseg_rol_acceso AS AR
				ON AR.id_vista_fk = V.id_vista

			WHERE
				AR.id_rol_fk = '{$_SESSION["id_rol"]}'
				AND V.id_vista = '{$piVista}'

			LIMIT 1 ;
		";
		// selecciona el contenido de la tabla
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			parent::faLiberarConsulta($tupla); //libera de la memoria la consulta obtenida
			return true;
		}
		return false;
	}



	/**
	 * @param integer $piRol el código del rol que se le consulta el acceso
	 * @param integer $piVista el código de la vista que se le consulta el acceso
	 * @param integer $piBoton el código del botón que se le consulta el acceso
	 * @return bool Si consiguió o no dentro de los registros accesos consultados
	 */
	function fmConsultaAccesoBoton($piVista, $piBoton)
	{
		$sql = "
			SELECT
				id_vista, nombre_vista, id_boton, nombre_boton, icono_boton,
				id_rol_acceso

			FROM
				vseg_RolAcceso

			WHERE
				id_rol = '{$_SESSION["id_rol"]}'
				AND id_vista = '{$piVista}'
				AND id_boton = '{$piBoton}'
			LIMIT 1;
		";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			parent::faLiberarConsulta($tupla); //libera de la memoria la consulta obtenida
			return true;
		}
		return false;
	}



	function fmVistaBotonRol($piRol)
	{
		$sql = "
			SELECT id_vista
			FROM vseg_RolAcceso
			WHERE id_rol='{$piRol}'
			GROUP by id_vista ; ";
		//selecciona el contenido de la tabla
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arrRetorna = array();
			$arrBoton = array();
			$viCont = 0;
			//convierte el RecordSet en un arreglo
			while ($arrConsulta = parent::getConsultaArreglo($tupla)) {
				//var_dump($arrConsulta);

				$code = $arrConsulta["id_vista"];
				$name = $arrConsulta["id_vista"];
				$arrRetorna["vista_" . $code] = $name; //a la posición con el código se le asigna el valor del nombre
				$arrBoton = $this->fmBotonRol($piRol, $code);
				$arrRetorna["boton_" . $code] = $arrBoton; //a la posición con el código se le asigna el valor del nombre
				//echo "$viCont";
				$viCont++;
			}
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			//var_dump($arrRetorna);
			return $arrRetorna; //retorna el arreglo creado
		}
		else
			return false;
	}



	function fmVistasRol($piRol)
	{
		$sql = "
			SELECT id_vista, nombre_vista
			FROM vseg_RolAcceso
			WHERE id_rol='{$piRol}'
			GROUP by id_vista ; ";
				//selecciona el contenido de la tabla
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arrRetorna = array();
			$viCont = 0;
			//convierte el RecordSet en un arreglo
			while ($arrConsulta = parent::getConsultaArreglo($tupla)) {
				//var_dump($arrConsulta);

				$code = $arrConsulta["id_vista"];
				$name = $arrConsulta["id_vista"];

				array_push($arrRetorna, array($code => $name, "pera" => 2));

				$arrRetorna["vista_" . $code] = $name; //a la posición con el código se le asigna el valor del nombre
				echo "$viCont";
				$viCont++;
			}
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			//var_dump($arrRetorna);
			return $arrRetorna; //retorna el arreglo creado
		}
		else
			return false;
	}



	function fmBotonRol($piRol, $piVista)
	{
		$sql = "
			SELECT id_boton, nombre_boton
			FROM vseg_RolAcceso
			WHERE
				id_rol='{$piRol}'
				AND id_vista = '{$piVista}';";
		//echo "$sql";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arrRetorna = array();
			//convierte el RecordSet en un arreglo
			while ($arrConsulta = parent::getConsultaArreglo($tupla)) {
				//var_dump($arrConsulta);
				$name = $arrConsulta["nombre_boton"];
				$code = $arrConsulta["id_boton"];

				$arrRetorna[ $code] = $name; //a la posición con el código se le asigna el valor del nombre
				//$arrAhora[ $arrConsulta["id_boton"] ] = $arrConsulta["id_boton"]
				//array_push($arrRetorna, array($code => $name));
			}
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			//var_dump($arrRetorna);
			return $arrRetorna; //retorna el arreglo creado
		}
		else
			return false;
	}



	function fmListarReporte()
	{
		$arrFormulario = $this->atrFormulario;
		$sql = "
			SELECT Rol.nombre_rol, Acc.*, Vis.*, Boton.nombre_boton, Modulo.nombre_modulo
			FROM tsacceso_rol AS Acc
			INNER JOIN tcRol AS Rol
				ON Rol.id_rol = Acc.nombre_id_rol_fk
			INNER JOIN tconf_VISTA AS Vis
				ON Vis.id_vista = Acc.id_vista_fk
			INNER JOIN tconf_BOTON AS Boton
				ON Boton.id_boton = Acc.id_vista_fk
			INNER JOIN tconf_MODULO AS Modulo
				ON Modulo.id_modulo = Vis.id_modulo_fk"; //selecciona todo de la tabla

		$sqlTipoRango = " "; //selecciona solo lo que esta dentro del rango
		if (array_key_exists("radRangoTipo", $arrFormulario)) {
			if ($arrFormulario['radRangoTipo'] == "fuera")
				$sqlTipoRango = " NOT "; //selecciona solo lo que esta fuera del rango
		}

		//define el rango a mostrar
		if (array_key_exists("radRango", $arrFormulario)) {
			switch ($arrFormulario['radRango']) {

				case 'id': //no esta imprimiendo el final
					$sql .= " WHERE $sqlTipoRango (id_rol_acceso >= '" . $arrFormulario["numIdInicio"] . "' ";
					if ($arrFormulario["numIdFinal"] != "") //si el rango final no esta vacio
						$sql .= " AND id_rol_acceso <= '" . $arrFormulario["numIdFinal"] . "' ";
					$sql .= ") ";
					#dentro SELECT * FROM tcmodulo WHERE ($this->atrId_P >= '3' AND $this->atrId_P <= '5')
					#fuera SELECT * FROM tcmodulo WHERE NOT ($this->atrId_P >= '3' AND $this->atrId_P <= '5')
					break;

				// MEJORAR LA CONSULTA POR RANGO DE NOMBRES
				case 'modulo': //no esta imprimiendo el final
					$sql .= " WHERE $sqlTipoRango (id_modulo_fk >= '" . $arrFormulario["cmbModuloInicial"] . "' ";
					if ($arrFormulario["cmbModuloFinal"] != "") //si el rango final no esta vacio
						$sql .= " AND id_modulo_fk <= '" . $arrFormulario["cmbModuloFinal"] . "' ";
					$sql .= ") ";
					#dentro SELECT * FROM tcmodulo WHERE ($this->atrId_P >= '3' AND $this->atrId_P <= '5')
					#fuera SELECT * FROM tcmodulo WHERE NOT ($this->atrId_P >= '3' AND $this->atrId_P <= '5')
					break;

				case 'boton': //no esta imprimiendo el final
					$sql .= " WHERE $sqlTipoRango (id_vista_fk >= '" . $arrFormulario["cmbBotonInicial"] . "' ";
					if ($arrFormulario["cmbBotonFinal"] != "") //si el rango final no esta vacio
						$sql .= " AND id_vista_fk <= '" . $arrFormulario["cmbBotonFinal"] . "' ";
					$sql .= ") ";
					#dentro SELECT * FROM tcmodulo WHERE ($this->atrId_P >= '3' AND $this->atrId_P <= '5')
					#fuera SELECT * FROM tcmodulo WHERE NOT ($this->atrId_P >= '3' AND $this->atrId_P <= '5')
					break;

				case 'estatus':
					$sql .= " WHERE $sqlTipoRango
						(estatus_acceso_rol LIKE '" . $arrFormulario["cmbEstatusInicial"] ."%'
						AND estatus_acceso_rol LIKE '" . $arrFormulario["cmbEstatusFinal"] ."%') ";
					break;
			}
		}

		//define el atributo en que se ordena y de que forma
		if (array_key_exists("cmbOrden", $arrFormulario))
			$sql .= " ORDER BY " . $arrFormulario['cmbOrden'] . " " .  $arrFormulario['radOrden'];
		// var_dump($sql);

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		// var_dump($tupla);
		if (parent::faVerificar($tupla)){
			return $tupla;

		}
		else
			return false;
	} //cierre de la función



} //cierre de la clase

?>
