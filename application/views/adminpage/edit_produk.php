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
				<div class="col-6">
					<span class="fw-bold">Update Produk</span>
				</div>
			</div>
			<hr>
			<form action="<?= site_url('/admincontroller/update_produk') ?>" id="formProduk" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="name" class="form-label">Nama Produk</label>
							<input type="text" class="form-control" id="name" name="name" value="<?= $produk->name ?>">
							<input type="hidden" name="id" id="id" value="<?= $produk->id ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="harga" class="form-label">Harga Produk</label>
							<input type="text" class="form-control" id="harga" name="harga" value="<?= $produk->harga ?>">
						</div>
					</div>
					<div class="col-md-3">
						<div class="mb-3">
							<label for="stok" class="form-label">Stok Produk</label>
							<input type="text" class="form-control" id="stok" name="stok" value="<?= $produk->stok ?>">
						</div>
					</div>
					<div class="col-md-3">
						<div class="mb-3">
							<label for="satuan" class="form-label">Satuan</label>
							<input type="text" class="form-control" id="satuan" name="satuan" value="<?= $produk->satuan ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="gambar" class="form-label">Gambar Produk</label>
							<input class="form-control" type="file" id="gambar" name="gambar">
							<div class="mt-2">
								<span class="fw-bold">Download: </span><a href="<?= base_url('/upload/produk/'.$produk->gambar) ?>"><?= $produk->gambar ?></a>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label for="deskripsi" class="form-label">Deskripsi Produk</label>
							<textarea name="deskripsi" id="deskripsi" rows="5" class="form-control"><?= $produk->deskripsi ?></textarea>
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end mt-3">
					<button class="btn btn-outline-secondary me-2" type="submit">Kembali</button>
					<button class="btn btn-primary" type="submit">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$("#btnRegister").click(function(e) {
		e.preventDefault();
		$("#formProduk").submit();
	});
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
