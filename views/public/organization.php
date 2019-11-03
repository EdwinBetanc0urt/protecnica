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
	<?= generatePublicView::head("Organigrama") ?>
    </head>

    <body class="bg-gris">
	    <?= generatePublicView::header() ?>

        <div id="main-container">
            <div class="row justify-content-center mx-0 px-3">
                <?= generatePublicView::badged() ?>

                <div class="col-sm-12 py-3 bg-white mb-3 rounded">
                    <h2 class="mb-2">Organigrama</h2>
                    <div class="border text-center">
                        <img src="<?= $relativePath ?>img/public/home-organization.png" style="width: 100%; max-width: 700px;">
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
    </body>
</html>
