<?php
	if ( isset($vsModalPais) && $vsModalPais == "1" ){
?>
		<script src='script/configuration/jsc_Pais.js'></script>
<?php
	}
?>
<form method="POST" id="formPais" name="formPais" action="controllers/configuration/ctr_Pais.php" role="form" class="form-horizontal" accept-charset="utf-8" >
	<div id="VentanaModal" class="modal fade ">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h2 class="modal-title">Gestionar País</h2>
				</div>

				<div class="modal-body">
					<div class="form-group">

							<input name="numId" id="numId" type="hidden" class="form-control" readonly onkeypress="return false" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente" />

						<div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
							<label for="ctxNombre">* Nombre</label>
							<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre" type="text" required value="<?php
								if(isset($_GET['getNombre']))
									echo $_GET['getNombre'];
							?>"  onkeydown="fjSiguiente(event, this.form.ctxDescripcion);" placeholder="Ingrese el Nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display:none">
							<label for="ctxDescripcion">* Nombre Oficial</label>
							<input id="ctxDescripcion" class="valida_alfabetico form-control" maxlength="45" name="ctxDescripcion" type="text" required value="<?php
								if(isset($_GET['getNombreOficial']))
									echo $_GET['getNombreOficial'];
							?>"  onkeydown="fjSiguiente(event, this.form.numCodigoIso);" placeholder="Ingrese el Nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>

							<label for="ctxCodigoIsoAlfa2" >* Cód. ISO Alfa-2</label>
							<input id="ctxCodigoIsoAlfa2" class="valida_desc_alfanum valor_mayuscula form-control" maxlength="2" name="ctxCodigoIsoAlfa2" type="text" value="<?php
								if(isset($_GET['getIcono']))
									echo $_GET['getIcono'];
							?>"  onkeydown="fjSiguiente(event, this.form.ctxCodigoIsoAlfa3);" placeholder="Ej: AB, YZ" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>

							<label for="ctxCodigoIsoAlfa3" >* Código ISO Alfa-3</label>
							<input id="ctxCodigoIsoAlfa3" class="valida_desc_alfanum valor_mayuscula form-control" maxlength="3" name="ctxCodigoIsoAlfa3" type="text" value="<?php
								if(isset($_GET['getIcono']))
									echo $_GET['getIcono'];
							?>"  onkeydown="fjSiguiente(event, this.form.ctxPrefijo);" placeholder="Ej: ABC, XYZ" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>

							<label for="numCodigoIso" >* Cód. ISO Num</label>
							<input id="numCodigoIso" class="valida_numerico form-control" maxlength="3" max="999" name="numCodigoIso" type="number" value="<?php
								if(isset($_GET['getIsoNumerico']))
									echo $_GET['getIsoNumerico'];
							?>" onkeydown="fjSiguiente(event, this.form.ctxCodigoIsoAlfa2);" placeholder="Ej: 001, 123" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />

							<label for="ctxPrefijo">* Prefijo Telf.</label>
							<input name="ctxPrefijo" id="ctxPrefijo" type="text" class="form-control" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente" onkeydown="fjSiguiente(event, this.form.ctxNombreOficial);" placeholder="Ej: +1, +890" value="<?php
								if(isset($_GET["getId"]))
									echo $_GET["getId"]; ?>" />

							<label for="cmbCiudad">* Ciudad Capital</label>
							<select name='cmbCiudad' id='cmbCiudad' class="dinamico form-control combo_buscar" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" style="width: 100%;">
								<option value="">Seleccione uno</option>
							</select>
							<input id="hidModulo" type="hidden" value="<?php
								if(isset($_GET['getCiudad']))
									echo $_GET['getCiudad']; ?>" />
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<?php
							include_once($vsRutaBase . "views" . DS . "_core" . DS . "vis_Botonera.php");
							fvHabilitar();
						?>
					</div>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
						<div id="divBotonesN" >
							<?php
								$vbAcceso = $objAcceso->fmConsultaAccesoBoton($_SESSION["id_rol"], $arrVistas["id_vista"], 1);
							?>
								<button type='button' value='Registrar' id="btnRegistrar" name="btnRegistrar" class="btn " onclick='return fjEnviarPais(this.value, <?=$vsModalPais;?>);' >
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
		<input type="hidden" name="hidEstatus" id="hidEstatus" value="<?php if (isset($_GET['getEstatus'])) echo $_GET['getEstatus']; ?>" />
		<input type="hidden" name="vvOpcion" id="vvOpcion" />
	</div>
</form>
