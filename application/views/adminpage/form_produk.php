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
					<span class="fw-bold">Tambah Produk</span>
				</div>
			</div>
			<hr>
			<form action="<?= site_url('/admincontroller/save_produk') ?>" id="formProduk" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="name" class="form-label">Nama Produk</label>
							<input type="text" class="form-control" id="name" name="name">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="harga" class="form-label">Harga Produk</label>
							<input type="text" class="form-control" id="harga" name="harga">
						</div>
					</div>
					<div class="col-md-3">
						<div class="mb-3">
							<label for="stok" class="form-label">Stok Produk</label>
							<input type="text" class="form-control" id="stok" name="stok">
						</div>
					</div>
					<div class="col-md-3">
						<div class="mb-3">
							<label for="satuan" class="form-label">Satuan</label>
							<input type="text" class="form-control" id="satuan" name="satuan">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="gambar" class="form-label">Gambar Produk</label>
							<input class="form-control" type="file" id="gambar" name="gambar">
						</div>
					</div>
					<div class="col-md-12">
						<div class="mb-3">
							<label for="deskripsi" class="form-label">Deskripsi Produk</label>
							<textarea name="deskripsi" id="deskripsi" rows="5" class="form-control"></textarea>
						</div>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col-6 d-flex align-items-center">
						<span class="fw-bold">Varian Produk</span>
					</div>
					<div class="col-6 d-flex justify-content-end">
						<span class="fw-bold">
							<button type="button" class="btn btn-primary btn-sm" id="btnTambahVarian">Tambah Varian</button>
						</span>
					</div>
				</div>
				<hr>
				<div id="varianContainer">
					<div class="row" id="varian_container_0">
						<div class="col-md-4">
							<div class="mb-3">
								<label for="varian_name_0" class="form-label">Nama Varian</label>
								<input type="text" class="form-control" id="varian_name_0" name="varian_name[]">
							</div>
						</div>
						<div class="col-md-4">
							<div class="mb-3">
								<label for="varian_gambar_0" class="form-label">Gambar Varian</label>
								<input class="form-control" type="file" id="varian_gambar_0" name="varian_gambar[]">
							</div>
						</div>
						<div class="col-md-4">
							<div class="row">
								<div class="col-10">
									<div class="mb-3">
										<label for="varian_harga_0" class="form-label">Harga Varian</label>
										<input type="text" class="form-control" id="varian_harga_0" name="varian_harga[]">
									</div>
								</div>
								<div class="col-2 d-flex align-items-end">
									<div class="mb-3">
										<button type="button" onclick="deleteVarianForm(0)" class="btn btn-danger">X</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="d-flex justify-content-end mt-3">
					<button class="btn btn-outline-secondary me-2" type="submit">Kembali</button>
					<button class="btn btn-primary" type="submit" id="btnProduk">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	let indexVarian = 0;

	function addVarianForm() {
		let components = `<div class="row" id="varian_container_` + indexVarian + `">
						<div class="col-md-4">
							<div class="mb-3">
								<label for="varian_name_` + indexVarian + `" class="form-label">Nama Varian</label>
								<input type="text" class="form-control" id="varian_name_` + indexVarian + `" name="varian_name[]">
							</div>
						</div>
						<div class="col-md-4">
							<div class="mb-3">
								<label for="varian_gambar_` + indexVarian + `" class="form-label">Gambar Varian</label>
								<input class="form-control" type="file" id="varian_gambar_` + indexVarian + `" name="varian_gambar[]">
							</div>
						</div>
						<div class="col-md-4">
							<div class="row">
								<div class="col-10">
									<div class="mb-3">
										<label for="varian_harga_` + indexVarian + `" class="form-label">Harga Varian</label>
										<input type="text" class="form-control" id="varian_harga_` + indexVarian + `" name="varian_harga[]">
									</div>
								</div>
								<div class="col-2 d-flex align-items-end">
									<div class="mb-3">
										<button type="button" onclick="deleteVarianForm(` + indexVarian + `)" class="btn btn-danger">X</button>
									</div>
								</div>
							</div>
						</div>
					</div>`;

		$('#varianContainer').append(components);
	}

	function deleteVarianForm(id) {
		$('#varian_container_' + id).remove();
	}

	$("#btnTambahVarian").click(function(e) {
		e.preventDefault();
		indexVarian++;
		addVarianForm();
	})

	$("#btnProduk").click(function(e) {
		e.preventDefault();
		let validateVarian = true;
		$('input[name="varian_name[]"]').each(function() {
			if (!$(this).val()) {
				validateVarian = false;
			}
		});
		$('input[name="varian_gambar[]"]').each(function() {
			if (!$(this).val()) {
				validateVarian = false;
			}
		});
		$('input[name="varian_harga[]"]').each(function() {
			if (!$(this).val()) {
				validateVarian = false;
			}
		});

		if (validateVarian === false) {
			alert('Lengkapi form!');
		} else {
			$("#formProduk").submit();
		}
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
