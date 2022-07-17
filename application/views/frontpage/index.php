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

<?php
if (isset($_SESSION['message_user'])) {
?>
	<div class="container my-4">
		<a href="<?= site_url('/frontcontroller/customer_profile/' . $user['userdata']['id']) ?>" style="text-decoration: none;">
			<div class="alert alert-<?= isset($_SESSION['message_user']['status']) ? $_SESSION['message_user']['status'] : 'success' ?> alert-dismissible fade show" role="alert">
				<div>
					<?= isset($_SESSION['message_user']['text']) ? $_SESSION['message_user']['text'] : '' ?>
				</div>
			</div>
		</a>
	</div>

<?php
}
?>
<div class="container py-3">
	<div class="mt-3 mb-5">
		<h3 class="text-center">Product</h3>
		<div class="col-md-8 mx-auto">
			<p class="text-center">Our raw materials go through numerous tests (MSDS, FSC, soyink, etc) & certification to avoid misrepresenting client’s brand value. We go through rigorous QC system to produce highest quality green label & packaging to all our clients.</p>
		</div>
	</div>
	<div class="row">
		<?php foreach ($produk as $key => $item) { ?>
			<div class="col-6 col-md-3">
				<div class="card mb-3 card-product">
					<img class="card-img-top-custom" src="<?= base_url('/upload/produk/' . $item->gambar) ?>" alt="...">
					<div class="card-body">
						<div class="col-12 mb-2">
							<span class="card-product-title two-line-text"><?= $item->name ?></span>
						</div>
						<a href="<?= site_url('frontcontroller/produk_detail/' . $item->slug) ?>" class="stretched-link"></a>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<div class="bg-light py-4">
	<div class="container">
		<div class="col-md-8 mx-auto">
			<h3 class="text-center">About Us</h3>
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
</div>
