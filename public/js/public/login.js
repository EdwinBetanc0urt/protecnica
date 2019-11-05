$(function () {
    //////////////////////////////////////////////////////////////////////
    // Variables para confirmar el estado de los campos
    let vUsername = false, vPassword = false;
    // Fin de las variables para confirmar el estado de los campos
    //////////////////////////////////////////////////////////////////////
    
    //////////////////////////////////////////////////////////////////////
    // Validaciones de los campos.
    // Validar el campo usuario.
    $('#username').keyup(validateUsername);
    function validateUsername(e) {
        if (e.keyCode != 9) {
            if (e.keyCode == 13 && $('#username').val() != '') {
                $('#password').focus();
            } else {
                let estado = validar('username');
                if (estado == 'error') {
                    vUsername = false;
                } else {
                    vUsername = true;
                }
            }
        }
    }
    // Validar el campo contraseña.
    $('#password').keyup(validatePassword);
    function validatePassword(e) {
        if (e.keyCode != 9) {
            if (e.keyCode == 13 && $('#password').val() != '') {
                login();
            } else {
                let estado = validar('password');
                if (estado == 'error') {
                    vPassword = false;
                } else {
                    vPassword = true;
                }
            }
        }
    }

    
    // Fin de las valicaciones de los campos.
    //////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////
    // Funciones para ejecutar acciones
    // Evento al botón para iniciar sesión.
    $('#execute').click(login);
    function login() {
        validateUsername('');
        validatePassword('');
        if (vUsername && vPassword) {
            $('#execute').attr('disabled','disabled');
            $('#execute').html('<i class="fas fa-spinner fa-spin mr-2"></i>Cargando...');
            
            /*$.ajax({
                method: "POST",
                url: arrFormulario.attr("action"),
                data: arrFormulario.serialize()
            })*/
            $.ajax({
                url : './controllers/public/ctr_Login.php',
                type: "POST",
                data: {
                    userName    : $('#username').val(),
                    userPassword    : $('#password').val(),
                    loginLocation : '',
                    option      : 'Login'
                }
            })
            .done(function(response) {
                console.log(response, location);
                if (response.isPredefined) {
                    alertMessage({
                        value: response.value
                    });
                }

                if (response.isRealod) {
                    window.location.href = './?view=login';
                }
                /* 
                if (info == 'there is a session') {
                    swal({
                        title   : 'No puede iniciar sesión',
                        text    : 'Ya hay una sesión iniciada, cierre esa sesión e intente nuevamente.',
                        type    : 'warning'
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 2500);
                } else if (info == 'option don\'t exist' || info == 'error option') {
                    swal({
                        title   : 'Error al ejecutar',
                        text    : 'Hubo un error con la acción a realizar.',
                        type    : 'error'
                    });
                } else if (info == 'error data') {
                    swal({
                        title   : 'Datos incorrectos',
                        text    : 'Un error no permitio obtener los datos.',
                        type    : 'warning',
                        buttons : [false, {
                            text    : "Continuar",
                            value   : true,
                            className: 'btn btn-sm fondo-claro'
                        }]
                    });
                } else if (info == 'incorrect username') {
                    swal({
                        title   : 'Los datos son incorrectos',
                        text    : 'Este nombre de usuario no existe.',
                        type    : 'warning',
                        buttons : [false, {
                            text    : "Continuar",
                            value   : true,
                            className: 'btn btn-sm fondo-claro'
                        }]
                    });
                } else if (info == 'user blocked') {
                    swal({
                        title   : 'Usuario bloqueado',
                        text    : 'El usuario se encuentra bloqueado.\nHable con el administrador o pulse en ¡Olvide mi contraseña!.',
                        type    : 'error',
                        buttons : [false, {
                            text    : "Continuar",
                            value   : true,
                            className: 'btn btn-sm fondo-claro'
                        }]
                    });
                } else if (info == 'user off') {
                    swal({
                        title   : 'usuario suspendido',
                        text    : 'Comuniquese con el administrador del sistema para habilitar nuevamente su usuario.',
                        type    : 'warning',
                        buttons : [false, {
                            text    : "Continuar",
                            value   : true,
                            className: 'btn btn-sm fondo-claro'
                        }]
                    });
                }
                 else if (info == 'incorrect password') {
                    swal({
                        title   : 'Contraseña incorrecta',
                        text    : 'La contraseña es incorrecta, tiene tres (3) intentos o su usuario sera bloqueado.',
                        type    : 'warning',
                        buttons : [false, {
                            text    : "Continuar",
                            value   : true,
                            className: 'btn btn-sm fondo-claro'
                        }]
                    });
                } else if (info == 'A') {
                    location.href = '../warehouse';
                } else if (info == 'C') {
                    location.href = '../purchase';
                } else if (info == 'S') {
                    location.href = '../solicitudes/solicitudm.php';
                } else {
                    swal({
                        title   : 'Información',
                        text    : info,
                        type    : 'info',
                        buttons : [false, {
                            text    : "Continuar",
                            value   : true,
                            className: 'btn btn-sm fondo-claro'
                        }]
                    });
                }

                clean();
                */
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                let messageValues = alertMessage({ value: 'serverError', isShowMessage: false})
                swal({
                    title: messageValues.title,
                    html: messageValues.html,
                    type: messageValues.type,
                    showCloseButton: true,
                    confirmButtonText: 'Ok',
                    footer: '<b>Información adicional: </b>' + errorThrown + " / " + jqXHR.status
                });
            })
            .always(function() {
                $('#execute').removeAttr('disabled');
                $('#execute').html('<i class="fas fa-sign-in-alt mr-2"></i>Inciar sesión');
                clean(); // clean form values
            });
        }
    }
    // Evento para limpiar el formulario.
    $('#clean').click(clean);
    function clean() {
        document.login.reset();
        vUsername = false, vPassword = false;
        $('.login[data-toggle="tooltip"]').tooltip('dispose');
        $('input').removeClass('errorInput');
    }
    // Fin de las funciones para ejecutar acciones
    //////////////////////////////////////////////////////////////////////
});
