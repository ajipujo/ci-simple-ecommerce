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
						<th>Name</th>
						<th>Role</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $user) { ?>
						<tr>
							<td><?= $user->name ?></td>
							<td><?= $user->role_nm ?></td>
							<td><?= $user->is_active == 1 ? 'Active' : 'Non-active' ?></td>
							<td>
								<form action="<?= site_url('/admincontroller/form_edit_user') ?>" method="post" class="d-inline">
									<input type="hidden" name="id" value="<?= $user->id ?>">
									<button type="submit" class="btn btn-primary btn-sm">Edit</button>
								</form>
								<form action="<?= site_url('/admincontroller/delete_user') ?>" method="post" class="d-inline">
									<input type="hidden" name="id" value="<?= $user->id ?>">
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
		$('#tableUser').DataTable();
	});
</script>
