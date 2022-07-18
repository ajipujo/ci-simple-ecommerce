<?php if ($existTransaction) { ?>
	<script>
		$(function() {
			if (localStorage.getItem('paycarts')) {
				let paycarts = JSON.parse(localStorage.getItem('paycarts'));
				paycarts.data = [...paycarts.data, ...<?= $existTransaction ?>];
				localStorage.setItem('paycarts', JSON.stringify(paycarts));
			} else {
				let paycarts = {
					data: <?= $existTransaction ?>
				};
				localStorage.setItem('paycarts', JSON.stringify(paycarts));
			}
		})
	</script>
<?php } ?>


<div class="container py-3">
	<div class="col-md-8 mx-auto">
		<div class="row">
			<div class="col-md-8" id="carts">
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<div class="col-12 d-flex justify-content-between">
							<span>subtotal</span>
							<span id="subtotal" class="fw-bold currency-format">10</span>
						</div>
						<div class="d-grid gap-2 mt-2">
							<a href="<?= base_url('frontcontroller/checkout') ?>" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart me-2" aria-hidden="true"></i>Checkout</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(function() {
		let paycarts = JSON.parse(localStorage.getItem('paycarts'));
		let component = (component, key) => {
			return `<div class="card mb-3">
					<div class="card-body">
						<div class="row">
							<div class="col-md-9">
								<h5>` + component.produk + ` - ` + component.name + `</h5>
								<span class="currency-format">` + component.price + `</span>
							</div>
							<div class="col-md-3">
								<div class="input-group py-2 d-flex align-items-center">
									<input type="text" name="jumlah_produk[]" class="form-control jumlah-produk" value="` + component.qty + `" data-id="` + key + `" data-price="` + component.price + `" min="1" max="100">
									<span class="btn-delete-cart" data-id="` + key + `"><i class="fa fa-trash-o ms-3" aria-hidden="true"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>`
		};

		paycarts.data.forEach(function(value, key) {
			$('#carts').append(component(value, key));
		});

		countAll();

		$('.jumlah-produk').change(function() {
			let id = $(this).data('id');
			let paycarts = JSON.parse(localStorage.getItem('paycarts'));
			paycarts.data[id].qty = $(this).val();
			localStorage.setItem('paycarts', JSON.stringify(paycarts));
			countAll();
		});

		function countAll() {
			let total = 0;
			$('input[name="jumlah_produk[]"]').each(function() {
				let price = $(this).data('price');
				let qty = $(this).val();
				total += price * qty;
			});
			$('#subtotal').text(total);
			activateCurrencyFormat();
		}

		$('.btn-delete-cart').click(function() {
			let id = $(this).data('id');
			let paycarts = JSON.parse(localStorage.getItem('paycarts'));
			paycarts.data.splice(id, 1);
			localStorage.setItem('paycarts', JSON.stringify(paycarts));
			location.reload();
		});
	})
</script>
