
/*!
 * Mensajes de Alerta o SweetAlert
 * @description: función javascript Mensajes, creado para centralizar la estructura
	de mensajes a mostrar y utilizado por las operaciones como Incluir, Consultar,
	Modificar, Eliminar y/o Restaurar del sistema, ademas de las diferentes acciones
	o respuestas que emita el sistema.
 * @author: Edwin Betancourt <EdwinBetanc0urt@outlook.com>
 * @version 0.9
 * @created: 19-Enero-2016
 * @modificated: 19-Junio-2018

		Este programa es software libre, su uso, redistribución, y/o modificación
	debe ser bajo los términos de las licencias indicadas, la GNU Licencia Pública
	General (GPL) publicada por la Fundación de Software Libre(FSF) de la versión
	3 o cualquier versión posterior y la Creative Commons Atribución - Compartir
	Igual (CC BY-SA) de la versión 4.0 Internacional o cualquier versión posterior.

		Este software esta creado con propósitos generales que sean requeridos,
	siempre que este sujeto a las licencias indicadas, pero SIN NINGUNA GARANTÍA
	Y/O RESPONSABILIDAD que recaiga a los creadores, autores y/o desarrolladores,
	incluso sin la garantía implícita de COMERCIALIZACIÓN o IDONEIDAD PARA UN
	PROPÓSITO PARTICULAR. Cualquier MODIFICACIÓN, ADAPTACIÓN Y/O MEJORA que se haga
	a partir de este código debe ser notificada y enviada a la fuente, comunidad
	o repositorio de donde fue obtenida, y/o a sus AUTORES.
 */

function fjMensajes(mensajes) {
	alertMessage({
		value: mensajes
	});
}

