
<div id="VentanaModal" class="modal fade">
	<form method="POST" name="form<?= $vsVista; ?>" id="form<?= $vsVista; ?>" action="controllers/<?= $vsModulo; ?>/ctr_<?= $vsVista; ?>.php" class="form-horizontal" role="form" accept-charset="utf-8" autocomplete="off">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> X </button>
					<h2 class="modal-title">Gestionar Accesos</h2>
				</div>
				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group">
							<div class="col-xs-3">
								<label for="numId">Código</label>
								<input type="number" id="numId" name="numId" class="form-control" maxlength="45" readonly required />
							</div>

							<div class="col-xs-5">
								<label for="ctxNombre">Vista</label>
								<input type="text" id="ctxNombre" class="form-control" maxlength="45" readonly disabled />
							</div>

							<div class="col-xs-4">
								<label for="ctxModulo">Modulo</label>
								<input type="text" id="ctxModulo" class="form-control" maxlength="45" readonly disabled />
							</div>

							<div class="col-xs-12">
								<label for="ctxDescripcion">Descripción de la Vista</label>
								<input type="text" id="ctxDescripcion" class="form-control" maxlength="45" readonly disabled />
							</div>

							<div id="divListaBoton"></div>

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type='button' id="btnModificar" name="btnModificar" class="btn btn-success"
						onClick='fjEnviar(this.value);' value="Cambiar">
						<i class="material-icons">done</i>
						Cambiar Accesos
					</button>

					<button type='button' id="btnAgregar" name="btnAgregar" class="btn btn-success"
						onClick='fjEnviar(this.value);' value="Agregar">
						<i class="material-icons">done</i>
						Asignar Accesos
					</button>
					<button type='button' id="btnQuitar" name="btnAgregar" class="btn btn-danger waves-light red darken-3"
						onClick='fjQuitarVista(this.form.numId.value);'  data-toggle='tooltip' data-placement='top' title='Quitar el acceso total a esta pagina'>
						<i class='material-icons'>visibility_off</i>
						Quitar Accesos
					</button>

				</div>
			</div>
		</div>
		<input type="hidden" name="vvOpcion" id="vvOpcion" />

		<input type="hidden" name="numRol" id="numRol" />
	</form>
</div>
