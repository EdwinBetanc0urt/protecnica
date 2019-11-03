<?php
	// start session if is empty
	if (strlen(session_id()) < 1) {
		session_start();
	}
    include_once("./views/_core/generatePublicView.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
	<?= generatePublicView::head("Mapa") ?>
    </head>

    <body class="bg-gris">
	    <?= generatePublicView::header() ?>

        <div id="main-container">
            <div class="row justify-content-center mx-0 px-3">
                <?= generatePublicView::badged() ?>

                <div class="col-sm-12 py-3 mb-3 bg-white rounded">
                    <h2 class="pb-2 mb-3 border-bottom">Mapa</h2>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3308.5818055222903!2d-69.21616948826826!3d9.544387901871659!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x9c9c82deefee3a19!2sAlmacenes+y+Transportes+Cerealeros+ATC!5e0!3m2!1sen!2sve!4v1499460758336" height="400" class="border w-100" allowfullscreen></iframe>
                    <p class="mb-0 mt-2 text-secondary">
                        <i class="fas fa-map-marker-alt"></i>
                        Ubicación: Av. Los Agricultores, Edificio Profinca. Punto de Referencia Redoma
                        La Espiga. Municipio Páez, Acarigua, Edo. Portuguesa, Venezuela.
                    </p>
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
    </body>
</html>
