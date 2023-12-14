@extends('layouts.dashboard')
@section('title', 'Detail Data')
@push('css')
	<link rel="stylesheet" href="{{ asset('css/extensions/filepond.css') }}">
	<link rel="stylesheet" href="{{ asset('css/extensions/filepond-plugin-image-preview.css') }}">
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<h5 class="mb-4">Pekerjaan</h5>
					<table class="table-striped table">
						<tr>
							<th>Tanggal</th>
							<td>{{ $task->tanggal }}</td>
						</tr>
						<tr>
							<th>Nama Paket</th>
							<td>{{ $task->nama_paket }}</td>
						</tr>
						<tr>
							<th>Target JTM</th>
							<td>{{ $task->target_jtm }} km/s</td>
						</tr>
						<tr>
							<th>Nilai Kontrak JTM</th>
							<td class="format-rupiah">{{ $task->nilai_kontrak_jtm }}</td>
						</tr>
						<tr>
							<th>Target JTR</th>
							<td>{{ $task->target_jtr }} km/s</td>
						</tr>
						<tr>
							<th>Nilai Kontrak JTR</th>
							<td class="format-rupiah">{{ $task->nilai_kontrak_jtr }}</td>
						</tr>
						<tr>
							<th>Target Gardu</th>
							<td>{{ $task->target_gardu }}</td>
						</tr>
						<tr>
							<th>Nilai Kontrak Gardu</th>
							<td class="format-rupiah">{{ $task->nilai_kontrak_gardu }}</td>
						</tr>
						<tr>
							<th>Ongkos Angkut</th>
							<td class="format-rupiah">{{ $task->ongkos_angkut }}</td>
						</tr>
						<tr>
							<th>Latitude</th>
							<td>{{ $task->latitude }}</td>
						</tr>
						<tr>
							<th>Longitude</th>
							<td>{{ $task->longitude }}</td>
						</tr>
						<tr>
							<th>Keterangan</th>
							<td>{{ $task->keterangan }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<h5 class="mb-4">Vendor</h5>
					<table class="table-striped table">
						<tr>
							<th>Nama Vendor</th>
							<td>{{ $task->vendor->user->name }}</td>
						</tr>
						<tr>
							<th>Pengawas K3</th>
							<td>{{ $task->vendor->pengawas_k3 }}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<h5 class="mb-4">Progres Terbaru</h5>
					<table class="table-striped table">
						<thead>
							<tr>
								<th>Jenis</th>
								<th>Progres Pekerjaan</th>
								<th>Nilai Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>JTM</td>
								<td>{{ $progress->jtm }}</td>
								<td class="format-rupiah">{{ $progress->nilai_total_rp_jtm }}</td>
							</tr>
							<tr>
								<td>JTR</td>
								<td>{{ $progress->jtr }}</td>
								<td class="format-rupiah">{{ $progress->nilai_total_rp_jtr }}</td>
							</tr>
							<tr>
								<td>Gardu</td>
								<td>{{ $progress->gardu }}</td>
								<td class="format-rupiah">{{ $progress->nilai_total_rp_gardu }}</td>
							</tr>
							<tr>
								<th>Progress Persen</th>
								<th>{{ $progress->persentase }} %</th>
								<th class="format-rupiah">{{ $progress->nilai_total_rp }}</th>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection
@push('scripts')
	<script src="{{ asset('js/extensions/simple-datatables.js') }}"></script>
	<script src="{{ asset('js/extensions/filepond-plugin-file-validate-size.min.js') }}"></script>
	<script src="{{ asset('js/extensions/filepond-plugin-file-validate-type.min.js') }}"></script>
	<script src="{{ asset('js/extensions/filepond-plugin-image-crop.min.js') }}"></script>
	<script src="{{ asset('js/extensions/filepond-plugin-image-exif-orientation.min.js') }}"></script>
	<script src="{{ asset('js/extensions/filepond-plugin-image-filter.min.js') }}"></script>
	<script src="{{ asset('js/extensions/filepond-plugin-image-preview.min.js') }}"></script>
	<script src="{{ asset('js/extensions/filepond-plugin-image-resize.min.js') }}"></script>
	<script src="{{ asset('js/extensions/filepond.js') }}"></script>
	<script src="{{ asset('js/static/add.js') }}"></script>
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
@endpush
