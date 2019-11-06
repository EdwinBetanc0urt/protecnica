

/*************************** FUNCION NUEVO REGISTRO ****************************************************************/
/*Utilizada para abrir la ventana y liberar los campos para la entrad nueva de datos*/
function fjNuevoRegistro() {
	fjHabilitar("Habilitar");
	fjUltimoID(vsModulo, vsVista);
	fjLimpiarCampos();
	$("#form" + vsVista + " #divBotonesM").css("display", "none");
	$("#form" + vsVista + " #divBotonesN").css("display", "");
	$("#form" + vsVista + " #divBotonesB").css("display", "none");
	$("#form" + vsVista + " #divBotonesR").css("display", "none");
	$("#form" + vsVista + " #hidEstatus").val("");
	$("#btnHabilitar").attr("disabled", true);

	fjComboGeneral("configuration", "Estado");
	fjComboGeneral("configuration", "Estado", "Municipio");
	// $("#form" + vsVista + " #cmbMunicipio").attr('disabled', true);
}
/*******************************************************************************************************************/

/*************************** FUNCION LIMPIAR CAMPOS ****************************************************************/
function fjLimpiarCampos() {
	$("#form" + vsVista + " #numId").val('');
	$("#form" + vsVista + " #ctxNombre").val('');
	$("#form" + vsVista + " #hidEstado").val('');
	$("#form" + vsVista + " #cmbEstado").val('');
	$("#form" + vsVista + " #hidMunicipio").val('');
	$("#form" + vsVista + " #cmbMunicipio").val('');
	$("#form" + vsVista + " #hidEstatus").val('');
}
/*******************************************************************************************************************/