function alertMessage({ isShowMessage = true, value, backgroundColor = '#ffffff' }) { //parámetro de la vista (msjMensaje) que contiene los valores
	//Color de fondo de las ventanas modales para mensajes
	// var vsColorFondo = "#e1e1e1"; //gris claro
	var vsColorFondo = "#b1b1b1"; //blanco
	vsColorFondo = "#ffffff"; //blanco
	var message = {};
	//si la búsqueda de la palabra noeliminousados en la cadena psValorUrl no da error
	if (value.includes("noeliminousados")) {
		//toma los caracteres a partir de la posición 15 (los números del URL a la derecha de msjAlerta=noeliminousados2342)
		message = {
			title: '¡Atención!',
			html: `No puede ser eliminado, está en uso en: <br /> ${psValorUrl.substring(15)} Registro(s)`,
			type: 'error'
		};
	}

	//si la búsqueda de la palabra noeliminousados en la cadena psValorUrl no da error
	if (value.includes("claverepetida")) {
		//toma los caracteres a partir de la posición 13 (los números del URL a la derecha de msjAlerta=claverepetida5)
		message = {
			title: '¡Clave Repetida!',
			html: `La clave debe ser diferente a las últimas <br /> ${psValorUrl.substring(13)} claves que ha utilizado`,
			type: 'error'
		};
	}

	switch (value) {
		case "serverError":
			message = {
				title: '¡Atención!',
				html: 'La petición para no ha sido procesada correctamente.',
				type: 'error'
			};
			break;


		case "welcome":
			message = {
				title: '¡Hecho!',
				html: 'Ha accedidio correctamente.',
				type: 'success'
			};
			break;
		/*
		default:
			alert("Prueba de librería de mensajes de alertas<br />");
			break;
		*/

		// si se solicita una pagina en construcción
		case "mantenimiento":
			message = {
				title: '¡Atención!',
				html: 'Página actualmente en mantenimiento.',
				type: 'info'
			};
			break;

		// si se trata de acceder a un sitio restingido
		case "accesoprohibido":
			message = {
				title: '¡Cuidado!',
				html: 'Hubo un intento de acceso a secciones restringidas, si continúa intetando será <b>BLOQUEADO</b>.',
				type: 'warning'
			};
			break;

		// si se CONSULTA la tabla en la base de datos
		case "sinconsulta":
			message = {
				title: '¡Ops!',
				html: 'No se encontró el registro buscado.',
				type: 'error'
			};
			break;

		// si se REGISTRA en la base de datos una transacción
		case "guardo":
			message = {
				title: '¡Hecho!',
				html: 'Registro guardado exitosamente',
				type: 'success'
			};
			break;
		case "noguardo":
			message = {
				title: '¡Error!',
				html: 'El registro no fue guardado.',
				type: 'error'
			};
			break;

		// si se REGISTRA en la base de datos
		case "registro":
			message = {
				title: '¡Hecho!',
				html: 'Registro guardado exitosamente',
				type: 'success'
			};
			break;
		case "noregistro":
			message = {
				title: '¡Error!',
				html: 'El registro no fue guardado.',
				type: 'error'
			};
			break;
		case "duplicado":
			message = {
				title: '¡Atención!',
				html: 'Registro duplicado, no será guardado.',
				type: 'info'
			}
			break;

		case "enelaboracion":
			message = {
				title: '¡Atención!',
				html: 'Existe un registro en construcción actualmente.',
				type: 'info'
			};
			break;

		case "verificar":
			message = {
				title: '¡Atención!',
				html: 'Verificar la información y los datos antes de continuar.',
				type: 'warning'
			};
			break;

		case "desactivado":
			message = {
				title: '¡Desactivado!',
				html: 'El registro está actualmente desactivado.',
				type: 'info'
			};
			break;

		case "anulado":
			message = {
				title: '¡Anulado!',
				html: 'Registro anulado exitosamente.',
				type: 'success'
			};
			break;
		case "noanulado":
			message = {
				title: '¡No Anulado!',
				html: 'El registro no fue anulado.',
				type: 'error'
			};
			break;

		case "procesado":
			message = {
				title: '¡Procesado!',
				html: 'Registro procesado exitosamente.',
				type: 'success'
			};
			break;
		case "noprocesado":
			message = {
				title: '¡No Procesado!',
				html: 'El registro no fue procesado exitosamente.',
				type: 'error'
			};
			break;


		case "aceptado":
			message = {
				title: '¡Aceptado!',
				html: 'El Registro de solicitud ha sido aceptado exitosamente.',
				type: 'success'
			};
			break;
		case "denegado":
			message = {
				title: '¡Denegado!',
				html: 'Registro de solicitud ha sido denegado.',
				type: 'success'
			};
			break;


		case "aprobado":
			message = {
				title: '¡Aprobado!',
				html: 'Registro aprobado exitosamente.',
				type: 'success'
			};
			break;
		case "noaprobado":
			message = {
				title: '¡Procesado!',
				html: 'El registro no fue aprobado.',
				type: 'info'
			};
			break;

		// si se MODIFICA en la base de datos
		case "nocambio":
			message = {
				title: '¡Atención!',
				html: 'No se realizaron cambios.',
				type: 'error'
			};
			break;
		case "cambio":
			message = {
				title: '¡Hecho!',
				html: 'Cambios realizados exitosamente.',
				type: 'success'
			};
			break;
		case "igual":
			message = {
				title: '¡Duplicado!',
				html: 'No se realizaron cambios, ya existe un registro con estos datos.',
				type: 'info'
			};
			break;

		// si se ELIMINA en la base de datos
		case "elimino":
			message = {
				title: '¡Hecho!',
				html: 'El registro se elimino exitosamente.',
				type: 'success'
			};
			break;
		case "noelimino":
			message = {
				title: '¡Error!',
				html: 'No se eliminó ningún registro.',
				type: 'error'
			};
			break;


		// si se RESTAURA en la base de datos
		case "restauro":
			message = {
				title: '¡Hecho!',
				html: 'Registro restaurado exitosamente.',
				type: 'success'
			};
			break;
		case "norestauro":
			message = {
				title: '¡Error!',
				html: 'El registro no se restauró.',
				type: 'error'
			};
			break;

		// si se Desbloquea un usuario en la base de datos
		case "bloqueo":
			message = {
				title: '¡Hecho!',
				html: 'Usuario Bloqueado exitosamente.',
				type: 'success'
			};
			break;
		case "desbloqueo":
			message = {
				title: '¡Hecho!',
				html: 'Usuario desbloqueado exitosamente.',
				type: 'success'
			};
			break;
		case "nodesbloqueo":
			message = {
				title: '¡Error!',
				html: 'El Usuario no se desbloqueo.',
				type: 'error'
			};
			break;

		//viene del ctr_AsignarRol.php cuando usuario con menos acceso intenta cambiar rol a un superior
		case "rolmayor":
			message = {
				title: '¡Atención!',
				html: 'Sin cambios, <br /> Operación restringida para tu usuario.',
				type: 'info'
			};
			break;

		// viene del ctr_CambiarClave y ctr_RecuperarClave
		case "respuestaincorrecta":
			message = {
				title: '¡Incorrecto!',
				html: 'Alguna o todas de las respuestas son incorrectas.',
				type: 'info'
			}
			break;


		// mensaje de ctr_RecuperarClave, exitoso
		case "clavecambio":
			message = {
				title: '¡Hecho!',
				html: 'Clave cambiada exitosamente.',
				type: 'success'
			};
			break;
		case "clavenocambio":
			message = {
				title: '¡Error!',
				html: 'La clave no ha sido cambiada.',
				type: 'error'
			};
			break;

		//mensaje de ctr_Login.php
		case "logindeshabilitado":
			message = {
				title: '¡Atención!',
				html: 'Usuario inhabilitado... <br /> Contacte al administrador del sistema.',
				type: 'info'
			};
			break;

		//mensaje ce ctr_Login.php si responde mal la contraseña
		case "claveousaurio":
			message = {
				title: '¡Atención!',
				type: 'error',
				html: 'Usuario y/o contraseña incorrecta... <br /> Por favor, verifique e intente nuevamente.'
			};
			break;

		//mensaje ce ctr_Login.php si responde mal la contraseña
		case "bloqueo_intentos":
			message = {
				title: '¡Atención!',
				html: 'Usuario Bloqueado... <br /> Ha superado el máximo de intentos permitidos.',
				type: 'info'
			};
			break;

		//mensaje de ctr_Login de ctr_RecuperarClave al no encontrar usuario
		case "nousuario":
			message = {
				title: '¡Atención!',
				html: 'No se encontró el Usuario.',
				type: 'error'
			};
			break;

		// mensaje de ctr_Login si hay una sesión abierta
		case "usuarioenlinea":
			message = {
				title: '¡Atención!',
				html: 'Usuario conectado (ONLINE). <br /> Solo puede haber una sesión activa.',
				type: 'info'
			};
			break;

		case "tiempoexpirado":
			message = {
				title: '¡Atención!',
				html: 'Tiempo de sesión expirado. <br /> el usuario superó el tiempo máximo inactivo.',
				type: 'info'
			};
			break;

		case "completadatos":
			message = {
				title: '¡Atención!',
				html: 'Es necesario completar sus datos antes de iniciar sesión.',
				type: 'info'
			};
			break;
		case "datoscompletos":
			message = {
				title: '¡Atención!',
				html: 'Sus datos se han actualizado exitosamente.',
				type: 'success'
			};
			break;

		//mensaje de ctr_AccesoRol al eliminar todos los accesos de un rol
		case "quitoacceso":
			message = {
				title: '¡Atención!',
				html: 'Los accesos a la vista seleccionada se han removido.',
				type: 'success'
			};
			break;
	} //cierre del switch

	if (isShowMessage) {
		if (typeof swal === 'function') {
			swal({
				title: message.title,
				html: message.html,
				type: message.type,
				showCloseButton: true,
				background: vsColorFondo,
				confirmButtonText: 'Ok'
			});
		} else {
			alert(`\t\t\t\t\t${message.tittle}\n ${message.html}`);
		}
	}
	return message;
} //cierre de la función fjMensajes

/*
	paMsj {
		datos {
			titulo
			cuerpo
			pie
		}
		parametros {
			tipo
			aceptar
			cancelar
			tiempo
			modo
			datosmodo {
				posicion
			}
		}
	}
*/
function fjMensaje(paMsj) {
	//comprueba si la libreria esta cargada
	if (typeof swal === 'function') {
		if (paMsj.parametros.modo == "minimo") {
			swal.mixin({
				toast: true,
				position: 'bottom-end',
				showConfirmButton: false,
				timer: 3000
			})({
				type: paMsj.parametros.tipo,
				html: paMsj.datos.cuerpo
			});
		}
		else {
			swal({
				title: paMsj.datos.titulo,
				html: paMsj.datos.cuerpo,
				footer: paMsj.datos.pie,
				type: paMsj.parametros.tipo,
				showCloseButton: true,
				background: vsColorFondo,
				confirmButtonText: 'Ok'
			});
		}
	} //cierre de si esta la libreria cargada
	else {
		alert(
			"\t\t\t" + paMsj.datos.titulo +
			"\n" + paMsj.datos.cuerpo +
			"\n" + paMsj.datos.pie
		);
	}
} //cierre de la funcion parametrizada
