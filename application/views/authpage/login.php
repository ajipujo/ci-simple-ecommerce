<div class="col-12 col-md-4">
	<div class="card">
		<div class="card-body">
			<form id="myform">
				<h5 class="card-title text-center mb-3">Sign In</h5>
				<div class="mb-3">
					<label for="email" class="form-label">Email address</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
				</div>
				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="your password...">
				</div>
				<div class="d-grid gap-2">
					<button type="submit" class="btn btn-primary" type="button">Submit</button>
					<button class="btn btn-outline-secondary" type="button">Register</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$("#myform").validate({
		rules: {
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
		submitHandler: function(form) {
			// some other code
			// maybe disabling submit button
			// then:
			// $(form).submit();
			alert('Validate!');
		}
	});
</script>
