<?php


include_once( "mpdf.php");

$mpdf = new mPDF();

// Write some HTML code:
$mpdf->WriteHTML('Hello World');

// Output a PDF file directly to the browser
$mpdf->Output();
