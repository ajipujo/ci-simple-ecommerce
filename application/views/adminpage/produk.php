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
						<th>Gambar</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
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
