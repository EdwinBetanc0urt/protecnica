
<div id="pestSinAcceso" class="tab-pane fade">
	<form name="formListaSinAcceso" id="formListaSinAcceso" role="form" accept-charset="utf-8" >

		<div class="row">
			<div class="form-group" >
				<div class="col-xs-7 col-sm-9 col-md-10 col-lg-10">
					<div class="input-group">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-search"></span>
						</span>
						<input type="search" id="ctxBuscaSinAcceso" name="ctxBuscaSinAcceso" 
						 oninput="fjListaSinAcceso();" class="valida_buscar form-control" 
						 placeholder="Filtro de Busqueda" />
					</div>	
				</div>

				<div class="col-xs-5 col-sm-3 col-md-2 col-lg-2">
					<div class="input-group">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-list-alt"></span>
						</span>
						<input type="text" id="ctxIntemSinAcceso" name="ctxIntemSinAcceso" maxlength="4" 
						 value="10" required class="valida_num_entero form-control" placeholder="Items" />
					</div>	
				</div>
			</div>
		</div>

		<!-- guarda el valor del atributo por donde va a ordenar -->
		<input type='hidden' name='hidOrden' id='hidOrden' />

		<!-- guarda el valor en la forma de ordenado si ASCendente o DESCendente -->
		<input type="hidden" id="hidTipoOrden" name="hidTipoOrden" />

		<!-- guarda el valor en la subpagina de a mostrar en la division de paginacion -->
		<input type='hidden' name='subPagina' id='subPagina' />
		
		<div id="divListado" class="divListado"></div> <!-- Dentro se mostrara la tabla con el listado que genera el controladdor -->

	</form>
</div> <!-- cierre de la pestaña listado a los cuales no tiene ningun acceso -->

