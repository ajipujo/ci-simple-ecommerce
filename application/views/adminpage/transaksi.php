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
						<th>No</th>
						<th>Kode Pembelian</th>
						<th>Customer</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($transaksi as $key => $item) { ?>
						<tr>
							<td><?= $key+1 ?></td>
							<td><?= $item->kode_pemesanan ?></td>
							<td><?= $item->user_name ?></td>
							<?php 
								switch ($item->status_transaksi) {
									case 1:
										$class = 'badge bg-warning';
										break;
									case 2:
										$class = 'badge bg-warning';
										break;
									case 3:
										$class = 'badge bg-warning';
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
							<td><span class="<?= $class ?>"><?= $item->status_name ?></span></td>
							<td>
								<a href="<?= site_url('/admincontroller/edit_produk/' . $item->kode_pemesanan) ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye me-2" aria-hidden="true"></i>View</a>
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