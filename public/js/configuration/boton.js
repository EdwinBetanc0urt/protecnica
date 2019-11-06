
/**
 * Función JavaScript Nuevo Registro, llama a la función fjUltimoID para obtener
 * el ultimo código, limpia el formulario y lo habilita para su edición.
 */
function fjNuevoRegistro() {
	fjHabilitar("Habilitar");

	$("#form" + vsComponente)[0].reset();

	fjCamposSoloLectura("#form" + vsComponente, false);
	fjUltimoID(vsModulo, vsComponente);

	$("#form" + vsComponente + " #divBotonesM").css("display", "none");
	$("#form" + vsComponente + " #divBotonesN").css("display", "");
	$("#form" + vsComponente + " #divBotonesR").css("display", "none");
	$("#btnHabilitar").attr("disabled", true);
} //cierre de la función



/**
 * Función JavaScript Habilitar, actúa como interruptor y dependiendo de la acción
 * pulsada, habilita o deshabilita los campos del formulario.
 * @param {string} pvValor, habilitar o deshabilitar.
 */
function fjHabilitar(pvValor) {
	if ("Habilitar" == pvValor) {
		vbDisable = false;
		vsValor = "Desabilitar";
		vsTexto = '<i class="material-icons">lock</i> ' + vsValor;
		vsMostrar = "";
	}
	else if ("Desabilitar" == pvValor) {
		vbDisable = true;
		vsValor = "Habilitar";
		vsTexto = '<i class="material-icons">vpn_key</i> ' + vsValor;
		vsMostrar = "none";
	}
	$("#form" + vsComponente + " #numId").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #ctxNombre").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #ctxIcono").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #ctxDescripcion").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnRegistrar").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnModificar").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnBorrar").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnRestaurar").attr('disabled', vbDisable);
	$("#btnHabilitar").html(vsTexto);
	$("#btnHabilitar").val(vsValor);
	$("#form" + vsComponente + " #divBotonesM").css("display", vsMostrar);
	//console.log(pvValor);
} //cierre de la función



/**
 * Función JavaScript Seleccionar Registro, coloca los datos de la fila seleccionada
 * en el formulario.
 * @param {string} pvValor, acción o botón pulsado por el usuario.
 */
function fjSeleccionarRegistro(pvDOM) {
	//console.log(pvDOM);
	//debe ser con javascript porque es recibido directamente del DOM
	if (typeof pvDOM.getAttribute !== 'undefined')
		arrFilas = pvDOM.getAttribute('datos_registro').split('|');
	//debe ser con jQuery porque es recibido como tal con jQuery
	else if (jQuery.isFunction(pvDOM.attr))
		arrFilas = pvDOM.attr('datos_registro').split('|');
	else
		return;
	//console.log(arrFilas);

	$("#btnHabilitar").attr('disabled', false);
	$("#form" + vsComponente + " #hidEstatus").val(arrFilas[1].trim());
	$("#form" + vsComponente + " #hidCondicion").val(arrFilas[2].trim());
	$("#form" + vsComponente + " #numId").val(parseInt(arrFilas[3].trim()));
	$("#form" + vsComponente + " #ctxNombre").val(arrFilas[4].trim());
	$("#form" + vsComponente + " #ctxDescripcion").val(arrFilas[5].trim());
	$("#form" + vsComponente + " #ctxIcono").val(arrFilas[6].trim());
	$("#vvOpcion").val(arrFilas[0].trim());

	if ($("#form" + vsComponente + " #hidEstatus").val() == "inactivo") {
		$("#form" + vsComponente + " #divBotonesM").css("display", "none");
		$("#form" + vsComponente + " #divBotonesN").css("display", "none");
		$("#form" + vsComponente + " #divBotonesR").css("display", "");
		fjCamposSoloLectura("#form" + vsComponente);
	}
	else {
		$("#form" + vsComponente + " #divBotonesM").css("display", "");
		$("#form" + vsComponente + " #divBotonesN").css("display", "none");
		$("#form" + vsComponente + " #divBotonesR").css("display", "none");
	}

	fjHabilitar("Desabilitar");
	$("#VentanaModal").modal('show'); //para boostrap v3.3.7
} //cierre de la función



