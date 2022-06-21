<div class="container my-4">
	<div class="card">
		<div class="card-body">
			<form action="<?= site_url('admincontroller/cetak_laporan') ?>" method="post" id="formLaporan">
				<div class="row">
					<div class="col-md-5 my-2">
						<label for="dateStartInput" class="mb-2 required-label">Tanggal awal:</label>
						<div class="input-group date" id="dateStart">
							<input type="text" class="form-control" id="dateStartInput" name="dateStartInput" />
							<span class="input-group-append">
								<span class="input-group-text bg-light d-block">
									<i class="fa fa-calendar"></i>
								</span>
							</span>
						</div>
					</div>
					<div class="col-md-5 my-2">
						<label for="dateStartEnd" class="mb-2 required-label">Tanggal akhir:</label>
						<div class="input-group date" id="dateEnd">
							<input type="text" class="form-control" id="dateStartEnd" name="dateStartEnd" />
							<span class="input-group-append">
								<span class="input-group-text bg-light d-block">
									<i class="fa fa-calendar"></i>
								</span>
							</span>
						</div>
					</div>
					<div class="col-md-2 d-flex align-items-end my-2">
						<button type="submit" class="btn btn-primary w-100"><i class="fa fa-print me-2" aria-hidden="true"></i>Cetak</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$('#dateStart').datepicker();
	$('#dateEnd').datepicker();
</script>
