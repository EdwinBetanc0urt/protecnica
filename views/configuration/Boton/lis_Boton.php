
<div id="pestListado" class="tab-pane fade in active">
	<form method="POST" id="formLista<?=$vsVista;?>" name="formLista<?=$vsVista;?>" role="form" accept-charset="utf-8">
		<div class="row">
			<div class="form-group" >

				<div class="col-xs-3 col-sm-2 col-md-2 col-lg-1">
					<button id="btnNuevo" class="btn" data-toggle="modal" data-target="#VentanaModal" onclick="fjNuevoRegistro();" type="button">
						<span class="glyphicon glyphicon-plus"></span>
						Nuevo
					</button>
				</div>

				<div class="col-xs-6 col-sm-8 col-md-8 col-lg-9">
					<div class="input-group">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-search"></span>
						</span>
						<input type="search" id="ctxBusqueda" name="ctxBusqueda"
						oninput="fjMostrarLista('<?= $vsModulo; ?>', '<?= $vsVista; ?>');"
						onkeyup="fjMostrarLista('<?= $vsModulo; ?>', '<?= $vsVista; ?>');"
						class="form-control valida_buscar"
						placeholder="Ejemplo: nombres, descripción, tipos." data-toggle="tooltip" data-placement="top" title="Terminos para buscar coincidencias en los registros" />
					</div>
				</div>

				<div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
					<div class="input-group">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-list-alt"></span>
						</span>
						<input type="text" id="numItems" name="numItems" maxlength="4"
						value="10" onkeyup="fjMostrarLista('<?= $vsModulo; ?>', '<?= $vsVista; ?>');" required
						class="valida_num_entero form-control" placeholder="Ej: 1" data-toggle="tooltip" data-placement="top" title="Cantidad de items a mostrar en el listado" />
					</div>
				</div>
			</div>
		</div>

		<!-- guarda el valor del atributo por donde va a ordenar -->
		<input type='hidden' name='hidOrden' id='hidOrden' />

		<!-- guarda el valor en la forma de ordenado si ASCendente o DESCendente -->
		<input type="hidden" id="hidTipoOrden" name="hidTipoOrden" />

		<!-- guarda el valor en la sub-pagina de a mostrar en la división de paginación -->
		<input type='hidden' name='subPagina' id='subPagina' />

		<div id="divListado" class="divListado"></div> <!-- Dentro se mostrara la tabla con el listado que genera el controllers -->
	</form>
</div>
