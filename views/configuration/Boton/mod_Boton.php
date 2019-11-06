
<div id="VentanaModal" class="modal fade ">
	<form method="POST" id="form<?= $vsVista; ?>" name="form<?= $vsVista; ?>" action="controllers/<?= $vsModulo; ?>/ctr_<?= $vsVista; ?>.php" role="form" class="form-horizontal" accept-charset="utf-8" autocomplete="off">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> X </button>
					<h2 class="modal-title">Gestionar <?= ucwords($arrVistas["nombre_vista"]); ?></h2>
				</div>

				<div class="modal-body">
					<div class="form-group">
							<input type="hidden" name="numId" id="numId" class="form-control" readonly onkeypress="return false;" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente" />

						<div class="col-xs-12 ">
							<label for="ctxNombre">* Nombre</label>
							<input type="text" name="ctxNombre" id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" required onkeydown="fjSiguiente(event, this.form.ctxIcono);" placeholder="Ingrese el Nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label for="ctxIcono" >* Icono</label>
							<input type="text" name="ctxIcono" id="ctxIcono" class="valida_desc_alfanum form-control" maxlength="45" required onkeydown="fjSiguiente(event, this.form.ctxDescripcion);" placeholder="Ingrese el Icono" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>
						</div>

						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<label for="ctxDescripcion" >* Descripción</label>
							<input type="text" name="ctxDescripcion" id="ctxDescripcion" class="valida_alfabetico form-control" maxlength="100" required placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>
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
								fvRegistrar();
							?>
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
		<input type="hidden" id="hidCondicion" name="hidCondicion" />
		<input type="hidden" name="hidEstatus" id="hidEstatus" />
		<input type="hidden" name="vvOpcion" id="vvOpcion" />
	</form>
</div>
