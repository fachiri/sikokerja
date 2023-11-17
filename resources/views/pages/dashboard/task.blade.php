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
								<th>Nama Paket</th>
								<th>JTM</th>
								<th>JTR</th>
								<th>Gardu</th>
								<th>Progres</th>
								<th>Pengawas K3</th>
								<th>Titik Koordinat</th>
								<th>Keterangan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($tasks as $task)
								<tr>
									<td>{{ $task->nama_paket }}</td>
									<td>{{ $task->jtm }}</td>
									<td>{{ $task->jtr }}</td>
									<td>{{ $task->gardu }}</td>
									<td>{{ $task->progres }}%</td>
									<td>{{ $task->vendor->pengawas_k3 ?? '-' }}</td>
									<td>{{ $task->latitude }}, {{ $task->longitude }}</td>
									<td>{{ $task->keterangan }}</td>
									<td>
                    <a href="{{ route('dashboard.dokumentasi', $task->uuid) }}" class="btn btn-primary btn-sm">
											<i class="bi bi-images"></i>
										</a>
										<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $task->uuid }}">
                      <i class="bi bi-pencil-fill"></i>
                    </button>
                    <div class="modal fade" id="editModal-{{ $task->uuid }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $task->uuid }}" aria-hidden="true">
                      <div class="modal-dialog">
                        <form action="{{ route('dashboard.task.update_pengawas', $task->vendor_id) }}" method="POST" class="modal-content">
                          @csrf
                          @method('PUT')
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editModalLabel-{{ $task->uuid }}">Edit Pengawas {{ $task->name }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="mb-3">
                              <label for="pengawas_k3-{{ $task->uuid }}" class="form-label">Pengawas K3</label>
                              <input type="text" class="form-control @error('pengawas_k3') is-invalid @enderror" name="pengawas_k3" id="pengawas_k3-{{ $task->uuid }}" value="{{ $task->vendor->pengawas_k3 }}">
                              @error('pengawas_k3')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </form>
                      </div>
                    </div>
                    <a href="{{ route('dashboard.task.progres', $task->uuid) }}" class="btn btn-primary btn-sm">
                      <i class="bi bi-ui-checks"></i>
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
