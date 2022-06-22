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
	<div id="carouselExampleControls" class="carousel carousel-home slide" data-bs-ride="carousel">
		<div class="carousel-inner rounded">
			<div class="carousel-item carousel-item-home active">
				<img src="https://images.remotehub.com/d42c62669a7711eb91397e038280fee0/original_thumb/ec1eb042.jpg?version=1618112516" class="d-block w-100" alt="...">
			</div>
			<div class="carousel-item carousel-item-home">
				<img src="https://images.remotehub.com/ace0aaa09a7711eb8e999a0aaf11a20e/original_thumb/ce972803.jpg?version=1618112444" class="d-block w-100" alt="...">
			</div>
			<div class="carousel-item carousel-item-home">
				<img src="https://images.remotehub.com/966718189a7711ebaff39a0aaf11a20e/original_thumb/e2fee7de.jpg?version=1618112414" class="d-block w-100" alt="...">
			</div>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>
</div>
<div class="container py-3">
	<div class="row">
		<?php foreach ($produk as $key => $item) { ?>
			<div class="col-6 col-md-3">
				<div class="card mb-3 card-product">
					<img class="card-img-top-custom" src="<?= base_url('/upload/produk/' . $item->gambar) ?>" alt="...">
					<div class="card-body">
						<!-- <div class="col-12 mb-2">
							<span class="card-product-stock text-danger">Stok tersisa <?= $item->stok ?></span>
						</div> -->
						<div class="col-12 mb-2">
							<span class="card-product-title two-line-text"><?= $item->name ?></span>
						</div>
						<!-- <div class="col-12 mb-3">
							<span class="card-product-price fw-bold currency-format"><?= $item->harga ?></span>
						</div> -->
						<a href="<?= site_url('frontcontroller/produk_detail/' . $item->slug) ?>" class="stretched-link"></a>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
