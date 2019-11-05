<?php

// existe y esta la variable de sesión rol
if (isset($_SESSION["sesion"]) AND $_SESSION["sesion"] == "sistema") {


	/* =============================================================================
						Función Vista BOTON REGISTRAR
	============================================================================= */
	function fvRegistrar() {
		global $objAcceso, $arrVistas; //variables globales que estan al inicio de la vista
		$vbAcceso = $objAcceso->fmConsultaAccesoBoton($arrVistas["id_vista"], 1); //consulta si tiene acceso al botón

		//si no hay un getOpcion lo muestra y tiene acceso
		//if (empty($_GET["getOpcion"]) AND $vbAcceso) {
		if ($vbAcceso) {
			?>
				<button type='button' value='Registrar' id="btnRegistrar"
					name="btnRegistrar" class="btn "
					onclick='fjEnviar("Registrar", "<?= $psVista; ?>" );' >
					<i class="material-icons white-text">done</i>
					<span class="white-text">Registrar</span>
				</button>
				
			<?php
		}
		else {
			?>
			No tiene accesos para ingresar nuevos registros
			<?php
		}
	}
	/* ==================================================================================
			Función Vista BOTON NUEVO, abre la ventana modal con el formulario
	================================================================================== */
	function fvNuevo($psTexto = 'Modificar', $psFuncionJS = "") {
		global $objAcceso, $arrVistas; //variables globales que estan al inicio de la vista
		$vbAcceso = $objAcceso->fmConsultaAccesoBoton($arrVistas["id_vista"], 1); //consulta si tiene acceso al botón
		//si existe el getOpcion la ventana modal tiene contenido
		//if (isset($_GET["getOpcion"])) {
		?>
			<button id="btnNuevo" class="btn " data-toggle="modal" data-target="#VentanaModal" onclick="fjNuevoRegistro();">
				<span class="glyphicon glyphicon-plus"></span>
			</button>
		<?php

	}


	/* =============================================================================
							Función Vista BOTON MODIFICAR
	============================================================================= */
	function fvModificar($psTexto = 'Modificar', $psFuncionJS = "") {
		global $objAcceso, $arrVistas; //variables globales que están al inicio de la vista
		//var_dump($objAcceso->fmConsultaAccesoBoton($arrVistas["id_vista"], 2));
		$vbAcceso = $objAcceso->fmConsultaAccesoBoton($arrVistas["id_vista"], 2); //consulta si tiene acceso al botón
		//si existe el getOpcion y vale Selección (del listado)
		//if ($vbAcceso AND isset($_GET["getOpcion"]) && ($_GET["getOpcion"] == "Seleccion" || $_GET["getOpcion"] == "Modificar")) {
		if ($vbAcceso) {
			?>
			<button type='button' value='Modificar' id='btnModificar'
				name="btnModificar" class="btn "
				onclick='fjConfirmar(this.value);' >
				<i class="material-icons">mode_edit</i>
				<?= $psTexto ?>
			</button>
			<?php
		}
	}




	/* ===============================================================================
						Funcion Vista BOTON BORRAR
	================================================================================ */
	function fvBorrar($psTexto = 'Modificar', $psFuncionJS = "")	{
		global $objAcceso, $arrVistas; //variables globales que estan al inicio de la vista
		$vbAcceso = $objAcceso->fmConsultaAccesoBoton($arrVistas["id_vista"], 3); //consulta si tiene acceso al boton
		//if ($vbAcceso AND isset($_GET["getOpcion"]) && ($_GET["getOpcion"] == "Seleccion"))	{
		if ($vbAcceso)	{
			?>
			<button type='button' value='Borrar' id='btnBorrar'
				name="btnBorrar" class="btn "
				onclick='fjConfirmar(this.value);' >
				<i class="material-icons">delete</i>
				Borrar
			</button>
			<?php
		}
	}



	/* ===============================================================================
						Función Vista BOTON RESTAURAR
	================================================================================ */
	function fvRestaurar($psTexto = 'Modificar', $psFuncionJS = "") {
		global $objAcceso, $arrVistas; //variables globales que estan al inicio de la vista
		$vbAcceso = $objAcceso->fmConsultaAccesoBoton($arrVistas["id_vista"], 7); //consulta si tiene acceso al boton
		//if ($_SESSION['rol']<=2 && isset($_GET["opcion"]) && $_GET["opcion"]=="Seleccion")
		//si gepOpcion existe y vale Inactivo o si getEstatus esxiste y vale incativo
		//if ($vbAcceso AND isset($_GET["getOpcion"]) && (isset($_GET["getEstatus"]) && $_GET["getEstatus"] == "inactivo")) {
		if ($vbAcceso) {
			?>
			<button type='button' value='Restaurar' id='btnRestaurar'
				name="btnRestaurar" class="btn "
				onclick='fjConfirmar(this.value);' >
				<i class="material-icons">loop</i>
				Restaurar
			</button>
			<?php
		}
	}




	/* ===============================================================================
						BotonesCancelar, acceden todos los roles
	================================================================================ */
	function fvHabilitar($psTexto = 'Modificar', $psFuncionJS = "") {
		?>
			<button type="button" value="Habilitar" id="btnHabilitar"
			 class="btn " name="btnHabilitar" onclick="fjHabilitar(this.value);" >
				<i class="material-icons">vpn_key</i>
				Habilitar
			</button>
		<?php
	}


	/* =============================================================================
						Función Vista BOTON PROCESAR
	============================================================================= */

	function fvProcesar($psTexto = 'Procesar', $psValue = "Procesar", $psFuncionJS = "") {
		global $objAcceso, $arrVistas; //variables globales que estan al inicio de la vista
		$vbAcceso = $objAcceso->fmConsultaAccesoBoton($arrVistas["id_vista"], 4); //consulta si tiene acceso al boton
		//si no hay un getOpcion lo muestra
		//if ($vbAcceso AND empty($_GET["getOpcion"]) || ($_GET["getEstatus"] != "procesado")) {
		if ($vbAcceso) {
			?>
			<button type='button' value='<?= $psValue ?>' id="btnProcesar" msj="<?= $psTexto ?>"
				name="btnProcesar" class="btn "
				onclick='fjConfirmar2(this.value, this);'>
				<i class="material-icons">done_all</i>
				<?= $psTexto ?>
			</button>
			<?php
		}
	}

	function fvGuardar($psTexto = 'Modificar', $psFuncionJS = "") {
		?>
		<button type='button' value='Guardar' id="btnGuardar"
			name="btnGuardar" class="btn "
			onclick='fjGuardar(this.value);' >
			<i class="material-icons">done_all</i>
			Guardar
		</button>
		<?php
	}




	/* ================================================================================
			Anular los 1 Administradores, 2 Coordinadores
	================================================================================ */
	function fvAnular($psTexto = 'Modificar', $psFuncionJS = "") {
		?>
		<button type='button' value='Anular' id="btnAnular"
			name="btnAnular" class="btn btn-danger"
			onclick='fjAnular(this.value);' >
			<i class="material-icons">not_interested</i>
			Anular
		</button>
		<?php
	}


	/* ================================================================================
			Borrar los 1 Administradores, 2 Coordinadores
	================================================================================ */
	function fvEliminar($psTexto = 'Modificar', $psFuncionJS = "") {
		?>
		<button type='button' value='Borrar' id="btnBorrar"
			name="btnBorrar" class="btn btn-danger"
			onclick='fjBorrar(this.value);' >
			<i class="material-icons">not_interested</i>
			Borrar
		</button>
		<?php
	}

	/* ===============================================================================
				BotonesCancelar, acceden todos los roles
	================================================================================ */
	function fvCancelar($psTexto = 'Modificar', $psFuncionJS = "") {
		?>
		<a id="btnCancelar"
		 class="btn btn-danger" name="btnCancelar" onclick='fjCancelar();'>
			<i class="material-icons">navigation</i>
			Cancelar
		</a>
		<?php
	}


	function fvAbrir($psTexto = 'Modificar', $psFuncionJS = "") {
		//si no hay un getOpcion lo muestra
		?>
		<button type='button' value='Abrir' id="btnAbrir"
			 name="btnAbrir" class="btn btn-warning"
			 onclick='fjEnviar(this.value);' >
			<i class="material-icons white-text"> lock_open </i>
			<span class="white-text">Abrir</span>
		</button>
		<?php
	}

	function fvCerrar($psTexto = 'Modificar', $psFuncionJS = "") {
		?>
		<button type='button' value='Cerrar' id="btnCerrar"
			 name="btnCerrar" class="btn btn-danger"
			 onclick='fjEnviar(this.value);' >
			<i class="material-icons white-text"> lock </i>
			<span class="white-text">Cerrar</span>
		</button>
		<?php
	}

	/* ==================================================================================
			Funcion Vista BOTON REPORTE, abre la ventana con el reporte a generar
	================================================================================== */
	function fvReporte($piVista = "") {
		global $objAcceso, $vsModulo, $vsVista; //variables globales que están al inicio de la vista
		$vbAcceso = $objAcceso->fmConsultaAccesoBoton($piVista, 8); //consulta si tiene acceso al botón

		if ($vbAcceso)
			$vsAcceso = 'title="Genera reportes" ';
		else
			$vsAcceso = 'title="No tiene acceso para generar reportes en esta pagina" disabled ';

		?>
		<button type='button' id="btnReporte" name="btnReporte" value='Reporte' <?=$vsAcceso;?>
			class="btn " data-toggle="tooltip" data-placement="top"
			onclick='fjGenerarReporte("<?=$vsModulo;?>", "<?=$vsVista;?>");' >
			<i class="material-icons">receipt</i>
			Generar Reporte
		</button>
		<?php
	}
} // cierre del condicional si existe el rol

?>
