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
					<form action="{{ route('dashboard.report') }}" method="get">
						<div class="row">
							<div class="col-6 mb-3">
								<label for="tanggal" class="form-label">Tanggal</label>
								<input type="date" class="form-control" name="tanggal" id="tanggal" value="{{ request('tanggal') }}">
							</div>
							<div class="col-6 mb-3">
								<label for="vendor_id" class="form-label">Paket</label>
								<select class="form-select @error('vendor_id') is-invalid @enderror" name="vendor_id" id="vendor_id">
									<option value="" hidden>Pilih Vendor</option>
									@foreach ($vendors as $item)
										<option value="{{ $item->id }}" {{ $item->id == request('vendor_id') ? 'selected' : '' }}>{{ $item->user->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-8 mb-3">
								<button type="submit" class="btn btn-primary w-100">
									<i class="bi bi-funnel-fill"></i>
									Filter
								</button>
							</div>
							<div class="col-4 mb-3">
								<a href="{{ route('dashboard.report.export', request()->all()) }}" class="btn btn-success w-100">
									<i class="bi bi-printer-fill"></i>
									Download
								</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 table-responsive px-4">
					<table class="table-striped table" id="tabel-tasks">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Nama Paket</th>
								<th>Vendor</th>
								<th>Target JTM</th>
								<th>Target JTR</th>
								<th>Target Gardu</th>
								<th>Progres</th>
								<th>Pengawas K3</th>
								<th>Titik Koordinat</th>
								<th>Keterangan</th>
								<th>Dokumentasi</th>
								@if (auth()->user()->role == 'ADMIN')
									<th>Aksi</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@foreach ($tasks as $task)
								<tr>
									<td>{{ $task->tanggal }}</td>
									<td>{{ $task->nama_paket }}</td>
									<td>{{ $task->vendor->user->name }}</td>
									<td>{{ $task->target_jtm }} kms</td>
									<td>{{ $task->target_jtr }} kms</td>
									<td>{{ $task->target_gardu }}</td>
									<td>{{ $task->progress->persentase }}%</td>
									<td>{{ $task->vendor->pengawas_k3 ?? '-' }}</td>
									<td>{{ $task->latitude }}, {{ $task->longitude }}</td>
									<td>{{ $task->keterangan }}</td>
									<td>
										<a href="{{ route('dashboard.dokumentasi', $task->uuid) }}" class="btn btn-primary btn-sm m-1">
											<i class="bi bi-images"></i>
										</a>
									</td>
									@if (auth()->user()->role == 'ADMIN')
										<td style="white-space: nowrap">
											<a href="{{ route('dashboard.detail', $task->uuid) }}" class="btn btn-primary btn-sm">
												<i class="bi bi-list-ul"></i>
											</a>
											<a href="{{ route('dashboard.edit', $task->uuid) }}" class="btn btn-warning btn-sm">
												<i class="bi bi-pencil-square"></i>
											</a>
											<form action="{{ route('dashboard.delete', $task->uuid) }}" method="POST" class="d-inline">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
													<i class="bi bi-trash-fill"></i>
												</button>
											</form>
										</td>
									@endif
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
