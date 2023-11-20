@extends('layouts.dashboard')
@section('title', 'Laporan')
@push('css')
	<link rel="stylesheet" href="{{ asset('css/extensions/simple-datatable-style.css') }}">
	<link rel="stylesheet" href="{{ asset('css/extensions/table-datatable.css') }}">
@endpush

@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 table-responsive px-4">
					<div class="mb-3">
						<a href="{{ route('dashboard.report.export') }}" class="btn btn-success">
							<i class="bi bi-printer-fill"></i>
							Download
						</a>
					</div>
					<table class="table-striped table" id="tabel-tasks">
						<thead>
							<tr>
								<th>Nama Paket</th>
								<th>Vendor</th>
								<th>JTM</th>
								<th>JTR</th>
								<th>Gardu</th>
								<th>Progres</th>
								<th>Pengawas K3</th>
								<th>Titik Koordinat</th>
								<th>Dokumentasi</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($tasks as $task)
								<tr>
									<td>{{ $task->nama_paket }}</td>
									<td>{{ $task->vendor->user->name }}</td>
									<td>{{ $task->jtm }}</td>
									<td>{{ $task->jtr }}</td>
									<td>{{ $task->gardu }}</td>
									<td>{{ $task->progres }}%</td>
									<td>{{ $task->vendor->pengawas_k3 ?? '-' }}</td>
									<td>{{ $task->latitude }}, {{ $task->longitude }}</td>
									<td>
										<a href="{{ route('dashboard.dokumentasi', $task->uuid) }}" class="btn btn-primary btn-sm m-1">
											<i class="bi bi-images"></i>
										</a>
									</td>
									<td>
										<a href="{{ route('dashboard.edit', $task->uuid) }}" class="btn btn-primary btn-sm">
											<i class="bi bi-pencil-fill"></i>
										</a>
										<form action="{{ route('dashboard.delete', $task->uuid) }}" method="POST" class="d-inline">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
												<i class="bi bi-trash-fill"></i>
											</button>
										</form>
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
	<script src="{{ asset('js/static/report.js') }}"></script>
@endpush
