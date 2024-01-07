<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Laporan Progres Pekerjaan</title>
	</head>

	<body>
		<table>
			<thead>
				<tr>
					<th colspan="12" style="text-align: center;">Monitoring Progres Pekerjaan Lisdes UP2K GORONTALO</th>
				</tr>
				<tr>
					<th>Tanggal</th>
					<th>Nama Paket</th>
					<th>Nama Vendor</th>
					<th>Pengawas K3</th>
					<th>JTM</th>
					<th>JTR</th>
					<th>Gardu</th>
					<th>Ongkos Angkut</th>
					<th>Progres</th>
					<th>Latitude</th>
					<th>Longitude</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($tasks as $task)
					<tr>
						<td>{{ $task->tanggal }}</td>
						<td>{{ $task->nama_paket }}</td>
						<td>{{ $task->vendor->user->name }}</td>
						<td>{{ $task->vendor->pengawas_k3 }}</td>
						<td>{{ $task->target_jtm }} kms</td>
						<td>{{ $task->target_jtr }} kms</td>
						<td>{{ $task->target_gardu }}</td>
						<td class="format-rupiah">{{ $task->ongkos_angkut }}</td>
						<td>{{ $task->progress->persentase }}%</td>
						<td>{{ $task->latitude }}</td>
						<td>{{ $task->longitude }}</td>
						<td>{{ $task->keterangan }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var rupiahElements = document.querySelectorAll('.format-rupiah');

				rupiahElements.forEach(function(element) {
					var value = element.textContent.trim();
					element.textContent = formatRupiah(value, 'Rp. ');
				});

				function formatRupiah(angka, prefix) {
					var numberString = angka.replace(/[^,\d]/g, '').toString(),
						split = numberString.split(','),
						sisa = split[0].length % 3,
						rupiah = split[0].substr(0, sisa),
						ribuan = split[0].substr(sisa).match(/\d{3}/gi);

					if (ribuan) {
						separator = sisa ? '.' : '';
						rupiah += separator + ribuan.join('.');
					}

					rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
					return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
				}
			});
		</script>
	</body>

</html>
