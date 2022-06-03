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
								<span class="fw-bold">Download: </span><a href="<?= base_url('/upload/produk/' . $produk->gambar) ?>"><?= $produk->gambar ?></a>
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
					<?php foreach ($produk->product_types as $key => $varian) { ?>
						<div class="row" id="<?= "varian_container_" . $key ?>">
							<div class="col-md-4">
								<div class="mb-3">
									<label for="<?= "varian_name_" . $key ?>" class="form-label">Nama Varian</label>
									<input type="hidden" name="varian_id[]" value="<?= $varian->id ?>">
									<input type="text" class="form-control" id="<?= "varian_name_" . $key ?>" name="varian_name[]" value="<?= $varian->name ?>">
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-3">
									<label for="<?= "varian_gambar_" . $key ?>" class="form-label">Gambar Varian</label>
									<input class="form-control" type="file" id="<?= "varian_gambar_" . $key ?>" name="varian_gambar[]">
									<div class="mt-2">
										<span class="fw-bold download-link">Download: </span><a href="<?= base_url('/upload/varian_produk/' . $varian->gambar) ?>"><?= $varian->gambar ?></a>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="row">
									<div class="col-10">
										<div class="mb-3">
											<label for="<?= "varian_harga_" . $key ?>" class="form-label">Harga Varian</label>
											<input type="text" class="form-control" id="<?= "varian_harga_" . $key ?>" name="varian_harga[]" value="<?= $varian->harga ?>">
										</div>
									</div>
									<div class="col-2 d-flex align-items-end">
										<div class="mb-3">
											<button type="button" onclick="deleteVarianForm(<?= $key ?>, <?= $varian->id ?>)" class="btn btn-danger">X</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php
						$key_variant = $key;
					}
					?>
				</div>
				<div class="d-flex justify-content-end mt-3">
					<input type="hidden" id="varian_delete_datas" name="varian_delete_datas">
					<button class="btn btn-outline-secondary me-2" type="button">Kembali</button>
					<button class="btn btn-primary" type="submit" id="btnProduk">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	let indexVarian = <?php echo $key + 1 ?>;
	let arrDeleted = [];

	function addVarianForm() {
		let components = `<div class="row" id="varian_container_` + indexVarian + `">
					<div class="col-md-4">
						<div class="mb-3">
							<label for="varian_name_` + indexVarian + `" class="form-label">Nama Varian</label>
							<input type="hidden" name="varian_id[]" value="">
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

	function deleteVarianForm(id, id_varian) {
		$('#varian_container_' + id).remove();
		if (id_varian) {
			arrDeleted.push(id_varian);
		}
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
			if ($(this).parent('div').find('.download-link') < 1) {
				if (!$(this).val()) {
					validateVarian = false;
				}
			}
		});
		$('input[name="varian_harga[]"]').each(function() {
			if (!$(this).val()) {
				validateVarian = false;
			}
		});

		if (validateVarian) {
			$("#varian_delete_datas").val(arrDeleted);
			$("#formProduk").submit();
		} else {
			alert("Mohon lengkapi data varian");
		}
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
