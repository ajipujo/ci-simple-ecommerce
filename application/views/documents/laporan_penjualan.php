<style>
	table {
		border-collapse: collapse;
		width: 100%;
		margin-top: 20px;
		margin-bottom: 20px;
	}

	table,
	th,
	td {
		border: 1px solid;
	}
</style>

<h1 class="text-center">Laporan Penjualan</h1>
<hr>
<?php foreach ($store as $key => $item) { ?>
	<div>
		<div>
			Kode Pemesanan : <?= $item->kode_pemesanan ?>
		</div>
		<div>
			Tanggal Transaksi : <?= $item->tanggal_transaksi ?>
		</div>
		<div>
			Status Transaksi : <b><?= $item->status_name ?></b>
		</div>
		<div>
			Nama Customer : <?= $item->user_name ?>
		</div>
		<table>
			<tbody>
				<tr>
					<th>No</th>
					<th>Nama Produk</th>
					<th>Nama Varian</th>
					<th>Harga</th>
					<th>Qty</th>
					<th>Subtotal</th>
				</tr>
				<?php
				$total = 0;

				foreach ($item->detail as $key2 => $item2) {
				?>
					<tr>
						<td><?= $key2 + 1 ?></td>
						<td><?= $item2->product_name ?></td>
						<td><?= $item2->product_type_name ?></td>
						<td><?= "Rp " . number_format($item2->product_price, 0, ',', '.') ?></td>
						<td><?= $item2->qty ?></td>
						<td><?= "Rp " . number_format($item2->product_price * $item2->qty, 0, ',', '.') ?></td>
					</tr>
				<?php
					$total += $item2->product_price * $item2->qty;
				}
				?>
				<tr>
					<td colspan="5">
						<b>Total</b>
					</td>
					<td><?= "Rp " . number_format($total, 0, ',', '.') ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<hr>
<?php } ?>
