<?php

//define el separador de rutas en Windows \ y basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

$gsObjeto = "Provider";
$gsModulo = "purchase";
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
 * @param string $gsOpcion, POST enviado ya satinado
 **/
switch ($gsOpcion) {
	case "listacombo":
		fcComboProvider();
		break;
}

//Función Combo Dinámico
function fcComboProvider()
{
	if (isset($_POST["hidCodigo"]))
		$pvCodigo = htmlentities(addslashes(trim($_POST["hidCodigo"])));
	else
		$pvCodigo = "";
	if (isset($_POST["hidCodPadre"]))
		$viCodigoPadre = htmlentities(trim(addslashes($_POST["hidCodPadre"])));
	else
		$viCodigoPadre = "";

	$lsSeleccionado = "";
	$objInstancia = new Provider();
	$rstRecordSet = $objInstancia->fmListar($viCodigoPadre);
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


?>
