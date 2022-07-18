<div class="container">
	<div class="col-md-8 mx-auto">
		<h3 class="text-center">Tentang <span class="h3 fw-bold"><?= $compro->nama_perusahaan ?></span></h3>
		<div class="my-4 about-image">
			<img src="<?= base_url('/assets/img/default-about-company.jpg') ?>" class="w-100">
		</div>
		<div class="col-12">
			<span class="fw-bold">Alamat:</span>
			<p><?= $compro->alamat_perusahaan ?></p>
		</div>
		<hr>
		<p><?= $compro->deskripsi_perusahaan ?></p>
	</div>
</div>
