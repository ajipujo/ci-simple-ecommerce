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
};

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
};
?>

<div class="container my-4">

	<?php
	if ($transaksi->status_transaksi != 5 && $transaksi->status_transaksi != 1 && $transaksi->batas_pembayaran && !$expired) {
	?>
		<div class="alert alert-danger col-12 d-flex justify-content-between mt-2">
			<span>Batas Pembayaran</span>
			<span class="fw-bold"><?= date("d F Y, H:i", strtotime($transaksi->batas_pembayaran)) ?> WIB</span>
		</div>
	<?php } ?>

	<div class="row">
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
		</div>
		<?php if ($transaksi->status_transaksi != 5 && $transaksi->status_transaksi != 1 && !$expired) { ?>
			<div class="col-md-4">
				<div class="card mb-3">
					<div class="card-body">
						<?php if ($transaksi->bukti_pembayaran) { ?>
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
						<?php } else { ?>
							<form action="<?= site_url('frontcontroller/upload_pembayaran') ?>" method="POST" id="formPembayaran" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12 mb-3">
										<div class="alert alert-danger" role="alert">
											Harap upload bukti pembayaran <i class="fa fa-exclamation-triangle ms-2" aria-hidden="true"></i>
										</div>
										<label for="buktiPembayaran" class="form-label fw-bold mb-3">Upload Bukti Pembayaran</label>
										<input type="hidden" name="kode_pemesanan" value="<?= $transaksi->kode_pemesanan ?>">
										<input class="form-control form-control-sm" id="buktiPembayaran" name="bukti_pembayaran" type="file" accept=".jpg,.png,.jpeg,.gif">
									</div>
									<div class="col-md-12">
										<button type="submit" id="btnUpload" class="btn btn-primary btn-sm w-100">Upload</button>
									</div>
								</div>
							</form>
						<?php } ?>
					</div>
				</div>
				<?php if ($transaksi->resi_pemesanan) { ?>
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="fw-bold mb-2">Resi Pemesanan</div>
									<div class="mt-2 d-flex justify-content-between">
										<div><?= $transaksi->resi_pemesanan ?></div>
										<div class="fw-bold">J&T</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			<?php } ?>
			</div>
	</div>
</div>
<?php

?>

<script>
	$("#btnUpload").click(function(e) {
		e.preventDefault();
		$("#formPembayaran").submit();
	})
	$("#formPembayaran").validate({
		rules: {
			buktiPembayaran: {
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
