
<div id="VentanaModal" class="modal fade">
	<form method="POST" id="form<?= $vsVista; ?>" name="form<?= $vsVista; ?>" action="controllers/<?= $vsModulo; ?>/ctr_<?= $vsVista; ?>.php" role="form" class="form-horizontal" accept-charset="utf-8" autocomplete="off">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h2 class="modal-title"> Gestionar Vista </h2>
				</div>

				<div class="modal-body">
					<div class="form-group">

							<input name="numId" id="numId" type="hidden" class="form-control" readonly onkeypress="return false" data-toggle="tooltip" data-placement="right" title="Código asignado automáticamente" />

						<div class="col-xs-12">
							<label for="ctxNombre">* Nombre</label>
							<input id="ctxNombre" class="valida_alfabetico form-control" maxlength="45" name="ctxNombre" type="text" size="20" required onKeyDown="fjSiguiente(event,this.form.ctxIcono);" placeholder="Ingrese el Nombre" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12">
							<label for="ctxDescripcion" >Descripción</label>
							<input id="ctxDescripcion" class="valida_alfabetico form-control" maxlength="100" name="ctxDescripcion" type="text" size="20" required value="<?php
								if(isset($_GET['getDescripcion']))
									echo $_GET['getDescripcion'];
							?>"  onKeyDown="fjSiguiente(event,this.form.numPosicion);" placeholder="Ingrese la Descripción" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-6">
							<label for="cmbModulo">* Módulo</label>
							<select name='cmbModulo' id='cmbModulo' class="dinamico form-control combo_buscar" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" style="width: 100%;">
								<option value="">Seleccione uno</option>
							</select>
							<input id="hidModulo" type="hidden" value="<?php
								if(isset($_GET['getModulo']))
									echo $_GET['getModulo']; ?>" />
						</div>

						<div class="col-xs-6">
							<label for="ctxIcono">* Icono</label>
							<input id="ctxIcono" class="valida_desc_alfanum form-control" maxlength="45" name="ctxIcono" type="text" size="20" required value="<?php
								if(isset($_GET['getIcono']))
									echo $_GET['getIcono'];
							?>"  onKeyDown="fjSiguiente(event,this.form.ctxDescripcion);" placeholder="Ingrese el Icono" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-6">
							<label for="numPosicion">* Posición</label>
							<input id="numPosicion" class="valida_num_entero form-control" maxlength="2" name="numPosicion" type="number" size="20" required value="<?php
								if(isset($_GET['getPosicion']))
									echo $_GET['getPosicion'];
							?>" onKeyDown="fjSiguiente(event,this.form.ctxRuta);" placeholder="Ingrese la Posición" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio" />
						</div>

						<div class="col-xs-6">
							<label for="ctxRuta">* Ruta</label>
							<input id="ctxRuta" class="valida_alfabetico form-control" maxlength="45" name="ctxRuta" type="text" size="20" required value="<?php
								if(isset($_GET['getRuta']))
									echo $_GET['getRuta'];
							?>" placeholder="Ingrese la Ruta" data-toggle="tooltip" data-placement="right" title="Campo Obligatorio"/>
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
