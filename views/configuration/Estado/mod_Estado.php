<?php
	if ( isset($vsModalEstado) && $vsModalEstado == "1" ){
	?>
		<script src='script/configuration/jsc_Estado.js'></script>
	<?php
	}
?>
<form method="POST" id="formEstado" name="formEstado" action="controllers/configuration/ctr_Estado.php" role="form" class="form-horizontal" accept-charset="utf-8" >
	<div id="VentanaModal" class="modal fade modal ">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
					<h2 class="modal-title">Gestionar Estado</h2>
				</div>

				<div class="modal-body">
					<div class="form-group">
						<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4" style="display:none">
							<label for="numId">* Código</label>
							<input name="numId" id="numId" type="number" class="form-control" readonly onkeypress="return false" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente" />
							<label for="numCodigoUbigeo">* Cód. Ubigeo</label>
							<input name="numCodigoUbigeo" id="numCodigoUbigeo" type="text" class="form-control valida_zero_fill" maxlength="2" placeholder="Ej: 01, 14, 36" data-toggle="tooltip" data-placement="right" title="Código UBIGEO DPT del INE" />
							<label for="ctxCodigoIso">* Cód. ISO</label>
							<input name="ctxCodigoIso" id="ctxCodigoIso" type="text" class="form-control valida_alfabetico valor_mayuscula" maxlength="6" data-toggle="tooltip" data-placement="right" title="Código ISO 3166-2" />
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >
							<label for="ctxNombreEstado" >* Nombre </label>
							<input name="ctxNombreEstado" id="ctxNombreEstado" type="text" class="valida_alfabetico form-control" maxlength="100" required onKeyDown="fjSiguiente(event,this.form.ctxIcono);" placeholder="Ingrese el Nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label for="cmbPais">* País</label>
							<select name='cmbPais1' id='cmbPais1' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" style="width: 100%;">
								<option value="">Seleccione uno</option>
							</select>
							<input id="hidPais" type="hidden" />
						</div>
					</div>


					<div class="form-group" style="display: none;">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label for="cmbPais">* País</label>
							<select name='cmbPais' id='cmbPais' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" style="width: 100%;">
								<option value="">Seleccione uno</option>
							</select>
							<input id="hidPais" type="hidden" />
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >
							<label for="cmbCiudad">* Ciudad Capital del Estado</label>
							<select name='cmbCiudad' id='cmbCiudad' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Debe Registar y luego Editar para ingresar la Capital" style="width: 100%;">
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
								<button type='button' value='Registrar' id="btnRegistrar" name="btnRegistrar" class="btn " onclick='return fjEnviarEstado(this.value, <?=$vsModalEstado;?>);' >
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