function fjHabilitar(pvValor) {
    if ("Habilitar" == pvValor) {
        vbDisable = false;
        vsValor = "Desabilitar";
        vsTexto = '<p class="fa fa-check-square-o mb"></p> ' + vsValor;
        vsMostrar = "";
    }
    if ("Desabilitar" == pvValor) {
        vbDisable = true;
        vsValor = "Habilitar";
        vsTexto = '<p class="fa fa-check-square-o mb"></p> ' + vsValor;
        vsMostrar = "none";
	}
	// $("#form" + vsVista + " #numId").attr('disabled', vbDisable);
	// $("#form" + vsVista + " #ctxNombre").attr('disabled', vbDisable);
	// $("#form" + vsVista + " #cmbEstado").attr('disabled', vbDisable);
	// $("#form" + vsVista + " #cmbMunicipio").attr('disabled', vbDisable);
	$("#form" + vsVista + " #btnRegistrar").attr('disabled', vbDisable);
	$("#form" + vsVista + " #btnModificar").attr('disabled', vbDisable);
	$("#form" + vsVista + " #btnBorrar").attr('disabled', vbDisable);
	$("#form" + vsVista + " #btnRestaurar").attr('disabled', vbDisable);
	// $("#form" + vsVista + " #cmbEstado").attr("disabled", vbDisable);
	$("#btnHabilitar").html(vsTexto);
	$("#btnHabilitar").val(vsValor);
	// $("#form" + vsVista + " #divBotonesM").css("display", vsMostrar);
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
    $("#form" + vsVista + " #numId").val( parseInt(arrFilas[3]));
    $("#form" + vsVista + " #ctxNombre").val(arrFilas[4]);
    /* $("#form" + vsVista + " #hidEstado").val(arrFilas[2]);
    fjComboGeneral("configuration", "Estado");
    $("#form" + vsVista + " #hidMunicipio").val(arrFilas[3]);
    fjComboGeneral("configuration", "Municipio", "Estado");
    $("#form" + vsVista + " #cmbEstado").attr("disabled", true);
*/
    $("#form" + vsVista + " #hidEstatus").val(arrFilas[1]);

	$("#form" + vsComponente + " #hidEstado").val(arrFilas[5].trim());
	$('#form' + vsComponente + ' #cmbEstado')
		.val(arrFilas[5].trim())
		.trigger('change');

	$("#form" + vsComponente + " #hidMunicipio").val(arrFilas[6].trim());
	$('#form' + vsComponente + ' #cmbMunicipio')
		.val(arrFilas[6].trim())
		.trigger('change');

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
//funcion.javascript.Enviar (parametro.vista.Valor)
function fjEnviar(pvValor) {
	let arrFormulario = $("#form" + vsVista);
	var vjNombre = document.getElementById("ctxNombre");
	var vjEstado = document.getElementById("cmbEstado");
	var vjMunicipio = document.getElementById("cmbMunicipio");
	var vbComprobar = true;

	//si el botón pulsado es igual a Registrar o Modificar enviara el formulario
	if (pvValor === "Registrar" || pvValor === "Modificar") {

		//si el ctxNombre está vació no enviara el formulario
		if (vjNombre.value === "") {
			vbComprobar = false;
			//alert(" LA DESCRIPCION ES OBLIGATORIA \n No puede estar vacía para " + pvValor.toUpperCase());
			swal({
				title: '¡Atención!',
				text: 'LA DESCRIPCION ES OBLIGATORIA \n No puede estar vacía para' + pvValor.toUpperCase(),
				type: 'warning',
				confirmButtonText: 'Ok'
			}).then(function () {
				vjNombre.focus();
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}

		if (vjEstado.value == "") {
			vbComprobar = false;
			//alert("EL Estado DE PROVEEDOR ES OBLIGATORIO \n Debe ser seleccionado para para " + pvValor.toUpperCase());
			swal({
				title: '¡Atención!',
				text: 'EL ESTADO ES OBLIGATORIO \n Debe ser seleccionado para para' + pvValor.toUpperCase(),
				type: 'warning',
				confirmButtonText: 'Ok'
			}).then(function () {
				vjEstado.focus();
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}

		if (vjMunicipio.value == "") {
			vbComprobar = false;
			//alert("EL Municipio DE PROVEEDOR ES OBLIGATORIO \n Debe ser seleccionado para para " + pvValor.toUpperCase());
			swal({
				title: '¡Atención!',
				text: 'EL MUNICIPIO ES OBLIGATORIO \n Debe ser seleccionado para para' + pvValor.toUpperCase(),
				type: 'warning',
				confirmButtonText: 'Ok'
			}).then(function () {
				vjMunicipio.focus();
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}
	}

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {
		document.getElementById("vvOpcion").value = pvValor; //valor.vista.Opcion del hidden
		arrFormulario.submit(); //Envía el formulario
	}
}



//al cargar el documento
$(function(){

	fjMostrarLista(vsModulo, vsVista); //llama esta función en el jsc_General.js
	//funcion en jsc_Reporte que genera los option en los select de la A a la Z
	//para los rangos de reporte desde letra inicial hasta letra incial
	/*
	fjAlfabetoCombo("cmbNombreInicial");
	fjAlfabetoCombo("cmbNombreFinal");

	fjSinRango();

	$("#radRangoTipoT").click(function () {
		fjSinRango();
	});
	$("#radRangoTipoD, #radRangoTipoF").click(function () {
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
	//llama la funcion para cargar los estados
	//fjCargarEstado();
	fjComboGeneral("configuration", "Estado");

	$("#cmbMunicipio").attr("disabled", true);

	//cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbEstado").change(function() {
		$("#cmbMunicipio").attr("disabled", false);
		//$("#cmbMunicipio").val(""); //deselecciona el campo del combo
		//$("#hidMunicipio").val(""); //blanquea el campo del hidden
		//fjCargarMunicipio();
		fjComboGeneral("configuration", "Municipio", "Estado");
	});


	if ($("#hidMunicipio").val() != "") {
		$("#cmbMunicipio").attr("disabled", false);
		viTemporal = $("#hidMunicipio").val(); //guarda el valor que trajo el GET
		fjComboGeneral("configuration", "Municipio", "Estado"); //carga (y blanquea) el combo
		$("#hidMunicipio").val(viTemporal) ; //reasigna el valor
		console.log($("#hidMunicipio").val() + ", codigo del MUNICIPIO con el GET");
	}
	else {
		console.log("el hid del MUNICIPIO esta vacio");
	}

});
