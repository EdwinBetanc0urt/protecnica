<?php

//define el separador de rutas en Windows \ y basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

if (strlen(session_id()) < 1) {
	session_start();
}


$relativePath = "";
//toma como referencia la ruta de la configuración
if (is_file("_core" . DS . "config_connection.php")) {
	$relativePath = "";
}
elseif (is_file(".." . DS . "_core" . DS . "config_connection.php")) {
	$relativePath = ".." . DS;
}
else {
	$relativePath = ".." . DS . ".." . DS;
}

//incluye la configuración Global
require_once($relativePath . "_core" . DS . "config_global.php");
require_once($relativePath . "_core" . DS . "config_connection.php");

//incluye la librería para encriptacion de claves
require_once($relativePath . "public" . DS . "libs" . DS . "lib_Cifrado.php");

//incluye la librería para AGENT USER y datos del cliente
require_once($relativePath . "public" . DS . "libs" . DS . "lib_Agente.php");

//incluye la librería FPDF para generar archivos *.PDF
require_once($relativePath . "public" . DS . "libs" . DS . "FPDF" .  DS . "fpdf.php");

//incluye la librería mPDF para generar archivos *.PDF con código HTML
require_once($relativePath . "public" . DS . "libs" . DS . "mPDF-v6.1.0" .  DS . "mpdf.php");


// Clase de Abstracción de la Base de Datos utilizando PDO
abstract class Connection
{

	/*******************	Propiedades de la clase		********************/
		/**
		 * @desc nombre del usuario de la base de datos
		 * @var str $atrServidor
		 * @access private
		 */
		private $atrServidor;

		/**
		 * @desc nombre del usuario de la base de datos
		 * @var str $atrUsuario
		 * @access private
		 */
		private $atrUsuario;

		/**
		 * @desc clave del usuario de la base de datos
		 * @var str $atrClave
		 * @access private
		 */
		private $atrClave;

		/**
		 * @desc str nombre de la base de datos a conectarse
		 * @var $atrBaseDatos
		 * @access private
		 */
		private $atrBaseDatos;

		/**
		 * @desc instancia o conexión, generalmente $link
		 * @var obj $atrConexion
		 * @access protected
		 */
		protected $atrConexion;

		/**
		 * @desc hash para el cifrado
		 * @var str $atrLlaveMaestra
		 * @access public
		 */
		public $atrLlaveMaestra;


		//atributos de paginación
		public $atrItems, $atrTotalRegistros, $atrPaginaInicio, $atrPaginaActual,
			$atrPaginaFinal, $atrOrden, $atrTipoOrden;
	/*******************	Propiedades de la clase 	********************/


	/**
	 * función constructor de la clase
	 * @param string $psPrivilegio que dependiendo el privilegio usa el usuario para la conexión
	 */
	protected function __construct($psPrivilegio = "")
	{
		// archivo para la configuración de la conexión del servidor DE la base de datos
		// require_once($relativePath . "_core" . DS . "config_connection.php");

		$this->atrServidor = SERVER; //atributo Servidor de Base de Datos
		$this->atrPuerto_Db = PORT; //atributo puerto de Base de Datos

		$this->atrUsuario = USER; //atributo Usuario
		$this->atrClave = PASSWORD; //atributo Clave
		$this->atrBaseDatos = DB;  //atributo Base de Datos

		$this->atrLlaveMaestra = PRIVATE_KEY; //atributo Llave Maestra
		$this->atrConexion = $this->faConectar(); //atributo de Conexión o link
	} //cierre de la función constructor

	//función abstracta Conectar, conecta SMDB y BD
	private function faConectar()
	{
		try {
			//header("charset=utf-8");
			$objPDO = new PDO("mysql:
				host={$this->atrServidor};
				port={$this->atrPuerto_Db};
				dbname={$this->atrBaseDatos};
				charset=utf8",
				"{$this->atrUsuario}", "{$this->atrClave}");
			$objPDO->exec("set names " . CHART);
			return $objPDO;
		}
		catch (PDOException $e) {
			//header("Content-Type: text/html; charset=utf-8");
			//var_dump(PDO::getAvailableDrivers());
			die (
				"<!DOCTYPE html>
				<html lang='es'>
					<head>
						<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
					</head>
					<body>
						<br /><br />
						<h1>Error al Realizar la Conexión con el Servidor, </h1>
						<h3>
							Utilice el siguiente error y contacte al soporte técnico para la pronta solución:
						</h3>
						<br /><br />
						<hr />
						<li>
							<h3>" . $e->getMessage() . "</h3>
						</li>
					</body>
				</html>"
			);
			return false;
		}
	} //cierre de la función



