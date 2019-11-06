<?php

$gsObjeto = "Municipio";
$gsModulo = "configuration";
$gsRutaBase = "";

//define el separador de rutas en windows \ en basados en Unix /
if (! defined("DS"))
	define("DS", DIRECTORY_SEPARATOR);


if (is_file("models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
	$gsRutaBase = "";
}
elseif (is_file(".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
	$gsRutaBase = ".." . DS;
}
else {
	$gsRutaBase = ".." . DS . ".." . DS;
}
require_once($gsRutaBase . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");



if (isset($_POST["vvOpcion"]))
	$gsOpcion = htmlentities(addslashes(strtolower(trim($_POST["vvOpcion"]))));
elseif (isset($_POST["setOpcion"]))
	$gsOpcion = htmlentities(addslashes(strtolower(trim($_POST["setOpcion"]))));
else
	$gsOpcion = NULL;


/**
 * @description: Condicional segun una variable enviada por POST ejecuta su funcion
 * @param sting $gsOpcion, POST enviado ya satinado
 **/
switch ($gsOpcion) {
	default:
	case NULL:
		//en caso de ser nulo se esta abriendo por URL
		//y debe sacar del sistema cerrando la sesion
		header(
			"Location: " . $gsRutaBase . "controllers" . DS . "security" . DS .
			"ctr_LogOut.php?getMotivoLogOut=indevido"
		);
		break;
	case "registrar":
		fcRegistrarMunicipio();
		break;
	case "modificar":
		fcModificarMunicipio();
		break;
	case "borrar":
		fcBorrarMunicipio();
		break;
	case "restaurar":
		fcRestaurarMunicipio();
		break;
	case "listaview":
		fcListaMunicipio();
		break;
	case "ultimocodigo":
		fcUltimoCodigoMunicipio();
		break;
	case "listacombo":
		fcComboMunicipio();
		break;
}



/**
 * función control Ultimo Código
 * llamada por la función JavaScript fjUltimoID, para colocar el ID automáticamente en la vista con AJAX
 * @return integer $arrCodigo[0], ultimo identificador de los registros de una tabla en la base de datos sumando 1
 */
function fcUltimoCodigoMunicipio()
{
	$objMunicipio = new clsMunicipio(); //instancia la clase
	$arrCodigo = $objMunicipio->fmUltimoCodigo(); //obtiene el arreglo con el codigo
	echo intval($arrCodigo[0]) + 1; //imprime el arreglo en la posicion cero y agrega 1

}



//funcion.control.Registrar
function fcRegistrarMunicipio()
{
	global $gsIndex; // variable global que contiene la ubicación del header
	$objMunicipio = new clsMunicipio(); //nuevo objMunicipio o clase Presentación
	$objMunicipio->setFormulario($_POST); //recibe los valores de la vista asignandolo al objeto
	$arrMunicipio = $objMunicipio->fmConsultar(); //realiza una consulta
	//si existe un registro
	if ($arrMunicipio) {
		if ($arrMunicipio[ $objMunicipio->atrEstatus ] == "inactivo") {
			//envía a la vista, con mensaje de la consulta
			header($gsIndex."&msjAlerta=desactivado&getOpcion=Inactivo" .
				"&getId=" . $arrMunicipio[ $objMunicipio->atrId_P ] .
				"&getNombre=" . $arrMunicipio[ $objMunicipio->atrNombre ] .
				"&getDescripcion=" . $arrMunicipio[ $objMunicipio->atrDescripcion ] .
				"&getIcono=" . $arrMunicipio["icono_boton"] .
				"&getEstatus=" . $arrMunicipio[ $objMunicipio->atrEstatus ]);
		}

		else {
			//envía a la vista, con mensaje de la consulta
			header($gsIndex."&msjAlerta=duplicado&getOpcion=" . $_POST["vvOpcion"] .
				"&getId=" . $arrMunicipio[ $objMunicipio->atrId_P ] .
				"&getNombre=" . $arrMunicipio[ $objMunicipio->atrNombre ] .
				"&getDescripcion=" . $arrMunicipio[ $objMunicipio->atrDescripcion ] .
				"&getIcono=" . $arrMunicipio["icono_boton"] .
				"&getEstatus=" . $arrMunicipio[ $objMunicipio->atrEstatus ]);
		}
	} //cierre del condicional si el RecordSet es verdadero
	//si el RecordSet es falso envía los valores a la  función.models.Insertar
	else {
		if ($objMunicipio->fmInsertar()) //si el fmInsertar es verdadero, realiza las sentencias
			header($gsIndex . "&msjAlerta=registro"); //envía a la vista, con mensaje de la consulta
		else
			header($gsIndex . "&msjAlerta=noregistro");
	} //cierre del condicional si el RecordSet es falso

	$objMunicipio->faDesconectar(); //cierra la conexión
	unset($objMunicipio); //destruye el objMunicipio
} //cierre de la función



function fcModificarMunicipio()
{
	global $gsIndex;
	$objMunicipio = new clsMunicipio();
	$objMunicipio->setFormulario($_POST); //recibe los valores de la vista a $objMunicipio
	$arrMunicipio = $objMunicipio->fmConsultarModificar(); //realiza una consulta
	if ($arrMunicipio[ $objMunicipio->atrEstatus ] == "inactivo") {
		//envía a la vista, con mensaje de la consulta
		header($gsIndex."&msjAlerta=desactivado&getOpcion=Inactivo" .
			"&getId=" . $arrMunicipio[ $objMunicipio->atrId_P ] .
			"&getNombre=" . $arrMunicipio[ $objMunicipio->atrNombre ] .
			"&getDescripcion=" . $arrMunicipio[ $objMunicipio->atrDescripcion ] .
			"&getIcono=" . $arrMunicipio["icono_boton"] .
			"&getEstatus=" . $arrMunicipio[ $objMunicipio->atrEstatus ]);
	} //cierre del condicional si el RecordSet es verdadero

	else {
		if ($objMunicipio->fmActualizar()) //retorna un RecordSet
			header($gsIndex . "&msjAlerta=cambio"); //envía a la vista, con mensaje de la consulta
		else
			header($gsIndex . "&msjAlerta=nocambio");  //envía a la vista, con mensaje de la consulta
	} //cierre del condicional si el RecordSet es falso

	$objMunicipio->faDesconectar(); //cierra la conexión
	unset($objMunicipio); //destruye el objMunicipio
}



function fcBorrarMunicipio()
{
	global $gsIndex; // variable global que contiene la ubicación del header
	$objMunicipio = new clsMunicipio();
	$objMunicipio->setFormulario($_POST); //recibe los valores de la vista a $objMunicipio
	$arrMunicipio = $objMunicipio->fmCuentaUsados(); //busco en las tablas relacionadas si esta en uso
	if (intval($arrMunicipio["UsoTotal"]) > 0)
		header($gsIndex . "&msjAlerta=noeliminousados" . $arrMunicipio["UsoTotal"]);  //envia a la vista, con totales de registros que lo usan
	//si no encontró registros que lo usen (su valor es 0)
	else {
		if ($objMunicipio->fmCambiarEstatus("inactivo")) //llama la función eliminar y si es verdadero
			header($gsIndex . "&msjAlerta=elimino"); //envía a la vista, con mensaje de la consulta
		else
			header($gsIndex . "&msjAlerta=noelimino");  //envía a la vista, con mensaje de la consulta
	}

	$objMunicipio->faDesconectar(); //cierra la conexión
	unset($objMunicipio); //destruye el objMunicipio
}



function fcRestaurarMunicipio()
{
	global $gsIndex; // variable global que contiene la ubicación del header
	$objMunicipio = new clsMunicipio();
	$objMunicipio->setFormulario($_POST); //recibe los valores de la vista a $objMunicipio
	if ($objMunicipio->fmCambiarEstatus("activo"))
		header($gsIndex . "&msjAlerta=restauro"); //envía a la vista, con mensaje de la consulta
	else
		header($gsIndex . "&msjAlerta=norestauro");  //envía a la vista, con mensaje de la consulta
	$objMunicipio->faDesconectar(); //cierra la conexiona
	unset($objMunicipio); //destruye el objMunicipio
}



//Funcion Combo Dinamico Municipio
//Utilizada por la vista de ACCESO ROL
function fcComboMunicipio()
{
	if (isset($_POST["hidCodigo"]))
		$pvCodigo = htmlentities(trim(addslashes($_POST["hidCodigo"])));
	else
		$pvCodigo = "";
	if (isset($_POST["hidCodPadre"]))
		$viCodigoPadre = htmlentities(trim(addslashes($_POST["hidCodPadre"])));
	else
		$viCodigoPadre = "";

	$lsSeleccionado = "";
	$objMunicipio = new clsMunicipio();
	$rstRecordSet = $objMunicipio->fmListar($viCodigoPadre);
	//si hay un arreglo devuelto en la consulta
	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		while ($arrRegistro = $objMunicipio->getConsultaAsociativo($rstRecordSet)) {
			if (intval($pvCodigo) == intval($arrRegistro[ $objMunicipio->atrId_P ]))
				$lsSeleccionado = "selected='selected'";
			else
				$lsSeleccionado = "";
			?>
			<option value="<?=$arrRegistro[ $objMunicipio->atrId_P ] ?>" <?= $lsSeleccionado; ?> >
				<?= $arrRegistro[ $objMunicipio->atrId_P ]; ?> - <?= ucwords($arrRegistro[ $objMunicipio->atrNombre ]); ?>
			</option>
			<?php
		} //cierre del while
		$objMunicipio->faLiberarConsulta($rstRecordSet); //libera de la memoria el resultado asociado a la consulta
	}
	//si no existe una consulta
	else {
		//imprime por lo MINIMO 2 option para que el js los separe en arreglo de lo contrario da error
		?>
		<option value='' > Seleccione Alguno </option>
		<option value='0' > Sin Registros </option>
		<?php
	}
	unset($objMunicipio); //destruye el objeto creado
}



function fcListaMunicipio()
{
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objeto = new clsMunicipio; //instancia la clase

	$objeto->setFormulario($_POST);

	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto
	$vpItems = 10;
	if (isset($_POST["setItems"]))  {
		$vpItems = htmlentities(trim(addslashes(intval($_POST['setItems'])))) ;
		if ($vpItems < 1) {
		 	$vpItems = 10 ; //muestra los items predeterminados
		}
	}
	$objeto->atrItems = $vpItems; //se le asigna al objeto cuantos items tomara

	//por defecto muesta la primera pagina del resultado

	if (isset($_POST['subPagina']) AND $_POST['subPagina'] > 1) {
		$vpPaginaActual = htmlentities(trim(intval($_POST['subPagina']))) ;
	}
	else
		$vpPaginaActual = 1 ;

	//si existe el elemento oculto hidOrden le indica al models por cual atributo listara
	if (isset($_POST["setOrden"])) {
		$objeto->atrOrden =  htmlentities(trim(strtolower($_POST["setOrden"])));
		//tambien idica de la forma en que listara ASC o DESC
		$objeto->atrTipoOrden = isset($_POST['setTipoOrden']) ? $_POST['setTipoOrden'] : "ASC";
	}

	$objeto->atrPaginaInicio = ($vpPaginaActual -1) * $objeto->atrItems;

	$rstRecordSet = $objeto->fmListarIndexMunicipio();

	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		?>
		<div class='table-responsiveX'>
			<br />
			<table border='0' valign='center' class='table table-striped text-center table-hover table-condensed table-bordered' id="tabLista<?= $gsObjeto; ?>">
				<thead>
					<tr>
						<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrId_P; ?>" onclick='fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrId_P; ?>")' >
							Cod
							<span class='glyphicon glyphicon-sort-by-attributes'></span>
						</th>
						<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrNombre; ?>")' >
							Descripción <span class='glyphicon glyphicon-sort'></span>
						</th>
						<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", "<?= $vpPaginaActual; ?>", "nombre_estado")' >
							Estado <span class='glyphicon glyphicon-sort'></span>
						</th>
						<th datos_orden_metodo="asc" datos_orden="<?= $objeto->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", "<?= $vpPaginaActual; ?>", "<?= $objeto->atrEstatus; ?>")' >
							Estatus  <span class='glyphicon glyphicon-sort'></span>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($arrRegistro = $objeto->getConsultaAsociativo($rstRecordSet)) : ?>
						<tr onclick='fjSeleccionarRegistro(this);' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
							datos_registro='seleccion
							|<?= $arrRegistro[ $objeto->atrEstatus ]; ?>
							|<?= $arrRegistro[ $objeto->atrCondicion ]; ?>
							|<?= $arrRegistro[ $objeto->atrId_P ]; ?>
							|<?= $arrRegistro[ $objeto->atrNombre ]; ?>
							|<?= $arrRegistro[ "id_estado_fk" ]; ?>' >

							<td> <?= $arrRegistro[ $objeto->atrId_P ]; ?> </td>
							<td> <?= $arrRegistro[ $objeto->atrNombre ] ; ?> </td>
							<td> <?= $arrRegistro[ "nombre_estado" ] ; ?> </td>
							<td> <?= $arrRegistro[ $objeto->atrEstatus ]; ?> </td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		<center>
			<nav aria-label="Page navigation">
				<ul class="pagination">
					<li>
						<a aria-label="Previous" rel="1" onclick='fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", this.rel);' >
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
					<?php
					for ($i = 1; $i <= $objeto->atrPaginaFinal; $i++)  {
						if ($i == $vpPaginaActual)
							$Activo = "active";
						else
							$Activo = "";
						?>
						<li class="<?= $Activo; ?> ">
							<a rel="<?= $i; ?>" onclick='console.log(this.rel); fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", this.rel);' >
								<?= $i; ?>
							</a>
						</li>
						<?php
					}
					?>
					<li>
						<a aria-label="Next" rel="<?= ($objeto->atrPaginaFinal); ?>" onclick='fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", this.rel);' >
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				</ul>
			</nav>
		</center>
		<?php
		$objeto->faLiberarConsulta($rstRecordSet); //libera de la memoria el resultado asociado a la consulta
	}

	else {
		?>
		<br />
		<b>¡No se ha encontrado ningún elemento!</b>
		<br /><br />
		<?php
	}
	$objeto->faDesconectar(); //cierra la conexión
	unset($objeto); //destruye el objeto
} //cierre de la función



//destruye lo enviado
if (isset($_POST))
	unset($_POST);

if (isset($_GET))
	unset($_GET);

?>
