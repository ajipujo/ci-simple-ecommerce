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
<span class="text-center">Periode : <b><?= $startDate ?></b> s/d <b><?= $endDate ?></b></span>
<hr>
<div>
	<table>
		<tbody>
			<tr>
				<th>No</th>
				<th>Kode Pemesanan</th>
				<th>Tanggal Transaksi</th>
				<th>Nama Customer</th>
				<th>Nama Produk</th>
				<th>Nama Varian</th>
				<th>Harga</th>
				<th>Qty</th>
				<th>Subtotal</th>
				<th>Status Transaksi</th>
			</tr>
			<?php foreach ($store as $key => $item) { ?>
				<tr>
					<td><?= $key + 1 ?></td>
					<td><?= $item->kode_pemesanan ?></td>
					<td><?= $item->tanggal_transaksi ?></td>
					<td><?= $item->user_name ?></td>
					<td><?= $item->product_name ?></td>
					<td><?= $item->product_type_name ?></td>
					<td><?= "Rp " . number_format($item->product_price, 0, ',', '.') ?></td>
					<td><?= $item->qty ?></td>
					<td><?= "Rp " . number_format($item->product_price * $item->qty, 0, ',', '.') ?></td>
					<td><?= $item->status_name ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
