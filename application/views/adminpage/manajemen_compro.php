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
	<div class="col-md-8 mx-auto">
		<div class="card">
			<div class="card-body">
				<div class="col-12">
					<span class="fw-bold">Update Company Profile</span>
				</div>
				<hr>
				<form action="<?= site_url('admincontroller/update_compro') ?>" method="POST" id="formCompro">
					<div class="mb-3">
						<label for="nama_perusahaan" class="form-label required-label">Nama Perusahaan</label>
						<input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="<?= $compro->nama_perusahaan ?>" placeholder="masukkan nama perusahaan...">
					</div>
					<div class="mb-3">
						<label for="alamat_perusahaan" class="form-label required-label">Alamat Perusahaan</label>
						<input type="text" class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" value="<?= $compro->alamat_perusahaan ?>" placeholder="masukkan alamat perusahaan...">
					</div>
					<div class="mb-3">
						<label for="deskripsi" class="form-label">Deskripsi Perusahaan</label>
						<textarea id="editor" name="deskripsi_perusahaan">
							<?= $compro->deskripsi_perusahaan ?>
						</textarea>
					</div>
					<button class="btn btn-primary w-100" id="btnSubmit" type="submit">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	CKEDITOR.replace('editor');

	$("#formCompro").validate({
		ignore: [],
		debug: false,
		rules: {
			nama_perusahaan: {
				required: true
			},
			alamat_perusahaan: {
				required: true
			},
			deskripsi_perusahaan: {
				required: function() {
					let content = CKEDITOR.instances.editor.getData();
					console.log(content);
					if (content == '') {
						return true;
					} else {
						return false;
					}
				}
			}
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
