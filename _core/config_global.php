<?php

	// controla si el parser debería reconocer las etiquetas < ? ... ? >, además de < ?php ... ? >
	ini_set("short_open_tag", "on");

	ini_set("expose_php", "off"); //Expone al mundo que PHP está instalado en el servidor

	// Localizacion español
	setlocale(LC_ALL, "es_VE.UTF-8", "es_VE", "spanish");
	date_default_timezone_set("America/Caracas");

	ini_set('default_charset', 'utf-8');

	// define el separador de rutas en Windows \ y basados en Unix /
	defined("DS") OR define("DS", DIRECTORY_SEPARATOR);

	if (! defined("PATH")) {
		define("PATH", dirname(dirname(__FILE__)));
	}

	if (! defined("ENVIROMENT")) {
		define("ENVIROMENT", "develop"); // Cambiar a true si queremos mostrar los errores
	}

	if (! defined("MEDIO")) {
		define("MEDIO", "offline");
	}

	if (! defined("ERRORES")) {
		// define("ERRORES", E_ALL & ~E_NOTICE & ~E_WARNING);
		// define("ERRORES", E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

		// Notificar solamente errores de ejecución
		//define("ERRORES", E_ERROR | E_WARNING | E_PARSE);

		// Notificar E_NOTICE también puede ser bueno (para informar de variables
		// no inicializadas o capturar errores en nombres de variables ...)
		define("ERRORES", E_ALL | E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

		// Notificar todos los errores excepto E_STRICT
		//define("ERRORES",  ~E_ALL & ~E_DEPRECATED ^ ~E_STRICT);
		//define("ERRORES", E_ALL & ~E_STRICT);

		// Notificar todos los errores de PHP (ver el registro de cambios)
		// define("ERRORES", E_ALL & E_NOTICE & E_STRICT & E_WARNING);

		// Observe que sólo serán interpretados '|', '~', '!', '^' y '&'
	}

	if (ENVIROMENT == "develop") {
		//MUESTRA todos los errores para entorno de DESARROLLO
		error_reporting(ERRORES);
		//error_reporting(E_ALL); //notifica todos los errores y advertencias
		//error_reporting(-1); //notifica todos los errores
		ini_set("display_errors", "On");
		//ini_set('display_errors', '1');
		ini_set("display_startup_errors", "On");
	}
	else {
		//OCULTA todos los errores, para entorno de PRODUCCION
		error_reporting(0); // Desactivar toda notificación y advertencia de error
		ini_set("display_errors", "off");
		//ini_set('display_errors', '0');
		ini_set("display_startup_errors", "off");
	}

	// indica al navegador que no exponga la cookie a las secuencias de comandaos del lado del cliente, como JavaScript
	// ini_set("session.cookie_httponly", 1);

	// garantiza que las cookies de sesión solo se envíen a través de conexiones seguras
	// ini_set("session.cookie_secure", 1);

	// solo utilice cookies para las sesiones y no permita el paso de ID de sesión como un parámetro GET
	// ini_set("session.use_only_cookies", 1);

	ini_set("output_buffering", "On");

	ini_set("log_errors", "On");
	ini_set("error_log", "error_srv.log");

	// desactiva ciertas funciones internas de PHP por security
    ini_set("disable_functions",
        "curl_exec, curl_multi_exec, diskfreespace,
        disk_free_space, exec, ini_set, leak, passthru,
        parse_ini_file, popen, proc_open, set_time_limit,
        shell_exec, show_sourcephpinfo, system, tmpfile"
    );

	// header('X-Powered-By: EdwinBetanc0urt, enviroment ' . ENVIROMENT); // por defecto PHP/5.6.30 o su version

?>
