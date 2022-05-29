<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
	<div class="container">
		<a class="navbar-brand fw-bold text-success" href="<?= site_url('/') ?>">VavaPedia</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
			</ul>
			<?php if ($user && $user['userdata']['role_id'] == 3) { ?>
				<ul class="navbar-nav mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="#">
							<span class="badge bg-secondary">
								<i class="fa fa-shopping-cart me-2" aria-hidden="true"></i>
								<span id="cartCounter">99+</span>
							</span>
						</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-user-circle me-1" aria-hidden="true"></i> <?= $user['userdata']['name'] ?>
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<li>
								<a href="<?= site_url('/frontcontroller/customer_profile/'.$user['userdata']['id']) ?>" class="dropdown-item">Profile</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item" href="<?= site_url('authcontroller/logout') ?>">Logout</a></li>
						</ul>
					</li>
				</ul>
			<?php } else { ?>
				<a href="<?= site_url('/authcontroller/login') ?>" class="btn btn-outline-secondary me-2">Login</a>
				<a href="<?= site_url('/authcontroller/register') ?>" class="btn btn-outline-secondary">Register</a>
			<?php } ?>
		</div>
	</div>
</nav>

<script>
	let cart = [];
	
	function refreshCart() {
		if (localStorage.getItem('cart') !== null) {
			cart = JSON.parse(localStorage.getItem('cart'));
		}

		$('#cartCounter').text(cart.length);
	}
	
	$(document).ready(function() {
		refreshCart();
	});
</script>
