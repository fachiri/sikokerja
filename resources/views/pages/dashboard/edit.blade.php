@extends('layouts.dashboard')
@section('title', 'Edit Data')
@push('css')
	<link rel="stylesheet" href="{{ asset('css/extensions/filepond.css') }}">
	<link rel="stylesheet" href="{{ asset('css/extensions/filepond-plugin-image-preview.css') }}">
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<form action="{{ route('dashboard.update', $task->uuid) }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="mb-3">
							<label for="nama_paket" class="form-label">Nama Paket</label>
							<input type="text" class="form-control @error('nama_paket') is-invalid @enderror" name="nama_paket" id="nama_paket" value="{{ $task->nama_paket }}">
							@error('nama_paket')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="vendor" class="form-label">Vendor</label>
							<input type="text" class="form-control @error('vendor') is-invalid @enderror" name="vendor" id="vendor" value="{{ $task->vendor }}">
							@error('vendor')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="jtm" class="form-label">Jaringan Tegangan Menengah (JTM)</label>
							<input type="number" class="form-control @error('jtm') is-invalid @enderror" name="jtm" id="jtm" value="{{ $task->jtm }}">
							@error('jtm')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="jtr" class="form-label">Jaringan Tegangan Rendah (JTR)</label>
							<input type="number" class="form-control @error('jtr') is-invalid @enderror" name="jtr" id="jtr" value="{{ $task->jtr }}">
							@error('jtr')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="gardu" class="form-label">Gardu</label>
							<input type="text" class="form-control @error('gardu') is-invalid @enderror" name="gardu" id="gardu" value="{{ $task->gardu }}">
							@error('gardu')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="progres" class="form-label">Progres</label>
							<div class="input-group">
								<input type="number" class="form-control @error('progres') is-invalid @enderror" name="progres" id="progres" value="{{ $task->progres }}">
								<span class="input-group-text">%</span>
							</div>
							@error('progres')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="pengawas_k3" class="form-label">Pengawas K3</label>
							<input type="text" class="form-control @error('pengawas_k3') is-invalid @enderror" name="pengawas_k3" id="pengawas_k3" value="{{ $task->pengawas_k3 }}">
							@error('pengawas_k3')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="koordinat" class="form-label">Titik Koordinat</label>
							<input type="text" class="form-control @error('koordinat') is-invalid @enderror" name="koordinat" id="koordinat" value="{{ $task->koordinat }}">
							@error('koordinat')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="dokumentasi" class="form-label"><a href="{{ route('dashboard.dokumentasi', $task->uuid) }}">Dokumentasi</a> <small>(opsional)</small></label>
							<input type="file" class="multiple-files-filepond  @error('dokumentasi') is-invalid @enderror" name="dokumentasi[]" multiple>
							@error('dokumentasi')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="pt-3">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
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
@endpush
