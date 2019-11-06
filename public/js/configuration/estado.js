vsComponente = "Estado";
vsVista = "Estado";

function fjNuevoRegistro() {
	fjHabilitar("Habilitar");

	$("#form" + vsComponente)[0].reset();


	$('#form' + vsComponente + ' #hidPais1').val(null);
	$('#form' + vsComponente + ' #cmbPais1')
		.val(null)
		.trigger('change');

	// $('#form' + vsComponente + ' #hidCiudad').val(null);
	// $('#form' + vsComponente + ' #cmbCiudad')
	// 	.val(null)
	// 	.attr('disabled', true)
	// 	.trigger('change');

	fjCamposNoSoloLectura("#form" + vsComponente);
	fjUltimoID(vsModulo, vsComponente);

	//$("#form" + vsComponente + " #cmbCiudad").attr('disabled', true);

	$("#form" + vsComponente + " #divBotonesM").css("display", "none");
	$("#form" + vsComponente + " #divBotonesN").css("display", "");
	$("#form" + vsComponente + " #divBotonesR").css("display", "none");
	$("#btnHabilitar").attr("disabled", true);
}



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
	$("#form" + vsComponente + " #ctxNombreEstado").attr('disabled', vbDisable);
	// $("#form" + vsComponente + " #numCodigoUbigeo").attr('disabled', vbDisable);
	// $("#form" + vsComponente + " #ctxCodigoIso").attr('disabled', vbDisable);
	// $("#form" + vsComponente + " #cmbCiudad").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #cmbPais1").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnRegistrar").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnModificar").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnBorrar").attr('disabled', vbDisable);
	$("#form" + vsComponente + " #btnRestaurar").attr('disabled', vbDisable);
	$("#btnHabilitar").html(vsTexto);
	$("#btnHabilitar").val(vsValor);
	$("#form" + vsComponente + " #divBotonesM").css("display", vsMostrar);
	//console.log(pvValor);
}



function fjSeleccionarRegistro(pvDOM) {
	//console.log(pvDOM);

	//debe ser con javascript porque es recibido directamente del DOM
	if (typeof pvDOM.getAttribute !== 'undefined')
		arrFilas = pvDOM.getAttribute('datos_registro').split('|');
	//debe ser con jquery porque es recibido como tal con jquery
	else if (jQuery.isFunction(pvDOM.attr))
		arrFilas = pvDOM.attr('datos_registro').split('|');
	else
		return;
	//console.log(arrFilas);

	$("#btnHabilitar").attr('disabled', false);
	$("#form" + vsComponente + " #hidEstatus").val(arrFilas[1].trim());
	$("#form" + vsComponente + " #hidCondicion").val(arrFilas[2].trim());
	$("#form" + vsComponente + " #numId").val(parseInt(arrFilas[3].trim()));
	$("#form" + vsComponente + " #ctxNombreEstado").val(arrFilas[4].trim());
	$("#vvOpcion").val(arrFilas[0].trim());

	$('#form' + vsComponente + ' #hidPais1').val(arrFilas[5].trim());
	$('#form' + vsComponente + ' #cmbPais1')
		.val(arrFilas[5].trim())
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

function fjEnviar(pvValor){
	fjEnviarEstado( pvValor );
}

//función.javascript.Enviar (parámetro.vista.Valor)
function fjEnviarEstado(pvValor) {
	//se definen las variables locales
	let arrFormulario = $("#formEstado");
	let vsNombre = $("#formEstado #ctxNombreEstado");
	let vsPais = $("#formEstado #cmbPais1");
	let vbComprobar = true; // variable booleana Comprobar, para verificar que todo este true o un solo false no envía

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
			return; // rompe la función para que el usuario verifique antes de continuar
		}
		//si el campo está vació no enviara el formulario
		if (vsPais.val().trim() === "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
				html: 'EL PAIS ES OBLIGATORIO <br /> No puede estar vacía para '
					+ pvValor.toUpperCase(),
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok',
				footer: ' '
			}).then((result) => {
				vsPais.focus();
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}
	} //cierre del condicional si es el boton registrar o modificar

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {
		$("#formEstado #vvOpcion").val(pvValor); //valor.vista.Opcion del hidden
        $.ajax({
            method: "POST",
            url: arrFormulario.attr("action"),
            data: arrFormulario.serialize()
        })
        .done(function(arrRespuesta) {
			console.log(arrRespuesta);
            fjMensajes(arrRespuesta.mensaje); //imprime el mensaje de estado
            if (arrRespuesta.ver == "no") {
                if ( $('#formEstado #VentanaModal').length > 0 ) {
                    $("#formEstado #VentanaModal").modal("hide");
                }
                $("#formEstado")[0].reset();
            }
            if (pvHeredado != "1"){
            	fjMostrarLista(vsModulo, vsComponente);
            }
            if (pvHeredado == "1"){
            	fjComboGeneral("configuration", "Estado");
            	fjMostarFormulario("Personal");
            	// $("#VentanaModal").modal("hide");
			}
			else{
				fjMostrarLista(vsModulo, pvVista),
				setTimeout(
					function () {
						fjMostrarLista(vsModulo, vsComponente); //lista el contenido en la vista
					},
					500
				);
			}
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            swal({
                title: 'Estatus: ' + textStatus,
                html: 'La petición para <b>' + pvValor.toUpperCase() +
                    '</b> no ha sido procesada correctamente',
                type: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok',
                footer: '<b>Error http:</b> ' + errorThrown + " / " + jqXHR.status
            });
		});
		//arrFormulario.submit(); //Envía el formulario
	}
} //cierre de la función enviar



// function fjColocarValores(arrDatos) {
// 	$("#form" + vsComponente + " #hidEstatus").val(arrDatos.estatus);
// 	$("#form" + vsComponente + " #hidCondicion").val(arrDatos.condicion);
// 	$("#form" + vsComponente + " #numId").val(arrDatos.id);
// 	$("#form" + vsComponente + " #ctxNombreEstado").val(arrDatos.nombre);
// 	$("#form" + vsComponente + " #cmbPais1").val(arrDatos.pais);
// 	$("#form" + vsComponente + " #ctxIcono").val(arrDatos.icono);
// 	$("#vvOpcion").val(arrDatos.getOpcion);
// }



//al cargar el documento
$(function() {
	//función en jsc_Reporte que genera los option en los select de la A a la Z
	//para los rangos de reporte desde letra inicial hasta letra incial
	fjMostrarLista(vsModulo, vsComponente); //lista el contenido en la vista

	fjComboGeneral("configuration", "Pais", "", "Pais1");
	// fjComboGeneral("configuration", "Ciudad");
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
