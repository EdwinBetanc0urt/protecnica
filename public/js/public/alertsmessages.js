function message (message)
{
    if (message == 'there is not a session') {
        swal({
            title   : 'Error de sesión',
            text    : 'No hay ninguna sesión abierta.',
            icon    : 'error',
            buttons : [false , {
                text    : "Continuar",
                value   : true,
                className: 'btn btn-sm fondo-claro'
            }]
        });

        return 'reload';
    } else if (message == 'there is a session') {
        swal({
            title   : 'Error de sesión',
            text    : 'Hay una sesión abierta, procede a cerrarla primero.',
            icon    : 'error',
            buttons : [false , {
                text    : "Continuar",
                value   : true,
                className: 'btn btn-sm fondo-claro'
            }]
        });

        return 'reload';
    } else if (message == 'does not have access') {
        swal({
            title   : 'No tienes acceso',
            text    : 'No puede realizar esta acción.',
            icon    : 'error',
            buttons : [false , {
                text    : "Continuar",
                value   : true,
                className: 'btn btn-sm fondo-claro'
            }]
        });

        return 'reload';
    } else if (message == 'option don\'t exist' || message == 'option error') {
        swal({
            title   : 'Error al realizar la acción',
            text    : 'La acción no esta bien definida internamante.',
            icon    : 'error',
            buttons : [false , {
                text    : "Continuar",
                value   : true,
                className: 'btn btn-sm fondo-claro'
            }]
        });

        return 'reload';
    } else if (message == 'without privileges') {
        swal({
            title   : 'No tienes permisos',
            text    : 'No cuentas con los permisos suficientes para realizar esta acción.',
            icon    : 'warning',
            buttons : [false , {
                text    : "Continuar",
                value   : true,
                className: 'btn btn-sm fondo-claro'
            }]
        });

        return 'reload';
    } else if (message == 'data error') {
        swal({
            title   : 'Error de datos',
            text    : 'Los datos no se están obteniendo correctamente.',
            icon    : 'warning',
            buttons : [false , {
                text    : "Continuar",
                value   : true,
                className: 'btn btn-sm fondo-claro'
            }]
        });

        return false;
    } else if (message == 'It is already registered') {
        swal({
            title   : 'Error al realizar la acción',
            text    : 'Este dato ya se encuentra registrado.',
            icon    : 'warning',
            buttons : [false , {
                text    : "Continuar",
                value   : true,
                className: 'btn btn-sm fondo-claro'
            }]
        });

        return false;
    } else if (message == 'requisition material') {
        swal({
            title   : '¡Lo sentimos!',
            text    : 'El material se encuenta actualmente solicitado en una requisición .',
            icon    : 'warning',
            buttons : [false , {
                text    : "Continuar",
                value   : true,
                className: 'btn btn-sm fondo-claro'
            }]
        });

        return false;
    } else if (message == 'no success') {
        swal({
            title   : 'No se realizo la operación',
            text    : 'Un error evito que se realizara la acción correctamente, vuelva a intentar.',
            icon    : 'error',
            buttons : [false , {
                text    : "Continuar",
                value   : true,
                className: 'btn btn-sm fondo-claro'
            }]
        });

        return false;
    } else if (message == 'success') {
        swal({
            title   : 'Perfecto',
            text    : 'La operación se realizo correctamente.',
            icon    : 'success',
            buttons : [false , {
                text    : "Continuar",
                value   : true,
                className: 'btn btn-sm fondo-claro'
            }]
        });

        return true;
    } else {
        swal({
            title   : 'Información',
            text    : message,
            icon    : 'info',
            buttons : [false , {
                text    : "Continuar",
                value   : true,
                className: 'btn btn-sm fondo-claro'
            }]
        });

        return false;
    }
}