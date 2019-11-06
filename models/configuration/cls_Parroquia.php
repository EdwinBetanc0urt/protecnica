<?php


if (! defined("DS"))
	define("DS", DIRECTORY_SEPARATOR); //define ell separador de rutas en windows \ en basados en Unix /


if (is_file("models" . DS . "_core" . DS . "cls_Connection.php")) {
	require_once("models" . DS . "_core" . DS . "cls_Connection.php");
}
elseif (is_file(".." . DS . "models" . DS . "_core" . DS . "cls_Connection.php")) {
	require_once(".." . DS . "models" . DS . "_core" . DS . "cls_Connection.php");
}
else {
	require_once(".." . DS . ".." . DS . "models" . DS . "_core" . DS . "cls_Connection.php");
}


class clsParroquia extends Connection
{
	//variables de la tabla y clase
	protected $atrTabla, $atrClase;

	//campos de la tabla
	public $atrId_P, $atrId_F, $atrNombre, $atrEstatus, $atrCondicion, $atrDescripcion;


	/**
	 * constructor de la clase
	 * @param ineger $piPrivilegio que dependiendo el privilegio usa el usuario para la conexión
	 */
	function __construct($piPrivilegio = 2)
	{
		parent::__construct($piPrivilegio); //instancia al constructor padre

		$this->atrClase = "parroquia";
		$this->atrTabla = "tglo_" . strtoupper($this->atrClase); //tabla principal de la Clase
		$this->atrId_P = "id_" . $this->atrClase; //clave primaria de esta tabla
		$this->atrId_F = $this->atrId_P . "_fk"; //clave foranea en otras tablas
		$this->atrNombre = "nombre_" . $this->atrClase ;
		$this->atrEstatus = "estatus_" . $this->atrClase ;
		$this->atrCondicion = "condicion_" . $this->atrClase ;
		$this->atrDescripcion = "descripcion_" . $this->atrClase ;

		$this->atrTablasRelacionadas = array(
			array(
				"tabla" => "tconf_BOTON_VISTA_d",
				"id" => "id_det_vista_boton",
				"estatus" => "estatus_det_vista_boton"
			)
		); //id dependiente o padre

		$this->atrId_Superior = "id_municipio_fk" ; //id dependiente o padre
		$this->atrId_Recursivo = "" ; //id dependiente o padre en su misma tabla

		$this->atrFormulario = array();
	}



	/**
	 * Funcion models Insertar, agrega nuevos registros en la tabla de esta clase
	 * @return bool $tupla del estatus si agrego en la base de datos
	 */
	function fmInsertar()
	{
		try {
			$sql = "
				INSERT INTO {$this->atrTabla}
					({$this->atrNombre}, {$this->atrDescripcion}, icono_boton)
				VALUES (?, ?, ?);";
			//envia el sql y un arreglo con los parametros
			$tupla = parent::ejecutar(
				$sql,
				[
					$this->atrFormulario["ctxNombre"],
					$this->atrFormulario["ctxDescripcion"],
					$this->atrFormulario["ctxIcono"]
				]
			);
			//console::log("mensaje de la consola del navegador sobre el estatus: " . $tupla);
			return $tupla; //envia el arreglo

		}
		catch (Exception $e) {
			//console::log("mensaje de la consola del navegador sobre el error: " . $e->getMessage());
			return false;
		}
	}



	/**
	 * Funcion models Actualizar, modifica registros existentes en la tabla de esta clase
	 * @return bool $tupla del estatus si modifico en la base de datos
	 */
	function fmActualizar()
	{
		try {
			$sql = "
				UPDATE {$this->atrTabla}
				SET
					{$this->atrNombre} = ?,
					{$this->atrDescripcion} = ?,
					icono_boton = ?
				WHERE
					{$this->atrId_P} = ?; ";
			//envia el sql y un arreglo con los parametros
			$tupla = parent::ejecutar(
				$sql,
				[
					$this->atrFormulario["ctxNombre"],
					$this->atrFormulario["ctxDescripcion"],
					$this->atrFormulario["ctxIcono"],
					$this->atrFormulario["numId"]
				]
			);
			//console::log("mensaje de la consola del navegador sobre el estatus: " . $tupla);
			return $tupla; //envia el arreglo
		} //cierre del try
		catch (Exception $e) {
			console::log("mensaje de la consola del navegador sobre el error: " . $e->getMessage());
			return false;
		} //cierre del catch
	} //cierre de la funcion actualizar



