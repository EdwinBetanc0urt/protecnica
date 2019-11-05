
<div id="pestListado" class="tab-pane fade in active">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<label for="cmbRole">Rol</label>
		<select id='cmbRole' name='getRol' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" size="1"  >
			<option value="">Seleccione uno</option>
		</select>
		<input id="hidRol" type="hidden" />
	</div>  

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<br />
	</div>

	<ul class="nav nav-tabs">
		<!--
		<li class="active" data-toggle="tooltip" data-placement="top" title="Lista general de todos los accesos">
			<a data-toggle="tab" href="#pestAccesoGeneral">Accesos General</a>
		</li>
		-->
		<li class="active" data-toggle="tooltip" data-placement="top" title="Lista de los acceso por vistas">
			<a data-toggle="tab" href="#pestAcceso">Accesos por vistas</a>
		</li>
		<li data-toggle="tooltip" data-placement="top" title="Lista de las vistas a las que no se tiene acceso">
			<a data-toggle="tab" href="#pestSinAcceso">Restringido por vista</a>
		</li>
		<!--
		<li data-toggle="tooltip" data-placement="top" title="Importa accesos desde otro rol">
			<a data-toggle="tab" href="#pestAccesoImportar">Importar Accesos</a>
		</li>
		-->
	</ul>

	<div class="tab-content">
		<br />	
		<?php
			include_once($currentPath . "lis_{$_GET["view"]}Si.php");

			include_once("lis_{$_GET["view"]}No.php");

			include_once("lis_{$_GET["view"]}Importar.php");
		?>
	</div>
</div>
