@extends('layouts.dashboard')
@section('title', 'Edit Progres')
@push('css')
	<link rel="stylesheet" href="{{ asset('css/extensions/filepond.css') }}">
	<link rel="stylesheet" href="{{ asset('css/extensions/filepond-plugin-image-preview.css') }}">
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<form action="{{ route('dashboard.task.update_progress', $task->uuid) }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')
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
							<label for="dokumentasi" class="form-label"><a href="{{ route('dashboard.dokumentasi', $task->uuid) }}">Dokumentasi</a></label>
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
