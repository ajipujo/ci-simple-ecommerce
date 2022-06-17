<div class="container my-4">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-6">
					Selamat datang <span class="fw-bold"><?= $user['userdata']['name'] ?></span>
				</div>
				<div class="col-md-6 d-flex justify-content-end">
					<span class="text-secondary"><?= date_format(new DateTime(), 'd F Y, H:i') ?> WIB</span>
				</div>
			</div>
		</div>
	</div>
</div>
