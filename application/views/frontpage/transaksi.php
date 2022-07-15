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
					<span class="fw-bold">Daftar Transaksi</span>
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
					<?php foreach ($transaksi as $key => $item) {
						$expired = false;

						if ($item->batas_pembayaran) {
							$from_db = date("d F Y, H:i", strtotime($item->batas_pembayaran));
							$now = date("d F Y, H:i");

							$expired = $from_db < $now;
						}
					?>
						<tr>
							<td></td>
							<td><?= $item->kode_pemesanan ?></td>
							<td><?= $item->user_name ?></td>
							<?php
							switch ($item->status_transaksi) {
								case 1:
									$class = 'badge bg-warning text-dark';
									break;
								case 2:
									$class = $expired ? 'badge bg-danger' : 'badge bg-warning text-dark';
									$item->status_name = $expired ? 'Pembayaran Kadaluarsa' : $item->status_name;
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
							<td><span class="<?= $class ?> p-2"><?= $item->status_name ?></span></td>
							<td>
								<a href="<?= site_url('/frontcontroller/view_transaksi/' . $item->kode_pemesanan) ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye me-2" aria-hidden="true"></i>View</a>
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
		let t = $('#example').DataTable({
			columnDefs: [{
				searchable: false,
				orderable: false,
				targets: 0,
			}, ],
			order: [
				[1, 'asc']
			],
		});

		t.on('order.dt search.dt', function() {
			let i = 1;

			t.cells(null, 0, {
				search: 'applied',
				order: 'applied'
			}).every(function(cell) {
				this.data(i++);
			});
		}).draw();
	});
</script>
