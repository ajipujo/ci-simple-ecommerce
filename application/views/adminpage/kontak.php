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
	<?php if (count($kontak) > 1) { ?>
		<div class="alert alert-danger">
			<span>Jumlah kontak sudah melebihi limit, hapus kontak terlebih dahulu sebelum menambahkan kontak baru.</span>
		</div>
	<?php } else { ?>
		<div class="card mb-4">
			<div class="card-body">
				<div class="row">
					<div class="col-12 d-flex align-items-center">
						<span class="fw-bold">Tambah Kontak</span>
					</div>
				</div>
				<hr>
				<form action="<?= site_url('admincontroller/add_kontak') ?>" id="formKontak" method="POST">
					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label for="no_hp" class="form-label required-label">No. Handphone</label>
								<input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="masukkan nomor...">
							</div>
						</div>
						<div class="col-md-6">
							<div class="mb-3">
								<label for="nama" class="form-label required-label">Nama Kontak</label>
								<input type="text" class="form-control" id="nama" name="nama" placeholder="masukkan nama...">
							</div>
						</div>
						<div class="col-12 d-flex justify-content-end">
							<button class="btn btn-secondary me-2" type="reset">Reset</button>
							<button class="btn btn-primary" type="submit">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php } ?>
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-12 d-flex align-items-center">
					<span class="fw-bold">Daftar Kontak</span>
				</div>
			</div>
			<hr>
			<table id="tableKontak" class="table table-striped" style="width:100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Telp/Handphone</th>
						<th>Nama</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($kontak as $key => $item) { ?>
						<tr>
							<td></td>
							<td><?= $item->no_hp ?></td>
							<td><?= $item->nama ?></td>
							<td>
								<a href="<?= site_url('admincontroller/delete_kontak/' . $item->id) ?>" class="btn btn-danger btn-sm">Delete</a>
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
		let t = $('#tableKontak').DataTable({
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

		$("#formKontak").validate({
			rules: {
				no_hp: {
					required: true
				},
				nama: {
					required: true
				},
			},
			highlight: function(element, errorClass, validClass) {
				$(element).addClass('is-invalid').removeClass('is-valid');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).addClass('is-valid').removeClass('is-invalid');
			},
			errorPlacement: function(error, element) {
				error.addClass("invalid-feedback")
				error.insertAfter(element);
			},
		});

		$('.confirmFirst').click(e => {
			e.preventDefault();

			let isExecuted = confirm("Are you sure to execute this action?");

			if (isExecuted === true) {
				location.href = $(e.currentTarget).attr('href');
			}
		});
	});
</script>
