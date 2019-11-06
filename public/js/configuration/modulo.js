
function fjNuevoRegistro() {
    fjHabilitar("Habilitar");
 
    $("#form" + vsVista)[0].reset();
     
    fjCamposNoSoloLectura("#form" + vsVista);
    fjUltimoID(vsModulo, vsVista);

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
    $("#form" + vsVista + " #ctxIcono").attr('disabled', vbDisable);
    $("#form" + vsVista + " #numPosicion").attr('disabled', vbDisable);

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
    console.log(pvDOM);
    
    if (typeof pvDOM.getAttribute !== 'undefined')
        arrFilas = pvDOM.getAttribute('datos_registro').split('|'); //debe ser con javascript porque es recibido cdirectamete del DOM
    
    else if (jQuery.isFunction(pvDOM.attr))
        arrFilas = pvDOM.attr('datos_registro').split('|'); //debe ser con jquery porque es recibido como tal con jquery
    else
        return;
     
    console.log(arrFilas);
     
    $("#btnHabilitar").attr('disabled', false);
    $("#form" + vsVista + " #hidEstatus").val(arrFilas[1].trim());
    $("#form" + vsVista + " #hidCondicion").val(arrFilas[2].trim());
    $("#form" + vsVista + " #numId").val(parseInt(arrFilas[3].trim()));
    $("#form" + vsVista + " #ctxNombre").val(arrFilas[4].trim());
    $("#form" + vsVista + " #ctxDescripcion").val(arrFilas[5].trim());
    $("#form" + vsVista + " #ctxIcono").val(arrFilas[6].trim());
    $("#form" + vsVista + " #numPosicion").val(arrFilas[7].trim());
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



//funcion.javascript.Enviar (parametro.vista.Valor)
function fjEnviar(pvValor) {
    //se definen las variables locales
    let arrFormulario = $("#form" + vsVista);
    let vsNombre = $("#form" + vsVista + " #ctxNombre");
    let vsDescripcion = $("#form" + vsVista + " #ctxDescripcion");
    let vbComprobar = true; // variable booleana Comprobar, para verificar que todo este true o un solo false no envía
 
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
        if (vsDescripcion.val().trim() === "") {
            vbComprobar = false;
            swal({
                title: '¡Atencion!',
                html: 'EL NOMBRE ES OBLIGATORIO <br /> No puede estar vacía para ' + pvValor.toUpperCase(),
                type: 'info',
                showCloseButton: true,
                confirmButtonText: 'Ok',
                footer: ' '
            }).then((result) => {
                vsDescripcion.focus();
            });
            return; // rompe la función para que el usuario verifique antes de continuar
        }
    } //cierre del condicional si es el boton registrar o modificar
 
    // Si la variable Comprobar es verdadero (paso exitosamente las demás condiciones)
    if (vbComprobar) {
        $("#form" + vsVista + " #vvOpcion").val(pvValor); //valor.vista.Opcion del hidden

        $.ajax({
            method: "POST",
            url: arrFormulario.attr("action"),
            data: arrFormulario.serialize()
        })
        .done(function(arrRespuesta) {
            fjMensajes(arrRespuesta.mensaje); //imprime el mensaje de estado
            if (arrRespuesta.ver == "no") {
                $("#VentanaModal").modal("hide");
                $("#form" + vsVista)[0].reset();
            }
            else {
                $("#VentanaModal").modal("show");
                fjColocarValores(arrRespuesta.datos);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            swal({
                title: 'Estatus: ' + textStatus,
                html: 'La petición para <b>' + pvValor.toUpperCase() + '</b> no ha sido procesada correctamente',
                type: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok',
                footer: '<b>Error http:</b> ' + errorThrown + " / " + jqXHR.status
            }).then((result) => {
                vsDescripcion.focus();
            });
            //$("#resultado").html("Se ha producido un error y no se han podido procesar los datos");
        });
        //espera un tiempo en milisegundos para ser ejecutado
        setTimeout(
            function () {
                fjMostrarLista(vsModulo, vsVista); //lista el contenido en la vista
                fjMenu(); //se refresca el menu ya que tiene que ver directamente con el
            },
            500
       );
        //arrFormulario.submit(); //Envía el formulario
    }
}



//al cargar el documento
$(function() {
    //funcion en jsc_Reporte que genera los option en los select de la A a la Z
    //para los rangos de reporte desde letra inicial hasta letra incial
    fjMostrarLista(vsModulo, vsVista); //lista el contenido en la vista
     
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
