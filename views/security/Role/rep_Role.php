
<div id="pestReporte" class="tab-pane fade">
	<form name="formReporte" id="formReporte" method="POST" target="_blank" action="?view=Reportes" accept-charset="utf-8" autocomplete="off">
		<div class="panel ">
			<div class="panel-heading">
				<h3 class="panel-title">Método de Ordenado</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group" >
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

							<label for="cmbOrden">Ordenar Por</label>
							<!-- COMBO  O LISTA DESPLEGABLE -->
							<select name='cmbOrden' id='cmbOrden' class="form-control">
								<option value="id_<?= strtolower($vsVista); ?>" selected="selected"> Identificador </option>
								<option value="<?= strtolower($vsVista); ?>"> Nombre </option>
								<option value="estatus_<?= strtolower($vsVista); ?>"> Estatus </option>
							</select>
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label>Mostrar De Forma</label><br />
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				    			<div class="input-group">
				      				<span class="input-group-addon">
				        				<input checked='checked' name="radOrden" id="radOrdenA" type="radio" value="ASC">
				      				</span>
				      				<input type="text" class="form-control" value="Ascendente" readonly="readonly">
				    			</div>
				  			</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				    			<div class="input-group">
				      				<span class="input-group-addon">
				        				<input  name="radOrden" id="radOrdenD" type="radio" value="DESC">
				      				</span>
				      				<input type="text" class="form-control" value="Descendente" readonly="readonly">
				    			</div>
				  			</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel ">
			<div class="panel-heading">
				<h3 class="panel-title">Rango a Mostrar</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		    			<div class="input-group">
		      				<span class="input-group-addon">
		        				<input type="radio" name="radRangoTipo" id="radRangoTipoT" value="todo" checked="checked">
		      				</span>
		      				<input type="text" class="form-control" value="Todos los Registros" readonly="readonly">
		    			</div>
		  			</div>

					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		    			<div class="input-group">
		      				<span class="input-group-addon">
		        				<input type="radio" name="radRangoTipo" id="radRangoTipoD" value="dentro">
		      				</span>
		      				<input type="text" class="form-control" value="Todos los Registros Dentro de este Rango" readonly="readonly">
		    			</div>
		  			</div>

					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		    			<div class="input-group">
		      				<span class="input-group-addon">
		        				<input  type="radio" name="radRangoTipo" id="radRangoTipoF" value="fuera">
		      				</span>
		      				<input type="text" class="form-control" value="Todos los Registros Fuera de este Rango" readonly="readonly">
		    			</div>
		  			</div>
				</div>
				<br /><br />

				<div class="form-group">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		    			<div class="input-group">
		      				<span class="input-group-addon">
		        				<input type="radio" name="radRango" id="radRangoId" value="id">
		      				</span>
		      				<input type="text" class="form-control" value="Rango por Identificador" readonly="readonly">
		    			</div>
		  			</div>

					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		    			<div class="input-group">
		      				<label for="numIdInicio" class="control-label col-xs-2">Inicial</label>
		      				<div class="col-xs-10">
		      					<input type="number" id="numIdInicio" min="0" name="numIdInicio" value="1" maxlength="10" required size="20" class="form-control">
		      				</div>
		    			</div>
		  			</div>

					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		    			<div class="input-group">
		      				<label for="numIdFinal" class="control-label col-xs-2">Final</label>
		      				<div class="col-xs-10">
		      					<input type="number" id="numIdFinal" min="1" name="numIdFinal" maxlength="10" required size="20" class="form-control">
		      				</div>
		    			</div>
		  			</div>
				</div>
				<br /><br />

				<div class="form-group">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		    			<div class="input-group">
		      				<span class="input-group-addon">
		        				<input type="radio" name="radRango" id="radRangoNombre" value="nombre">
		      				</span>
		      				<input type="text" class="form-control" value="Rango por Nombre" readonly="readonly">
		    			</div>
		  			</div>

					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		    			<div class="input-group">
		      				<label for="cmbNombreInicial" class="control-label col-xs-4">Desde</label>
		      				<div class="col-xs-8">
		      					<select name='cmbNombreInicial' id='cmbNombreInicial' class="form-control">
								</select>
		      				</div>
		    			</div>
		  			</div>

					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		    			<div class="input-group">
		      				<label for="cmbNombreFinal" class="control-label col-xs-4 col-sm-4 col-md-4 col-lg-4">Hasta</label>
		      				<div class="col-xs-8">
		      					<select name='cmbNombreFinal' id='cmbNombreFinal' class="form-control">
								</select>
		      				</div>
		    			</div>
		  			</div>
				</div>
				<br /><br />

				<div class="form-group">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		    			<div class="input-group">
		      				<span class="input-group-addon">
		        				<input type="radio" name="radRango" id="radRangoEstatus" value="estatus">
		      				</span>
		      				<input type="text" class="form-control" value="Rango por Estatus" readonly="readonly">
		    			</div>
		  			</div>

					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<div class="input-group">
							<label for="cmbEstatusInicial" class="control-label col-xs-4">Desde</label>
							<div class="col-xs-8">
								<select name='cmbEstatusInicial' id='cmbEstatusInicial' class="form-control" >
									<option value="activo" selected="selected"> Activo </option>
									<option value="inactivo"> Inactivo </option>
								</select>
		    				</div>
		    			</div>
		  			</div>

					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		    			<div class="input-group">
		    				<label for="cmbEstatusFinal" class="control-label col-xs-4">Hasta</label>
		    				<div class="col-xs-8">
		    					<select name='cmbEstatusFinal' id='cmbEstatusFinal' class="form-control">
									<option value="activo" selected="selected"> Activo </option>
									<option value="inactivo"> Inactivo </option>
								</select>
		      				</div>
		    			</div>
		  			</div>
				</div>
			</div>
		</div>
		<center>
			<?php
				include_once($rutabase . "views/_core/vis_Botonera.php");
				fvReporte($arrVistas["id_vista"]);
			?>
		</center>
	</form>
</div>
