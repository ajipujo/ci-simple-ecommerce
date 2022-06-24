<div class="col-12 col-md-4">
	<div class="card">
		<div class="card-body">
			<form id="formRegister" action="<?= site_url('/authcontroller/send_password') ?>" method="POST">
				<h5 class="card-title text-center mb-3">Reset Password</h5>
				<div class="d-flex justify-content-center mb-2">
					<small>*Password baru akan dikirimkan melalui email</small>
				</div>
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
				<div class="mb-2">
					<label for="email" class="form-label required-label">Email</label>
					<input type="email" name="email" class="form-control" id="email" placeholder="Masukkan email...">
					<?php echo form_error('email'); ?>
				</div>
				<div class="d-grid gap-2 mb-4">
					<button id="btnResetPassword" class="btn btn-primary" type="submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-12 d-flex justify-content-center mt-3">
		<a href="<?= site_url('/') ?>">Kembali ke halaman utama</a>
	</div>
</div>

<script>
	$("#btnResetPassword").click(function(e) {
		e.preventDefault();
		$("#formRegister").submit();
	})
	$("#formRegister").validate({
		rules: {
			email: {
				required: true,
				email: true
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
