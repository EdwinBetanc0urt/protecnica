<?php

//define el separador de rutas en Windows \ y en basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

if (strlen(session_id()) < 1) {
	session_start();
}

if (is_file("models" . DS . "perfil" . DS . "cls_Persona.php")) {
    require_once("models" . DS . "perfil" . DS . "cls_Persona.php");
	require_once("controllers" . DS . "_core" . DS . "ctr_EnviarCorreo.php");
}
elseif (is_file(".." . DS . "models" . DS . "perfil" . DS . "cls_Persona.php")) {
    require_once(".." . DS . "models" . DS . "perfil" . DS . "cls_Persona.php");
	require_once(".." . DS . "controllers" . DS . "perfil" . DS . "cls_Persona.php");
}
else {
    require_once(".." . DS . ".." . DS . "models" . DS . "perfil" . DS . "cls_Persona.php");
	require_once(".." . DS . ".." . DS . "controllers" . DS . "_core" . DS . "ctr_EnviarCorreo.php");
}


class clsUsuario extends clsPersona
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

		$this->atrClase = "usuario";
		$this->atrTabla = "tseg_" . strtoupper($this->atrClase) . "_m"; //tabla principal de la Clase
		$this->atrId_P = "id_" . $this->atrClase; //clave primaria de esta tabla
		$this->atrId_F = $this->atrClase . "_fk"; //clave foránea en otras tablas
		$this->atrNombre = "alias" ;
		$this->atrEstatus = "estatus_" . $this->atrClase ;
		$this->atrCondicion = "condicion_" . $this->atrClase ;
		$this->atrDescripcion = "";

		$this->atrTablasRelacionadas = array(
			array(
				"tabla" => "tseg_SEDE_USUARIO_d",
				"id" => "id_sede_usuario",
				"estatus" => "estatus_sede_usuario"
			),
			array(
				"tabla" => "tseg_ACCESO_USUARIO_d",
				"id" => "id_acceso_usuario",
				"estatus" => "estatus_acceso_usuario"
			)
		); //id dependiente o padre

		$this->atrId_Superior = array() ; //id dependiente o padre
		$this->atrId_Recursivo = "" ; //id dependiente o padre en su misma tabla

		$this->atrFormulario = array();
	} //cierre de la función



	//función.models.Insertar
	function fmInsertar()
	{
		parent::faTransaccionInicio();
		$vsId = NULL;
		$arrPersona = parent::fmConsultarPersona(
			$this->atrFormulario["cmbDocumentoIdentidad"],
			$this->atrFormulario["ctxIdentificacion"]
		);
		if ($arrPersona) {
			$vsId = $arrPersona["id_persona"];
		}
		else {
			try {
				$sql = "
					INSERT INTO tglo_PERSONA_m (
						identificacion, rif, identificacion_fk,
						pri_nombre, seg_nombre, pri_apellido, seg_apellido,
						sexo, fecha_nacimiento
					)
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
				//envía el sql y un arreglo con los parámetros
				$vsId = parent::faUltimoId(
					$sql,
					[
						$this->atrFormulario["ctxIdentificacion"],
						$this->atrFormulario["ctxRIF"],
						$this->atrFormulario["cmbDocumentoIdentidad"],
						$this->atrFormulario["ctxNombre"],
						$this->atrFormulario["ctxSegNombre"],
						$this->atrFormulario["ctxApellido"],
						$this->atrFormulario["ctxSegApellido"],
						$this->atrFormulario["cmbSexo"],
						parent::faFechaFormato(
							$this->atrFormulario["datFechaNacimiento"],
							"dma",
							"amd"
						)
					]
				);
                $sql = "
                    INSERT INTO tpers_DATOS_BASICOS (
                        correo1, persona_fk
                    )
                    VALUES (?, ?);";
                //envía el sql y un arreglo con los parámetros
                $tupla = parent::ejecutar(
                    $sql,
                    [
                        $this->atrFormulario["ctxCorreo"],
                        $vsId
                    ]
                );
				//console::log("mensaje de la consola del navegador sobre el estatus: " . $vsId);
			}
			catch (Exception $e) {
				//console::log("mensaje de la consola del navegador sobre el error: " . $e->getMessage());
				return false;
			}
		}

		//verifica si se ejecuto bien
		if ($vsId > 0) {
			//verifica si se ejecuto bien
			$estatus = $this->fmInsertarUsuario($vsId);
			if ($estatus == true){
				parent::faTransaccionFin();
				return true; //envía el id para insertar el usuario
			}
			elseif (is_string($estatus)) {
				parent::faTransaccionDeshace();
				return $estatus; //envía el id para insertar el usuario
			}
			else {
				parent::faTransaccionDeshace();
				return false; //envía el id para insertar el usuario
			}
		}
		else {
			parent::faTransaccionDeshace();
			return false;
		}
	} //cierre de la función

	//función.models.Insertar
	function fmInsertarUsuario($piIdPersona)
	{
		$vsId = NULL;
		$objDocumento = new clsDocumentoIdentidad;
		$vsCaracter = strtoupper(
			$objDocumento->fmSeleccionarCaracter(
				$this->atrFormulario["cmbDocumentoIdentidad"]
			)
		);
		unset($objDocumento);

		$arrUsuario = $this->fmBuscarUsuario($this->atrFormulario["ctxIdentificacion"]);
		if ($arrUsuario) {
			return "ya existe un usuario";
		}
		else {
			try {
				$vsAlias = $vsCaracter . "-" . $this->atrFormulario["ctxIdentificacion"];

				$sql = "
					INSERT INTO tseg_USUARIO_m (
						alias, persona_fk, rol_fk
					)
					VALUES (?, ?, ?);";
				//envía el sql y un arreglo con los parámetros
				$vsId = parent::faUltimoId(
					$sql,
					[
						$vsAlias,
						$piIdPersona,
						$this->atrFormulario["cmbRol"]
					]
				);
				//console::log("mensaje de la consola del navegador sobre el estatus: " . $vsId);
			}
			catch (Exception $e) {
				//console::log("mensaje de la consola del navegador sobre el error: " . $e->getMessage());
				return false;
			}
		}
		if ($vsId > 0) //verifica si se ejecuto bien
			return $this->fmInsertarClave($vsId, $vsCaracter); //envía el id para insertar la clave
		else
			return false;
	} //cierre de la función



	//función.models.Insertar
	function fmInsertarClave($piIdUsuario, $psCaracter = "")
	{
		if ($psCaracter == "") {
			$objDocumento = new clsDocumentoIdentidad;
			$psCaracter = $objDocumento->fmSeleccionarCaracter(
				$this->atrFormulario["cmbDocumentoIdentidad"]
			);
			unset($objDocumento);
		}

        $clave = strtolower($psCaracter) . "-" . $this->atrFormulario["ctxIdentificacion"];
        $vsAlias = $psCaracter . "-" . $this->atrFormulario["ctxIdentificacion"];

		//nacionalidad guion documento. Ejemplo. v-12345678
		$clave_encriptada = clsCifrado::getCifrar( $clave );

		try {
			$sql = "
				INSERT INTO tseg_CLAVE_USUARIO_m
				(clave, fecha_creacion, estatus_clave, usuario_fk)
			VALUES
				(?, CURRENT_DATE, 'temporal', ?) ;";
			//envía el sql y un arreglo con los parámetros
			$tupla = parent::ejecutar(
				$sql,
				[
					$clave_encriptada,
					$piIdUsuario
				]
			);
            $razon_social = $this->atrFormulario["ctxNombre"] . " " . $this->atrFormulario["ctxApellido"];
            $mensaje = array( $vsAlias, $clave );
            EnviarCorreo($this->atrFormulario["ctxCorreo"], $razon_social, $mensaje);
			//console::log("mensaje de la consola del navegador sobre el estatus: " . $tupla);
			return $tupla; //envía el arreglo
		}
		catch (Exception $e) {
			//console::log("mensaje de la consola del navegador sobre el error: " . $e->getMessage());
			return false;
		}
	} //cierre de la función



	function fmBuscarUsuario($piAlias)
	{
		$sql = "
			SELECT * FROM tseg_USUARIO_m
			WHERE
				alias = '{$piAlias}'
			LIMIT 1 ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) //verifica si se ejecuto bien
			return parent::getConsultaArreglo($tupla); //retorna la tupla convertida en array
		else
			return false;
	} //cierre de la función



	//función.models.Actualizar
	function fmActualizar()
	{
		parent::faTransaccionInicio();
		$objDocumento = new clsDocumentoIdentidad;
		$vsCaracter = strtoupper(
			$objDocumento->fmSeleccionarCaracter(
				$this->atrFormulario["cmbDocumentoIdentidad"]
			)
		);
		unset($objDocumento);
		$vsAlias = $vsCaracter . "-" . $this->atrFormulario["ctxIdentificacion"];

		$arrPersona = parent::fmConsultarPersona(
			$this->atrFormulario["cmbDocumentoIdentidad"],
			$this->atrFormulario["ctxIdentificacion"]
		);
		$vsId = $arrPersona["id_persona"];

		$sql = "
			UPDATE {$this->atrTabla}
			SET
				alias = '{$vsAlias}',
				rol_fk = '{$this->atrFormulario["cmbRol"]}'
			WHERE
				id_usuario = '{$this->atrFormulario["numId"]}' ; ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql

		$vsFecha = parent::faFechaFormato(
			$this->atrFormulario["datFechaNacimiento"],
			"dma",
			"amd"
		);

		$sql = "
			UPDATE tglo_PERSONA_m
			SET
				nacionalidad = '{$this->atrFormulario["cmbDocumentoIdentidad"]}',
				identificacion = '{$this->atrFormulario["ctxIdentificacion"]}',
				rif = '{$this->atrFormulario["ctxRIF"]}',

				pri_nombre  = '{$this->atrFormulario["ctxNombre"]}',
				seg_nombre = '{$this->atrFormulario["ctxSegNombre"]}',
				pri_apellido = '{$this->atrFormulario["ctxApellido"]}',
				seg_apellido = '{$this->atrFormulario["ctxSegApellido"]}',

				sexo = '{$this->atrFormulario["cmbSexo"]}',
				fecha_nacimiento = '{$vsFecha}'
			WHERE
				id_persona = '{$vsId}' ; ";
		$tupla2 = parent::faEjecutar($sql); //Ejecuta la sentencia sql

		//verifica si se ejecuto bien
		if (parent::faVerificar($tupla) OR parent::faVerificar($tupla2)) {
			parent::faTransaccionFin();
			return true; //envía el arreglo
		}
		else {
			parent::faTransaccionDeshace();
			return false;
		}
	} //cierre de la función



	/**
	 * Función models Eliminar, Restaurar, elimina lógicamente de la base de datos
	 * @param string $psEstatus valor nuevo a modificar
	 * @return bool $tupla del estatus si modifico en la base de datos
	 */
	function fmDebloquearUsuario()
	{
		try {
			$sql = "
				UPDATE {$this->atrTabla}
				SET
					{$this->atrEstatus} = ?,
					intentos_fallidos = ?,
					idusuario =  ?
				WHERE
					{$this->atrId_P} = ?;";
			//echo "$sql";
			//envia el sql y un arreglo con los parámetros
			$tupla = $this->ejecutar(
				$sql,
				[
					"activo",
					"0",
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




	function fmConsultar() //función.models.Consultar
	{
		$_REQUEST["ctxIdentificacion"] = htmlentities(trim(intval(
			$_REQUEST["ctxIdentificacion"]
		)));

		$objInstancia = new clsDocumentoIdentidad;
		$vsCaracter = strtoupper(
			$objInstancia->fmSeleccionarCaracter(
				$_REQUEST["cmbDocumentoIdentidad"]
			)
		);

		$sql = "
			SELECT *
			FROM vwsUsuario
			WHERE
				alias = '{$vsCaracter}-{$this->atrFormulario["ctxIdentificacion"]}'
			LIMIT 1 ; ";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla)) //verifica si se ejecuto exitosamente la sentencia
		{
			$arreglo = parent::getConsultaArreglo($tupla); //convierte el RecordSet en un arreglo
			parent::faLiberarConsulta($tupla); //libera de la memoria el resultado asociado a la consulta
			return $arreglo; //retorna los datos obtenidos de la bd en un arreglo
		}
		else
			return false;
	} //cierre de la función



	//función.models.Consultar
	function fmConsultarUsuario($psBusqueda)
	{
		$sql = "
			SELECT
				U.alias, U.id_usuario, Per.identificacion_fk, Per.pri_nombre,
				Per.seg_nombre, Per.pri_apellido, Per.seg_apellido, I.caracter_tipo_id
				AS nacionalidad, R.*, D.departamento, D.id_departamento

			FROM
				{$this->atrTabla} AS U, tmDepartamento AS D,  tmPersona AS Per,
				tcRol AS R, tcTipo_ID AS I

			WHERE
				(U.id_usuario LIKE '%{$psBusqueda}%' OR
				U.alias LIKE '%{$psBusqueda}%' OR
				Per.pri_nombre LIKE '%{$psBusqueda}%' OR
				Per.pri_apellido LIKE '%$psBusqueda%' OR
				R.rol LIKE '%{$psBusqueda}%') AND
				(U.persona_fk = Per.id_persona AND
				U.rol_fk = R.id_rol AND
				D.id_departamento = R.departamento_fk AND
				Per.identificacion_fk = I.id_tipo_id) ";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		//verifica si se ejecuto exitosamente la sentencia
		if (parent::faVerificar($tupla)) {
			return $tupla;
		}
		else
			return false;
	} //cierre de la función



	/**
	 * función models Listar Vista, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parámetro controllers Búsqueda $pcBusqueda, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE. para ser montado en el index
	 */
	function fmListarIndexUsuario()
	{
		$sql = "
			SELECT
				P.*, U.*, R.id_rol, R.nombre_rol
			FROM
				tglo_PERSONA_m AS P

				INNER JOIN tseg_USUARIO_m AS U
					ON P.id_persona = U.persona_fk

				INNER JOIN tseg_ROL_m AS R
					ON R.id_rol = U.rol_fk

			WHERE
				(id_usuario LIKE '%{$this->atrFormulario["setBusqueda"]}%' OR
				alias LIKE '%{$this->atrFormulario["setBusqueda"]}%' OR
				pri_nombre LIKE '%{$this->atrFormulario["setBusqueda"]}%' OR
				pri_apellido LIKE '%{$this->atrFormulario["setBusqueda"]}%' OR
				nombre_rol LIKE '%{$this->atrFormulario["setBusqueda"]}%')
				AND estatus_usuario = 'activo' ";

		if ($this->atrOrden != "")
			$sql .= " ORDER BY $this->atrOrden $this->atrTipoOrden ";

		$this->atrTotalRegistros = parent::getNumeroFilas(parent::faEjecutar($sql));
		$this->atrPaginaFinal = ceil($this->atrTotalRegistros / $this->atrItems);

		//concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio}, {$this->atrItems} ; ";
		//echo "$sql";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	} //cierre de la función



	/**
	 * función models Listar Vista, consulta en la base de datos según el termino de búsqueda, paginación y orden
	 * @param string parámetro controllers Búsqueda $pcBusqueda, trae todo lo escrito en el ctxBusqueda
	 * @return object $tupla, resultado de consulta SQL o en caso contrario un FALSE. para ser montado en el index
	 */
	function fmListarIndexUsuarioBloqueado()
	{
		$sql = "
			SELECT *

			FROM
				vwsUsuario
			WHERE
				(id_usuario LIKE '%{$this->atrFormulario["setBusqueda"]}%' OR
				alias LIKE '%{$this->atrFormulario["setBusqueda"]}%' OR
				pri_nombre LIKE '%{$this->atrFormulario["setBusqueda"]}%' OR
				pri_apellido LIKE '%{$this->atrFormulario["setBusqueda"]}%' OR
				nombre_rol LIKE '%{$this->atrFormulario["setBusqueda"]}%')
				AND estatus_usuario = 'bloqueado' ";

		if ($this->atrOrden != "")
			$sql .= " ORDER BY {$this->atrOrden} {$this->atrTipoOrden} ";

		$this->atrTotalRegistros = parent::getNumeroFilas(parent::faEjecutar($sql));
		$this->atrPaginaFinal = ceil($this->atrTotalRegistros / $this->atrItems);

		//concatena estableciendo los limites o rango del resultado, interpolando las variables
		$sql .= " LIMIT {$this->atrPaginaInicio}, {$this->atrItems} ; ";
		//echo "$sql";
		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	} //cierre de la función



	function fmListarReporte()
	{
		$arrFormulario = $this->atrFormulario;
		$sql = "
			SELECT
				U.*, Per.identificacion_fk, Per.identificacion, Per.pri_nombre,
				Per.seg_nombre, Per.pri_apellido, Per.seg_apellido,
				I.caracter_tipo_id, R.*, D.departamento, D.id_departamento
			FROM
				tseg_USUARIO_m AS U

				INNER JOIN tmPersona AS Per
					ON  Per.id_persona = U.persona_fk

				INNER JOIN tcTipo_ID AS I
					ON Per.identificacion_fk = I.id_tipo_id

				INNER JOIN tcRol AS R
					ON U.rol_fk = R.id_rol

				INNER JOIN tmDepartamento AS D
					ON D.id_departamento = R.departamento_fk  "; //selecciona todo de la tabla

		$sqlTipoRango = " "; //selecciona solo lo que esta dentro del rango
		if (array_key_exists("radRangoTipo", $arrFormulario)) {
			if ($arrFormulario['radRangoTipo'] == "fuera")
				$sqlTipoRango = " NOT "; //selecciona solo lo que esta fuera del rango
		}

		//define el rango a mostrar
		if (array_key_exists("radRango", $arrFormulario)) {
			switch ($arrFormulario['radRango']) {

				case 'id': //no esta imprimiendo el final
					$sql .= "WHERE $sqlTipoRango ({$this->atrId_P} >= '{$arrFormulario["numIdInicio"]}' ";
					if ($arrFormulario["numIdFinal"] != "") //si el rango final no esta vació
						$sql .= " AND $this->atrId_P <= '{$arrFormulario["numIdFinal"]}' ";
					$sql .= ") ";
					#dentro SELECT * FROM tcrol WHERE (id_rol >= '3' AND id_rol <= '5')
					#fuera SELECT * FROM tcrol WHERE NOT (id_rol >= '3' AND id_rol <= '5')
					break;

				// MEJORAR LA CONSULTA POR RANGO DE NOMBRES
				case 'nombre':
					$sql .= "WHERE ({$this->atrNombre} {$sqlTipoRango} BETWEEN
						'{$arrFormulario["cmbNombreInicial"]}%'
						AND '{$arrFormulario["cmbNombreFinal"]}%') ";
					break;

				case 'estatus':
					$sql .= "WHERE $sqlTipoRango
						(estatus_rol LIKE '{$arrFormulario["cmbEstatusInicial"]}%'
						AND estatus_rol LIKE '{$arrFormulario["cmbEstatusFinal"]}%') ";
					break;

				case 'departamento': //no esta imprimiendo el final
					$sql .= "WHERE $sqlTipoRango (departamento_fk >= '{$arrFormulario["cmbDepartamentoInicial"]}' ";
					if ($arrFormulario["cmbDepartamentoFinal"] != "") //si el rango final no esta vació
						$sql .= " AND departamento_fk <= '{$arrFormulario["cmbDepartamentoFinal"]}' ";
					$sql .= ") ";
					#dentro SELECT * FROM tcrol WHERE (id_rol >= '3' AND id_rol <= '5')
					#fuera SELECT * FROM tcrol WHERE NOT (id_rol >= '3' AND id_rol <= '5')
					break;
			}
		}

		//define el atributo en que se ordena y de que forma
		if (array_key_exists("cmbOrden", $arrFormulario))
			$sql .= " ORDER BY {$arrFormulario['cmbOrden']} {$arrFormulario['radOrden']}";

		$tupla = parent::faEjecutar($sql); //Ejecuta la sentencia sql
		if (parent::faVerificar($tupla))
			return $tupla;
		else
			return false;
	} //cierre de la función



} //cierre de la clase

?>
