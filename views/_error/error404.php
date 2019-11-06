
<br /><br />

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<div class="box-header with-border">
			<h1>¡Ups! Error 404</h1>
            <h5>Pagina no encontrada </h5>
		</div>
		<div class="box-body">
			<div class="panel-body" align="center">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<img src="public/img/_error/404.png" class="img-responsive pad">
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h3>
						La URL <b><?= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?></b> solicitada no se encontró en este servidor. Asegúrese que la dirección web este bien escrita, sobre todo en <b>=<?= $_GET["view"]; ?></b>
					</h3>
				</div>
			</div>
		</div>
	</div>
</div>
