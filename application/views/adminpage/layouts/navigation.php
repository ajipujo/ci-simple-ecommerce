<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
	<div class="container">
		<a class="navbar-brand fw-bold text-success" href="<?= site_url('admincontroller/index') ?>">VavaPedia</a>
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
				<li class="nav-item dropdown <?= $title == 'Transaksi' ? 'active' : '' ?>">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Transaksi
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="#">Riwayat</a></li>
						<li><a class="dropdown-item" href="#">Bukti Pembayaran</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown <?= $title == 'Manajemen User' ? 'active' : '' ?>">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Manajemen User
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="<?= site_url('admincontroller/user_admin') ?>">Admin</a></li>
						<li><a class="dropdown-item" href="<?= site_url('admincontroller/user_customer') ?>">Customer</a></li>
					</ul>
				</li>
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
