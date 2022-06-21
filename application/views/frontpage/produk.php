<div class="container my-4">
	<div class="row">
		<div class="col-md-9">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<img src="<?= base_url('/upload/produk/' . $produk->gambar) ?>" alt="<?= $produk->name ?>" class="w-100">
						</div>
						<div class="col-md-8">
							<div class="row">
								<div class="col-12">
									<input type="hidden" id="produk_name" value="<?= $produk->name ?>">
									<input type="hidden" id="produk_id" value="<?= $produk->id ?>">
									<h5><?= $produk->name ?><span id="varian_name"></span></h5>
								</div>
								<div class="col-12 my-2">
									<?php echo $produk->deskripsi ?>
								</div>
								<div class="col-12">
									<div class="row">
										<?php foreach ($produk->product_types as $item) { ?>
											<div class="col-md-auto mb-3">
												<label>
													<input class="radio-image varian-produk" type="radio" name="produk_type" value="<?= $item->id ?>" data-name="<?= $item->name ?>" data-price="<?= $item->harga ?>">
													<img src="<?= base_url('/upload/varian_produk/' . $item->gambar) ?>" alt="<?= $produk->name ?>" class="varian-image">
												</label>
											</div>
										<?php } ?>
									</div>
								</div>
								<div class="col-12" id="container_harga_produk">
									<span id="harga_produk" class="h5 currency-format"><?= $produk->harga ?></span>
									<span>/</span>
									<span><?= $produk->satuan ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-body">
					<div id="kuantitas_produk" class="col-12">
						<div class="input-group py-2">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="jumlah_produk">
									<span class="fa fa-minus"></span>
								</button>
							</span>
							<input type="text" name="jumlah_produk" id="jumlah_produk" class="form-control input-number" value="1" min="1" max="100">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="jumlah_produk">
									<span class="fa fa-plus"></span>
								</button>
							</span>
						</div>
						<div class="col-12 py-2 d-flex justify-content-between">
							<span>subtotal</span>
							<span class="currency-format fw-bold" id="subtotal">0</span>
						</div>
					</div>
					<div class="d-grid gap-2 py-2">
						<?php if ($user && $user['userdata']['role_id'] == 3) { ?>
							<a class="btn btn-primary btn-sm" href="<?= site_url('frontcontroller/paycarts') ?>" id="btnBeliProduk"><i class="fa fa-shopping-cart me-2" aria-hidden="true"></i>beli sekarang</a>
						<?php } else { ?>
							<a href="<?= site_url('authcontroller/login') ?>" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart me-2" aria-hidden="true"></i>beli sekarang</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	let statusVarian = false;

	$(function() {
		$('#kuantitas_produk').hide();
		$('#container_harga_produk').hide();
	});

	$("input[type=radio][name=produk_type]").change(function() {
		$('#jumlah_produk').val(1);
		let name = " - " + $(this).data('name');
		let harga = $(this).data('price');
		let jumlah_produk = $('#jumlah_produk').val();
		let subtotal = harga * jumlah_produk;
		$('#harga_produk').text(harga);
		$('#subtotal').text(subtotal);
		$('#varian_name').text(name);
		activateCurrencyFormat();
		$('#kuantitas_produk').show();
		$('#container_harga_produk').show();
		statusVarian = true;
	});

	$('#jumlah_produk').change(function() {
		let harga = $("input[type=radio][name=produk_type]:checked").data('price');
		let qty = $('#jumlah_produk').val();
		let subtotal = harga * qty;
		$('#subtotal').text(subtotal);
		activateCurrencyFormat();
	});

	$("#btnBeliProduk").click(function(e) {
		e.preventDefault();
		if (statusVarian) {
			let varian = $("input[type=radio][name=produk_type]:checked");
			let price = varian.data('price');
			let name = varian.data('name');
			let qty = $('#jumlah_produk').val();
			let user_id = <?= isset($user['userdata']['id']) ? $user['userdata']['id'] : 0 ?>;
			let subtotal = price * qty;
			let produk = $('#produk_name').val();
			let produk_id = $('#produk_id').val();
			let varian_id = $("input[type=radio][name=produk_type]:checked").val();
			
			let data = {
				price: price,
				name: name,
				produk: produk,
				qty: qty,
				subtotal: subtotal,
				produk_id: produk_id,
				varian_id: varian_id
			};
			
			if (localStorage.getItem('paycarts')) {
				let paycarts = JSON.parse(localStorage.getItem('paycarts'));
				paycarts.data.push(data);
				localStorage.setItem('paycarts', JSON.stringify(paycarts));
			} else {
				let paycarts = {
					user: user_id,
					data: [data]
				};
				localStorage.setItem('paycarts', JSON.stringify(paycarts));
			}
			
			window.location.href = $(this).attr('href');
		} else {
			alert('Pilih varian terlebih dahulu!');
		}
	});
</script>
