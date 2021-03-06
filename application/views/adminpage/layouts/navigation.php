<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
	<div class="container">
		<a class="navbar-brand fw-bold text-success" href="<?= site_url('admincontroller/index') ?>">
			<img src="<?= base_url('/assets/img/logo.png') ?>" alt="" width="150px" class="d-inline-block align-text-top">
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link <?= $title == 'Dashboard' ? 'active' : '' ?>" aria-current="page" href="<?= site_url('/admincontroller/index') ?>">Dashboard</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= $title == 'Produk' ? 'active' : '' ?>" aria-current="page" href="<?= site_url('/admincontroller/produk') ?>">Produk</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link <?= $title == 'Transaksi' ? 'active' : '' ?> dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Worklist
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="<?= site_url('admincontroller/transaksi') ?>">Transaksi</a></li>
						<li><a class="dropdown-item" href="<?= site_url('admincontroller/laporan_keuangan') ?>">Laporan Penjualan</a></li>
					</ul>
				</li>
				<?php
				if ($user['userdata']['role_id'] == 1) {
				?>
					<li class="nav-item dropdown <?= $title == 'Manajemen User' ? 'active' : '' ?>">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Manajemen User
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="<?= site_url('admincontroller/user_admin') ?>">Admin</a></li>
							<li><a class="dropdown-item" href="<?= site_url('admincontroller/user_customer') ?>">Customer</a></li>
						</ul>
					</li>
					<li class="nav-item dropdown <?= $title == 'Perusahaan' ? 'active' : '' ?>">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Perusahaan
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="<?= site_url('admincontroller/manajemen_compro') ?>">Company Profile</a></li>
							<li><a class="dropdown-item" href="<?= site_url('admincontroller/banner') ?>">Banner</a></li>
							<li><a class="dropdown-item" href="<?= site_url('admincontroller/kontak') ?>">Contact Person</a></li>
						</ul>
					</li>
				<?php } ?>
			</ul>
			<ul class="navbar-nav mb-2 mb-lg-0">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-user-circle me-1" aria-hidden="true"></i> <?= $user['userdata']['name'] ?>
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li>
							<a class="dropdown-item" href="<?= site_url('admincontroller/admin_profile/' . $user['userdata']['id']) ?>">Profile</a>
						</li>
						<!-- <li><a class="dropdown-item" href="<?= site_url('admincontroller/admin_profile') ?>">Profile</a></li> -->
						<li>
							<hr class="dropdown-divider">
						</li>
						<li><a class="dropdown-item" href="<?= site_url('authcontroller/logout') ?>">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
