<?php

//define el separador de rutas en Windows \ en basados en Unix /
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);


if (is_file("models" . DS . "security" . DS . "cls_RoleAccess.php")) {
	require_once("models" . DS . "security" . DS . "cls_RoleAccess.php");
}
elseif (is_file(".." . DS . "models" . DS . "security" . DS . "cls_RoleAccess.php")) {
	require_once(".." . DS . "models" . DS . "security" . DS . "cls_RoleAccess.php");
}
else {
	require_once(".." . DS . ".." . DS . "models" . DS . "security" . DS . "cls_RoleAccess.php");
}


?>
