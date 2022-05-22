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
<?php

$dummy = [
	[
		'name' => 'Headphone X | Premium & Gaming gear for PC | Comfortable & Lightweight',
		'price' => '10000',
		'image' => 'https://img.freepik.com/free-psd/headphone-brand-product-sale-facebook-cover-banner_161103-93.jpg?w=2000',
		'stok' => 3
	],
	[
		'name' => 'Cosmetic X',
		'price' => '10000',
		'image' => 'https://media.istockphoto.com/vectors/cosmetic-bottle-on-geometric-podium-mock-up-banner-vector-id1206770955?b=1&k=20&m=1206770955&s=612x612&w=0&h=xaAoBp7a0Swazwi-AZKp_iwq4Fk1moATudwPiSRfzkA=',
		'stok' => 30
	],
	[
		'name' => 'Dapur X',
		'price' => '10000',
		'image' => 'https://img.pikbest.com/01/76/00/51VpIkbEsTUMC.jpg-0.jpg!bw700',
		'stok' => 50
	],
];

?>
<div class="container py-3">
	<div class="row">
		<?php foreach ($dummy as $key => $item) { ?>
			<div class="col-6 col-md-3">
				<div class="card mb-3 card-product">
					<img class="card-img-top-custom" src="<?= $item['image'] ?>" alt="...">
					<div class="card-body">
						<div class="col-12 mb-2">
							<span class="card-product-stock text-danger">Stok tersisa <?= $item['stok'] ?></span>
						</div>
						<div class="col-12 mb-2">
							<span class="card-product-title two-line-text"><?= $item['name'] ?></span>
						</div>
						<div class="col-12 mb-3">
							<span class="card-product-price fw-bold currency-format"><?= $item['price'] ?></span>
						</div>
						<a href="#" class="stretched-link"></a>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
