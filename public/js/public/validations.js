//////////////////////////////////////////////////////////////////////
// Función principal para validar los campos del formulario.
// Recibimos el campo a validar y el tipo de validación.
function validar (campo,tipo)
{
    if ($("#"+campo).val() != '') {
        EliminarTooltips(campo);
        if (tipo) {
            if (tipo == "l") {
                let estado = validarLetras($("#"+campo).val());
                if (estado) {
                    EliminarTooltips(campo);
                    $("#"+campo).removeClass('errorInput');
                } else {
                    setTimeout(function () { ActualizarTooltips(campo, 'No debe tener números o caracteres especiales'); },50);
                    $("#"+campo).addClass('errorInput');
                }
                return estado;
            }
            else if (tipo == "n") {
                let estado = validarNumeros($("#"+campo).val());
                if (estado) {
                    EliminarTooltips(campo);
                    $("#"+campo).removeClass('errorInput');
                } else {
                    setTimeout(function () { ActualizarTooltips(campo, 'No debe tener letras o caracteres especiales'); },50);
                    $("#"+campo).addClass('errorInput');
                }
                return estado;
            }
            else if (tipo == "c") {
                let estado = validarCorreo($("#"+campo).val());
                if (estado) {
                    EliminarTooltips(campo);
                    $("#"+campo).removeClass('errorInput');
                } else {
                    setTimeout(function () { ActualizarTooltips(campo, 'Correo invalido'); },50);
                    $("#"+campo).addClass('errorInput');
                }
                return estado;
            }
        } else {
            $("#"+campo).removeClass('errorInput');
            return 'bien';
        }
    } else {
        setTimeout(function () { ActualizarTooltips(campo, 'No debe estar vacío'); },50);
        $("#"+campo).addClass('errorInput');
        return 'error';
    }
}
////////////////////////// Función para validar letras.
function validarLetras(letras)
{
    if (/^([a-zA-Zá-úÁ-Ú ])*$/.test(letras))
         return true;
    else
        return false;
}
////////////////////////// Función para validar números.
function validarNumeros(numeros)
{
    if (/^([0-9])*$/.test(numeros))
         return true;
    else
        return false;
}
////////////////////////// Función para validar correo.
function validarCorreo(correo)
{
    if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/.test(correo))
         return true;
    else
        return false;
}

//////////////////////////////////////////////////////////////////////
// Funciones extras para las validaciones
// Actualizar los tooltips de los inputs.
function ActualizarTooltips (campo,texto)
{
    $('#'+campo).tooltip('dispose');
    $('#'+campo).attr('title',texto);
    $('#'+campo).tooltip('update');
    $('#'+campo).tooltip('show');
}
// Eliminar los tooltips y su visibilidad.
function EliminarTooltips (campo)
{
    $('#'+campo).tooltip('dispose');
}
// Fin funciones extras para las validaciones
//////////////////////////////////////////////////////////////////////