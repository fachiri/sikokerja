@extends('layouts.dashboard')
@section('title', 'Dashboard')
@push('css')
	<link rel="stylesheet" href="{{ asset('css/iconly.css') }}">
@endpush
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<h5 class="mb-4">Anda login sebagai</h5>
					<div class="d-flex align-items-center">
						<div class="avatar avatar-xl">
							<img src="{{ asset('images/default.jpg') }}">
						</div>
						<div class="name ms-3">
							<h5 class="font-bold">{{ auth()->user()->name }}</h5>
							<h6 class="text-muted mb-0">{{ auth()->user()->email }}</h6>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<h5 class="mb-4">Daftar Pekerjaan</h5>
					<table class="table">
						<thead>
							<tr>
								<th>No.</th>
								<th>Nama Paket</th>
								<th>Progres</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($tasks as $task)
								<tr>
									<th>{{ $loop->iteration }}</th>
									<td>{{ $task->nama_paket }}</td>
									<td>{{ $task->progress->persentase }}%</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<h5 class="mb-4">Daftar Vendor</h5>
					<table class="table">
						<thead>
							<tr>
								<th>No.</th>
								<th>Vendor</th>
								<th>Pengawas K3</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($vendors as $vendor)
								<tr>
									<th>{{ $loop->iteration }}</th>
									<td>{{ $vendor->user->name }}</td>
									<td>{{ $vendor->pengawas_k3 }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<h5 class="mb-4">Kurva</h5>
					<div id="line"></div>
				</div>
			</div>
		</div>
	</section>
@endsection
@push('scripts')
	<script src="{{ asset('js/extensions/apexcharts.min.js') }}"></script>
	<script>
		const graph = @json($graph);

		const lineOptions = {
			chart: {
				type: "line",
			},
			series: graph.series,
			xaxis: {
				categories: graph.categories,
			},
		}

		const line = new ApexCharts(document.querySelector("#line"), lineOptions)
		line.render()
	</script>
@endpush