	//funcion.models.Consultar
	function fmConsultar()
	{
		$sql = "
			SELECT * FROM {$this->atrTabla}
			WHERE
				{$this->atrId_P} = {$this->atrFormulario["numId"]}' OR
				{$this->atrNombre} = '{$this->atrFormulario["ctxNombre"]}'
			LIMIT 1;";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arreglo = parent::getConsultaArreglo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}


	//funcion.models.Consultar
	function fmConsultarModificar()
	{
		$sql = "
			SELECT * FROM {$this->atrTabla}
			WHERE
				{$this->atrNombre} = '{$this->atrFormulario["ctxNombre"]}'
			LIMIT 1;";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			$arreglo = parent::getConsultaArreglo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	}



	/**
	 * función models Listar, consulta en la base de datos según el codigo de busqueda, usado para los combos
	 * @param string $psCod_padre, si existe un codigo para filtrado
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListar($psCod_padre = "")
	{
		$sql = "
			SELECT * FROM {$this->atrTabla}
			WHERE
				{$this->atrEstatus} = 'activo'"; //selecciona todo de la tabla
		if ($psCod_padre != "") {
			$sql .= "AND {$this->atrId_Superior} = '{$psCod_padre}' ; "; //selecciona todo de la tabla
		}
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	}



	//función.models.Listar Reporte
	//devuelve la consulta con los parametros de rango y ordenado que se le indiquen
	function fmListarReporte()
	{
		$sql = "SELECT P.*,  M.nombre_municipio AS municipio, E.nombre_estado AS estado FROM {$this->atrTabla} AS P
					INNER JOIN tglo_MUNICIPIO AS M ON P.id_municipio_fk = M.id_municipio
					INNER JOIN tglo_ESTADO AS E ON M.id_estado_fk = E.id_estado"; //selecciona todo de la tabla
		$sqlTipoRango = " "; //selecciona solo lo que esta dentro del rango
		if (array_key_exists("radRangoTipo", $this->atrFormulario)) {
			if ($this->atrFormulario['radRangoTipo'] == "fuera")
				$sqlTipoRango = " NOT "; //selecciona solo lo que esta fuera del rango
		}

		//define el rango a mostrar
		if (array_key_exists("radRango", $this->atrFormulario)) {
			switch ($this->atrFormulario['radRango']) {

				case 'id': //no esta imprimiendo el final
					$sql .= " WHERE {$sqlTipoRango}
						({$this->atrId_P} >= '{$this->atrFormulario["numIdInicio"]}' ";
					if ($this->atrFormulario["numIdFinal"] != "") //si el rango final no esta vacio
						$sql .= " AND {$this->atrId_P} <= '{$this->atrFormulario["numIdFinal"]}' ";
					$sql .= ") ";
					break;

				// MEJORAR LA CONSULTA POR RANGO DE NOMBRES
				case 'nombre':
					$sql .= " WHERE ({$this->atrNombre} $sqlTipoRango BETWEEN
						'{$this->atrFormulario["cmbNombreInicial"]}%'
						AND '{$this->atrFormulario["cmbNombreFinal"]}%') ";
					break;

				case 'estatus':
					$sql .= " WHERE $sqlTipoRango
						({$this->atrEstatus} LIKE '{$this->atrFormulario["cmbEstatusInicial"]}'
						AND {$this->atrEstatus} LIKE '{$this->atrFormulario["cmbEstatusFinal"]}') ";
					break;
			}
		}

		//define el atributo en que se ordena y de que forma
		if (array_key_exists("cmbOrden", $this->atrFormulario))
			$sql .= " ORDER BY {$this->atrFormulario['cmbOrden']} {$this->atrFormulario['radOrden']} ";

		// var_dump($sql);
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	} //cierre de la funcion



	/**
	 * función models Listar Vista, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parametro control Busqueda $pcBusqueda, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndexParroquia($pcBusqueda = "")
	{

		$sql = "
			SELECT
				P.*, M.id_municipio, M.nombre_municipio,
				E.id_estado, E.nombre_estado, Pa.id_pais, Pa.nombre_pais

			FROM tglo_parroquia AS P

			LEFT JOIN tglo_MUNICIPIO AS M
				ON P.id_municipio_fk = M.id_municipio

			LEFT JOIN tglo_ESTADO AS E
				ON M.id_estado_fk = E.id_estado

			LEFT JOIN tglo_PAIS AS Pa
				ON E.id_pais_fk = Pa.id_pais

			WHERE
				{$this->atrEstatus} = 'activo' AND
				({$this->atrNombre} LIKE '%{$this->atrFormulario["setBusqueda"]}%' OR
				{$this->atrId_P} LIKE '%{$this->atrFormulario["setBusqueda"]}%') "; //selecciona todo de la tabla

		if ($this->atrOrden != "")
			$sql .= " ORDER BY $this->atrOrden $this->atrTipoOrden ";
		else
			$sql .= " ORDER BY {$this->atrId_P} ASC ";
		$piTotalRegistros = parent::getNumeroFilas(parent::faEjecutar($sql));
		$this->atrPaginaFinal = ceil($piTotalRegistros / $this->atrItems);

		//$objeto->atrPaginaInicio = ($vpPaginaActual -1) * $objeto->atrItems;
		//concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio}, {$this->atrItems} ; ";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	}



} //cierre de la clase

?>
