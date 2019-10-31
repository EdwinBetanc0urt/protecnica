<?php
/**
 * @author EdwinBetanc0urt@outlook.com
 */
class generateView {
	public static $relativePath = "../../public/";

	public static function head($title = "Inicio") {
		?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Protecnica <?= "| " . $title ?></title>

		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

		<?php
		// print css styles and fonts
		self::styles();
		self::fonts();
	}

	public static function styles() {
		$relativePath = self::$relativePath . "libs/";
		?>
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="<?= $relativePath ?>bootstrap/css/bootstrap.min.css">

		<!-- Theme style -->
		<link rel="stylesheet" href="<?= $relativePath ?>AdminLTE/dist/css/AdminLTE.min.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->

		<link rel="stylesheet" href="<?= $relativePath ?>AdminLTE/dist/css/skins/_all-skins.min.css">

		<!-- Morris chart -->
		<!--
		<link rel="stylesheet" href="bower_components/morris.js/morris.css">
		-->

		<!-- jvectormap -->
		<!--
		<link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
		-->

		<!-- Date Picker -->
		<link rel="stylesheet" href="<?= $relativePath ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

		<!-- Daterange picker -->
		<!--
		<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
		-->

		<!-- bootstrap wysihtml5 - text editor -->
		<!--
		<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
		-->

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

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

		<!-- Ionicons -->
		<link rel="stylesheet" href="<?= $relativePath ?>Ionicons/css/ionicons.min.css">
		<?php
	}

	public static function menu() {
		?>
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- search form -->
			<form action="#" method="get" class="sidebar-form">
				<div class="input-group">
					<input type="text" name="q" class="form-control" placeholder="Search...">
					<!--
					<span class="input-group-btn">
						<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
						</button>
					</span>
					-->
					<span class="input-group-btn text-menu">
						<span class="btn btn-fla">
							<i class="fa fa-search"></i>
						</span>
					</span>
				</div>
			</form>
			<!-- /.search form -->
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu" data-widget="tree">
				<!-- <li class="header">MAIN NAVIGATION</li> -->
				<li class="active treeview">
					<a href="#">
						<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
						<li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-files-o"></i>
						<span>Layout Options</span>
						<span class="pull-right-container">
							<span class="label label-primary pull-right">4</span>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
						<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
						<li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
						<li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
					</ul>
				</li>
				<li>
					<a href="pages/widgets.html">
						<i class="fa fa-th"></i> <span>Widgets</span>
						<span class="pull-right-container">
							<small class="label pull-right bg-green">new</small>
						</span>
					</a>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-pie-chart"></i>
						<span>Charts</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
						<li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
						<li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
						<li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-laptop"></i>
						<span>UI Elements</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
						<li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
						<li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
						<li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
						<li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
						<li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-edit"></i> <span>Forms</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
						<li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
						<li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-table"></i> <span>Tables</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
						<li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
					</ul>
				</li>
				<li>
					<a href="pages/calendar.html">
						<i class="fa fa-calendar"></i> <span>Calendar</span>
						<span class="pull-right-container">
							<small class="label pull-right bg-red">3</small>
							<small class="label pull-right bg-blue">17</small>
						</span>
					</a>
				</li>
				<li>
					<a href="pages/mailbox/mailbox.html">
						<i class="fa fa-envelope"></i> <span>Mailbox</span>
						<span class="pull-right-container">
							<small class="label pull-right bg-yellow">12</small>
							<small class="label pull-right bg-green">16</small>
							<small class="label pull-right bg-red">5</small>
						</span>
					</a>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-folder"></i> <span>Examples</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
						<li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
						<li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
						<li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
						<li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
						<li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
						<li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
						<li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
						<li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-share"></i> <span>Multilevel</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
						<li class="treeview">
							<a href="#"><i class="fa fa-circle-o"></i> Level One
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
								<li class="treeview">
									<a href="#"><i class="fa fa-circle-o"></i> Level Two
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu">
										<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
										<li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
					</ul>
				</li>
				<!--
				<li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
				<li class="header">LABELS</li>
				<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
				<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
				<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
				-->
			</ul>
		</section>
		<!-- /.sidebar -->
		<?php
	}

	public static function scripts() {
		$relativePath = self::$relativePath . "js/";
		self::scriptsLibs();
		?>
		<!-- AdminLTE for demo purposes -->
		<script src="<?= $relativePath ?>_core/adminTemplate.js"></script>
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

		<!-- Morris.js charts -->
		<!--
		<script src="<?= $relativePath ?>raphael/raphael.min.js"></script>
		<script src="<?= $relativePath ?>morris.js/morris.min.js"></script>
		-->

		<!-- Sparkline -->
		<!--
		<script src="<?= $relativePath ?>jquery-sparkline/dist/jquery.sparkline.min.js"></script>
		-->

		<!-- jvectormap -->
		<!--
		<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
		-->

		<!-- jQuery Knob Chart -->
		<!--
		<script src="<?= $relativePath ?>jquery-knob/dist/jquery.knob.min.js"></script>
		-->

		<!-- daterangepicker -->
		<script src="<?= $relativePath ?>moment/min/moment.min.js"></script>
		<script src="<?= $relativePath ?>bootstrap-daterangepicker/daterangepicker.js"></script>

		<!-- datepicker -->
		<script src="<?= $relativePath ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

		<!-- Bootstrap WYSIHTML5 -->
		<!--
		<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
		-->

		<!-- Slimscroll -->
		<script src="<?= $relativePath ?>jquery-slimscroll/jquery.slimscroll.min.js"></script>

		<!-- FastClick -->
		<script src="<?= $relativePath ?>fastclick/lib/fastclick.js"></script>

		<!-- AdminLTE App -->
		<script src="<?= $relativePath ?>AdminLTE/dist/js/adminlte.min.js"></script>

		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<!--
		<script src="dist/js/pages/dashboard.js"></script>
		-->

		<?php
	}

	public static function footer() {
		?>
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 1.1
			</div>
			<strong>Copyright &copy; <?= date("Y") ?> Protecnica</strong>
			Todos los derechos reservados.
		</footer>
		<?php
	}
}

?>
