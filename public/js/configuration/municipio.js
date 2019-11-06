
function fjNuevoRegistro() {
	fjHabilitar("Habilitar");

	$("#form" + vsComponente)[0].reset();

	fjCamposNoSoloLectura("#form" + vsComponente);
	fjUltimoID(vsModulo, vsComponente);

	$("#form" + vsComponente + " #divBotonesM").css("display", "none");
	$("#form" + vsComponente + " #divBotonesN").css("display", "");
	$("#form" + vsComponente + " #divBotonesR").css("display", "none");
	$("#btnHabilitar").attr("disabled", true);
	fjComboGeneral("configuration", "Estado", "", "Estado");
}//al cargar el documento



function fjHabilitar(pvValor) {
	if ("Habilitar" == pvValor) {
		vbDisable = false;
		vsValor = "Desabilitar";
		vsTexto = '<i class="material-icons">lock</i> ' + vsValor;
		vsMostrar = "";
	}
	if ("Desabilitar" == pvValor) {
		vbDisable = true;
		vsValor = "Habilitar";
		vsTexto = '<i class="material-icons">vpn_key</i> ' + vsValor;
		vsMostrar = "none";
	}
	$("#form" + vsComponente + " #numId").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #ctxNombre").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #cmbEstado").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #hidEstado").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnRegistrar").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnModificar").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnBorrar").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnRestaurar").attr('disabled', vbDisable);
	$("#btnHabilitar").html(vsTexto);
	$("#btnHabilitar").val(vsValor);
	$("#form" + vsComponente + " #divBotonesM").css("display", vsMostrar);
	console.log(pvValor);
}



function fjSeleccionarRegistro(pvDOM) {
	console.log(pvDOM);

	if (jQuery.isFunction(pvDOM.attr))
		arrFilas = pvDOM.attr('datos_registro').split('|'); //debe ser con jquery porque es recibido como tal con jquery

	if (typeof pvDOM.getAttribute !== 'undefined')
		arrFilas = pvDOM.getAttribute('datos_registro').split('|'); //debe ser con javascript porque es recibido cdirectamete del DOM

	console.log(arrFilas);

	$("#btnHabilitar").attr('disabled', false);

	$("#form" + vsComponente + " #hidEstatus").val(arrFilas[1].trim());
	$("#form" + vsComponente + " #hidCondicion").val(arrFilas[2].trim());
	$("#form" + vsComponente + " #numId").val( parseInt(arrFilas[3].trim()));
	$("#form" + vsComponente + " #ctxNombre").val(arrFilas[4].trim());
	$("#form" + vsComponente + " #hidEstado").val("");
	$("#form" + vsComponente + " #cmbEstado").val("");
	$("#form" + vsComponente + " #hidEstado").val(arrFilas[5].trim());
	fjComboGeneral("configuration", "Estado");

	// $("#formLista" + vsComponente + "TipoArticulo #divListado").html("");
	$("#vvOpcion").val(arrFilas[0].trim());

	$("#form" + vsComponente + " #cmbEstado").attr('disabled', true);

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
}


//funcion.javascript.Enviar (parametro.vista.Valor)
function fjEnviar(pvValor) {
	//se definen las variables locales
	let arrFormulario = $("#form" + vsComponente);
	let vsNombre = $("#form" + vsComponente + " #ctxNombre");
	let vsEstado = $("#form" + vsComponente + " #hidEstado");
	let vbComprobar = true; // variable javascript Comprobar, para verificar que todo este true o un solo false no envía

//si el botón pulsado es igual a Registrar o Modificar
	if (pvValor === "Registrar" || pvValor === "Modificar") {

		//si el campo está vació no enviara el formulario
		if (vsNombre.val().trim() === "") {
			vbComprobar = false;
			swal({
				title: '¡Atencion!',
				html: 'EL NOMBRE ES OBLIGATORIO <br /> No puede estar vacía para ' + pvValor.toUpperCase(),
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok',
				footer: ' '
			}).then((result) => {
				vsNombre.focus();
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}
		//si el campo está vació no enviara el formulario
		if (vsEstado.val().trim() === "") {
			vbComprobar = false;
			swal({
				title: '¡Atencion!',
				html: 'EL ESTADO ES OBLIGATORIO <br /> No puede estar vacía para ' + pvValor.toUpperCase(),
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok',
				footer: ' '
			}).then((result) => {
				vsEstado.focus();
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}
	} //cierre del condicional si es el boton registrar o modificar

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {
		$("#form" + vsComponente + " #vvOpcion").val(pvValor); //valor.vista.Opcion del hidden
		fjEnvioDinamico(vsComponente);

		//espera un tiempo en milisegundos para ser ejecutado
		setTimeout(
			function () {
				fjMostrarLista(vsModulo, vsComponente); //lista el contenido en la vista
			},
			500
		);
		//arrFormulario.submit(); //Envía el formulario
	}
}



function fjColocarValores(arrDatos) {
	$("#form" + vsComponente + " #hidEstatus").val(arrDatos.estatus);
	$("#form" + vsComponente + " #hidCondicion").val(arrDatos.condicion);
	$("#form" + vsComponente + " #numId").val(arrDatos.id);
	$("#form" + vsComponente + " #ctxNombre").val(arrDatos.nombre);
	$("#form" + vsComponente + " #cmbEstado").val(arrDatos.estado);
	// $("#form" + vsComponente + " #hidEstado").val(arrDatos.estado);
	$("#vvOpcion").val(arrDatos.getOpcion);
}



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
