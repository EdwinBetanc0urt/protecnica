<?php

// Archivo de configuración de la intranet, con todos los privilegios para
// la base de datos db_protecnica

// defines const of the system
defined("SERVER") OR define("SERVER", "127.0.0.1"); // server of database
defined("PORT") OR define("PORT", 3306); // port of access to database, 3306 default port to MySQL and 5432 default port to pgSQL
defined("HOST") OR define("HOST",  SERVER . ":" . PORT);
defined("MOTOR") OR define("MOTOR",  "mysql"); // database management system

defined("DB") OR define("DB", "db_protecnica"); // database name to connect
defined("USER") OR define("USER", "user_db_protecnica"); // database user name with access
defined("PASSWORD") OR define("PASSWORD", "+*123.protecnica#456-/"); // password to user name form database
defined("CHART") OR define("CHART", "utf8"); // charset to

defined("PRIVATE_KEY") OR define("PRIVATE_KEY", "*123$.-abC"); // master key to encipted

?>
