<?php

$kontak = $this->db->get('kontak_perusahaan')->result();
$compro = $this->db->get('profil_perusahaan')->row();

?>
<footer class="bg-dark text-light py-5">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h3>Kontak</h3>
				<ul>
					<?php foreach ($kontak as $key => $item) { ?>
						<li>
							<div class="my-2">
								<?= "$item->no_hp ($item->nama)" ?>
							</div>
						</li>
					<?php } ?>
				</ul>
			</div>
			<div class="col-md-6">
				<h3>Alamat</h3>
				<ul>
					<li>
						<div class="my-2">
							<?= $compro->alamat_perusahaan ?>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</footer>
