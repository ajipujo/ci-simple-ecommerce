<?php
switch ($transaksi->status_transaksi) {
	case 1:
		$class = 'badge bg-warning text-dark';
		break;
	case 2:
		$class = 'badge bg-warning text-dark';
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

	default:
		$class = 'badge bg-primary';
		break;
}
?>
<div class="container my-4">
	<div class="col-md-8 mx-auto">
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
		<div class="row">
			<?php

			switch ($transaksi->status_transaksi) {
				case 1:
					$next_process = 'Konfirmasi Pesanan';
					break;
				case 2:
					$next_process = 'Konfirmasi Pembayaran';
					break;
				case 3:
					$next_process = 'Kirim Pesanan';
					break;

				default:
					$next_process = null;
					break;
			}

			if ($next_process) {
			?>
				<div class="col-md-6 mb-2">
					<form action="<?= site_url('admincontroller/next_process') ?>" class="form-inline" method="POST">
						<input type="hidden" name="kode_transaksi" value="<?= $transaksi->kode_pemesanan ?>">
						<div class="d-grid gap-2">
							<button type="submit" class="btn btn-primary"><?= $next_process ?></button>
						</div>
					</form>
				</div>
				<div class="col-8 col-md-4 mb-2">
					<form action="<?= site_url('admincontroller/cancel_order') ?>" class="form-inline" method="POST">
						<input type="hidden" name="kode_transaksi" value="<?= $transaksi->kode_pemesanan ?>">
						<div class="d-grid gap-2">
							<button type="submit" class="btn btn-danger">Cancel Order</button>
						</div>
					</form>
				</div>
				<div class="col-4 col-md-2 mb-2">
					<div class="d-grid gap-2">
						<button type="submit" class="btn btn-success"><i class="fa fa-whatsapp" aria-hidden="true"></i></button>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