	//función abstracta LLave Maestra, contiene la clave maestra de cifrado y descifrado de datos
	protected function faLLaveMaestra()
	{
		return $this->atrLlaveMaestra; //retorna la llave maestra a la librería de cifrado
	} //cierre de la función
	//función abstracta LLave Maestra, contiene la clave maestra de cifrado y descifrado de datos
	static function privateKey()
	{
		return PRIVATE_KEY; //retorna la llave maestra a la librería de cifrado
	} //cierre de la función



	/**
	 * función que envía y sanea los datos del controllers al constructor en conjunto con la función sanearFormulario
	 * que detectan cuando hay un arreglo y lo recorre para limpiarlo, es decir existe un arreglo multidimensional
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @param array parámetro control Formulario $pcForm, trae todo lo enviado de la vista mediante el arreglo global $_POST
	 * @return array atributo $this->atrFormulario, arreglo agregado al constructor con todos los valores y quitando las primeras 3 letras de la clave
	 */
	public function setFormulario($pcForm)
	{
		foreach ($pcForm as $clave => $valor) {
			//$clave_new = substr($clave, 3);
			$clave_new = $clave ;

			if (is_array($pcForm[$clave])) {
				$this->atrFormulario[$clave_new] = $this->sanearSubFormulario($pcForm[$clave]);
			}
			else {
				//la clave es igual a ctxRuta sanea de forma diferente
				if ($clave == "pswClave" || $clave == "ctxRuta" || $clave == "ctxRespuesta"
					|| $clave == "ctxRespuesta1" || $clave == "ctxRespuesta2" ) {
					//sanea pero sin pasar a minúsculas ya que la ruta es sensible
					$this->atrFormulario[$clave] = htmlentities(
						trim(addslashes( $valor ) )
					);
				}
				else {
					//la clave debe ser diferente a setBusqueda, ya que de lo contrario
					//se debe modificar todos los controllerses y pasar el termino de
					//búsqueda como parámetro para el fmListarIndex de los modelss
					if ($valor == "" AND $clave != "setBusqueda") {
						$this->atrFormulario[$clave_new] = NULL;
					}
					else {
						$this->atrFormulario[$clave_new] = htmlentities(
							strtoupper(addslashes(trim($pcForm[$clave])))
						);
					}
				}
			}
		}
	} //cierre de la función
	public function sanearSubFormulario($pcForm)
	{
		$arrFormulario = array();
		foreach ($pcForm as $clave => $valor) {
			//$clave_new = substr($clave, 3);
			$clave_new = $clave ;

			if (is_array($pcForm[$clave])) {
				$arrFormulario[$clave_new] = $this->sanearSubFormulario($pcForm[$clave]);
			}
			else {
				if ($valor == "")
					$arrFormulario[$clave_new] = NULL;
				else
					$arrFormulario[$clave_new] = htmlentities(strtoupper(addslashes(trim($pcForm[$clave]))));
			}
		}
		return $arrFormulario;
	} //cierre de la función



	//delete data in any table in the database
	public function fmEliminarF2($psValor, $psColumna = "")
	{
		if ($psColumna == "") {
			$psColumna = $this->atrId_P;
		}
		$sql = "
			DELETE FROM {$this->atrTabla}
			WHERE
				{$psColumna} = '{$psValor}' ; ";

		return $this->faEjecutar($sql);
	} //cierre de la función

	//función.models.Eliminar
	function fmEliminarF()
	{
		try {
			$sql = "
				DELETE FROM
					{$this->atrTabla}
				WHERE
					{$this->atrId_P} = ?;";
			//envia el sql y un arreglo con los parámetros
			$tupla = parent::ejecutar(
				$sql,
				[
					$psEstatus,
					$this->atrFormulario["numId"]
				]
			);
			//console::log("mensaje de la consola del navegador sobre el estatus: " . $tupla);
			return $tupla; //envía el arreglo
		} //cierre del try
		catch (Exception $e) {
			//console::log("mensaje de la consola del navegador sobre el error: " . $e->getMessage());
			return false;
		} //cierre del catch
	} //cierre de la función eliminar




	//delete data in any table in the database
	//ELIMINAR FUNCION
	public function faEliminar()
	{
		$sql = "
			UPDATE {$this->atrTabla}
			SET
				{$this->atrEstatus} = 'inactivo',
				idusuario = {$_SESSION["id_usuario"]}
			WHERE
				{$this->atrId_P} = '{$this->atrFormulario["numId"]}' ; ";
		return $this->faEjecutar($sql);
	} //cierre de la función



