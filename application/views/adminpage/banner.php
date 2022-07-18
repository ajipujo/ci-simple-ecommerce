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
	<div class="card mb-4">
		<div class="card-body">
			<div class="row">
				<div class="col-12 d-flex align-items-center">
					<span class="fw-bold">Tambah Banner</span>
				</div>
			</div>
			<hr>
			<form action="<?= site_url('admincontroller/add_banner') ?>" id="formBanner" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<div class="mb-3">
							<label for="gambar" class="form-label required-label">Gambar Banner</label>
							<input class="form-control" type="file" id="gambar" name="gambar">
						</div>
					</div>
					<div class="col-md-6">
						<div class="mb-3">
							<label for="gambar" class="form-label required-label">Keterangan Banner</label>
							<input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="masukkan keterangan...">
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
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-12 d-flex align-items-center">
					<span class="fw-bold">Daftar Banner</span>
				</div>
			</div>
			<hr>
			<table id="tableBanner" class="table table-striped" style="width:100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Gambar</th>
						<th>Deskripsi</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($banners as $key => $item) { ?>
						<tr>
							<td></td>
							<td><img src="<?= base_url('upload/banner/' . $item->gambar) ?>" alt="banner-<?= $item->id ?>" width="200px"></td>
							<td><?= $item->keterangan ?></td>
							<td>
								<a href="<?= site_url('admincontroller/delete_banner/' . $item->id) ?>" class="btn btn-danger btn-sm confirmFirst">Delete</a>
							</td>
						<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		let t = $('#tableBanner').DataTable({
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

		$("#formBanner").validate({
			rules: {
				gambar: {
					required: true
				},
				keterangan: {
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
