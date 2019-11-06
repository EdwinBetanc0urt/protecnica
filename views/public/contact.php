<?php
	// start session if is empty
	if (strlen(session_id()) < 1) {
		session_start();
	}
    include_once("./views/_core/generatePublicView.php");

    $relativePath = generatePublicView::$relativePath;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
	<?= generatePublicView::head("Contacto") ?>
    </head>

    <body class="bg-gris">
	    <?= generatePublicView::header() ?>

        <div id="main-container">
            <div class="row justify-content-center mx-0 px-3">
                <?= generatePublicView::badged() ?>

                <div class="col-sm-12 py-3 mb-3 bg-white rounded">
                    <h2 class="pb-2 mb-3 border-bottom">Contacto</h2>
                    <img src="<?= $relativePath ?>/img/public/contact.jpg" alt="" class="w-100">

                    <div class="row">
                        <div class="col-sm-4 mt-2">
                            <h4 class="mb-2 pb-2 border-bottom">Redes sociales</h4>
                            <a href="https://www.facebook.com/protecnicaoficial/" target="_blank" class='text-secondary mb-1'><i class="fab fa-facebook"></i> Oficial Facebook - ProTécnica</a><br>
                            <a href="https://www.facebook.com/profile.php?id=100026265499562" target="_blank" class='text-secondary mb-1'><i class="fab fa-facebook"></i> Cuenta ProTécnica</a><br>
                            <a href="https://twitter.com/ProTecnicaOfic" target="_blank" class='text-secondary mb-1'><i class="fab fa-twitter"></i> Oficial Twitter nuevo - ProTécnica</a><br>
                            <a href="https://twitter.com/ProtecnicaCA" target="_blank" class='text-secondary mb-1'><i class="fab fa-twitter"></i> Oficial Twitter Viejo - ProTécnica</a><br>
                            <a href="https://twitter.com/GrupoProOficial" target="_blank" class='text-secondary mb-1'><i class="fab fa-twitter"></i> Grupo Pro Oficial</a>
                        </div>
                        <div class="col-sm-4 mt-2">
                            <h4 class="mb-2 pb-2 border-bottom">Contacto</h4>
                            <p class="mb-1 text-secondary"><i class="fas fa-phone"></i> 0255-664-4648 | <i class="fas fa-phone"></i> 0255-664-5220</p>
                            <p class="mb-1 text-secondary"><i class="fas fa-map-marker-alt"></i> Ubicación: Av. Los Agricultores, Edificio Profinca. Punto de Referencia Redoma La Espiga. Municipio Páez, Acarigua, Edo. Portuguesa, Venezuela.</p>
                            <a href="http://www.minpal.gob.ve/" target="_blank" class='text-secondary mb-1'><i class="fas fa-globe"></i> Web del Ministerio del Poder Popular para la Alimentación</a>
                        </div>
                        <div class="col-sm-4 mt-2">
                            <h4 class="mb-2 pb-2 border-bottom position-relative">Grupo Pro <i class="fas fa-exclamation-circle position-absolute" style="right: 10px; top: 7px; font-size: 16px;" data-toggle="tooltip" data-placement="left" title="Pulse en las imagenes para mas información."></i></h4>
                            <div class="row">
                                <div class="col-sm-6 py-1 text-center">
                                    <img src="<?= $relativePath ?>/img/public/interbagPlasticos.png" width="30" class="border rounded" alt="Interbag Plasticos" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Plasticos Industriales Interbag C.A." data-content="UPS, dedicada a la Elaboración de Bobinas para empaque de Harina, Arroz, Azúcar, entre otros productos Mercal, PDVAL. Garantizando la security Alimentaria"><br>
                                    <a href="https://twitter.com/PlasticoInterGS" target="_blank" class='text-secondary'>
                                        <i class="fab fa-twitter"></i> Interbag Plasticos
                                    </a>
                                </div>
                                <div class="col-sm-6 py-1 text-center">
                                    <img src="<?= $relativePath ?>/img/public/proarepaOficial.png" width="30" class="border rounded" alt="Proarepa" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Industria Venezolana Maizera Proarepa C.A." data-content="La Industria Venezolana Maizera Proarepa C.A. Planta Apissa, es una empresa del sector agroindustrial, la cual elabora productos de primera necesidad que forman parte de la cesta básica, como lo es la harina."><br>
                                    <a href="https://twitter.com/ProarepaOficial" target="_blank" class='text-secondary'><i class="fab fa-twitter"></i> Proarepa Oficial</a>
                                </div>
                                <div class="col-sm-6 py-1 text-center">
                                    <img src="<?= $relativePath ?>/img/public/venarroz.png" width="30" class="border rounded" alt="VENARROZ R.S.A, C.A" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Venarroz R.S.A C.A." data-content="Recepción, proceso, empaquetado y comercialización de arroz, así como el financiamiento de cosechas, agrícolas, tales como: silos maquinarias agrícolas, siembras y cosechas en general."><br>
                                    <a href="https://twitter.com/VenarrozA" target="_blank" class='text-secondary'><i class="fab fa-twitter"></i> Venarroz R.S.A, C.A</a>
                                </div>
                                <div class="col-sm-6 py-1 text-center">
                                    <img src="<?= $relativePath ?>/img/public/pronutricos.png" width="30" class="border rounded" alt="Pronutricos C.A" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Pronutricos" data-content="Industria Venezolana Maicera Pronutricos. Empresa administrada por el MINPPAL en pro a la security alimentaria de la patria. Harina de maíz precocida Venezuela."><br>
                                    <a href="https://twitter.com/pronutricos" target="_blank" class='text-secondary'>
                                        <i class="fab fa-twitter"></i>
                                        PronutricosOficial
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="position-fixed bg-white w-100 h-100 loader" style="top: 0px; z-index: 4;">
            <div class="row align-items-center justify-content-center mx-0 h-100">
                <div class="col-sm-12 text-center">
                    <h3 class="h2 text-secondary">
                        <i class="fas fa-spinner fa-spin"></i>
                        Cargando...
                    </h3>
                </div>
            </div>
        </div>

	    <?= generatePublicView::footer() ?>
	    <?= generatePublicView::scripts() ?>
        <!-- <script>
            $(function () {
                $('[data-toggle="popover"]').popover();
            });
        </script> -->
    </body>
</html>