	/**
	 * Función models Eliminar, Restaurar, elimina lógicamente de la base de datos
	 * @param string $psEstatus valor nuevo a modificar
	 * @return bool $tupla del estatus si modifico en la base de datos
	 */
	public function fmCambiarEstatus($psEstatus = "inactivo")
	{
		try {
			$sql = "
				UPDATE {$this->atrTabla}
				SET
					{$this->atrEstatus} = ?,
					idusuario =  ?
				WHERE
					{$this->atrId_P} = ?;";
			//echo "$sql";
			//envia el sql y un arreglo con los parámetros
			$tupla = $this->ejecutar(
				$sql,
				[
					$psEstatus,
					$_SESSION["id_usuario"],
					$this->atrFormulario["numId"]
				]
			);
			//console::log("mensaje de la consola del navegador sobre el estatus: " . $tupla);
			return $tupla; //envía el arreglo
		} //cierre del try
		catch (Exception $e) {
			////console::log("mensaje de la consola del navegador sobre el error: " . $e->getMessage());
			return false;
		} //cierre del catch
	} //cierre de la función eliminar




	/**
	 * función abstracta Desconectar, cierra la conexión actual
	 * @return boolean, Dependiendo si se cerro o no la conexión actual con el servidor
	 * @param link, o enlace de conexión (tomado directamente del constructor)
	 */
	public function faDesconectar()
	{
		$this->atrConexion = null;
	} //cierre de la función



	/**
	 * función abstracta Liberar Consulta, libera de la memoria del servidor los resultados obtenidos
	 * @param object $pmConsulta, tupla o recordset (solo con SELECT)
	 */
	public function faLiberarConsulta($pmConsulta)
	{
		return  $pmConsulta->closeCursor();
	} //cierre de la función



	//función abstracta Ejecutar, ejecuta cualquier operación en la base de datos
	//parámetro string SQL
	protected function faEjecutar($psSQL)
	{
		//$vbConexion = $this->faConectar();
		//$vbConexion = $this->atrConexion;
		//return $vbConexion->query($pmSql);
		return $this->atrConexion->query($psSQL);
	} //cierre de la función


	/**
	 * función abstracta Desconectar, cierra la conexión actual
	 * @param object, de la conexión con la consulta preparada
	 * @return boolean, Dependiendo si se cerro o no la conexión actual con el servidor
	 */
	public function ejecutar($psSQL, $paParametros)
	{
		$poStmt = $this->atrConexion->prepare($psSQL);
		return $poStmt->execute($paParametros);
	} //cierre de la función


	/**
	 * función abstracta Desconectar, cierra la conexión actual
	 * @param string, de la consulta SQL
	 * @return boolean, Dependiendo si se cerro o no la conexión actual con el servidor
	 */
	protected function preparar($psSQL)
	{
		return $this->atrConexion->prepare($psSQL);
	} //cierre de la función



	/**
	 * función abstracta Desconectar, cierra la conexión actual
	 * @param object, de la conexión con la consulta preparada
	 * @return boolean, Dependiendo si se cerro o no la conexión actual con el servidor
	 */
	public function ejecuta_preparada($poStmt, $paParametros)
	{
		return $poStmt->execute($paParametros);
	} //cierre de la función



	// función abstracta Verificar, verifica si las operaciones Inc, Con, Mod, Eli se ejecutan bien
	public function faVerificar($pcTupla = "")
	{
		if ($pcTupla == false) {
			return $pcTupla;
		}
		if ($pcTupla->rowCount() > 0)  {
			return true; // retorna verdadero
		}
		return false; // retorna falso si no se afecto ninguna columna
	} // cierre de la función



	/******************************************************************************
						FUNCIONES RELACIONADAS A CONSULTAS
	*******************************************************************************/


	/**
	 * función que devuelve los datos de una consulta en arreglo
	 * @param object $pmRecordSet, tupla o recordset (que fue obtenida mediante un SELECT)
	 * @return array asociativos por nombre de indice y asociados por numero (o posición) de indice
	 */
	public function getConsultaArreglo($pmRecordSet)
	{
		//return mysqli_fetch_array($pmRecordSet);
		return $pmRecordSet->fetch(PDO::FETCH_BOTH);
	} //cierre de la función



