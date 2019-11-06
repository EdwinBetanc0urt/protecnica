<?php
	if ( isset($vsModalCiudad) && $vsModalCiudad == "1" ){
?>
		<script src='script/institucion/jsc_Ciudad.js'></script>
<?php
	}
?>
<form method="POST" id="formCiudad" name="formCiudad" action="controllers/configuration/ctr_Ciudad.php" role="form" class="form-horizontal" accept-charset="utf-8" >
	<div id="VentanaModal" class="modal fade ">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
					<h2 class="modal-title">Gestionar Ciudad</h2>
				</div>

				<div class="modal-body">
					<div class="form-group">

							<input name="numId" id="numId" type="hidden" class="form-control" readonly onkeypress="return false" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente" />

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label for="ctxNombreCiudad">* Nombre</label>
							<input id="ctxNombreCiudad" class="valida_alfabetico form-control" maxlength="45" name="ctxNombreCiudad" type="text" size="20" required onKeyDown="fjSiguiente(event,this.form.ctxIcono);" placeholder="Ingrese el Nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label for="cmbPais2">* País</label>
							<select name='cmbPais2' id='cmbPais2' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" style="width: 100%;">
								<option value="">Seleccione uno</option>
							</select>
							<input id="hidPais" type="hidden" />
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label for="cmbEstado2">* Estado</label>
							<select name='cmbEstado2' id='cmbEstado2' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" style="width: 100%;">
								<option value="">Seleccione uno</option>
							</select>
							<input id="hidEstado" type="hidden" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<?php
							include_once($rutabase. "views/_core/vis_Botonera.php");
								fvHabilitar();
						?>
					</div>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
						<div id="divBotonesN" >
							<?php
								$vbAcceso = $objAcceso->fmConsultaAccesoBoton($_SESSION["id_rol"], $arrVistas["id_vista"], 1);
							?>
								<button type='button' value='Registrar' id="btnRegistrar" name="btnRegistrar" class="btn " onclick='return fjEnviarCiudad(this.value, <?=$vsModalEstado;?>);' >
									<i class="material-icons white-text">done</i>
									<span class="white-text">Registrar</span>
								</button>
						</div>
						<div id="divBotonesM" >
							<?php
								fvModificar();

								fvBorrar();
							?>
						</div>
						<div id="divBotonesR">
							<?php
								fvRestaurar();
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" id="hidCondicion" name="hidCondicion">
		<input type="hidden" name="hidEstatus" id="hidEstatus" />
		<input type="hidden" name="vvOpcion" id="vvOpcion" />
	</div>
</form>
