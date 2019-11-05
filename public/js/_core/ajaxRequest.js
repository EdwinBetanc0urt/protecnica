
function getMenuRequest() {
	//abre el archivo controllers y envía por POST
	vsURL = 'controllers/_core/ctr_Menu.php';
	$.post(
		vsURL,
		{
			//variables enviadas (name: valor)
			vvOpcion: 'principal', //abre la función en el controllers
			setBusqueda: $('#formMenu #ctxBuscarMenu').val(), //palabra para filtrar la búsqueda
			currentView: $('#formMenu #hidCurrentView').val()
		},
		function(resultado) {
			if (resultado == false) {
				console.log('sin consultas de menú');
			}
			else {
				//console.log('el id que toca es ' + resultado);
				//$('#listMenu').html(''); //habilita el campo de estado
				$('#listMenu').html(resultado); //imprime la lista del menú
			}
		}
	);
} //cierre de la función


/**
 * Función JavaScript Envió Dinámico, envía los datos del formulario al controllers
 * de su componente utilizando ajax, para evitar recargar toda la pagina.
 * @param {string} psFormulario, nombre del formulario que se va a enviar.
 * @param {string} psModal, nombre la ventana modal que abrirá o cerrara.
 */
function fjEnvioDinamico(psFormulario, pvValor = "registrar", psModal = "VentanaModal") {
	let arrFormulario = $("#form" + psFormulario);

	$.ajax({
		method: "POST",
		url: arrFormulario.attr("action"),
		data: arrFormulario.serialize()
	})
	.done(function(arrRespuesta) {
		fjMensajes(arrRespuesta.mensaje); //imprime el mensaje de estado
		if (arrRespuesta.ver == "no") {
			if ( $('#' + psModal).length > 0 ) {
				$("#" + psModal).modal("hide");
			}
			$("#form" + psFormulario)[0].reset();
		}
		else {
			if ( $('#' + psModal).length > 0 ) {
				$("#" + psModal).modal("show");
			}
			fjColocarValores(arrRespuesta.datos);
			fjBotonera(arrRespuesta.mensaje, psFormulario);
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
		//$("#resultado").html("Se ha producido un error y no se han podido procesar los datos");
	});
} //cierre de la función


/**
 * Función JavaScript Envió Dinámico, Cada combo debe llevar un hidden con su
 * mismo nombre para hacer fácil las consultas sea con combos anidados y con
 * GET, para no hacer ciclos que recorran arreglos.
 * @param {string} psModulo, nombre del formulario que se va a enviar.
 * @param {string} psComponente, nombre la ventana modal que abrirá o cerrara.
 * @param {string} psDependiente, nombre la ventana modal que abrirá o cerrara.
 * @param {string} psDestino, nombre la ventana modal que abrirá o cerrara.
 */
function fjComboGeneral(psModulo, psComponente, psDependiente = "", psDestino = "", paParametros = []) {

	let viDependiente = "";
	//abre el archivo controllers y envía por POST
	let vsRuta = "controllers/" + psModulo + "/ctr_" + psComponente + ".php";

	if (psDependiente != "") {
		viDependiente = $("#cmb" + psDependiente).val();
		// console.log("El padre o superior es: " + psDependiente + " y su valor es: " + viDependiente);
	}

	if (psDestino != "") {
		psComponente = psDestino;
		// console.log("nuevo destino " + psComponente);
	}

	$.post(
		vsRuta,
		{
			//variables enviadas (name: valor)
			setOpcion: "ListaCombo", //abre la función en el controllers
			hidCodPadre: viDependiente, //código del que depende para filtrar
			hidCodigo: $("#hid" + psComponente).val(), //código principal que fue seleccionado
			setParametros: paParametros
		},
		function(resultado) {
			if (resultado == false) {
				console.log("sin consultas de " + psComponente);
			}
			else {
				cmbCombo = document.getElementById("cmb" + psComponente);
				$("#cmb" + psComponente).attr("disabled", false); //habilita el campo de estado

				//cmbCombo.options.length = 0; //limpia los option del select
				cmbCombo.options.length = 1; //limpia los option del select
				$("#cmb" + psComponente).append(resultado); //agrega los nuevos option al select

				//console.log(resultado);
				//console.log("combo generado de " + psComponente);
			}
		}
	);
} //cierre de la función
$(function() {
	//función anónima que al cambiar un select asigna el valor al hidden que esta abajo de el
	//$('select > .dinamico').on('change', function() {
	$('select.dinamico').on('change', function() {
		let vsId = $(this).attr("id"); //toma el id del select
		//$(this).css("width", "100%"); //agrega el ancho del 100%
		//toma la cadena desde la posición 3 hacia la derecha cmbEJEMPLO = EJEMPLO
		let vsComponente = vsId.substr(3); //le quita las primeras 3 letras "cmb"

		//asigna el valor del select al hidden
		$("#hid" + vsComponente).val($(this).val());
		// console.log(vsComponente);
		console.log($("#hid" + vsComponente).val());

		//para tomar el texto

		if ($("#hid " + vsComponente + "Texto")) {
			//let txt = $("#cmb" + vsComponente + " option:selected").text();
			let txt = $("#cmb" + vsComponente + " option:selected").html();
			$("#hid " + vsComponente + "Texto").val(txt);
			//console.log(txt);
		}

	});
});

function fjUltimoID(psModulo, psComponente, psDestino = "") {
	//abre el archivo controllers y envía por POST
	vsURL = "controllers/" + psModulo + "/ctr_" + psComponente + ".php";
	$.post(
		vsURL,
		{
			//variables enviadas (name: valor)
			vvOpcion: "UltimoCodigo" //abre la función en el controllers
		},
		function(resultado) {
			if (resultado == false) {
				console.log("sin consultas de id");
			}
			else {
				if (psDestino != "") {
					psComponente = psDestino;
					//console.log("nuevo destino para el id en form" + psComponente);
				}
                //console.log("el id que toca es " + resultado);
                $("#form" + psComponente + " #numId").val(parseInt(resultado)); //imprime el id generado
			}
		}
	);
} //cierre de la función




/**
 * @param {string} psModulo, la carpeta del modulo que abrirá
 * @param {string} psComponente, indica el controllers del componente que abrirá dentro del modulo anterior
 * @param {integer} piPagina, envía el atributo de la sub pagina que imprimirá de la paginación
 * @param {string} psOrden, envía el atributo en que realizara el ordenado
 * @param {string} psDesino, por defecto el destino donde imprimirá los datos es el formulario lista de la clase sin embargo puede cambiar
 * @param {string} psSwicth, por defecto la lista que llamara es ListaVista (anteriormente ListaInteligente) pero pueden existir mas de una lista del mismo controllers
 */
function fjMostrarLista(
		psModulo,
		psComponente,
		piPagina = "",
		psOrden = "",
		psDestino = "",
		psSwicth = "ListaView",
		psOpcional = ""
	) {

	// console.log(psModulo);
	// console.log(psComponente);

	//abre el archivo controllers y envía por POST
	let vsRuta = "controllers/" + psModulo + "/ctr_" + psComponente + ".php";
	 // console.log(vsRuta);

	//si el parámetro contiene algo, reasigna el valor enviado
	if (psDestino != "") {
		psComponente = psDestino;
		// console.log("Nuevo formulario destino " + psComponente);
	}

	let liItem = $.trim($("#formLista" + psComponente + " #numItems").val());

	if (piPagina != "") {
		$("#formLista" + psComponente + " #subPagina").val(piPagina);
	}

	// console.log(piPagina);

	if (psOrden != "") {
		$("#formLista" + psComponente + " #hidOrden").val(psOrden);
		//$("#formLista" + psComponente + " #tabLista" + psComponente + " thead tr span").removeClass(" glyphicon-sort-by-attributes");
		//$("#formLista" + psComponente + " #tabLista" + psComponente + " thead tr span").addClass(" glyphicon-sort");
		// console.log($("#formLista" + psComponente + " #tabLista" + psComponente + " thead tr span"));

		$("#formLista" + psComponente + " #tabLista" + psComponente + " thead tr th").click(function(e){
			//var id = e.target.id;
			//e.target.firstElementChild.addClass(" glyphicon-sort-by-attributes ");
			$(this).children().addClass(" glyphicon-sort-by-attributes ");
			//console.log($(this).children());
			//console.log($(this));
		});
	}

	//si el orden es el mismo alterna el tipo
	if(psOrden == $("#formLista" + psComponente + " #hidOrden").val()) {
		fjTipoOrdenLista(psComponente);
	}

	//renglones a mostrar
	if(liItem == "" || parseInt(liItem) < 1 || liItem == NaN) {
		liItem = 10;
	}

	$.post(
		vsRuta,
		{
			//variables enviadas (name: valor)
			setOpcion: psSwicth, //abre la función de la lista en el controllers
			setBusqueda: $("#formLista" + psComponente + " #ctxBusqueda").val(), //palabra para filtrar la búsqueda
			setItems: parseInt(liItem), //cantidad de items a mostrar
			setDestino: psComponente,
			subPagina: parseInt($("#formLista" + psComponente + " #subPagina").val()),
			setOrden: $("#formLista" + psComponente + " #hidOrden").val(),
			setTipoOrden: $("#formLista" + psComponente + " #hidTipoOrden").val(),
			setOpcional: psOpcional,
			setDestino: psDestino //valor adicional que se quiera enviar
		},
		function(resultado) {
			if(resultado == false) {
				console.log("sin consultas de búsqueda de " + psComponente);
			}
			else {
				$("#formLista" + psComponente + " #divListado").html(resultado);
				//console.log(resultado);

				if (psOrden != "") {
					$("#formLista" + psComponente + " #tabLista" + psComponente + " thead tr span").removeClass("glyphicon-sort-by-attributes");
					$("#formLista" + psComponente + " #tabLista" + psComponente + " thead tr span").addClass("glyphicon-sort");
					//console.log($("#formLista" + psComponente + " #tabLista" + psComponente + " thead tr span"));

					$("#formLista" + psComponente + " #tabLista" + psComponente + " thead tr th").click(function(e){
						//var id = e.target.id;
						//e.target.firstElementChild.addClass(" glyphicon-sort-by-attributes ");
						//$(this).children().addClass("glyphicon-sort-by-attributes ");
						//console.log($(this).children());
					});
					//console.log($("#formLista" + psComponente + " #tabLista" + psComponente + " thead tr"));
				}

				//inicializa los tooltip nuevo html generado
				if ($.isFunction($.fn.tooltip)) {
					setTimeout(
						function () {
							if ($('[data-toggle="tooltip"]').length > 0) {
								$('[data-toggle="tooltip"]').tooltip("destroy");
								$('[data-toggle="tooltip"]').tooltip();
							}
						},
						500
					);
				} //cierre del condicional si existe tooltip
			}
		}
	);
} //cierre de la función



//Tipo de Ordenado, si ASCendente o DESCendente para la lista de la vista
function fjTipoOrdenLista(psComponente) {
	//console.log(vsSeleccion);
	vsSeleccion = $("#formLista" + psComponente + " #hidTipoOrden");
	//console.log("orden " + psComponente + " " + vsSeleccion.val());
	if (vsSeleccion) {
		if (vsSeleccion.val() == "ASC") {
			vsSeleccion.val("DESC");
		}
		else if (vsSeleccion.val() == "DESC" || vsSeleccion.val() == "") {
			vsSeleccion.val("ASC");
		}
		//console.log("orden " + psComponente + " " + vsSeleccion.val());
	}
	else {
		//console.log("orden " + psComponente + " " + vsSeleccion.val());
		return "ASC";
	}
} //cierre de la función
function fjTipoOrdenLista_(psComponente) {
	$("#formLista" + psComponente + " #hidTipoOrden").toggle(
		function(){
			$(this).val("ASC");
		},
		function(){
			$(this).val("DESC");
		}
	);
} //cierre de la función



//Tipo de Ordenado, si ASCendente o DESCendente para la lista de la vista
function fjTipoOrden() {
	vsSeleccion = document.getElementById("hidTipoOrden");
	// console.log(vsSeleccion);
	if (vsSeleccion) {
		if (vsSeleccion.value == "ASC") {
			vsSeleccion.value = "DESC";
			console.log(vsSeleccion.value);
		}
		else if (vsSeleccion.value == "DESC" || vsSeleccion.value == "") {
			vsSeleccion.value = "ASC";
			// console.log(vsSeleccion.value);
		}
		return vsSeleccion.value;
	}
	else {
		return "ASC";
	}
} //cierre de la función
