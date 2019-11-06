<?php

//define el separador de rutas en Windows \ y basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

$gsObjeto = "Vista";
$gsModulo = "configuration";
$gsRutaBase = "";


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
 * @description: Condicional según una variable enviada por POST ejecuta su función
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
		fcRegistrarVista();
		break;
	case "modificar":
		fcModificarVista();
		break;
	case "borrar":
		fcBorrarVista();
		break;
	case "restaurar":
		fcRestaurarVista();
		break;
	case "listaview":
		fcListaVista();
		break;
	case "ultimocodigo":
		fcUltimoCodigoVista();
		break;
	case "listacombo":
		fcComboVista();
		break;
}



/**
 * función control Ultimo Código
 * llamada por la función JavaScript fjUltimoID, para colocar el ID automáticamente en la vista con AJAX
 * @return integer $arrCodigo[0], ultimo identificador de los registros de una tabla en la base de datos sumando 1
 */
function fcUltimoCodigoVista()
{
	$objInstancia = new clsVista(); //instancia la clase
	$arrCodigo = $objInstancia->fmUltimoCodigo(); //obtiene el arreglo con el código
	echo intval($arrCodigo[0]) + 1; //imprime el arreglo en la posición cero y agrega 1

}



//funcion.control.Registrar
function fcRegistrarVista()
{
	$objInstancia = new clsVista(); //nuevo objInstancia o clase Presentación
	$objInstancia->setFormulario($_POST); //recibe los valores de la vista asignándolo al objInstancia
	$arrConsulta = $objInstancia->fmConsultar(); //realiza una consulta
	//si existe un registro
	if ($arrConsulta) {
		if ($arrConsulta[$objInstancia->atrEstatus] == "inactivo") {
			$arrRetorno = array(
				"mensaje" => "desactivado",
				"ver" => "si",
				"datos" => array(
					"getOpcion" => "Inactivo",
					"id" => $arrConsulta[$objInstancia->atrId_P],
					"nombre" => $arrConsulta[$objInstancia->atrNombre],
					"descripcion" => $arrConsulta[$objInstancia->atrDescripcion],
					"icono" => $arrConsulta["icono_vista"],
					"idmodulo" => $arrBoton["modulo_fk"],
					"condicion" => $arrConsulta[$objInstancia->atrCondicion],
					"estatus" => $arrConsulta[$objInstancia->atrEstatus]
				)
			);
		}
		else {
			$arrRetorno = array(
				"mensaje" => "duplicado",
				"ver" => "si",
				"datos" => array(
					"getOpcion" => $_POST["vvOpcion"],
					"id" => $arrBoton[$objBoton->atrId_P],
					"nombre" => $arrBoton[$objBoton->atrNombre],
					"descripcion" => $arrBoton[$objBoton->atrDescripcion],
					"icono" => $arrBoton["icono_vista"],
					"idmodulo" => $arrBoton["modulo_fk"],
					"condicion" => $arrBoton[$objBoton->atrCondicion],
					"estatus" => $arrBoton[$objBoton->atrEstatus]
				)
			);
		}
	} //cierre del condicional si el RecordSet es verdadero
	//si el RecordSet es falso envía los valores a la  función.models.Insertar
	else {
		if ($objInstancia->fmInsertar()) {
			$arrRetorno = array(
				"mensaje" => "registro",
				"ver" => "no",
				"datos" => array()
			);
		}
		else {
			$arrRetorno = array(
				"mensaje" => "noregistro",
				"ver" => "no",
				"datos" => array()
			);
		}
	} //cierre del condicional si el RecordSet es falso
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 2000 05:00:00 GMT');
	header('Content-type: application/json');
	echo json_encode($arrRetorno);

	$objInstancia->faDesconectar(); //cierra la conexión
	unset($objInstancia); //destruye el objInstancia
} //cierre de la función



function fcModificarVista()
{
	$objInstancia = new clsVista();
	$objInstancia->setFormulario($_POST); //recibe los valores de la vista a $objInstancia
	$arrConsulta = $objInstancia->fmConsultarModificar(); //realiza una consulta
	if ($arrConsulta[$objInstancia->atrEstatus] == "inactivo") {
		$arrRetorno = array(
			"mensaje" => "desactivado",
			"ver" => "no",
			"datos" => array(
				"getOpcion" => "Inactivo",
				"id" => $arrBoton[$objBoton->atrId_P],
				"nombre" => $arrBoton[$objBoton->atrNombre],
				"descripcion" => $arrBoton[$objBoton->atrDescripcion],
				"icono" => $arrBoton["icono_vista"],
				"idmodulo" => $arrBoton["modulo_fk"],
				"condicion" => $arrBoton[$objBoton->atrCondicion],
				"estatus" => $arrBoton[$objBoton->atrEstatus]
			)
		);
	} //cierre del condicional si el RecordSet es verdadero
	else {
		if ($objInstancia->fmActualizar()){
			$arrRetorno = array(
				"mensaje" => "cambio",
				"ver" => "no",
				"datos" => array()
			);
		}
		else {
			$arrRetorno = array(
				"mensaje" => "nocambio",
				"ver" => "no",
				"datos" => array()
			);
		}
	} //cierre del condicional si el RecordSet es falso
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 2000 05:00:00 GMT');
	header('Content-type: application/json');
	echo json_encode($arrRetorno);

	$objInstancia->faDesconectar(); //cierra la conexión
	unset($objInstancia); //destruye el objInstancia
}



