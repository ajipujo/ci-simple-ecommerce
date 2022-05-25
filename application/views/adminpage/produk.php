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

<div class="container my-4">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-6 d-flex align-items-center">
					<span class="fw-bold">Daftar Produk</span>
				</div>
				<div class="col-6 d-flex justify-content-end">
					<a href="<?= site_url('/admincontroller/form_produk') ?>" class="btn btn-primary btn-sm">Tambah Produk (+)</a>
				</div>
			</div>
			<hr>
			<table id="example" class="table table-striped" style="width:100%">
				<thead>
					<tr>
						<th>Name</th>
						<th>Stok</th>
						<th>Harga</th>
						<th>Gambar</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($produk as $item) { ?>
						<tr>
							<td><?= $item->name ?></td>
							<td><?= $item->stok ?></td>
							<td><span class="currency-format"><?= $item->harga ?></span></td>
							<td><img src="<?= base_url('upload/produk/' . $item->gambar) ?>" alt="<?= $item->name ?>" width="100"></td>
							<td>
								<a href="<?= site_url('/admincontroller/edit_produk/' . $item->slug) ?>" class="btn btn-primary btn-sm">Edit</a>
								<form action="<?= site_url('/admincontroller/delete_produk') ?>" method="post" class="d-inline">
									<input type="hidden" name="id" value="<?= $item->id ?>">
									<button type="submit" class="btn btn-danger btn-sm">Hapus</button>
								</form>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#example').DataTable();
	});
</script>
