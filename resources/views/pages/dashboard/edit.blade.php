@extends('layouts.dashboard')
@section('title', 'Edit Data')
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<form action="{{ route('dashboard.update', $task->uuid) }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="mb-3">
							<label for="tanggal" class="form-label">Tanggal</label>
							<input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" value="{{ $task->tanggal }}">
							@error('tanggal')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="mb-3">
							<label for="nama_paket" class="form-label">Nama Paket</label>
							<input type="text" class="form-control @error('nama_paket') is-invalid @enderror" name="nama_paket" id="nama_paket" value="{{ $task->nama_paket }}">
							@error('nama_paket')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						{{-- <div class="mb-3">
							<label for="vendor_id" class="form-label">Vendor</label>
							<select class="form-select @error('vendor_id') is-invalid @enderror" name="vendor_id" id="vendor_id">
								<option value="" hidden>-- Pilih Vendor --</option>
								@foreach ($vendors as $vendor)
									<option value="{{ $vendor->id }}" {{ $vendor->id == $task->vendor_id ? 'selected' : '' }}>{{ $vendor->user->name }}</option>
								@endforeach
							</select>
							@error('vendor_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div> --}}
						{{-- <div class="mb-3">
							<label for="pengawas_k3" class="form-label">Pengawas K3</label>
							<input type="text" class="form-control @error('pengawas_k3') is-invalid @enderror" name="pengawas_k3" id="pengawas_k3" value="{{ $task->vendor->pengawas_k3 }}">
							@error('pengawas_k3')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div> --}}
						<div class="row">
							<div class="col-6">
								<div class="mb-3">
									<label for="target_jtm" class="form-label">Target Jaringan Tegangan Menengah (JTM)</label>
									<input type="text" class="km-per-s form-control @error('target_jtm') is-invalid @enderror" name="target_jtm" id="target_jtm" value="{{ formatKms($task->target_jtm) }}">
									@error('target_jtm')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="mb-3">
									<label for="nilai_kontrak_jtm" class="form-label">Nilai Kontrak JTM</label>
									<input type="text" class="rupiah form-control @error('nilai_kontrak_jtm') is-invalid @enderror" name="nilai_kontrak_jtm" id="nilai_kontrak_jtm" value="{{ formatRupiah($task->nilai_kontrak_jtm) }}">
									@error('nilai_kontrak_jtm')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="mb-3">
									<label for="target_jtr" class="form-label">Target Jaringan Tegangan Rendah (JTR)</label>
									<input type="text" class="km-per-s form-control @error('target_jtr') is-invalid @enderror" name="target_jtr" id="target_jtr" value="{{ formatKms($task->target_jtr) }}">
									@error('target_jtr')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="mb-3">
									<label for="nilai_kontrak_jtr" class="form-label">Nilai Kontrak JTR</label>
									<input type="text" class="rupiah form-control @error('nilai_kontrak_jtr') is-invalid @enderror" name="nilai_kontrak_jtr" id="nilai_kontrak_jtr" value="{{ formatRupiah($task->nilai_kontrak_jtr) }}">
									@error('nilai_kontrak_jtr')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="mb-3">
									<label for="target_gardu" class="form-label">Target Gardu</label>
									<input type="text" class="form-control @error('target_gardu') is-invalid @enderror" name="target_gardu" id="target_gardu" value="{{ $task->target_gardu }}">
									@error('target_gardu')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="col-6">
								<div class="mb-3">
									<label for="nilai_kontrak_gardu" class="form-label">Nilai Kontrak Gardu</label>
									<input type="text" class="rupiah form-control @error('nilai_kontrak_gardu') is-invalid @enderror" name="nilai_kontrak_gardu" id="nilai_kontrak_gardu" value="{{ formatRupiah($task->nilai_kontrak_gardu) }}">
									@error('nilai_kontrak_gardu')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label for="ongkos_angkut" class="form-label">Ongkos Angkut</label>
							<input type="text" class="rupiah form-control @error('ongkos_angkut') is-invalid @enderror" name="ongkos_angkut" id="ongkos_angkut" value="{{ formatRupiah($task->ongkos_angkut) }}">
							@error('ongkos_angkut')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="row">
							<div class="col-12 col-lg-6 mb-3">
								<label for="latitude" class="form-label">Latitude</label>
								<input type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" id="latitude" value="{{ $task->latitude }}">
								@error('latitude')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="col-12 col-lg-6 mb-3">
								<label for="longitude" class="form-label">Longitude</label>
								<input type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" id="longitude" value="{{ $task->longitude }}">
								@error('longitude')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="mb-3">
							<label for="keterangan" class="form-label">Keterangan</label>
							<input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" value="{{ $task->keterangan }}">
							@error('keterangan')
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
	<script>
		const inputs = document.querySelectorAll('.km-per-s');
		const rupiah = document.querySelectorAll('.rupiah');

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
	</script>
@endpush
