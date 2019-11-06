vsComponente = "Pais";
vsVista = "Pais";

function fjNuevoRegistro() {
	fjHabilitar("Habilitar");

	$("#form" + vsVista)[0].reset();

	fjCamposNoSoloLectura("#form" + vsVista);
	fjUltimoID(vsModulo, vsVista);

	$('#form' + vsComponente + ' #hidCiudad').val(null);
	$('#form' + vsComponente + ' #cmbCiudad')
		.val(null)
		.attr('disabled', true)
		.trigger('change');
	//$("#form" + vsVista + " #divCiudad").css("display", "none");

	$("#form" + vsVista + " #divBotonesM").css("display", "none");
	$("#form" + vsVista + " #divBotonesN").css("display", "");
	$("#form" + vsVista + " #divBotonesR").css("display", "none");
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
	$("#form" + vsVista + " #numId").attr('disabled', vbDisable);
	$("#form" + vsVista + " #ctxNombre").attr('disabled', vbDisable);
	$("#form" + vsVista + " #ctxDescripcion").attr('disabled', vbDisable);
	$("#form" + vsVista + " #numCodigoIso").attr('disabled', vbDisable);
	$("#form" + vsVista + " #ctxCodigoIsoAlfa2").attr('disabled', vbDisable);
	$("#form" + vsVista + " #ctxCodigoIsoAlfa3").attr('disabled', vbDisable);
	$("#form" + vsVista + " #ctxPrefijo").attr('disabled', vbDisable);
	$("#form" + vsVista + " #btnRegistrar").attr('disabled', vbDisable);
	$("#form" + vsVista + " #btnModificar").attr('disabled', vbDisable);
	$("#form" + vsVista + " #btnBorrar").attr('disabled', vbDisable);
	$("#form" + vsVista + " #btnRestaurar").attr('disabled', vbDisable);
	$("#btnHabilitar").html(vsTexto);
	$("#btnHabilitar").val(vsValor);
	$("#form" + vsVista + " #divBotonesM").css("display", vsMostrar);
	console.log(pvValor);
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
	$("#form" + vsVista + " #hidEstatus").val(arrFilas[1].trim());
	$("#form" + vsVista + " #hidCondicion").val(arrFilas[2].trim());
	$("#form" + vsVista + " #numId").val(parseInt(arrFilas[3].trim()));
	$("#form" + vsVista + " #ctxNombre").val(arrFilas[4].trim());
	$("#form" + vsVista + " #ctxDescripcion").val(arrFilas[5].trim());
	$("#form" + vsVista + " #numCodigoIso").val(arrFilas[6].trim());
	$("#form" + vsVista + " #ctxCodigoIsoAlfa2").val(arrFilas[7].trim());
	$("#form" + vsVista + " #ctxCodigoIsoAlfa3").val(arrFilas[8].trim());
	$("#form" + vsVista + " #ctxPrefijo").val(arrFilas[9].trim());

	$('#form' + vsComponente + ' #hidCiudad').val(arrFilas[10].trim());
	$('#form' + vsComponente + ' #cmbCiudad')
		.val(arrFilas[10].trim())
		.trigger('change');

	$("#vvOpcion").val(arrFilas[0].trim());

	if ($("#form" + vsVista + " #hidEstatus").val() == "inactivo") {
		$("#form" + vsVista + " #divBotonesM").css("display", "none");
		$("#form" + vsVista + " #divBotonesN").css("display", "none");
		$("#form" + vsVista + " #divBotonesR").css("display", "");
		fjCamposSoloLectura("#form" + vsVista);
	}
	else {
		$("#form" + vsVista + " #divBotonesM").css("display", "");
		$("#form" + vsVista + " #divBotonesN").css("display", "none");
		$("#form" + vsVista + " #divBotonesR").css("display", "none");
	}
	fjHabilitar("Desabilitar");
	$("#VentanaModal").modal('show'); //para boostrap v3.3.7
}

function fjEnviar(pvValor){
	fjEnviarPais( pvValor );
}

//funcion.javascript.Enviar (parámetro.vista.Valor)
function fjEnviarPais(pvValor, pvHeredado="") {
	//se definen las variables locales
	let arrFormulario = $("#formPais");
	let vsNombre = $("#formPais #ctxNombre");
	let vsDescripcion = $("#formPais #ctxDescripcion");
	let vbComprobar = true; // variable booleana Comprobar, para verificar que todo este true o un solo false no envía

	//si el botón pulsado es igual a Registrar o Modificar
	if (pvValor === "Registrar" || pvValor === "Modificar") {

		//si el campo está vació no enviara el formulario
		if (vsNombre.val().trim() === "") {
			vbComprobar = false;
			swal({
				title: '¡Atención!',
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
	} //cierre del condicional si es el boton registrar o modificar

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {
		$("#formPais #vvOpcion").val(pvValor); //valor.vista.Opcion del hidden
        $.ajax({
            method: "POST",
            url: arrFormulario.attr("action"),
            data: arrFormulario.serialize()
        })
        .done(function(arrRespuesta) {
			console.log(arrRespuesta);
            fjMensajes(arrRespuesta.mensaje); //imprime el mensaje de estado
            if (arrRespuesta.ver == "no") {
                if ( $('#formPais #VentanaModal').length > 0 ) {
                    $("#formPais #VentanaModal").modal("hide");
                }
                $("#formPais")[0].reset();
            }
            if (pvHeredado != "1"){
            	fjMostrarLista(vsModulo, vsComponente);
            }
            if (pvHeredado == "1"){
            	fjComboGeneral("configuration", "Pais");
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
}


function fjColocarValores(arrDatos) {
	$("#form" + vsVista + " #hidEstatus").val(arrDatos.estatus);
	$("#form" + vsVista + " #hidCondicion").val(arrDatos.condicion);
	$("#form" + vsVista + " #numId").val(arrDatos.id);
	$("#form" + vsVista + " #ctxNombre").val(arrDatos.nombre);
	$("#form" + vsVista + " #ctxDescripcion").val(arrDatos.descripcion);
	$("#form" + vsVista + " #numCodigoIso").val(arrDatos.cod_iso_numerico);
	$("#form" + vsVista + " #ctxCodigoIsoAlfa2").val(arrDatos.cod_iso_alfa_2);
	$("#form" + vsVista + " #ctxCodigoIsoAlfa3").val(arrDatos.cod_iso_alfa_3);
	$("#form" + vsVista + " #ctxPrefijo").val(arrDatos.prefijo_telefonico);
	$("#form" + vsVista + " #cmbCiudad").val(arrDatos.ciudad_capital);
	$("#vvOpcion").val(arrDatos.getOpcion);
}



//al cargar el documento
$(function() {
	//funcion en jsc_Reporte que genera los option en los select de la A a la Z
	//para los rangos de reporte desde letra inicial hasta letra incial
	fjMostrarLista(vsModulo, vsVista); //lista el contenido en la vista
	fjComboGeneral(vsModulo, "Ciudad"); //lista el contenido en la vista

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
