<div class="container my-4">
	<div class="card mb-3">
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					Selamat datang <span class="fw-bold"><?= $user['userdata']['name'] ?></span>
				</div>
				<div class="col-md-6 d-flex justify-content-end">
					<span class="text-secondary"><?= date_format(new DateTime(), 'd F Y, H:i') ?> WIB</span>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<?php foreach ($statistik_transaksi as $transaksi) { ?>
			<div class="col-md-4 pb-3">
				<div class="card">
					<div class="card-body">
						<div class="col-12 d-flex justify-content-center">
							<h1 class="text-success"><?= $transaksi->total ?></h1>
						</div>
						<div class="col-12 d-flex justify-content-center">
							<small><?= $transaksi->name ?><?= in_array($transaksi->id, [1, 6, 3]) ? '<i class="fa fa-exclamation-circle ms-2" aria-hidden="true"></i>' : '' ?></small>
						</div>
					</div>
					<a href="<?= site_url('admincontroller/transaksi') ?>" class="stretched-link"></a>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
