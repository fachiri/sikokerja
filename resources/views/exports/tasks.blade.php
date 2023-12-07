<table>
	<thead>
        <tr>
            <th colspan="10" style="text-align: center;">Monitoring Progres Pekerjaan Lisdes UP2K GORONTALO</th>
        </tr>
		<tr>
			<th>Nama Paket</th>
			<th>Nama Vendor</th>
			<th>JTM</th>
			<th>JTR</th>
			<th>Gardu</th>
			<th>Progres</th>
			<th>Pengawas K3</th>
			<th>Keterangan</th>
			<th>Latitude</th>
			<th>Longitude</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($tasks as $task)
			<tr>
				<td>{{ $task->nama_paket }}</td>
				<td>{{ $task->nama_user }}</td>
				<td>{{ $task->jtm }}</td>
				<td>{{ $task->jtr }}</td>
				<td>{{ $task->gardu }}</td>
				<td>{{ $task->progres }}</td>
				<td>{{ $task->pengawas_k3 }}</td>
				<td>{{ $task->keterangan }}</td>
				<td>{{ $task->latitude }}</td>
				<td>{{ $task->longitude }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
