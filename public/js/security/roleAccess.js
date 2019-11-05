$(function() {
	$("#formListaSinAcceso #ctxBuscaSinAcceso").attr("disabled", true);
	$("#formListaConAcceso #ctxBuscaAcceso").attr("disabled", true);
	$("#formListaAccesoRol #ctxBusqueda").attr("disabled", true);

	//cuando se hace un cambio en el combo del estado se cargan las ciudades
	fjComboGeneral("security", "Role");
	//espera un tiempo en mili segundos para ser ejecutado
	setTimeout(
		function() {
			$("#cmbRole").select2("open");
		},
		200
	);

	//cuando se hace un cambio en el combo del estado se cargan las ciudades
	$("#cmbRole").on('change', function() {
		$("#numRol").val($(this).val());

		$("#formListaSinAcceso #ctxBuscaSinAcceso").attr("disabled", false);
		$("#formListaConAcceso #ctxBuscaAcceso").attr("disabled", false);
		$("#formListaAccesoRol #ctxBusqueda").attr("disabled", false);

		fjListaConAcceso();
		fjListaSinAcceso();
	});

	//$("#btnAgregar").attr("disabled", true); //deshabilita el campo para que no sea enviado al servidor
	$("#ctxBuscaAcceso, #ctxIntemAcceso").on('keyup', function(){
		fjListaConAcceso();
	});
	$("#ctxBuscaSinAcceso, #ctxIntemSinAcceso").on('keyup', function(){
		fjListaSinAcceso();
	});

	/*
	$("#pestAcceso").on('click', function(){
		$("#btnAgregar").attr("disabled", true); //deshabilita el campo
		$("#btnModificar").attr("disabled", false); //habilita el campo
	});
	$("#pestSinAcceso ").on('click', function(){
		$("#btnAgregar").attr("disabled", false); //deshabilita el campo
		$("#btnModificar").attr("disabled", true); //habilita el campo
	});
	*/
});

//comprueba si fue seleccionado por lo menos 1 elemento
function fjComprobarChekcbox() {
	//if($('.chkBotones').prop('checked')) {
	//if($('.chkBotones').attr('checked')) {
	if($('.chkBotones').is(':checked')) {
		return true;
	}
	return false;
} //cierre de la función

function fjDesactivarChek() {
	//$('.chkBotones').prop('checked', false);
	$('.chkBotones').attr('checked', false);
	return true;
} //cierre de la función


function fjEnviar(pvValor) {
	//se definen las variables locales
	let arrFormulario = $("#form" + vsVista);
	let viRol = $("#form" + vsVista + " #numRol");
	let vbComprobar = true; // variable booleana Comprobar, para verificar que todo este true o un solo false no envía

	if (fjComprobarChekcbox()) {
		//si el ctxNombre está val botón pulsado es igual a Registrar o Modificar no enviara el formulario
		if (viRol.val().trim() === "") {
			vbComprobar = false;
			swal({
				title: '¡Atencion!',
				html: 'HA OCURRIDO UN ERROR <br> El ROL no ha sido seleccionado ' + pvValor.toUpperCase(),
				type: 'info',
				confirmButtonText: 'Ok'
			}).then((result) => {
				viRol.focus();
			});
			return; // rompe la función para que el usuario verifique antes de continuar
		}
	}
	else {
		swal({
			title: '¡Atención!',
			html: 'Debe seleccionar por lo menos (1) BOTON <br> Para poder ASIGNAR ACCESOS',
			type: 'warning',
			confirmButtonText: 'Ok'
		});
		vbComprobar = false;
		return;
	}

	// Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
	if (vbComprobar) {
		document.getElementById("vvOpcion").value = pvValor; //valor.vista.Opcion del hidden
		fjEnvioDinamico(vsComponente);
		//arrFormulario.submit(); //Envía el formulario
		setTimeout(
			function () {
				fjListaConAcceso();
				fjListaSinAcceso();
				getMenuRequest();
			},
			500
		);
	}
} //cierre de la función


function fjSeleccionarRegistro(pvDOM) {
	console.log(pvDOM);

	//debe ser con javascript porque es recibido directamente del DOM
	if (typeof pvDOM.getAttribute !== 'undefined')
		arrFilas = pvDOM.getAttribute('datos_registro').split('|');
	//debe ser con jquery porque es recibido como tal con jquery
	else if (jQuery.isFunction(pvDOM.attr))
		arrFilas = pvDOM.attr('datos_registro').split('|');
	else
		return;

	console.log(arrFilas);

	$("#form" + vsVista + " #numId").val(parseInt(arrFilas[3]));
	$("#form" + vsVista + " #ctxNombre").val(arrFilas[4]);
	$("#form" + vsVista + " #ctxDescripcion").val(arrFilas[5]);
	$("#form" + vsVista + " #ctxModulo").val(arrFilas[7]);
	//$("#form" + vsVista + " #hidBloquearModulo").val(arrFilas[5]);

	//$("#form" + vsVista + " #hidEstatus").val(arrFilas[1]);
	$("#vvOpcion").val(arrFilas[0].trim());

	if (arrFilas[0].trim() == "Seleccion") {
		$("#form" + vsVista + " #btnAgregar").css("display", "none");
		$("#form" + vsVista + " #btnModificar").css("display", "");
		$("#form" + vsVista + " #btnQuitar").css("display", "");
		fjListaBotonSi();
	}
	else {
		$("#form" + vsVista + " #btnAgregar").css("display", "");
		$("#form" + vsVista + " #btnModificar").css("display", "none");
		$("#form" + vsVista + " #btnQuitar").css("display", "none");
		fjListaBotonNo();
	}

	$("#VentanaModal").modal('show'); //para boostrap v3.3.7
} //cierre de la función

