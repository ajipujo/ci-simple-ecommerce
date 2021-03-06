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
					<span class="fw-bold">Daftar User Admin</span>
				</div>
				<div class="col-6 d-flex justify-content-end">
					<a href="<?= site_url('/admincontroller/form_user') ?>" class="btn btn-primary btn-sm">Tambah Admin (+)</a>
				</div>
			</div>
			<hr>
			<table id="tableUser" class="table table-striped" style="width:100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Email</th>
						<th>Role</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $user) { ?>
						<tr>
							<td></td>
							<td><?= $user->name ?></td>
							<td><?= $user->email ?></td>
							<td><?= $user->role_nm ?></td>
							<td><?= $user->is_active == 1 ? 'Active' : 'Non-active' ?></td>
							<td>
								<a href="<?= site_url('admincontroller/form_edit_user/' . $user->id) ?>" class="btn btn-primary btn-sm">Edit</a>
								<a href="<?= site_url('admincontroller/reset_password/' . $user->email) ?>" class="btn btn-danger btn-sm confirmFirst">Reset Password</a>
								<a href="<?= site_url('admincontroller/delete_user/' . $user->id) ?>" class="btn btn-danger btn-sm confirmFirst">Hapus</a>
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
		let t = $('#tableUser').DataTable({
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

	$('.confirmFirst').click(e => {
		e.preventDefault();

		let isExecuted = confirm("Are you sure to execute this action?");

		if (isExecuted === true) {
			location.href = $(e.currentTarget).attr('href');
		}
	});
</script>
