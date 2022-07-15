<div class="container my-4">
	<div class="card">
		<div class="card-body">
			<form action="<?= site_url('admincontroller/cetak_laporan') ?>" method="post" id="formLaporan">
				<div class="row">
					<div class="col-md-5 my-2">
						<label for="dateStartInput" class="mb-2 required-label">Tanggal awal:</label>
						<div class="input-group date" id="dateStart">
							<span class="input-group-append">
								<span class="input-group-text bg-light d-block">
									<i class="fa fa-calendar"></i>
								</span>
							</span>
							<input type="text" class="form-control" id="dateStartInput" name="dateStartInput" autocomplete="off" />
						</div>
					</div>
					<div class="col-md-5 my-2">
						<label for="dateEndInput" class="mb-2 required-label">Tanggal akhir:</label>
						<div class="input-group date" id="dateEnd">
							<span class="input-group-append">
								<span class="input-group-text bg-light d-block">
									<i class="fa fa-calendar"></i>
								</span>
							</span>
							<input type="text" class="form-control" id="dateEndInput" name="dateEndInput" autocomplete="off" />
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

<?php foreach ($invoices as $key => $inv) { ?>
	<tr>
		<td>
			<?= $key + 1 ?>
		</td>
		<td><?= $inv['nama'] ?></td>
		<td></td>
		<td></td>
	</tr>
<?php } ?>

<script>
	$('#dateStart').datepicker('update', new Date());
	$('#dateEnd').datepicker('update', new Date());

	$("#formLaporan").validate({
		rules: {
			dateStartInput: {
				required: true
			},
			dateEndInput: {
				required: true
			},
		},
		highlight: function(element, errorClass, validClass) {
			$(element).addClass('is-invalid').removeClass('is-valid');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).addClass('is-valid').removeClass('is-invalid');
		},
		errorPlacement: function(error, element) {
			error.addClass("invalid-feedback")
			error.insertAfter(element);
		},
	});

	$('#dateStartInput').change(function() {
		let dateX = new Date($(this).val());
		$('#dateEnd').datepicker('setStartDate', new Date($(this).val()));
	});

	$('#dateEndInput').change(function() {
		let dateX = new Date($(this).val());
		$('#dateStart').datepicker('setEndDate', new Date($(this).val()));
	});
</script>
