
<div id="VentanaModal" class="modal fade ">
	<form method="POST" id="form<?= $vsVista; ?>" name="form<?= $vsVista; ?>" action="controllers/<?= $vsModulo; ?>/ctr_<?= $vsVista; ?>.php" role="form" class="form-horizontal" accept-charset="utf-8" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> X </button>
					<h2 class="modal-title">Gestionar <?= $arrVistas["nombre_vista"]; ?></h2>
				</div>

				<div class="modal-body">
					<div class="form-group">
							<input name="numId" id="numId" type="hidden" class="form-control" readonly onkeypress="return false" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente" />			
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<label for="ctxNombre">* Nombre</label>
							<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre" type="text" size="20" required onKeyDown="fjSiguiente(event,this.form.ctxIcono);" placeholder="Ingrese el Nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="col-xs-4">
						<?php
							include_once($vsRutaBase . "views/_core/vis_Botonera.php");
							fvHabilitar(); 
						?>
					</div>
					<div class="col-xs-8">
						<div id="divBotonesN" >
							<?php
								fvRegistrar();
							?>
						</div>
						<div id="divBotonesM" >
							<?php
								fvModificar(); fvBorrar();
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
	</form>
</div>