function fcBorrarVista()
{
	$objInstancia = new clsVista();
	$objInstancia->setFormulario($_POST); //recibe los valores de la vista a $objInstancia
	$arrConsulta = $objInstancia->fmCuentaUsados(); //busco en las tablas relacionadas si esta en uso
	if (intval($arrConsulta["UsoTotal"]) > 0) {
		$arrRetorno = array(
			"mensaje" => "noeliminousados" . $arrConsulta["UsoTotal"],
			"ver" => "no",
			"datos" => array()
		);
	}
	//si no encontró registros que lo usen (su valor es 0)
	else {
		if ($objInstancia->fmCambiarEstatus("inactivo")) {
			$arrRetorno = array(
				"mensaje" => "elimino",
				"ver" => "no",
				"datos" => array()
			);
		}
		else {
			$arrRetorno = array(
				"mensaje" => "noelimino",
				"ver" => "no",
				"datos" => array()
			);
		}
	}
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 2000 05:00:00 GMT');
	header('Content-type: application/json');
	echo json_encode($arrRetorno);

	$objInstancia->faDesconectar(); //cierra la conexión
	unset($objInstancia); //destruye el objInstancia
}



function fcRestaurarVista()
{
	$objInstancia = new clsVista();
	$objInstancia->setFormulario($_POST); //recibe los valores de la vista a $objInstancia
	if ($objInstancia->fmCambiarEstatus("activo")) {
		$arrRetorno = array(
			"mensaje" => "restauro",
			"ver" => "no",
			"datos" => array()
		);
	}
	else {
		$arrRetorno = array(
			"mensaje" => "norestauro",
			"ver" => "no",
			"datos" => array()
		);
	}
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 2000 05:00:00 GMT');
	header('Content-type: application/json');
	echo json_encode($arrRetorno);

	$objInstancia->faDesconectar(); //cierra la conexiona
	unset($objInstancia); //destruye el objInstancia
}



//Funcion Combo Dinamico Vista
//Utilizada por la vista de ACCESO ROL
function fcComboVista()
{
	if (isset($_POST["hidCodigo"]))
		$pvCodigo = htmlentities(trim(addslashes(strtolower($_POST["hidCodigo"]))));
	else
		$pvCodigo = "";
	if (isset($_POST["hidCodPadre"]))
		$viCodigoPadre = htmlentities(trim(addslashes(strtolower($_POST["hidCodPadre"]))));
	else
		$viCodigoPadre = "";
	$lsSeleccionado = "";
	$objInstancia = new clsVista();
	$rstRecordSet = $objInstancia->fmListar();
	//si hay un arreglo devuelto en la consulta
	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		while ($arrRegistro = $objInstancia->getConsultaAsociativo($rstRecordSet)) {
			if (intval($pvCodigo) == intval($arrRegistro[$objInstancia->atrId_P]))
				$lsSeleccionado = "selected='selected'";
			else
				$lsSeleccionado = "";
			?>
			<option value="<?=$arrRegistro[$objInstancia->atrId_P] ?>" <?= $lsSeleccionado; ?> >
				<?= $arrRegistro[$objInstancia->atrId_P]; ?> - <?= ucwords($arrRegistro[$objInstancia->atrNombre]); ?>
			</option>
			<?php
		} //cierre del while
		$objInstancia->faLiberarConsulta($rstRecordSet); //libera de la memoria el resultado asociado a la consulta
	}
	//si no existe una consulta
	else {
		//imprime por lo MINIMO 2 option para que el js los separe en arreglo de lo contrario da error
		?>
		<option value='' > Seleccione Alguno </option>
		<option value='0' > Sin Registros </option>
		<?php
	}
	unset($objInstancia); //destruye el objInstancia creado
}



