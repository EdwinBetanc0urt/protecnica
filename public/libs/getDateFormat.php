<?php

/**
 * 
 */
class DateFormat
{
	public $date, $day, $month, $year;

	static function getFormatoRetorno($arrDate, $psFormatOut = 'amd') {
		switch ($psFormatOut) {
			default:
			case 'amd':
				// 2016 - 10 - 23
				$psDate = $lsAno . "-" . $month . "-" . $day;
				break;

			case 'dma':
				// 23 - 10 - 2016
				$psDate = $day . "-" . $month . "-" . $lsAno;
				break;

			case 'mda':
				// 10 - 23 - 2016
				$psDate = $month . "-" . $day . "-" . $lsAno;
				break;

			case 'am':
				// 10 - 23 - 2016
				$psDate = $lsAno . "-" . $month;
				break;
		}
		return array_merge(
			$arrDate,
			array(
				'date_out' => $psDate,
				'format_out' => $psFormatOut,
			),
		);
	}

	static function getFormatoEntrada($psDate, $psFormatIn = 'dma') {
		switch ($psFormatIn) {
			default:
			case 'dma':
				$day = substr($psDate, 0, 2);
				$month = substr($psDate, 3, 2);
				$year = substr($psDate, 6, 4);
				break;

			case 'amd':
				$day = substr($psDate, 8, 2);
				$month = substr($psDate, 5, 2);
				$year = substr($psDate, 0, 4);
				break;

			case 'mda':
				$day = substr($psDate, 3, 2);
				$month = substr($psDate, 0, 2);
				$year = substr($psDate, 6, 4);
				break;
		}

		return array(
			'date_in' => $psDate,
			'format_in' => $psFormatIn,
			'day' => $day,
			'month' => $month,
			'year' => $year,
		);
	}


	static public function getDateNow() {
		$date = date("Y-m-d"); //fecha actual php para servidor
		//$lsActual="NOW()"; //fecha actual SQL para servidor

		//$lsDiaSemanaN = date("N"); // día de la semana en números, 1 (lunes) a 7 (domingo)
		//$lsDiaSemanaC = date("D"); // día de la semana en letras cortas, Mon a Sun
		//$lsDiaSemanaL = date("l"); // día de la semana en letras largas, Sunday a Saturday

		$day = date("d"); //día del mes, 01 a 31
		//$lsDiaS = date("j"); //día del mes sin ceros delate, 1 a 31

		$month = date("m"); //mes del año en números, 01 a 12
		//$lsMesS = date("n"); //mes del año en números sin ceros, 1 a 12
		//$lsMesC = date("M"); //mes del año en letras, Jan a Dec
		//$lsMesL = date("F"); //mes del año en letras, January a December

		//$lsAnoC = date("y"); //dos últimos dígitos del año, 16
		$year = date("Y"); //año en cuatro dígitos, 2016

		return array(
			'date' => $psDate,
			'format' => "amd",
			'day' => $day,
			'month' => $month,
			'year' => $year,
		);
	}



	/**
	 * @author Edwin Betancourt <EdwinBetanc0urt@outlook.com>
	 */
	static public function faFechaFormato($psFecha = "", $pmFormatoE = "amd", $pmFormatoR = "dma")
	{
		if ($psFecha == "") {
			$psFecha = date("Y-m-d"); //fecha actual php para servidor
			//$lsActual="NOW()"; //fecha actual SQL para servidor
		}

		else {

		}

		switch ($pmFormatoR) {
			default:
			case 'amd':
				// 2016 - 10 - 23
				$lsFecha = $lsAno . "-" . $lsMes . "-" . $lsDia;
				break;

			case 'dma':
				// 23 - 10 - 2016
				$lsFecha = $lsDia . "-" . $lsMes . "-" . $lsAno;
				break;

			case 'mda':
				// 10 - 23 - 2016
				$lsFecha = $lsMes . "-" . $lsDia . "-" . $lsAno;
				break;

			case 'am':
				// 10 - 23 - 2016
				$lsFecha = $lsAno . "-" . $lsMes;
				break;
		}
		return $lsFecha;
	} //cierre de la función
}

?>