	/**
	 * función que devuelve los datos de una consulta en arreglo
	 * @param object $pmRecordSet, tupla o recordset (que fue obtenida mediante un SELECT)
	 * @return array asociativos por por numero (o posición) de indice
	 */
	public function getConsultaNumerico($pmRecordSet)
	{
		//return mysqli_fetch_array($pmRecordSet);
		$result = $pmRecordSet->fetch(PDO::FETCH_NUM);
		$pmRecordSet->closeCursor();
		return $result;
	} //cierre de la función



	/**
	 * función que devuelve los datos de una consulta en arreglo
	 * @param object $pmRecordSet, tupla o recordset (que fue obtenida mediante un SELECT)
	 * @return array asociativos por nombre de indice
	 */
	public function getConsultaAsociativo($pmRecordSet)
	{
		//return mysqli_fetch_array($pmRecordSet);
		return $pmRecordSet->fetch(PDO::FETCH_ASSOC);
	} //cierre de la función



	/**
	 * FUNCION NO USADA
	 * función que devuelve los datos de una consulta en arreglo
	 * @param object sql, $pmRecordSet, tupla o recordset (que fue obtenida mediante un SELECT)
	 * @return object sql integger, devuelve el numero total de filas en esa consulta
	 */
	public function getCuentaColumnas($pmRecordSet)
	{
		//return mysqli_fetch_lengths($pmRecordSet);
		return $pmRecordSet->fetchColumn();
	} //cierre de la función



	/**
	 * función que devuelve los datos de una consulta en arreglo
	 * utilizada al hacer la paginación de los listados
	 * @param object $pmRecordSet, tupla o recordset (que fue obtenida mediante un SELECT)
	 * @return devuelve el numero total de filas en esa consulta del parámetro enviado
	 */
	public function getNumeroFilas($pmRecordSet)
	{
		return $pmRecordSet->rowCount();
		//return mysqli_num_rows($pmRecordSet);
	} //cierre de la función


	/***************************************************************************************
						FUNCIONES RELACIONADAS A TRANSACCIONES
	***************************************************************************************/



	//función abstracta Ultimo ID, funciona solo para las clave primaria INT y autoincrementables
	//parámetro models SQL
	public function faUltimoId($psSql, $paParametros = null)
	{
		$poStmt = $this->atrConexion->prepare($psSql);
		$poStmt->execute($paParametros);
		return $this->atrConexion->lastInsertId();
	} //cierre de la función

	//función abstracta Ultimo ID, funciona solo para las clave primaria INT
	// y autoincrementablesparámetro models SQL
	public function getUltimoId($psSql, $paParametros = null)
	{
		$poStmt = $this->atrConexion->prepare($psSql);
		$poStmt->execute($paParametros);
		return $this->atrConexion->lastInsertId();
	} //cierre de la función

	//función abstracta Ultimo ID, funciona solo para las clave primaria INT y autoincrementables
	public function faUltimoId2($pmSql) //parámetro models SQL
	{
		$pmSql .= " SELECT @@identity AS id ; ";
		$RecordSet = $this->faEjecutar($pmSql);
		//return mysqli_fetch_array($RecordSet); // se ejecuta el query
		return $pmSql; // se ejecuta el query
	} //cierre de la función

	/**
	 * función models Ultimo Código, toma el identificador mas alto de la tabla y lo devuelve convertido en arreglo
	 * @return array atributo $arrConsulta, arreglo con la clave [id] o [0] y el valor tomado de la base de datos
	 */
	public function fmUltimoCodigo()
	{
		$sql = "
			SELECT
				MAX({$this->atrId_P}) AS id
			FROM
				{$this->atrTabla} ; ";
		$tupla = $this->faEjecutar($sql); //Ejecuta la sentencia sql
		$arrConsulta = $this->getConsultaNumerico($tupla); //convierte el RecordSet en un arreglo numérico
		$this->faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
		return $arrConsulta; //sino encuentra nada devuelve un cero en el arreglo
	} //cierre de la función