function fcListaVista()
{
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto
	$objInstancia = new clsVista; //instancia la clase

	$objInstancia->setFormulario($_POST);

	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto
	$vpItems = 10;
	if (isset($_POST["setItems"]))  {
		$vpItems = htmlentities(trim(addslashes(intval($_POST['setItems'])))) ;
		if ($vpItems < 1) {
		 	$vpItems = 10 ; //muestra los items predeterminados
		}
	}
	$objInstancia->atrItems = $vpItems; //se le asigna al objInstancia cuantos items tomara

	//por defecto muestra la primera pagina del resultado

	if (isset($_POST['subPagina']) AND $_POST['subPagina'] > 1) {
		$vpPaginaActual = htmlentities(trim(intval($_POST['subPagina']))) ;
	}
	else
		$vpPaginaActual = 1 ;

	//si existe el elemento oculto hidOrden le indica al models por cual atributo listara
	if (isset($_POST["setOrden"])) {
		$objInstancia->atrOrden =  htmlentities(trim(strtolower($_POST["setOrden"])));
		//también indica de la forma en que listara ASC o DESC
		$objInstancia->atrTipoOrden = isset($_POST['setTipoOrden']) ? $_POST['setTipoOrden'] : "ASC";
	}

	$objInstancia->atrPaginaInicio = ($vpPaginaActual -1) * $objInstancia->atrItems;

	$rstRecordSet = $objInstancia->fmListarIndexVista();

	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		?>
		<div class='table-responsiveX'>
			<br />
			<table border='0' valign='center' class='table table-striped text-center table-hover table-condensed table-bordered' id="tabLista<?= $gsObjeto; ?>">
				<thead>
					<tr>
						<th datos_orden_metodo="asc" datos_orden="<?= $objInstancia->atrId_P; ?>" onclick='fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", "<?= $vpPaginaActual; ?>", "<?= $objInstancia->atrId_P; ?>")' >
							Cod
							<span class='glyphicon glyphicon-sort-by-attributes'></span>
						</th>
						<th datos_orden_metodo="asc" datos_orden="<?= $objInstancia->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", "<?= $vpPaginaActual; ?>", "<?= $objInstancia->atrNombre; ?>")' >
							Descripción <span class='glyphicon glyphicon-sort'></span>
						</th>
						<th datos_orden_metodo="asc" datos_orden="<?= $objInstancia->atrNombre; ?>" onclick='fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", "<?= $vpPaginaActual; ?>", "nombre_modulo")' >
							Modulo <span class='glyphicon glyphicon-sort'></span>
						</th>
						<th datos_orden_metodo="asc" datos_orden="<?= $objInstancia->atrEstatus; ?>" onclick='fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", "<?= $vpPaginaActual; ?>", "<?= $objInstancia->atrEstatus; ?>")' >
							Estatus  <span class='glyphicon glyphicon-sort'></span>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($arrRegistro = $objInstancia->getConsultaAsociativo($rstRecordSet)) : ?>
						<tr onclick='fjSeleccionarRegistro(this);' data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación'
							datos_registro='seleccion
							|<?= $arrRegistro[$objInstancia->atrEstatus]; ?>
							|<?= $arrRegistro[$objInstancia->atrCondicion]; ?>
							|<?= $arrRegistro[$objInstancia->atrId_P]; ?>
							|<?= $arrRegistro[$objInstancia->atrNombre]; ?>
							|<?= $arrRegistro[$objInstancia->atrDescripcion]; ?>
							|<?= $arrRegistro["modulo_fk"]; ?>
							|<?= $arrRegistro["modulo"]; ?>
							|<?= $arrRegistro["icono_vista"]; ?>
							|<?= $arrRegistro["posicion_modulo"]; ?>
							|<?= $arrRegistro["url_vista"]; ?>' >

							<td> <?= $arrRegistro[$objInstancia->atrId_P]; ?> </td>
							<td> <?= $arrRegistro[$objInstancia->atrNombre] ; ?> </td>
							<td> <?= $arrRegistro["nombre_modulo"] ; ?> </td>
							<td> <?= $arrRegistro[$objInstancia->atrEstatus]; ?> </td>
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
					for ($i = 1; $i <= $objInstancia->atrPaginaFinal; $i++)  {
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
						<a aria-label="Next" rel="<?= ($objInstancia->atrPaginaFinal); ?>" onclick='fjMostrarLista("<?= $gsModulo; ?>", "<?= $gsObjeto; ?>", this.rel);' >
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
				</ul>
			</nav>
		</center>
		<?php
		$objInstancia->faLiberarConsulta($rstRecordSet); //libera de la memoria el resultado asociado a la consulta
	}

	else {
		?>
		<br />
		<b>¡No se ha encontrado ningún elemento!</b>
		<br /><br />
		<?php
	}
	$objInstancia->faDesconectar(); //cierra la conexión
	unset($objInstancia); //destruye el objInstancia
} //cierre de la función



//destruye lo enviado
if (isset($_POST))
	unset($_POST);

if (isset($_GET))
	unset($_GET);

?>
