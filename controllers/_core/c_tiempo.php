<?php

if (isset($_POST['opcion'])) {
    $opcion = $_POST['opcion'];

    switch ($opcion) {
        case 'Traer fecha':
            date_default_timezone_set("America/Caracas");

            $dia = date('j', time());
            $mes = date('n', time());
            $ano = date('Y', time());
            $diaActual = date('w', time());

            $hora = date('h', time());
            $minutos = date('i', time());
            $segundos = date('s', time());
            $AmPm = date('a', time());

            $Datos["datos"][] = [
                'diaN'  => $dia,
                'mes'   => $mes,
                'ano'   => $ano,
                'diaL'  => $diaActual,
                'hora'  => $hora,
                'minuto'    => $minutos,
                'segundo'   => $segundos,
                'AmPm'  => $AmPm
            ];

            echo json_encode($Datos);
            break;

        default:
            echo 'Error';
            break;
    }
} else {
    echo 'Error';
}

?>
