<div class="container py-3">
	<div class="col-md-8 mx-auto">
		<form action="<?= site_url('frontcontroller/buy') ?>" method="post">
			<div id="carts">
			</div>
			<div class="card my-2">
				<div class="card-body">
					<span class="fw-bold">Alamat Pengiriman</span>
					<p><?= $user['userdata']['alamat']; ?></p>
					<input type="hidden" name="alamat" value="<?= $user['userdata']['alamat']; ?>">
				</div>
			</div>
			<div class="card my-2">
				<div class="card-body">
					<div class="d-flex justify-content-between my-2">
						<span class="fw-bold">Subtotal</span>
						<span class="currency-format" id="subtotal">0</span>
					</div>
					<!-- <div class="d-flex justify-content-between my-2">
						<span class="fw-bold">Biaya Ongkir</span>
						<span class="currency-format" id="biaya_ongkir">15000</span>
					</div>
					<hr>
					<div class="d-flex justify-content-between my-2">
						<span class="fw-bold">Total</span>
						<span class="currency-format" id="biaya_ongkir">15000</span>
					</div> -->
				</div>
			</div>
			<div class="d-grid gap-2">
				<button class="btn btn-primary" type="submit"><i class="fa fa-shopping-cart me-2" aria-hidden="true"></i>Pesan sekarang</button>
			</div>
		</form>
	</div>
</div>

<script>
	$(function() {
		let paycarts = JSON.parse(localStorage.getItem('paycarts'));
		let component = (component, key) => {
			return `<div class="col-12 my-2">
				<div class="card">
					<div class="card-body">
						<div class="col-12">
							<span class="fw-bold">Produk - Varian</span>
						</div>
						<div class="col-12">
							<span class="currency-format">` + component.price + `</span> x <span>` + component.qty + ` pcs</span>
							<input type="hidden" name="produk_name[]" value="` + component.produk + `">
							<input type="hidden" name="varian_name[]" value="` + component.name + `">
							<input type="hidden" name="harga[]" value="` + component.price + `">
							<input type="hidden" name="qty[]" value="` + component.qty + `">
							<input type="hidden" name="produk_id[]" value="` + component.produk_id + `">
							<input type="hidden" name="varian_id[]" value="` + component.varian_id + `">
						</div>
					</div>
				</div>
			</div>`;
		};

		paycarts.data.forEach(function(value, key) {
			$('#carts').append(component(value, key));
		});

		countAll();

		function countAll() {
			let total = 0;
			$('input[name="harga[]"]').each(function(key, value) {
				let price = $(this).val();
				let qty = $('input[name="qty[]"]')[key].value;
				total += price * qty;
			});
			$('#subtotal').text(total);
			activateCurrencyFormat();
		}
	});
</script>
