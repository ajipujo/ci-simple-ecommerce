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
					<span class="fw-bold">Detail User</span>
				</div>
			</div>
			<hr>
			<form action="<?= site_url('/admincontroller/update_user') ?>" method="POST" id="formUser">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="name" class="form-label required-label">Nama Lengkap</label>
							<input type="hidden" name="id" id="id" value="<?= $user_detail->id ?>">
							<input type="text" class="form-control" id="name" name="name" value="<?= $user_detail->name ?>" placeholder="masukkan nama lengkap...">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="email" class="form-label required-label">Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="masukkan email..." value="<?= $user_detail->email ?>">
						</div>
					</div>
					<?php if ($user_detail->is_admin == 1) { ?>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="role" class="form-label required-label">Role</label>
								<select name="role" id="role" class="form-select">
									<?php foreach($adminRoles as $role) { ?>
										<option value="<?= $role->id ?>" <?= $user_detail->role_id == $role->id ? 'selected' : '' ?>><?= $role->role_nm ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="no_hp" class="form-label required-label">No. Handphone</label>
								<input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $user_detail->no_hp ?>" placeholder="masukkan no. hp...">
							</div>
						</div>
					<?php } else { ?>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="no_hp" class="form-label required-label">No. Handphone</label>
								<input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $user_detail->no_hp ?>" placeholder="masukkan no. hp...">
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="alamat" class="form-label">Alamat</label>
								<input type="text" class="form-control" id="alamat" name="alamat" value="<?= $user_detail->alamat ?>" placeholder="masukkan alamat...">
							</div>
						</div>
					<?php } ?>
					<div class="d-flex justify-content-end mt-3">
						<a href="javascript:history.go(-1)" class="btn btn-outline-secondary me-2">Kembali</a>
						<button class="btn btn-primary" type="submit">Simpan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$("#btnUser").click(function(e) {
		e.preventDefault();
		$("#formUser").submit();
	})
	$("#formUser").validate({
		rules: {
			name: {
				required: true
			},
			email: {
				required: true
			},
			no_hp: {
				required: true
			},
			role: {
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
