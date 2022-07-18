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
			<?php foreach ($banners as $key => $item) { ?>
				<div class="carousel-item carousel-item-home <?= $key == 0 ? 'active' : '' ?>">
					<img src="<?= base_url('/upload/banner/'.$item->gambar) ?>" class="d-block w-100" alt="...">
				</div>
			<?php } ?>
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

<div class="container">
	<div class="my-5">
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
