@extends('layouts.dashboard')
@section('title', 'Dokumentasi')
@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<div class="row">
						@foreach ($task->documentations as $doc)
							<a href="{{ asset('storage/dokumentasi/'.$doc->dokumentasi) }}" class="col-3 mb-3">
								<img src="{{ asset('storage/dokumentasi/'.$doc->dokumentasi) }}" alt="Dokumentasi" class="w-100 h-100 object-fit-cover rounded-3 border">
							</a>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection