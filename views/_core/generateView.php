<?php
/**
 * @author EdwinBetanc0urt@outlook.com
 */
class generateView {
	public static $relativePath = "./public/";

	public static function head($title = "Inicio") {
		?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?= $title ?> | ProTécnica C.A.</title>

		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
		<link rel="stylesheet" href="<?= $relativePath ?>global.css">
		<?php
	}

	public static function stylesLibs() {
		$relativePath = self::$relativePath . "libs/";
		?>
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="<?= $relativePath ?>bootstrap/css/bootstrap.min.css">

		<!-- Theme style -->
		<link rel="stylesheet" href="<?= $relativePath ?>AdminLTE/dist/css/AdminLTE.min.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->

		<link rel="stylesheet" href="<?= $relativePath ?>AdminLTE/dist/css/skins/_all-skins.min.css">

		<link rel="stylesheet" href="<?= $relativePath ?>select2/dist/css/select2.min.css">
		<link rel="stylesheet" href="<?= $relativePath ?>select2/dist/css/select2-bootstrap.min.css">

		<!-- Google Font -->
		<!--
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
		-->
		<?php
	}

	public static function fonts() {
		$relativePath = self::$relativePath . "fonts/";
		?>
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?= $relativePath ?>font-awesome/css/font-awesome.min.css">

		<!-- Font Awesome v5 -->
		<!-- <link rel="stylesheet" href="<?= $relativePath ?>font-awesome5/css/all.min.css"> -->

		<!-- Ionicons -->
		<link rel="stylesheet" href="<?= $relativePath ?>Ionicons/css/ionicons.min.css">

		<link rel="stylesheet" href="<?= $relativePath ?>MaterialDesign-Webfont/css/materialdesignicons.min.css">
		<style>
			/* ICONOS Y FUENTES */
			@font-face {
				font-family: 'Material Icons';
				font-style: normal;
				font-weight: 400;
				src: local('Material Icons'),
					local('MaterialIcons-Regular'),
					url(<?= $relativePath ?>/material-design-icons/Iconos.woff2)
					format('woff2');
			}

			.material-icons {
				font-family: 'Material Icons';
				font-weight: normal;
				font-style: normal;
				font-size: 14px;
				line-height: 1;
				letter-spacing: normal;
				text-transform: none;
				display: inline-block;
				white-space: nowrap;
				word-wrap: normal;
				direction: ltr;
				-webkit-font-feature-settings: 'liga';
				-webkit-font-smoothing: antialiased;
			}
		</style>
		<?php
	}

	public static function header() {
		$relativePath = self::$relativePath;
		?>
		<header class="main-header">
			<!-- Logo -->
			<a href="index2.html" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>P</b>T</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>Pro</b>Técnica</span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- User Account: style can be found in dropdown.less -->
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="<?= $relativePath ?>libs/AdminLTE/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
								<span class="hidden-xs"><?= $_SESSION["nombres_completos"] ?></span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<img src="<?= $relativePath ?>libs/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

									<p>
										<?= $_SESSION["nombre_completo"]; ?>
										<small>Member since Nov. 2012</small>
									</p>
								</li>
								<!-- Menu Body -->
								<li class="user-body">
									<div class="row">
										<div class="col-xs-4 text-center">
											<a href="#">Followers</a>
										</div>
										<div class="col-xs-4 text-center">
											<a href="#">Sales</a>
										</div>
										<div class="col-xs-4 text-center">
											<a href="#">Friends</a>
										</div>
									</div>
									<!-- /.row -->
								</li>
								<!-- Menu Footer-->
								<li class="user-footer">
									<div class="row">
										<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
											<div class="pull-left">
												<small>
													<!-- Dpto:
													<?= $_SESSION["sede"]["id_cargo"] . " - " . ucwords($_SESSION["sede"]["departamento"]) ?> -->
												</small>
											</div>
										</div>

										<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
											<div class="pull-right">
												<button type="button" onclick="closeSession();" class="btn btn-flat" data-toggle="tooltip" data-placement="bottom" title="Cerrar Sesión y Salir">
													<span class="white-text">
														<i class="fa fa-power-off"></i>
													</span>
													Salir
												</button>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</li>
						<!-- Control Sidebar Toggle Button -->
						<li>
							<a href="#" data-toggle="control-sidebar">
								<i class="fa fa-gears"></i>
							</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<?php
	}

	public static function generateMenu($currentView) {
		?>
		<!-- Menú lateral izquierdo (Menú principal) -->
		<aside class="main-sidebar">

			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">

				<!-- search form -->
				<form method="POST" class="sidebar-form" id="formMenu" accept-charset="utf-8" >
					<div class="input-group">
						<input type="text" id="ctxBuscarMenu" class="form-control valida_alfabetico valor_sin_diacriticos" placeholder="Ej: Proveedor, Cotización" onkeyup="getMenuRequest();" data-toggle="tooltip" data-placement="top" title="Realizar una busqueda de paginas" />
						<span class="input-group-btn text-menu">
							<span class="btn btn-fla">
								<i class="fa fa-search"></i>
							</span>
						</span>
					</div>
					<input type="hidden" id="hidCurrentView" value="<?= $currentView ?>" />
				</form>
				<!-- /.search form -->

				<!-- sidebar menú: : style can be found in sidebar.less -->
				<ul class="sidebar-menu" data-widget="tree" id="listMenu">
					<!-- AQUI SE IMPRIME EL MENU -->
				</ul>

			</section>
			<!-- /.sidebar -->

		</aside>
		<!-- /Menú lateral izquierdo (Menú principal) -->

		<?php
	}

	public static function scripts() {
		$relativePath = self::$relativePath . "js/";
		self::scriptsLibs();
		?>
		<!-- AdminLTE for demo purposes -->
		<script src="<?= $relativePath ?>_core/adminTemplate.js"></script>
		<script src="<?= $relativePath ?>_core/ajaxRequest.js"></script>
		<script src="<?= $relativePath ?>_core/system.js"></script>
		<script src="<?= $relativePath ?>_core/alertMessage.js"></script>
		<?php
	}

	public static function scriptsLibs() {
		$relativePath = self::$relativePath . "libs/";
		?>
		<!-- jQuery 3 -->
		<script src="<?= $relativePath ?>jquery/dist/jquery.min.js"></script>

		<!-- jQuery UI 1.11.4 -->
		<script src="<?= $relativePath ?>jquery-ui/jquery-ui.min.js"></script>

		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
			$.widget.bridge('uibutton', $.ui.button);
		</script>

		<!-- Bootstrap 3.3.7 -->
		<script src="<?= $relativePath ?>bootstrap/js/bootstrap.min.js"></script>

		<script src="<?= $relativePath ?>sweetalert2/dist/sweetalert2.all.min.js"></script>

		<script src="<?= $relativePath ?>select2/dist/js/select2.min.js"></script>
		<script src="<?= $relativePath ?>select2/dist/js/i18n/es.js"></script>

		<!-- Slimscroll -->
		<script src="<?= $relativePath ?>jquery-slimscroll/jquery.slimscroll.min.js"></script>

		<!-- FastClick -->
		<script src="<?= $relativePath ?>fastclick/lib/fastclick.js"></script>

		<!-- AdminLTE App -->
		<script src="<?= $relativePath ?>AdminLTE/dist/js/adminlte.min.js"></script>
		<?php
	}

	public static function footer() {
		?>
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Versión</b> 1.1
			</div>
			<strong>Copyright &copy; <?= date("Y") ?> ProTécnica C.A.</strong>
			Todos los derechos reservados.
		</footer>
		<?php
	}
}

?>
