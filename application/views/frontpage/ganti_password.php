<div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
	<div class="col-12 col-md-4">
		<div class="card">
			<div class="card-body">
				<form id="formGantiPassword" action="<?= site_url('/frontcontroller/update_password') ?>" method="POST">
					<h5 class="card-title text-center mb-3">Ganti Password</h5>
					<hr>
					<?php
					if (isset($_SESSION['message'])) {
					?>
						<div class="alert alert-<?= isset($_SESSION['message']['status']) ? $_SESSION['message']['status'] : 'success' ?> alert-dismissible fade show" role="alert">
							<div>
								<?= isset($_SESSION['message']['text']) ? $_SESSION['message']['text'] : '' ?>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php
					}
					?>
					<div class="mb-3">
						<label for="password_lama" class="form-label required-label">Password lama</label>
						<input type="password" name="password_lama" class="form-control" id="password_lama" placeholder="Masukkan password...">
						<?php echo form_error('password_lama'); ?>
					</div>
					<div class="mb-3">
						<label for="password_baru" class="form-label required-label">Password Baru</label>
						<input type="password" name="password_baru" class="form-control" id="password_baru" placeholder="Masukkan password...">
						<?php echo form_error('password_baru'); ?>
					</div>
					<div class="d-grid gap-2 mb-4">
						<button id="btnGantiPassword" class="btn btn-primary" type="submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$("#btnGantiPassword").click(function(e) {
		e.preventDefault();
		$("#formGantiPassword").submit();
	})
	$("#formGantiPassword").validate({
		rules: {
			password_lama: {
				required: true,
			},
			password_baru: {
				required: true,
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
</script>
