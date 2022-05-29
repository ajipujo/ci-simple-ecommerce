<?php
if (isset($_SESSION['message'])) {
?>
	<div class="container my-4">

		<div class="alert alert-<?= isset($_SESSION['message']['status']) ? $_SESSION['message']['status'] : 'success' ?> alert-dismissible fade show" role="alert">
			<div>
				<?= isset($_SESSION['message']['text']) ? $_SESSION['message']['text'] : '' ?>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	</div>

<?php
}
?>

<div class="container my-4">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-12">
					<span class="fw-bold">Tambah Admin</span>
				</div>
			</div>
			<hr>
			<form action="<?= site_url('/admincontroller/save_admin') ?>" method="POST">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="name" class="form-label">Fullname</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Must have at least 2 characters">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="role" class="form-label">Role</label>
							<select name="role" id="role" class="form-select">
								<option value="2" selected>Marketing</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="password" class="form-label">Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="your password...">
						</div>
					</div>
					<div class="d-flex justify-content-end mt-3">
						<button class="btn btn-outline-secondary me-2" type="submit">Kembali</button>
						<button class="btn btn-primary" type="submit">Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$("#btnRegister").click(function(e) {
		e.preventDefault();
		$("#formProduk").submit();
	})
	$("#formProduk").validate({
		rules: {
			name: {
				required: true
			},
			stok: {
				required: true
			},
			harga: {
				required: true
			},
			gambar: {
				required: true
			},
			deskripsi: {
				required: true
			},
			satuan: {
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
