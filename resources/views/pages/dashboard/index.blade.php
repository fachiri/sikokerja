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
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>First</th>
								<th>Last</th>
								<th>Handle</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Mark</td>
								<td>Otto</td>
								<td>@mdo</td>
							</tr>
							<tr>
								<th scope="row">2</th>
								<td>Jacob</td>
								<td>Thornton</td>
								<td>@fat</td>
							</tr>
							<tr>
								<th scope="row">3</th>
								<td colspan="2">Larry the Bird</td>
								<td>@twitter</td>
							</tr>
							<tr>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection
@push('scripts')
	<script src="{{ asset('js/extensions/apexcharts.min.js') }}"></script>
	<script></script>
@endpush
