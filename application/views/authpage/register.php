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
					<label for="fullname" class="form-label">Fullname</label>
					<input type="text" name="fullname" class="form-control" id="fullname" placeholder="Must have at least 2 characters">
					<?php echo form_error('fullname'); ?>
				</div>
				<div class="mb-3">
					<label for="email" class="form-label">Email address</label>
					<input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
					<?php echo form_error('email'); ?>
				</div>
				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" name="password" class="form-control" id="password" placeholder="your password...">
					<?php echo form_error('password'); ?>
				</div>
				<div class="d-grid gap-2">
					<button id="btnRegister" class="btn btn-primary" type="submit">Submit</button>
					<a class="btn btn-outline-secondary" href="<?= site_url('/authcontroller/login') ?>">Sign In</a>
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
	$("#formRegister").validate({
		rules: {
			fullname: {
				required: true
			},
			email: {
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
