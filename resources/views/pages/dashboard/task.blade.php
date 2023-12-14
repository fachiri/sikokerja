@extends('layouts.dashboard')
@section('title', 'Pekerjaan')
@push('css')
	<link rel="stylesheet" href="{{ asset('css/extensions/simple-datatable-style.css') }}">
	<link rel="stylesheet" href="{{ asset('css/extensions/table-datatable.css') }}">
	<link rel="stylesheet" href="{{ asset('css/extensions/filepond.css') }}">
	<link rel="stylesheet" href="{{ asset('css/extensions/filepond-plugin-image-preview.css') }}">
@endpush

@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 table-responsive px-4">
					<table class="table-striped table" id="tabel-tasks">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Nama Paket</th>
								<th>Target JTM</th>
								<th>Target JTR</th>
								<th>Target Gardu</th>
								<th>Progres</th>
								<th>Pengawas K3</th>
								<th>Titik Koordinat</th>
								<th>Keterangan</th>
								<th>Dokumentasi</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($tasks as $task)
								<tr>
									<td>{{ $task->tanggal }}</td>
									<td>{{ $task->nama_paket }}</td>
									<td>{{ $task->target_jtm }}</td>
									<td>{{ $task->target_jtr }}</td>
									<td>{{ $task->target_gardu }}</td>
									<td>{{ $task->progress->persentase }}%</td>
									<td>{{ $task->vendor->pengawas_k3 ?? '-' }}</td>
									<td>{{ $task->latitude }}, {{ $task->longitude }}</td>
									<td>{{ $task->keterangan }}</td>
									<td>
										<a href="{{ route('dashboard.dokumentasi', $task->uuid) }}" class="btn btn-primary btn-sm me-1">
											<i class="bi bi-images"></i>
										</a>
									</td>
									<td style="white-space: nowrap">
										<a href="{{ route('dashboard.detail', $task->uuid) }}" class="btn btn-primary btn-sm">
											<i class="bi bi-list-ul"></i>
										</a>
									</td>
								</tr>
							@endforeach
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
	<script src="{{ asset('js/static/report.js') }}"></script>
	<script src="{{ asset('js/static/add.js') }}"></script>
@endpush