	/**
	 * Función models CuentaUsados, registros en otras tablas relacionadas que han usado este registro
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 * @return array $arreglo cantidad de registros en un entero
	 */
	function fmCuentaUsados()
	{
		$tam = count($this->atrTablasRelacionadas);
		$liCont = 0;
		$sql = " SELECT (";

		foreach ($this->atrTablasRelacionadas as $laValor) {
			$liCont++;
			$sql .= "
				(SELECT COUNT(*) FROM {$laValor["tabla"]}

				WHERE
					{$laValor["tabla"]}.{$this->atrId_F} = {$this->atrFormulario["numId"]}
					AND
					{$laValor["tabla"]}.{$laValor["estatus"]} = 'activo') ";
			if ($liCont < $tam) {
				$sql .= " + ";
			}
		}
		$sql .= "
			) AS UsoTotal
			LIMIT 1 ;"; //suma todas las veces que ha encontrado el registro en las diferentes tablas
		// echo $sql;
		$tupla = $this->faEjecutar($sql); //Ejecuta la sentencia sql
		$arreglo = $this->getConsultaArreglo($tupla); //convierte el RecordSet en un arreglo
		$this->faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
		return $arreglo; //devuelve las veces que ha sido usado, sino encuentra nada devuelve un cero*/
	} //cierre de la función



	//función abstracta Transacción Inicio
	public function faTransaccionInicio()
	{
		//$this->beginTransaction(); //indica el comienzo de la transacción
		$this->atrConexion->beginTransaction(); //indica el comienzo de la transacción
		//$this->fmEjecutar("BEGIN"); //indica el comienzo de la transacción
	} //cierre de la función


	//función abstracta Transacción Inicio
	public function faTransaccionFin()
	{
		//$this->commit(); //indica que la transacción culmino
		$this->atrConexion->commit(); //indica que la transacción culmino
	} //cierre de la función



	//función abstracta Transacción Deshace
	public function faTransaccionDeshace()
	{
		$this->atrConexion->rollBack();//devuelve al estado anterior del inicio de la transacción cada cambio hecho
	} //cierre de la función


	//parámetro del models FechaBD
	/**
	 * @author Edwin Betancourt <EdwinBetanc0urt@hotmail.com>
	 */
	public function faFechaFormato($pmFecha = "", $pmFormatoE = "amd", $pmFormatoR = "dma")
	{
		if ($pmFecha == "") {
			return NULL;
		}
		else {
			switch ($pmFormatoE) {
				default:
				case 'dma':
					$lsDia = substr($pmFecha, 0, 2);
					$lsMes = substr($pmFecha, 3, 2);
					$lsAno = substr($pmFecha, 6, 4);
					break;

				case 'amd':
					$lsDia = substr($pmFecha, 8, 2);
					$lsMes = substr($pmFecha, 5, 2);
					$lsAno = substr($pmFecha, 0, 4);
					break;

				case 'mda':
					$lsDia = substr($pmFecha, 3, 2);
					$lsMes = substr($pmFecha, 0, 2);
					$lsAno = substr($pmFecha, 6, 4);
					break;
			}
		}

		switch ($pmFormatoR) {
			default:
			case 'amd':
				// 2016 - 10 - 23
				$lsFecha = $lsAno . "-" . $lsMes . "-" . $lsDia;
				break;

			case 'dma':
				// 23 - 10 - 2016
				$lsFecha = $lsDia . "-" . $lsMes . "-" . $lsAno;
				break;

			case 'mda':
				// 10 - 23 - 2016
				$lsFecha = $lsMes . "-" . $lsDia . "-" . $lsAno;
				break;

			case 'am':
				// 10 - 23 - 2016
				$lsFecha = $lsAno . "-" . $lsMes;
				break;
		}
		return $lsFecha;
	} //cierre de la función

} //cierre de la clase



// Clase para imprimir en la consola del navegador
class console
{
	//función estática se accede de la forma console::log($mensaje);
	public static function log($psMensaje = "PHP consola", $psTipo = "log")
	{
		$lsMensaje = json_encode($psMensaje);
		echo "
			<script type='text/javascript'>
				console.{$psTipo}('{$lsMensaje}');
			</script>
		";
	} //cierre de la función
} //cierre de la clase


/*
//Se eliminan los valores de las constantes
if (defined("SERVER"))
	runkit_constant_remove("SERVER"); //servidor donde se aloja el sistema

if (defined("USER"))
	runkit_constant_remove("USER"); //Usuario del servidor de base de datos

if (defined("PASSWORD"))
	runkit_constant_remove("PASSWORD"); //clave del servidor de base de datos

if (defined("MOTOR"))
	runkit_constant_remove("MOTOR"); //manejador de base de datos

if (defined("BD"))
	runkit_constant_remove("BD"); //nombre de la base de datos del sistema

if (defined("PRIVATE_KEY"))
	runkit_constant_remove("PRIVATE_KEY"); //llave maestra para encriptacion

if (defined("PORT"))
	runkit_constant_remove("PORT"); //3306 es el puerto por defecto de MySQL y 5432 pgSQL

if (defined("HOST"))
	runkit_constant_remove("HOST");
*/

?>
