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


class clsPais extends Connection
{
	//variables de la tabla y clase
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

		$this->atrClase = "pais";
		$this->atrTabla = "tglo_" . strtoupper($this->atrClase); //tabla principal de la Clase
		$this->atrId_P = "id_" . $this->atrClase; //clave primaria de esta tabla
		$this->atrId_F = $this->atrId_P . "_fk"; //clave foránea en otras tablas
		$this->atrNombre = "nombre_" . $this->atrClase;
		$this->atrEstatus = "estatus_" . $this->atrClase;
		$this->atrCondicion = "condicion_" . $this->atrClase;
		$this->atrDescripcion = "nombre_oficial_pais";

		$this->atrTablasRelacionadas = array(
			array(
				"tabla" => "tconf_BOTON_VISTA_d",
				"id" => "id_vista_boton",
				"estatus" => "estatus_vista_boton"
			)
		); //id dependiente o padre

		$this->atrId_Superior = array(); //id dependiente o padre
		$this->atrId_Recursivo = $this->atrClase . "_superior_fk"; //id dependiente o padre en su misma tabla

		$this->atrFormulario = array();
	} //cierre de la función



	/**
	 * Función models Insertar, agrega nuevos registros en la tabla de esta clase
	 * @return bool $tupla del estatus si agrego en la base de datos
	 */
	function fmInsertar()
	{
		try {
			$sql = "
				INSERT INTO {$this->atrTabla} (
					{$this->atrNombre}
				)
				VALUES (?);";
			//envía el sql y un arreglo con los parámetros
			$tupla = parent::ejecutar(
				$sql,
				[
					$this->atrFormulario["ctxNombre"]
				]
			);
			//console::log("mensaje de la consola del navegador sobre el estatus: " . $tupla);
			return $tupla; //envía el arreglo
		}
		catch (Exception $e) {
			//console::log("mensaje de la consola del navegador sobre el error: " . $e->getMessage());
			return false;
		}
	} //cierre de la función



	/**
	 * Función models Actualizar, modifica registros existentes en la tabla de esta clase
	 * @return bool $tupla del estatus si modifico en la base de datos
	 */
	function fmActualizar()
	{
		try {
			$sql = "
				UPDATE {$this->atrTabla}
				SET
					{$this->atrNombre} = ?
				WHERE
					{$this->atrId_P} = ?; ";
			//envía el sql y un arreglo con los parámetros
			$tupla = parent::ejecutar(
				$sql,
				[
					$this->atrFormulario["ctxNombre"]
				]
			);
			//console::log("mensaje de la consola del navegador sobre el estatus: " . $tupla);
			return $tupla; //envía el arreglo
		} //cierre del try
		catch (Exception $e) {
			//console::log("mensaje de la consola del navegador sobre el error: " . $e->getMessage());
			return false;
		} //cierre del catch
	} //cierre de la función actualizar



	//función.models.Consultar
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
	} //cierre de la función


	//función.models.Consultar
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
	} //cierre de la función



	/**
	 * función models Listar, consulta en la base de datos según el código de búsqueda, usado para los combos
	 * @param string $psCod_padre, si existe un código para filtrado
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListar($psCod_padre = "")
	{
		$sql = "
			SELECT * FROM {$this->atrTabla}
			WHERE
				{$this->atrEstatus} = 'activo'"; //selecciona todo de la tabla
		if ($psCod_padre != "") {
			$sql .= " {$this->atrId_Superior} = {$psCod_padre} ; "; //selecciona todo de la tabla
		}
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) //verifica si se ejecuto bien
			return $tupla;
		else
			return false;
	} //cierre de la función



	/**
	 * función models Listar Vista, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parámetro control Búsqueda $pcBusqueda, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE.
	 */
	function fmListarIndexPais($pcBusqueda = "")
	{
		$sql = "
			SELECT *
			FROM {$this->atrTabla}

			WHERE
				{$this->atrEstatus} = 'activo' AND
				({$this->atrNombre} LIKE '%{$this->atrFormulario["setBusqueda"]}%' OR
				{$this->atrId_P} LIKE '%{$this->atrFormulario["setBusqueda"]}%') "; //selecciona todo de la tabla

		if ($this->atrOrden != "")
			$sql .= " ORDER BY {$this->atrOrden} {$this->atrTipoOrden} ";
		else
			$sql .= " ORDER BY {$this->atrId_P} ASC ";

		$piTotalRegistros = parent::getNumeroFilas(parent::faEjecutar($sql));
		$this->atrPaginaFinal = ceil($piTotalRegistros / $this->atrItems);

		//$objeto->atrPaginaInicio = ($vpPaginaActual -1) * $objeto->atrItems;
		//concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio}, {$this->atrItems};";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	} //cierre de la función



	//función.models.Listar Reporte
	//devuelve la consulta con los parámetros de rango y ordenado que se le indiquen
	function fmListarReporte()
	{
		$sql = "SELECT * FROM {$this->atrTabla}"; //selecciona todo de la tabla
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
					if ($this->atrFormulario["numIdFinal"] != "") //si el rango final no esta vació
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
	} //cierre de la función



} //cierre de la clase

?>
