<?php

//define el separador de rutas en Windows \ en basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

$gsObjeto = "RoleAccess";
$gsModulo = "security";
//$gsRutaBase = "";

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
	/*
	case NULL: //en caso de ser nulo se esta abriendo por URL y se debe sacar del sistema
		header("Location: ../../control/security/ctr_LogOut.php?getMotivoLogOut=indevido"); //cierra la sesion
		break;
	*/
	case "agregar":
		addAccess();
		break;
	case "cambiar":
		changeAccess();
		break;
	case "eliminar":
		removeAccess();
		break;
	case "listaconacceso":
		fcListaAccesoRol();
		break;
	case "listasinacceso":
		fcListaSinAccesoRol();
		break;
	case "listabotonconacceso":
		fcListaBotonSi();
		break;
	case "listabotonsinacceso":
		fcListaBotonNo();
		break;
}



//funcion.control.Registrar
function addAccess() {
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto

	if (is_file("models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php")) {
		require_once("models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}
	elseif (is_file(".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php")) {
		require_once(".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}
	$objInstancia = new RoleAccess(); //nuevo objeto o clase Accesos
	$objInstancia->setFormulario($_POST); //recibe los valores de la vista y los sanea
	//var_dump($objInstancia->fmInsertar());
	//envía a la vista, con mensaje de la consulta
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
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 2000 05:00:00 GMT');
	header('Content-type: application/json');
	echo json_encode($arrRetorno);
	//*/
	//var_dump($arrRetorno);
	$objInstancia->faDesconectar(); //cierra la conexión
	unset($objInstancia); //destruye el objeto
} //cierre de la función



//funcion.control.Modificar
function changeAccess() {
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto

	if (is_file("models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
		require_once("models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}
	elseif (is_file(".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
		require_once(".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}

	$objInstancia = new RoleAccess(); //nuevo objeto o clase Accesos
	$objInstancia->setFormulario($_POST); //recibe los valores de la vista y los sanea
	//var_dump($objInstancia->fmCambiarEstatus("inactivo"));
	//*
	if ($objInstancia->fmEliminar()) {
		//envía a la vista, con mensaje de la consulta
		if ($objInstancia->fmInsertar()) {
			$arrRetorno = array(
				"mensaje" => "cambio",
				"ver" => "no",
				"datos" => array()
			);
		}
	}
	else {
		$arrRetorno = array(
			"mensaje" => "nocambio",
			"ver" => "no",
			"datos" => array()
		);
	}
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 2000 05:00:00 GMT');
	header('Content-type: application/json');
	echo json_encode($arrRetorno);

	$objInstancia->faDesconectar(); //cierra la conexión
	unset($objInstancia); //destruye el objeto
} //cierre de la función



function fcConsultaAccesoVista($piRol, $piVista) {
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto

	if (is_file("models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
		require_once("models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}
	elseif (is_file(".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
		require_once(".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}

	$objAcceso = new RoleAccess(); //nuevo objeto o clase Accesos
	$vbAccesa = $objAcceso->fmConsultaAccesoVista($piRol, $piVista);
	return  $vbAccesa; //retorna un booleano
}



function fcConsultaAccesoBoton($piRol, $piVista, $piBoton) {
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto

	if (is_file("models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
		require_once("models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}
	elseif (is_file(".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
		require_once(".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}

	$objAcceso = new RoleAccess(); //nuevo objeto o clase Accesos
	$vbAccesa = $objAcceso->fmConsultaAccesoBoton($piRol, $piVista, $piBoton); //retorna un booleano
	return $vbAccesa; //retorna un booleano
}



function fcConsultaIdVista($psURL) {
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto

	if (is_file("models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
		require_once("models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}
	elseif (is_file(".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
		require_once(".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}

	$objAcceso = new RoleAccess(); //nuevo objeto o clase Accesos
	$viIdVista = $objAcceso->fmConsultaCodigoVista($psURL); //obtiene el codigo a partir de la url o $vsVista
	return $viIdVista;
}



//función.control.Registrar
function removeAccess() {
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto

	if (is_file("models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
		require_once("models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}
	elseif (is_file(".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php")) {
		require_once(".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "models" . DS . $gsModulo . DS . "cls_{$gsObjeto}.php");
	}

	$objInstancia = new RoleAccess(); //nuevo objeto o clase Accesos
	$objInstancia->setFormulario($_POST); //recibe los valores de la vista y los sanea
	//envía a la vista, con mensaje de la consulta
	if ($objInstancia->fmEliminar()) {
		$arrRetorno = array(
			"mensaje" => "quitoacceso",
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
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 2000 05:00:00 GMT');
	header('Content-type: application/json');
	echo json_encode($arrRetorno);

	$objInstancia->faDesconectar(); //cierra la conexión
	unset($objInstancia); //destruye el objeto
} //cierre de la función



function fcListaAccesoRol() {
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto

	if (is_file("models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php")) {
		require_once("models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}
	elseif (is_file(".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php")) {
		require_once(".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}

	$objInstancia = new RoleAccess;  //instancia la clase
	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto
	$vpItems = $_POST['setItemsCA'];
	if ($_POST['setItemsCA'] <= 0) //si vvItems vale menor a 0
		$vpItems = 10; //muestra los items predeterminados

	$objInstancia->atrIdRol = $_POST["setRol"];

	$objInstancia->atrItems = $vpItems; //se le asigna al objeto cuantos items tomara

	//por defecto muesta la primera pagina del resultado
	$vpPaginaActual = $_POST['subPaginaCA'];
	if ($_POST['subPaginaCA'] <= 1) //si la subPagina vale menor a 1 muestra la pagina inicial
		$vpPaginaActual = 1;

	//si existe el elemento oculto hidOrden le indica al models por cual atributo listara
	if (isset($_POST["setOrdenCA"])) {
		$objInstancia->atrOrden = $_POST["setOrdenCA"];
		//tambien idica de la forma en que listara ASC o DESC
		$objInstancia->atrTipoOrden = isset($_POST['setTipoOrdenCA']) ? $_POST['setTipoOrdenCA'] : "ASC";
	}

	$objInstancia->atrPaginaInicio = ($vpPaginaActual -1) * $objInstancia->atrItems;

	$rstRecordSet = $objInstancia ->fmListarConAcceso($_POST['setBusquedaCA']);

	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		?>
		<div class='table-responsive'>
			<br />
			<table border='0' valign='center' class='table table-striped text-center table-hover'>
				<thead>
					<tr >
						<th >
							Cod <span class='caret'></span>
						</th>
						<th >
							Vista <span class='caret'></span>
						</th>
						<th >
							Modulo <span class='caret'></span>
						</th>
						<th >
							ACCESOS
						</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($arrRegistro = $objInstancia->getConsultaAsociativo($rstRecordSet)) : ?>
						<tr >
							<td > <?= $arrRegistro["id_vista"]; ?> </td>
							<td> <?= ucwords($arrRegistro["nombre_vista"]); ?> </td>
							<td> <?= ucwords($arrRegistro["nombre_modulo"]); ?> </td>
							<td>
								<a class='btn waves-effect waves-light blue darken-3' data-toggle='tooltip' data-placement='top' title='Editar los accesos de esta pagina' onclick='fjSeleccionarRegistro(this)'
								datos_registro='Seleccion
									|<?= $arrRegistro["estatus_vista"]; ?>
									|<?= $arrRegistro["condicion_vista"]; ?>
									|<?= $arrRegistro["id_vista"]; ?>
									|<?= $arrRegistro["nombre_vista"]; ?>
									|<?= $arrRegistro["descripcion_vista"]; ?>
									|<?= $arrRegistro["id_modulo"]; ?>
									|<?= $arrRegistro["nombre_modulo"]; ?>' >
									<i class='material-icons'>mode_edit</i>
								</a>
								<a class='btn waves-effect waves-light blue darken-3' data-toggle='tooltip' data-placement='top' title='Quitar el acceso total a esta pagina'
									onClick='fjQuitarVista(<?= $arrRegistro["id_vista"]; ?>)' >
									<i class='material-icons'>visibility_off</i>
								</a>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		<center>
			<nav aria-label="Page navigation">
				<ul class="pagination">
					<li>
						<a aria-label="Previous" rel="1" onclick=' fjListaConAcceso(this.rel);' >
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
							<a rel="<?= $i; ?>" onclick='fjListaConAcceso(this.rel);' >
								<?= $i; ?>
							</a>
						</li>
						<?php
					}
					?>
					<li>
						<a aria-label="Next" rel="<?= ($objInstancia->atrPaginaFinal); ?>" onclick=' fjListaConAcceso(this.rel);' >
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
		echo "<br /> <b>¡No se ha encontrado ningún elemento!</b> <br /><br />";
	}
	$objInstancia->faDesconectar(); //cierra la conexión
	unset($objInstancia); //destruye el objeto
} //cierre de la función



function fcListaSinAccesoRol() {
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto

	if (is_file("models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php")) {
		require_once("models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}
	elseif (is_file(".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php")) {
		require_once(".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}

	$objInstancia = new RoleAccess;  //instancia la clase
	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto
	$vpItems = $_POST['setItemsSA'];
	if ($_POST['setItemsSA'] <= 0) //si vvItems vale menor a 0
		$vpItems = 10; //muestra los items predeterminados

	$objInstancia->atrIdRol = $_POST["setRol"];

	$objInstancia->atrItems = $vpItems; //se le asigna al objeto cuantos items tomara

	//por defecto muesta la primera pagina del resultado
	$vpPaginaActual = $_POST['subPaginaSA'];
	if ($_POST['subPaginaSA'] <= 1) //si la subPagina vale menor a 1 muestra la pagina inicial
		$vpPaginaActual = 1;

	//si existe el elemento oculto hidOrden le indica al models por cual atributo listara
	if (isset($_POST["setOrdenSA"])) {
		$objInstancia->atrOrden = $_POST["setOrdenSA"];
		//tambien idica de la forma en que listara ASC o DESC
		$objInstancia->atrTipoOrden = isset($_POST['setTipoOrdenSA']) ? $_POST['setTipoOrdenSA'] : "ASC";
	}

	$objInstancia->atrPaginaInicio = ($vpPaginaActual -1) * $objInstancia->atrItems;
	$rstRecordSet = $objInstancia ->fmListarSinAcceso($_POST['setBusquedaSA']);

	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		?>
		<div class='table-responsive'>
			<br />
			<table border='0' valign='center' class='table table-striped text-center table-hover'>
				<thead>
					<tr>
						<th >
							Cod <span class='caret'></span>
						</th>
						<th >
							Vista <span class='caret'></span>
						</th>
						<th >
							Modulo <span class='caret'></span>
						</th>
						<th >
							ACCESOS
						</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($arrRegistro = $objInstancia->getConsultaAsociativo($rstRecordSet)): ?>
						<tr >
							<td > <?= $arrRegistro["id_vista"]; ?> </td>
							<td> <?= ucwords($arrRegistro["nombre_vista"]); ?> </td>
							<td> <?= ucwords($arrRegistro["nombre_modulo"]); ?> </td>
							<td>
								<a class='btn waves-effect waves-light blue darken-3' data-toggle='tooltip' data-placement='top' onclick='fjSeleccionarRegistro(this);' title='Editar los accesos de esta pagina'
								datos_registro='Asignar
									|<?= $arrRegistro["estatus_vista"]; ?>
									|<?= $arrRegistro["condicion_vista"]; ?>
									|<?= $arrRegistro["id_vista"]; ?>
									|<?= $arrRegistro["nombre_vista"]; ?>
									|<?= $arrRegistro["descripcion_vista"]; ?>
									|<?= $arrRegistro["modulo_fk"]; ?>
									|<?= $arrRegistro["nombre_modulo"]; ?>' >
									<i class='material-icons'>mode_edit</i>
								</a>
							</td>
						</tr>
					<?php endwhile;	?>
				</tbody>
			</table>
		</div>
		<center>
			<nav aria-label="Page navigation">
				<ul class="pagination">
					<li>
						<a aria-label="Previous" rel="1" onclick=' fjListaSinAcceso(this.rel);' >
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
							<a rel="<?= $i; ?>" onclick='fjListaSinAcceso(this.rel);' >
								<?= $i; ?>
							</a>
						</li>
						<?php
					}
					?>
					<li>
						<a aria-label="Next" rel="<?= ($objInstancia->atrPaginaFinal); ?>" onclick=' fjListaSinAcceso(this.rel);' >
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
		echo "<br /> <b>¡No se ha encontrado ningún elemento!</b> <br /><br />";
	}
	$objInstancia->faDesconectar(); //cierra la conexión
	unset($objInstancia); //destruye el objeto
} //cierre de la función



function fcListaBotonSi() {
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto

	if (is_file("models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php")) {
		require_once("models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}
	elseif (is_file(".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php")) {
		require_once(".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}

	$objInstancia = new RoleAccess;  //instancia la clase
	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto

	$objInstancia->atrVista = $_POST["setVista"];
	$objInstancia->atrIdRol = $_POST["setRol"];

	$rstRecordSet = $objInstancia->fmListarBotonNo();
	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		$rstBotonesSi = $objInstancia->fmListarBotonSi();
		$i = 0;
		while ($arrBotonesSi = $objInstancia->getConsultaAsociativo($rstBotonesSi)) {
			$arrB[$i] = $arrBotonesSi["id_boton"];
			$i++;
		}

		$objInstancia->faLiberarConsulta($rstBotonesSi);
		?>
		<div class='table-responsiveX'>
			<br />
			<table border='0' valign='center' class='table table-stripedEEE text-center table-hoverEEE'>
				<thead>
					<tr >
						<th >
							Cod
						</th>
						<th >
							Boton
						</th>
						<th >
							Accesa
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						while ($arrRegistro = $objInstancia->getConsultaAsociativo($rstRecordSet)) :
							$vsSeleccionado = "";
							if (in_array($arrRegistro["id_boton"], $arrB)) {
								$vsSeleccionado = " checked='checked' ";
							}
							?>

							<tr data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación' datos_id='<?= $arrRegistro["id_boton"]; ?>' onclick='fjSeleccionFila(this);'  >
								<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->
								<td> <?= $arrRegistro["id_boton"]; ?> </td>
								<td> <?= ucwords($arrRegistro["nombre_boton"]); ?> </td>
								<td >
									<input type='checkbox' id='chkBoton<?=$arrRegistro["id_boton"]; ?>' name='chkBoton[]' value='<?= $arrRegistro["id_boton"]; ?>' class='chkBotones' <?= $vsSeleccionado; ?> />
								</td>
							</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		<?php
		$objInstancia->faLiberarConsulta($rstRecordSet); //libera de la memoria el resultado asociado a la consulta
	}
	else {
		echo "<br /> <b>¡No se ha encontrado ningún elemento!</b> <br /><br />";
	}
	$objInstancia->faDesconectar(); //cierra la conexión
	unset($objInstancia); //destruye el objeto
} //cierre de la función



function fcListaBotonNo() {
	global $gsObjeto, $gsModulo; //variable que contiene la cadena con el nombre de la Clase u Objeto

	if (is_file("models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php")) {
		require_once("models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}
	elseif (is_file(".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php")) {
		require_once(".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}
	else {
		require_once(".." . DS . ".." . DS . "models" . DS . "{$gsModulo}" . DS . "cls_{$gsObjeto}.php");
	}

	$objInstancia = new RoleAccess;  //instancia la clase
	// se le asignan la cantidad de items a mostrar, si no se define toma el valor por defecto
	$objInstancia->atrIdRol = $_POST["setRol"];

	$rstRecordSet = $objInstancia ->fmListarBotonNo();
	header("Content-Type: text/html; charset=utf-8");
	if ($rstRecordSet) {
		?>
		<div class='table-responsiveX'>
			<br />
			<table border='0' valign='center' class='table table-stripedEEE text-center table-hoverEE'>
				<thead>
					<tr >
						<th >
							Cod
						</th>
						<th >
							Boton
						</th>
						<th >
							Accesa
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						while ($arrRegistro = $objInstancia->getConsultaAsociativo($rstRecordSet)) : ?>

							<tr data-toggle='tooltip' data-placement='top' title='Doble clic para detallar los datos y realizar alguna operación' datos_id='<?= $arrRegistro["id_boton"]; ?>' onclick='fjSeleccionFila(this);'  >
								<!-- FINAL DE LA APERTURA DEL TR DE LA FILA -->
								<td > <?= $arrRegistro["id_boton"]; ?></td>
								<td> <?= ucwords($arrRegistro["nombre_boton"]); ?> </td>
								<td >
									<input type='checkbox' id='chkBoton<?= $arrRegistro["id_boton"]; ?>' name='chkBoton[]' value='<?= $arrRegistro["id_boton"]; ?>' class='chkBotones' />
								</td>
							</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		<?php
		$objInstancia->faLiberarConsulta($rstRecordSet); //libera de la memoria el resultado asociado a la consulta
	}
	else {
		echo "<br /> <b>¡No se ha encontrado ningún elemento!</b> <br /><br />";
	}
	$objInstancia->faDesconectar(); //cierra la conexión
	unset($objInstancia); //destruye el objeto
} //cierre de la función


/*
//destruye lo enviado
if (isset($_POST))
	unset($_POST);

if (isset($_GET))
	unset($_GET);
*/
?>