//Elimina todos los accesos
function fjQuitarVista(piVista) {
	let arrFormulario = $("#form" + vsVista);
	let vbComprobar = true; // variable booleana Comprobar, para verificar que todo este true o un solo false no envía
	let vsNombreVista = $("#form" + vsVista + " #ctxNombre");
	$("#form" + vsVista + " #numId").val(parseInt(piVista));

	document.getElementById('ctxModulo').value = ""; //blanquea el campo

	swal({
		title: '¡Atención!',
		html: "¿Esta seguro que desea quitar <br> todos los accesos de la pagina" + vsNombreVista.val() + "? \n Esto restringira el acceso total a la misma",
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si',
		showCloseButton: true,
		cancelButtonText: 'No',
	})
    .then((result) => {
		if (result.value) {
			document.getElementById("vvOpcion").value = "Eliminar"; //valor.vista.Opcion del hidden
			$.ajax({
				method: "POST",
				url: arrFormulario.attr("action"),
				data: arrFormulario.serialize()
			})
			.done(function(arrRespuesta) {
				fjMensajes(arrRespuesta.mensaje);
				fjListaConAcceso();
				fjListaSinAcceso();
				fjMenu();
			})
			.fail(function() {
				//$("#resultado").html("Se ha producido un error y no se han podido procesar los datos");
			});
		}
		else {
			swal({
				title: 'Cancelado!',
				text: 'Se cancelo la operacion, no se realizaron cambios',
				type: 'info',
				showCloseButton: true,
				confirmButtonText: 'Ok'
			});
		}
	});
} //cierre de la función

//selecciona o deselecciona el checkbox con solo tocar la fila
//para mejor facilidad al hacerlo con pantallas pequeñas
function fjSeleccionFila(paRegistro) {
	var viId = "chkBoton" + paRegistro.getAttribute('datos_id');
	//$('#' + viId).attr('checked', true)
	if ($("#" + viId).is(':checked')) {
		$("#" + viId).attr("checked", false); //deshabilita el campo
	}
	else {
		$("#" + viId).attr("checked", true); //deshabilita el campo
	}
} //cierre de la función


function fjListaSinAcceso(piPagina = "") {
	//abre el archivo controllers y envia por POST
	vsRuta = "controllers/security/ctr_RoleAccess.php";
	if (piPagina == "")
		piPagina = 1;

	$.post(vsRuta, {
			//variables enviadas (name: valor)
			vvOpcion: "ListaSinAcceso", //abre la función en el controllers
			setBusquedaSA: $("#ctxBuscaSinAcceso").val(), //código del que depende para filtrar
			setItemsSA: $("#ctxIntemSinAcceso").val(),
			subPaginaSA: piPagina,
			setOrdenSA: "",
			setTipoOrdenSA: "",
			setRol: $("#cmbRole").val()
		},
		function(resultado) {
			if(resultado == false) {
				console.log("sin consultas en lista sin acceso ");
			}
			else {
				$("#formListaSinAcceso #divListado").html(resultado) ;
				//console.log(resultado);
			}
		}
	);
} //cierre de la función


function fjListaBotonNo(piPagina = "") {
	//abre el archivo controllers y envía por POST
	vsRuta = "controllers/security/ctr_RoleAccess.php";
	$.post(vsRuta, {
			//variables enviadas (name: valor)
			vvOpcion: "ListaBotonSinAcceso", //abre la función en el controllers
			setRol: $("#cmbRole").val()
		},
		function(resultado) {
			if(resultado == false) {
				console.log("sin consultas en botones sin acceso ");
			}
			else {
				$("#divListaBoton").html("");
				$("#divListaBoton").html(resultado) ;
				//console.log(resultado);
			}
		}
	);
} //cierre de la función

//Cada combo debe llevar un hidden con su mismo nombre para hacer fácil las consultas
// sea con combos anidados y con GET, para no hacer ciclos que recorran arreglos
function fjListaConAcceso(piPagina = "") {
	//abre el archivo controllers y envía por POST
	vsRuta = "controllers/security/ctr_RoleAccess.php";
	$.post(vsRuta, {
			//variables enviadas (name: valor)
			vvOpcion: "ListaConAcceso", //abre la función en el controllers
			setBusquedaCA: $("#ctxBuscaAcceso").val(), //código del que depende para filtrar
			setItemsCA: $("#ctxIntemAcceso").val(),
			subPaginaCA: piPagina,
			setRol: $("#cmbRole").val(),
			setOrdenCA: "",
			setTipoOrdenCA: ""
		},
		function(resultado) {
			if(resultado) {
				$("#formListaConAcceso #divListado").html(resultado);
			}
			else {
				console.log("sin consultas en lista con acceso ");
			}
		}
	);
} //cierre de la función

function fjListaBotonSi(piPagina = "") {
	//abre el archivo controllers y envia por POST
	vsRuta = "controllers/security/ctr_RoleAccess.php";
	$.post(vsRuta, {
			//variables enviadas (name: valor)
			vvOpcion: "ListaBotonConAcceso", //abre la función en el controllers
			setVista: $("#numId").val(), //abre la función en el controllers
			setRol: $("#cmbRole").val()
		},
		function(resultado) {
			if(resultado) {
				$("#divListaBoton").html("");
				$("#divListaBoton").html(resultado);
			}
			else {
				console.log("sin consultas en botones con acceso ");
			}
		}
	);
} //cierre de la función
