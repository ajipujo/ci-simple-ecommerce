<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
	<div class="container">
		<a class="navbar-brand" href="#">VavaPedia</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="#">Dashboard</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="#">Produk</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Transaksi
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="#">Riwayat</a></li>
						<li><a class="dropdown-item" href="#">Bukti Pembayaran</a></li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="#">Manajemen User</a>
				</li>
			</ul>
			<ul class="navbar-nav mb-2 mb-lg-0">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-user-circle me-1" aria-hidden="true"></i> <?= $user['userdata']['name'] ?>
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
						<li><a class="dropdown-item" href="#">Profile</a></li>
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