/**
 * Función JavaScript Enviar, envía los datos del formulario al controllers.
 * @param {string} pvValor, acción o botón pulsado por el usuario.
 */
function fjEnviar(pvValor) {
	//se definen las variables locales
	let vsNombre = $("#form" + vsComponente + " #ctxNombre"),
		vsDescripcion = $("#form" + vsComponente + " #ctxDescripcion"),
		vbComprobar = true; //verifica que todo este true o un solo false no envía

	//si el botón pulsado es igual a Registrar o Modificar
	if (pvValor === "Registrar" || pvValor === "Modificar") {
		//si el campo está vació no enviara el formulario
		if (vsNombre.val().trim() === "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'EL NOMBRE ES OBLIGATORIO <br /> No puede estar vacía para '
					+ pvValor.toUpperCase(),
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok',
				footer: ' '
			}).then((result) => {
				vsNombre.focus();
			});
			return; //rompe la función para se verifique antes de continuar
		}
		//si el campo está vació no enviara el formulario
		if (vsDescripcion.val().trim() === "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'LA DESCROPCION ES OBLIGATORIA <br /> No puede estar ' +
					'vacía para ' + pvValor.toUpperCase(),
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok',
				footer: ' '
			}).then((result) => {
				vsDescripcion.focus();
			});
			return; // rompe la función para que se verifique antes de continuar
		}
	} //cierre del condicional si es el botón registrar o modificar

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {
		$("#form" + vsComponente + " #vvOpcion").val(pvValor);
		fjEnvioDinamico(vsComponente); //envía él formulario mediante ajax
		//arrFormulario.submit(); //Envía el formulario
		//espera un tiempo en mili segundos para ser ejecutado
		setTimeout(
			function () {
				fjMostrarLista(vsModulo, vsComponente); //lista el contenido en la vista
			},
			500
		);
	}
} //cierre de la función



/**
 * Función JavaScript Colocar Valores, según los datos recibidos en la función
 * fjEnviar y los coloca en los campos del formulario.
 * @param {array} arrDatos, datos recibidos de la consulta.
 */
function fjColocarValores(arrDatos) {
	$("#form" + vsComponente + " #hidEstatus").val(arrDatos.estatus);
	$("#form" + vsComponente + " #hidCondicion").val(arrDatos.condicion);
	$("#form" + vsComponente + " #numId").val(arrDatos.id);
	$("#form" + vsComponente + " #ctxNombre").val(arrDatos.nombre);
	$("#form" + vsComponente + " #ctxDescripcion").val(arrDatos.descripcion);
	$("#form" + vsComponente + " #ctxIcono").val(arrDatos.icono);
	$("#form" + vsComponente + " #vvOpcion").val(arrDatos.getOpcion);
} //cierre de la función



//al cargar el documento
$(function() {
	//funcion en jsc_Reporte que genera los option en los select de la A a la Z
	//para los rangos de reporte desde letra inicial hasta letra incial
	fjMostrarLista(vsModulo, vsComponente); //lista el contenido en la vista

	/*
	fjAlfabetoCombo("cmbNombreInicial");
	fjAlfabetoCombo("cmbNombreFinal");

	fjSinRango();

	$("#radRangoTipoT").click(function () {
		fjSinRango();
	});
	$("#radRangoTipoD, #radRangoTipoF ").click(function () {
		fjConRango();
	});

	$("#radRangoId").click(function () {
		fjRangoId();
	});

	$("#radRangoNombre").click(function () {
		fjRangoNombre();
	});

	$("#radRangoEstatus").click(function () {
		fjRangoEstatus();
	});
	*/
});
