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
	<?= generatePublicView::head() ?>
    </head>

    <body class="bg-gris">
	    <?= generatePublicView::header() ?>

        <div id="main-container">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?= $relativePath ?>img/public/home-slide-1.jpg" class="d-block w-100">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>Empresa Socialista ProTécnica C.A.</h3>
                            <p>Empresa Técnica Socialista, comprometida con la patria. Ejemplo de eficiencia industrial y de trabajo con los sectores garantes de la security agroalimentaria.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= $relativePath ?>img/public/home-slide-2.jpg" class="d-block w-100">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>Empresa Socialista ProTécnica C.A.</h3>
                            <p>Nuestro objetivo es garantizar el funcionamiento optimo de las empresas de producción deAlimentos #MisionAlimentacion.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= $relativePath ?>img/public/home-slide-3.jpg" class="d-block w-100">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>Empresa Socialista ProTécnica C.A.</h3>
                            <p>Protécnica y sus trabajos voluntarios Nuestro compromiso social con los mas necesitados demostrado con acción y trabajo.</p>
                        </div>
                    </div>
                </div>

                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="row mx-0 px-3">
                <?= generatePublicView::badged() ?>

                <div class="col-sm-12 bg-white rounded text-secondary mb-3">
                    <div class="row">
                        <div class="col-sm-12 pt-2">
                            <h4 class="mb-0">Tweets de <span class="texto-oscuro">ProTécnica Oficial</span></h4>
                        </div>
                        <div class="col-sm-6 col-md-3 py-2">
                            <div class="card">
                                <img src="<?= $relativePath ?>img/public/home-tweets-1.jpg" class="card-img-top">
                                <div class="card-body">
                                    <p class="card-text">Ejemplo de eficiencia industrial comprometidos con los sectores agro-alimentarios. <br><span class="texto-oscuro">#PorUnaMejorVenezuela</span></p>
                                    <a href="https://twitter.com/ProTecnicaOfic/status/994285116607422464" target="_blank" class="btn btn-sm fondo-claro"><i class="fab fa-twitter mr-2"></i>Ir al tweet</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3 py-2">
                            <div class="card">
                                <img src="<?= $relativePath ?>img/public/home-tweets-2.jpg" class="card-img-top">
                                <div class="card-body">
                                    <p class="card-text">Brindando todo tipo de servicio del área metalmecanica para garantizar el buen funcionamiento de todas las empresas productoras del país <span class="texto-oscuro">#PorUnaMejorVenezuela</span></p>
                                    <a href="https://twitter.com/ProTecnicaOfic/status/994634228137684992" target="_blank" class="btn btn-sm fondo-claro"><i class="fab fa-twitter mr-2"></i>Ir al tweet</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3 py-2">
                            <div class="card">
                                <img src="<?= $relativePath ?>img/public/home-tweets-3.jpg" class="card-img-top">
                                <div class="card-body">
                                    <p class="card-text">Comprometidos con el buen funcionamiento de las plantas de producción <span class="texto-oscuro">#VenezuelaProductivaYProspera</span></p>
                                    <a href="https://twitter.com/ProTecnicaOfic/status/994284032178491397" target="_blank" class="btn btn-sm fondo-claro"><i class="fab fa-twitter mr-2"></i>Ir al tweet</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3 py-2">
                            <div class="card">
                                <img src="<?= $relativePath ?>img/public/home-tweets-4.jpg" class="card-img-top">
                                <div class="card-body">
                                    <p class="card-text">Proyecto adecuación de camión de transporte ATC. <br><span class="texto-oscuro">#TrabajoYEsfuerzo</span></p>
                                    <a href="https://twitter.com/ProTecnicaOfic/status/999377342219935744" target="_blank" class="btn btn-sm fondo-claro"><i class="fab fa-twitter mr-2"></i>Ir al tweet</a>
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
    </body>
</html>
