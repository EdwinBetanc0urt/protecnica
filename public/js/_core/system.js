
$(function() {
	"use strict";

	$("#listMenu").ready(function(){
		getMenuRequest();
	});


	//Resolve conflict in jQuery UI tooltip with Bootstrap tooltip
	//$.widget.bridge('uibutton', $.ui.button);

	//inicia la función para los mensajes de ayuda de bootstrap
	if ($.isFunction($.fn.tooltip)) {
		$('[data-toggle="tooltip"]').tooltip();
	}

	//if ($.isFunction($.fn.dropdown)) {
	//	$('.dropdown-toggle').dropdown();
	//	$('.dropdown').dropdown('toggle');
	//}

	//inicia la función para búsquedas en los select
	if ($.isFunction($.fn.select2)) {
		$(".select2, .combo_buscar, .select_dinamico, .combo_dinamico")
		.select2({
			language: "es",
			theme: "bootstrap"
		});
		//.css("width", "100%");
	}

	//inicia la función para calendarios
	if ($.isFunction($.fn.datepicker)) {
		$(".calendario, .datepicker").datepicker({
			language: 'es',
			format: 'dd-mm-yyyy'
		});
	}
});

//para cerrar las ventanas modales con la tecla Escape
$(document).keyup(function(pEvento){
	if(pEvento.keyCode == 27 || pEvento.which == 27 || pEvento.key == "Esc" || pEvento.code == "Esc") {
		$(".modal").modal('hide'); //para boostrap v3.3.7
	}
});

// función javascript Salir, utilizado por el botón de OFF del menú
function closeSession(psMotivo = "sesioncerrada", psForzado = false) {
	if (psForzado) {
		window.location.href = "controllers/_core/ctr_LogOut.php?getMotivoLogOut=" + psMotivo;
	}
	else {
		swal({
			title: '¡SALIR!',
			html: 'Está a punto de cerrar sesión... ¿Seguro que quiere salir del sistema?',
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			showCloseButton: true,
			confirmButtonText: 'Si, Salir',
			cancelButtonText: 'No, Quedarse'
		}).then((result) => {
			if (result.value) {
				window.location.href = "controllers/_core/ctr_LogOut.php?getMotivoLogOut=" + psMotivo;
			}
			else if (result.dismiss == 'cancel') {
				swal({
					title: 'Cancelado',
					html: '¡Gracias por permanecer en la página!',
					showCloseButton: true,
					type: 'error'
				});
			}
		});
	}
} // cierre de la función

function fjSinAcceso2() {
	if(typeof swal === 'function') {
		swal({
			title: '¡Ops!',
			html: 'No tiene acceso a esta pagina, por favor contacte al soporte' +
				' técnico para que le accedan los privilegios',
			type: 'error',
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Ok ',
			showCloseButton: true,
			//cancelButtonText: 'No, ' + pvValor,
			//confirmButtonClass: 'btn btn-primary',
			//confirmButtonClass: 'swal2-confirm swal2-styled',
			//cancelButtonClass: 'btn btn-danger',
			//buttonsStyling: false
		}).then((result) => {
			fjAtras();
		});
	}
	else {
		alert("No tiene acceso a esta pagina, por favor contacte al soporte " +
			"técnico para que le accedan los privilegios");
		fjAtras();
	}
} //cierre de la función

//BUSCAR COMO DETERMINAR SI SE TUVO HISTORIAL EN EL SERIVOR
//función para ir 1 atrás en el historial
function fjAtras() {
	console.log(window.history.length);

	if (window.history.length > 1) {
		history.go(-1);
		//document.location = "../../";
	}
	else{
		document.location = "../../";
	}
} //cierre de la función

/**
 * Función JavaScript Campo Solo Lectura, agrega o elimina el atributo solo
 * lectura (readonly) de los elementos input[text] y textarea, y agrega o elimina
 * el atributo selected de los elementos option en los select.
 * @param {string} psFormulario, nombre del formulario que se va a evaluar.
 * @param {bool} pbSoloLectura, estatus del atributo readonly.
 * @param {array} arrExcluye, id de los elementos a excluir del formulario.
 */
function fjCamposSoloLectura(psFormulario, pbSoloLectura = true, arrExcluye = []) {
	//console.log(psFormulario);
	let _Formulario = document.querySelector(psFormulario);

	// Se encarga de leer todas las etiquetas input del formulario
	let _elementosDOM = _Formulario.querySelectorAll(
		"textarea, input[type=text], input[type=number], input[type=password], " +
		"input[type=email], input[type=search], input[type=url], " +
		"input[type=tel], input[type=date], input[type=datetime-local], " +
		"input[type=month], input[type=time], input[type=week]"
	);

	let _elementosDOM2 = _Formulario.querySelectorAll("select");

	for(let i = 0; i < _elementosDOM.length; i++){
		if (arrExcluye.indexOf(_elementosDOM[i].id) != -1)
			continue;
		if (pbSoloLectura) {
			_elementosDOM[i].setAttribute('readonly', 'readonly');
		}
		else {
			_elementosDOM[i].removeAttribute("readonly");
		}
	}

	for(let i = 0; i < _elementosDOM2.length; i++){
		if (arrExcluye.indexOf(_elementosDOM2[i].id) != -1)
			continue;
		if (pbSoloLectura) {
			_elementosDOM2[i].setAttribute("selected", 'selected');
		}
		else {
			//console.log(_elementosDOM2[i]);
			_elementosDOM2[i].removeAttribute("selected");
		}
	}
} //cierre de la función
function fjCamposSoloLectura2(psFormulario, pbSoloLectura = true, arrExcluye = []) {
	//console.log(psFormulario);
	// Se encarga de leer todas las etiquetas input del formulario
	$(psFormulario).find('input').each(function() {
		switch (this.type) {
			case 'text':
				if (arrExcluye.indexOf(this.id) != -1)
					return true;
				$(this).attr("readonly", pbSoloLectura);
				break;
		}
	});

	// Se encarga de leer todas las etiquetas select del formulario
	$(psFormulario).find('select').each(function() {
		$("#" + this.id + " option[value=0]").attr("selected", !pbSoloLectura);
	});

	// Se encarga de leer todas las etiquetas textarea del formulario
	$(psFormulario).find('textarea').each(function() {
		if (arrExcluye.indexOf(this.id) != -1)
			return true;
		$(this).attr('readonly', pbSoloLectura);
	});
} //cierre de la función

/**
 * @deprecated
 */
function fjCamposNoSoloLectura(psFormulario, pbSoloLectura = false, arrExcluye = []) {
	fjCamposSoloLectura(psFormulario, pbSoloLectura, arrExcluye);
} //cierre de la función
