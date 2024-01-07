@extends('layouts.dashboard')
@section('title', 'Update Progress')
@push('css')
	<link rel="stylesheet" href="{{ asset('css/extensions/filepond.css') }}">
	<link rel="stylesheet" href="{{ asset('css/extensions/filepond-plugin-image-preview.css') }}">
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<form action="{{ route('progress.store') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="mb-3">
							<label for="task_id" class="form-label">Pilih Paket</label>
							<select class="form-select @error('task_id') is-invalid @enderror" name="task_id" id="task_id">
								<option value="" hidden>Pilih Paket</option>
								@foreach ($tasks as $item)
										<option value="{{ $item->id }}" {{ $item->id == old('task_id') || $item->id == request('paket_id') ? 'selected' : '' }}>{{ $item->nama_paket }}</option>
								@endforeach
							</select>
							@error('task_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="row">
							<div class="col-6">
								<div class="mb-3">
									<label for="jtm" class="form-label">Jaringan Tegangan Menengah (JTM)</label>
									<input type="text" class="km-per-s form-control @error('jtm') is-invalid @enderror" name="jtm" id="jtm" value="{{ old('jtm') }}">
									@error('jtm')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="mb-3">
									<label for="target_jtm" class="form-label">Target JTM</label>
									<input type="text" class="form-control" id="target_jtm" value="{{ $task?->target_jtm ?? '0' }} kms" disabled>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="mb-3">
									<label for="jtr" class="form-label">Jaringan Tegangan Rendah (JTR)</label>
									<input type="text" class="km-per-s form-control @error('jtr') is-invalid @enderror" name="jtr" id="jtr" value="{{ old('jtr') }}">
									@error('jtr')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="mb-3">
									<label for="target_jtr" class="form-label">Target JTR</label>
									<input type="text" class="form-control" id="target_jtr" value="{{ $task?->target_jtr ?? '0' }} kms" disabled>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="mb-3">
									<label for="gardu" class="form-label">Gardu</label>
									<input type="number" class="form-control @error('gardu') is-invalid @enderror" name="gardu" id="gardu" value="{{ old('gardu') }}" step="0.1" min="0" max="{{ $task?->target_gardu }}">
									@error('gardu')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="mb-3">
									<label for="target_gardu" class="form-label">Target Gardu</label>
									<input type="text" class="form-control" id="target_gardu" value="{{ $task?->target_gardu ?? '0' }}" disabled>
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label for="dokumentasi" class="form-label">Dokumentasi</label>
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
		const inputs = document.querySelectorAll('.km-per-s');
		const rupiah = document.querySelectorAll('.rupiah');
		const task = document.getElementById('task_id')
		const route = @json(route('progress.add'));

		inputs.forEach(input => {
			input.addEventListener('input', (e) => {
				let value = e.target.value
				const cursorPosition = e.target.selectionStart;

				value = value.replace(/[^0-9.]/g, '');
				input.value = value + ' kms'

				e.target.setSelectionRange(e.target.value.length - 4, e.target.value.length - 4);
			});
		})

		rupiah.forEach(input => {
			input.addEventListener('keyup', function() {
				this.value = formatRupiah(this.value, 'Rp. ');
			});
		});

		function formatRupiah(angka, prefix) {
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
				split = number_string.split(','),
				sisa = split[0].length % 3,
				rupiah = split[0].substr(0, sisa),
				ribuan = split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if (ribuan) {
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}

		task.addEventListener('change', (e) => {
			window.location.href = `${route}?paket_id=${e.target.value}`;
		})
	</script>
@endpush
