$(function (){
    let dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
    let meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    traerFecha();

    function traerFecha() {
        $.ajax({
            url: './controllers/_core/c_tiempo.php',
            type: 'post',
            data: {
                'opcion': 'Traer fecha'
            }
        })
        .done (function (info) {
            let datos = JSON.parse(info);
            $("#dia-nombre").html(dias[datos.datos[0].diaL-1]);
            $("#dia-nombre").attr('dia',datos.datos[0].diaL);
            $("#dia-numero").html(datos.datos[0].diaN);
            $("#mes").html(meses[datos.datos[0].mes-1]);
            $("#mes").attr('mes',datos.datos[0].mes);
            $("#ano").html(datos.datos[0].ano);

            $("#horas").html(datos.datos[0].hora);
            $("#minutos").html(datos.datos[0].minuto);
            $("#segundos").html(datos.datos[0].segundo);
            $("#am-pm").html(datos.datos[0].AmPm);

            horaDinamica();
        });
    }

    function horaDinamica() {
        setInterval(function () {
            let segundos = parseInt($("#segundos").html());
            if (segundos == 59) {
                segundos = '00';

                let minutos = parseInt($("#minutos").html());
                if (minutos == 59) {
                    minutos = '00';

                    let horas = parseInt($("#horas").html());
                    if (horas == 12) {
                        horas = '01';
                    } else if (horas == 11) {
                        horas++;

                        let horario = $("#am-pm").html();
                        if (horario == 'am') {
                            horario = 'pm';
                        } else {
                            horario = 'am';
                        }
                        $("#am-pm").html(horario);

                        let letraDia = parseInt($("#dia-nombre").attr('dia'));
                        if (letraDia == 7) {
                            letraDia = 1;
                        } else {
                            letraDia++;
                        }

                        $("#dia-nombre").html(dias[letraDia-1]);
                        $("#dia-nombre").attr('dia',letraDia);

                        let NumeroDia = parseInt($("#dia-numero").html());
                        let mes = parseInt($("#mes").attr('mes'));
                        if (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 || mes == 10 || mes == 12) {
                            if (NumeroDia == 31) {
                                NumeroDia = '01';
                            } else {
                                NumeroDia++;
                            }
                        } else if (mes == 2) {
                            if (NumeroDia == 28) {
                                NumeroDia = '01';
                            } else {
                                NumeroDia++;
                            }
                        } else {
                            if (NumeroDia == 30) {
                                NumeroDia = '01';
                            } else {
                                NumeroDia++;
                            }
                        }

                        if (NumeroDia == '01') {
                            if (mes == 12) {
                                mes = 1;

                                let nuevoAno = parseInt($("#ano").html());
                                nuevoAno++;
                                $("#ano").html(nuevoAno);
                            } else {
                                mes++;
                            }

                            $("#mes").attr('mes',mes);
                            $("#mes").html(meses[mes-1]);
                        }

                        $("#dia-numero").html(NumeroDia);
                    } else {
                        horas++;
                        if (horas < 10) {
                            horas = '0'+horas;
                        }
                    }

                    $("#horas").html(horas);
                } else {
                    minutos++;
                    if (minutos < 10) {
                        minutos = '0'+minutos;
                    }
                }

                $("#minutos").html(minutos);
            } else {
                segundos++;
                if (segundos < 10) {
                    segundos = '0'+segundos;
                }
            }

            $("#segundos").html(segundos);
        }, 1000);
    }
});
