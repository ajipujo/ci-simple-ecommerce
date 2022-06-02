<div class="container my-4">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<img src="<?= base_url('/upload/produk/' . $produk->gambar) ?>" alt="<?= $produk->name ?>" class="w-100">
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-12">
							<h5><?= $produk->name ?><span id="varian_name"></span></h5>
						</div>
						<div class="col-12">
							<p><?= $produk->deskripsi ?></p>
						</div>
						<div class="col-12">
							<div class="row">
								<?php foreach ($produk->product_types as $item) { ?>
									<div class="col-md-auto mb-3">
										<label>
											<input class="radio-image varian-produk" type="radio" name="produk_type" value="small" data-name="<?= $item->name ?>" data-price="<?= $item->harga ?>">
											<img src="<?= base_url('/upload/varian_produk/' . $item->gambar) ?>" alt="<?= $produk->name ?>" class="varian-image">
										</label>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="col-12">
							<span id="harga_produk" class="h5 currency-format"><?= $produk->harga ?></span>
							<span>/</span>
							<span><?= $produk->satuan ?></span>
						</div>
					</div>
					<div class="col-12 mt-3">
						<button class="btn btn-primary"><i class="fa fa-shopping-cart me-2" aria-hidden="true"></i>beli sekarang</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$("input[type=radio][name=produk_type]").change(function() {
		let name = " - " + $(this).data('name');
		let harga = $(this).data('price');
		$('#harga_produk').text(harga);
		$('#varian_name').text(name);
		activateCurrencyFormat();
	})
</script>
