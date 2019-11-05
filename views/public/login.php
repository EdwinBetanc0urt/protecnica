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
	<?= generatePublicView::head("Iniciar sesión") ?>
    </head>

    <body class="bg-gris">
	    <?= generatePublicView::header() ?>

        <div id="main-container">
            <div class="row align-items-center justify-content-center mx-0 px-3 h-100">
                <!--
                <form name="login" method="POST" action="./controllers/public/ctr_Login.php" class="col-sm-8 col-md-6 col-lg-4 p-0">
                -->
                <form name="login" method="POST" class="col-sm-8 col-md-6 col-lg-4 p-0">
                    <div class="bg-white rounded px-3 py-4">
                        <div class="text-center">
                            <img src="<?= $relativePath ?>img/public/login-user.jpg" width="100" class="mb-2 rounded">
                            <p class="h5">Inicio de sesión</p>
                        </div>

                        <div class="form-row">
                            <div class="col-sm-12 mb-1">
                                <label for="username">Nombre de usuario: <i class="fas fa-asterisk"></i></label>
                                <input type="text" id="username" name="userName" class="form-control form-control-sm login" autocomplete="off" data-toggle="tooltip" data-placement="top" title="">
                            </div>
                            <div class="col-sm-12">
                                <label for="password">Contraseña: <i class="fas fa-asterisk"></i></label>
                                <input type="password" id="password" name="userPassword" class="form-control form-control-sm login" autocomplete="off" data-toggle="tooltip" data-placement="top" title="">
                            </div>
                            <input type="hidden" name="loginLocation">
                        </div>

                        <div class="d-flex justify-content-between mt-1">
                            <a href="../views/forgotPassword" class="texto-oscuro">¡Olvide mi contraseña!</a>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-sm fondo-claro" id="execute">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Iniciar sesión
                            </button>
                            <button type="reset" class="btn btn-sm" id="clean" style="background: #e2e2e2;">
                                <i class="fas fa-backspace mr-2"></i>
                                Limpiar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--
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
        -->

	    <?= generatePublicView::footer() ?>
	    <?= generatePublicView::scripts() ?>
        <script src="<?= $relativePath ?>js/_core/alertMessage.js"></script>
        <script src="<?= $relativePath ?>js/public/validations.js"></script>
        <script src="<?= $relativePath ?>js/public/login.js"></script>
    </body>
</html>
