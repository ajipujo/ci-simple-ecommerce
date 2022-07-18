<?php

$expired = false;

if ($transaksi->batas_pembayaran) {
	$from_db = date("d F Y, H:i", strtotime($transaksi->batas_pembayaran));
	$now = date("d F Y, H:i");
	
	$expired = $from_db > $now;
}

switch ($transaksi->status_transaksi) {
	case 1:
		$class = 'badge bg-warning text-dark';
		break;
	case 2:
		$class = $expired ? 'badge bg-danger' : 'badge bg-warning text-dark';
		$transaksi->status_name = $expired ? 'Pembayaran Kadaluarsa' : $transaksi->status_name;
		break;
	case 3:
		$class = 'badge bg-warning text-dark';
		break;
	case 4:
		$class = 'badge bg-success';
		break;
	case 5:
		$class = 'badge bg-danger';
		break;
	case 6:
		$class = 'badge bg-warning text-dark';
		break;

	default:
		$class = 'badge bg-primary';
		break;
}
?>
<div class="container my-4">
	<div class="row">
		<div class="col-md-8 mx-auto mb-2">
			<div class="card mb-3">
				<div class="card-body">
					<div class="col-12 d-flex justify-content-between mb-2">
						<span>No. Pemesanan</span>
						<span class="fw-bold"><?= $transaksi->kode_pemesanan ?></span>
					</div>
					<div class="col-12 d-flex justify-content-between mb-2">
						<span>Tanggal Pemesanan</span>
						<span><?= date("d F Y, h:i", strtotime($transaksi->created_at)) ?> WIB</span>
					</div>
					<div class="col-12 d-flex justify-content-between">
						<span>Status Pemesanan</span>
						<span class="<?= $class ?> p-2"><?= $transaksi->status_name ?></span>
					</div>
				</div>
			</div>
			<div class="card mb-3">
				<div class="card-body">
					<?php foreach ($transaksi->detail_transaction as $item) { ?>
						<div class="col-12 my-3">
							<div class="row">
								<div class="col-md-6">
									<div class="col-12 mb-2">
										<span class="fw-bold"><?= $item->product_name ?> - <?= $item->product_type_name ?></span>
									</div>
									<div class="col-12">
										<span class="currency-format"><?= $item->product_price ?></span>
										<span>x <?= $item->qty ?></span>
									</div>
								</div>
								<div class="col-md-6 d-flex align-items-center justify-content-md-end">
									<span>Total harga:&nbsp;</span>
									<span class="currency-format fw-bold"><?= $item->product_price * $item->qty ?></span>
								</div>
							</div>
						</div>
						<hr>
					<?php } ?>
				</div>
			</div>
			<div class="card mb-3">
				<div class="card-body">
					<div class="fw-bold mb-2">Alamat Pengiriman</div>
					<div class="col-md-12">
						<span><?= $transaksi->alamat_pemesanan ?></span>
					</div>
				</div>
			</div>
			<div class="card mb-3">
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<span>Total Pembayaran</span>
						</div>
						<div class="col-md-6 d-flex justify-content-md-end">
							<?php
							$total_pembayaran = 0;
							foreach ($transaksi->detail_transaction as $item) {
								$total_pembayaran += $item->product_price * $item->qty;
							}
							?>
							<span class="currency-format fw-bold"><?= $total_pembayaran ?></span>
						</div>
					</div>
				</div>
			</div>
			<?php if ($transaksi->status_transaksi == 3) { ?>
				<form action="#" id="form_resi">
					<div class="card mb-3">
						<div class="card-body">
							<div class="mb-3">
								<label for="input_resi" class="form-label required-label fw-bold">Resi Pembayaran</label>
								<input type="text" class="form-control" id="input_resi" name="input_resi" placeholder="masukkan no. resi...">
							</div>
						</div>
					</div>
				</form>
			<?php } ?>
			<div class="row">
				<?php if ($transaksi->status_transaksi != 5 && $transaksi->status_transaksi != 4) { ?>
					<?php if ($transaksi->status_transaksi == 1 || $transaksi->status_transaksi == 3 || $transaksi->status_transaksi == 6) { ?>
						<?php
						switch ($transaksi->status_transaksi) {
							case 1:
								$action_name = 'Konfirmasi Pesanan';
								$action_class = 'btnKirim';
								$action_class = 'btnKonfirmasi';
								break;
							case 6:
								$action_name = 'Konfirmasi Pembayaran';
								$action_class = 'btnKonfirmasi';
								break;
							case 3:
								$action_name = 'Kirim Pesanan';
								$action_class = 'btnKirim';
								break;

							default:
								$action_name = '';
								$action_class = '';
								break;
						}
						?>
						<div class="col-md-4 mb-2">
							<form action="<?= site_url('admincontroller/next_process') ?>" class="form-inline" method="POST" id="form_process">
								<input type="hidden" name="kode_transaksi" value="<?= $transaksi->kode_pemesanan ?>">
								<input type="hidden" name="resi_pemesanan" id="resi_pemesanan" value="">
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-primary <?= $action_class ?>"><?= $action_name ?></button>
								</div>
							</form>
						</div>
					<?php } ?>
					<?php if ($transaksi->status_transaksi == 6) { ?>
						<div class="col-8 col-md-3 mb-2">
							<form action="<?= site_url('admincontroller/cancel_pembayaran') ?>" class="form-inline" method="POST">
								<input type="hidden" name="kode_transaksi" value="<?= $transaksi->kode_pemesanan ?>">
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-danger">Cancel Pembayaran</button>
								</div>
							</form>
						</div>
						<div class="col-8 col-md-3 mb-2">
							<form action="<?= site_url('admincontroller/cancel_order') ?>" class="form-inline" method="POST">
								<input type="hidden" name="kode_transaksi" value="<?= $transaksi->kode_pemesanan ?>">
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-danger">Cancel Order</button>
								</div>
							</form>
						</div>
					<?php } else { ?>
						<div class="col-8 col-md-4 mb-2">
							<form action="<?= site_url('admincontroller/cancel_order') ?>" class="form-inline" method="POST">
								<input type="hidden" name="kode_transaksi" value="<?= $transaksi->kode_pemesanan ?>">
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-danger">Cancel Order</button>
								</div>
							</form>
						</div>
					<?php } ?>
					<div class="col-4 col-md-2 mb-2">
						<button type="submit" class="btn btn-success w-100"><i class="fa fa-whatsapp" aria-hidden="true"></i></button>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php if ($transaksi->bukti_pembayaran) { ?>
			<div class="col-md-4 mb-2">
				<div class="card">
					<div class="card-body">
						<div class="row mb-2">
							<div class="col-md-12">
								<div class="fw-bold mb-2">Bukti Pembayaran</div>
								<div class="mt-2">
									<a href="<?= base_url('/upload/bukti_pembayaran/' . $transaksi->bukti_pembayaran) ?>">
										<img src="<?= base_url('/upload/bukti_pembayaran/' . $transaksi->bukti_pembayaran) ?>" class="w-100">
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<script>
	$(function() {
		$('#input_resi').change(function() {
			let val = $(this).val();
			$('#resi_pemesanan').val(val);
		})

		$(".btnKirim").click(function(e) {
			e.preventDefault();
			let validation = $("#form_resi").valid();
			if (validation === true) {
				$("#form_process").submit();
			}
		})

		$("#form_resi").validate({
			rules: {
				input_resi: {
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
	})
</script>
