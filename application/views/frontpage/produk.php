<div class="container my-4">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<img src="<?= base_url('/upload/produk/'.$produk->gambar) ?>" alt="" class="w-100">
				</div>
				<div class="col-md-6">
					<h5><?= $produk->name ?></h5>
					<p><?= $produk->deskripsi ?></p>
					<span class="h5 currency-format"><?= $produk->harga ?></span>
					<div class="col-12 mt-3">
						<button class="btn btn-primary"><i class="fa fa-shopping-cart me-2" aria-hidden="true"></i>beli sekarang</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
