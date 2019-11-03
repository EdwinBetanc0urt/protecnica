<?php
/**
 * @author EdwinBetanc0urt@outlook.com
 */
class generatePublicView {
	public static $relativePath = "./public/";

	public static function head($title = "Inicio") {
		?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?= $title ?> | ProTécnica C.A.</title>

		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <link rel="shortcut icon" type="image/png" href="<?= self::$relativePath ?>img/_core/logo.png">

		<?php
		// print css styles and fonts
		self::styles();
		self::fonts();
	}

	public static function styles() {
		$relativePath = self::$relativePath . "css/";
		self::stylesLibs();
		?>
		<link rel="stylesheet" href="<?= $relativePath ?>public/general-style.css">
		<link rel="stylesheet" href="<?= $relativePath ?>/public/page.css">
		<?php
	}


	public static function stylesLibs() {
		$relativePath = self::$relativePath . "libs/";
		?>
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="<?= $relativePath ?>bootstrap4/css/bootstrap.min.css">
		<?php
	}

	public static function fonts() {
		$relativePath = self::$relativePath . "fonts/";
		?>
		<!-- Font Awesome -->
		<!-- <link rel="stylesheet" href="<?= $relativePath ?>font-awesome/css/font-awesome.min.css"> -->
		<link rel="stylesheet" href="<?= $relativePath ?>font-awesome5/css/all.min.css">
		<!-- <link rel="stylesheet href="../styles/css/all.css""> -->

		<!-- Ionicons -->
		<!-- <link rel="stylesheet" href="<?= $relativePath ?>Ionicons/css/ionicons.min.css"> -->

    	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Hind+Vadodara:300,400"> -->
		<?php
	}

	public static function header($elementHeader = '') {
		?>
		<header style="height:57px; z-index: 0;" class="header">
			<nav class="navbar navbar-expand-md fixed-top navbar-dark fondo-claro" style="z-index: 2;">
				<a class="navbar-brand d-inline-block" href="?view=home" id="titleHeader">
					<img src="<?= self::$relativePath ?>img/_core/logo.png" class="d-inline-block align-top" alt="Logo de la Empresa Socialista Protécnica C.A. - Acarigua. edo Portuguesa">
					P<span style="font-size:20px;">RO</span>T<span style="font-size:20px;">ÉCNICA</span> C.A.
				</a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainHeader" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="mainHeader">
					<ul class="navbar-nav w-100 justify-content-end">
						<li class="nav-item <?php if ($elementHeader == 1) echo 'active'; ?>">
							<a class="nav-link" href="?view=home">
								<i class="fas fa-home mr-1"></i>
								Inicio
							</a>
						</li>

						<li class="nav-item <?php if ($elementHeader == 2 or $elementHeader == 3 or $elementHeader == 4) echo 'active'; ?> dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-users mr-1"></i>
								Nosotros
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item <?php if ($elementHeader == 2) echo 'active'; ?>" href="?view=missionAndVision">
									Misión y visión</a>
								<a class="dropdown-item <?php if ($elementHeader == 3) echo 'active'; ?>" href="?view=strategicObjectives">
									Objetivos estratégicos</a>
								<a class="dropdown-item <?php if ($elementHeader == 4) echo 'active'; ?>" href="?view=history">
									Reseña histórica</a>
							</div>
						</li>
						<li class="nav-item <?php if ($elementHeader == 5) echo 'active'; ?>">
							<a class="nav-link" href="?view=organization">
								<i class="fas fa-sitemap mr-1"></i>
								Organigrama
							</a>
						</li>
						<li class="nav-item <?php if ($elementHeader == 6) echo 'active'; ?>">
							<a class="nav-link" href="?view=map">
								<i class="fas fa-map-marked-alt mr-1"></i>
								Mapa
							</a>
						</li>
						<li class="nav-item <?php if ($elementHeader == 7) echo 'active'; ?>">
							<a class="nav-link" href="?view=contact">
								<i class="fas fa-headphones mr-1"></i>
								Contacto
							</a>
						</li>
						<li class="nav-item <?php if ($elementHeader == 8) echo 'active'; ?>">
							<a class="nav-link" href="?view=login">
								<i class="fas fa-sign-in-alt mr-1"></i>
								Iniciar sesión
							</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<?php
	}

	public static function badged() {
		?>
		<div class="col-sm-12 bg-white rounded text-secondary my-3 py-2 px-3 d-flex justify-content-between">
			<div>
				<i class="fas fa-calendar"></i>
				<!-- <span id="dia-nombre"></span>, -->
				<span id="dia-numero"></span>
				de <span id="mes"></span>
				del <span id="ano"></span>
				| <i class="fas fa-clock"></i>
				<span id="horas"></span>:<span id="minutos"></span>:<span id="segundos"></span>
				<span id="am-pm"></span>
			</div>

			<div>
				Empresa Socialista ProTécnica C.A.
			</div>
        </div>
		<?php
	}

	public static function scripts() {
		$relativePath = self::$relativePath . "js/public/";
		self::scriptsLibs();
		?>
		<script src="<?= $relativePath ?>generals.js"></script>
		<script src="<?= $relativePath ?>alertsmessages.js"></script>
        <script src="<?= $relativePath ?>date.js"></script>
		<?php
	}

	public static function scriptsLibs() {
		$relativePath = self::$relativePath . "libs/";
		?>
		<!-- jQuery 3 -->
		<script src="<?= $relativePath ?>jquery/dist/jquery.min.js"></script>

		<script src="<?= $relativePath ?>propper/popper.min.js"></script>
		
		<!-- Bootstrap 4 -->
		<script src="<?= $relativePath ?>bootstrap4/js/bootstrap.min.js"></script>

		<script src="<?= $relativePath ?>sweetalert2/dist/sweetalert2.all.js"></script>
		<?php
	}

	public static function footer() {
		?>
		<footer class="fondo-claro">
			<p class="p-1 mb-0 text-white text-center" style="font-size: 12px;">
				Todos los derechos reservados © ProTécnica C.A. 2019
			</p>
		</footer>
		<?php
	}
}

?>
