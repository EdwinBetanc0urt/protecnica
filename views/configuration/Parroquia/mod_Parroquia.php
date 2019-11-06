
<div id="VentanaModal" class="modal fade">
	<form method="POST" id="form<?= $vsVista; ?>" name="form<?= $vsVista; ?>" action="controllers/<?= $vsModulo; ?>/ctr_<?= $vsVista; ?>.php" role="form" class="form-horizontal" accept-charset="utf-8" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h2 class="modal-title">Gestionar Parroquia</h2>
				</div>

				<div class="modal-body">
					<div class="form-group">

							<input name="numId" id="numId" type="hidden" class="form-control" readonly onkeypress="return false" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente"  />

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label for="ctxNombre">*Nombre</label>
							<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre" type="text" size="20" required value="<?php
								if(isset($_GET['getNombre']))
									echo $_GET['getNombre'];
							?>"  onKeyDown="fjSiguiente(event,this.form.ctxIcono);" placeholder="Ingrese el Nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-6">
							<label for="cmbEstado">* Estado</label>
							<select name='cmbEstado' id='cmbEstado' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" style="width: 100%;">
								<option value="">Seleccione uno</option>
							</select>
							<input id="hidEstado" type="hidden" value="<?php
								if(isset($_GET['getEstado']))
									echo $_GET['getEstado']; ?>" />
						</div>

						<div class="col-xs-6">
							<label for="cmbMunicipio">* Municipio</label>
							<select name='cmbMunicipio' id='cmbMunicipio' class="dinamico form-control select2" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" style="width: 100%;">
								<option value="">Seleccione uno</option>
							</select>
							<input id="hidMunicipio" type="hidden" value="<?php
								if(isset($_GET['getMunicipio']))
									echo $_GET['getMunicipio']; ?>" />
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
								fvRegistrar();
							?>
						</div>
						<div id="divBotonesM" >
							<?php
								fvModificar();
							?>

							<?php
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
		<input type="hidden" name="hidEstatus" id="hidEstatus" value="<?php if(isset($_GET['getEstatus'])) echo $_GET['getEstatus']; ?>" />
		<input type="hidden" name="vvOpcion" id="vvOpcion" />
	</form>
</div>
