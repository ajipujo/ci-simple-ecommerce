<div class="col-12 col-md-4">
	<div class="card">
		<div class="card-body">
			<form id="formLogin" method="POST" action="<?= site_url('/authcontroller/authlogin') ?>">
				<h5 class="card-title text-center mb-3">Sign In</h5>
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
					<label for="email" class="form-label required-label">Email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="masukkan email...">
				</div>
				<div class="mb-2">
					<label for="password" class="form-label required-label">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="masukkan password...">
				</div>
				<div class="col-12 d-flex justify-content-between mb-2">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="passwordAvailability">
						<label class="form-check-label" for="passwordAvailability">
							Lihat password
						</label>
					</div>
					<a href="<?= site_url('authcontroller/reset_password') ?>" class="text-danger" style="text-decoration: none;">Lupa password?</a>
				</div>
				<div class="d-grid gap-2 mb-2">
					<button type="submit" id="btnLogin" class="btn btn-primary">Submit</button>
					<a class="btn btn-outline-secondary" href="<?= site_url('/authcontroller/register') ?>">Register</a>
				</div>
			</form>
		</div>
	</div>
	<div class="col-12 d-flex justify-content-center mt-3">
		<a href="<?= site_url('/') ?>">Kembali ke halaman utama</a>
	</div>
</div>

<script>
	$("#btnLogin").click(function(e) {
		e.preventDefault();
		$("#formLogin").submit();
	})

	$("#passwordAvailability").change(function() {
		if ($(this).is(":checked")) {
			$("#password").attr("type", "text");
		} else {
			$("#password").attr("type", "password");
		}
	});

	$("#formLogin").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: {
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
</script>
