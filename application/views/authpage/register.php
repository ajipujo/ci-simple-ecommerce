<div class="col-12 col-md-4">
	<div class="card">
		<div class="card-body">
			<form id="formRegister" action="<?= site_url('/authcontroller/authregister') ?>" method="POST">
				<h5 class="card-title text-center mb-3">Register</h5>
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
					<label for="fullname" class="form-label required-label">Nama Lengkap</label>
					<input type="text" name="fullname" class="form-control" id="fullname" placeholder="Masukkan nama lengkap...">
					<?php echo form_error('fullname'); ?>
				</div>
				<div class="mb-3">
					<label for="no_hp" class="form-label required-label">No. Handphone</label>
					<input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="Masukkan no. hp...">
					<?php echo form_error('no_hp'); ?>
				</div>
				<div class="mb-3">
					<label for="email" class="form-label required-label">Email</label>
					<input type="email" name="email" class="form-control" id="email" placeholder="masukkan email...">
					<?php echo form_error('email'); ?>
				</div>
				<div class="mb-3">
					<label for="password" class="form-label required-label">Password</label>
					<input type="password" name="password" class="form-control" id="password" placeholder="masukkan password...">
					<?php echo form_error('password'); ?>
				</div>
				<div class="col-12 d-flex justify-content-between mb-2">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="passwordAvailability">
						<label class="form-check-label" for="passwordAvailability">
							Lihat password
						</label>
					</div>
				</div>
				<div class="d-grid gap-2 mb-2">
					<button id="btnRegister" class="btn btn-primary" type="submit">Submit</button>
					<a class="btn btn-outline-secondary" href="<?= site_url('/authcontroller/login') ?>">Sign In</a>
				</div>
				<div class="col-12 d-flex justify-content-center">
					<a href="<?= site_url('/') ?>">Kembali ke halaman utama</a>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$("#btnRegister").click(function(e) {
		e.preventDefault();
		$("#formRegister").submit();
	})

	$("#passwordAvailability").change(function() {
		if ($(this).is(":checked")) {
			$("#password").attr("type", "text");
		} else {
			$("#password").attr("type", "password");
		}
	});
	
	$("#formRegister").validate({
		rules: {
			fullname: {
				required: true
			},
			email: {
				required: true,
				email: true
			},
			no_hp: {
				required: true
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
