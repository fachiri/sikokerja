@extends('layouts.dashboard')
@section('title', 'Pengguna')
@push('css')
	<link rel="stylesheet" href="{{ asset('css/extensions/simple-datatable-style.css') }}">
	<link rel="stylesheet" href="{{ asset('css/extensions/table-datatable.css') }}">
@endpush

@section('content')
	<section class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-4-5 px-4">
					<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
						Tambah Pengguna
					</button>
					<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form action="{{ route('dashboard.users.store') }}" method="POST" class="modal-content">
								@csrf
								<div class="modal-header">
									<h1 class="modal-title fs-5" id="addModalLabel">Tambah Pengguna</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<div class="mb-3">
										<label for="role" class="form-label">Role</label>
										<select name="role" id="role" class="form-select @error('role') is-invalid @enderror"">
												<option value="" hidden>-- Pilih Role --</option>
											@foreach ($roles as $role)
												<option value="{{ $role->role }}" {{ $role->role == old('role') ? 'selected' : '' }}>{{ $role->role }}</option>
											@endforeach
										</select>
										@error('role')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									<div class="mb-3">
										<label for="name" class="form-label">Nama</label>
										<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
										@error('name')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									<div class="mb-3">
										<label for="username" class="form-label">Username</label>
										<input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{ old('username') }}">
										@error('username')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									<div class="mb-3">
										<label for="email" class="form-label">Email</label>
										<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}">
										@error('email')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									<div>
										<label for="no_telp" class="form-label">No. Telpon</label>
										<input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" id="no_telp" value="{{ old('no_telp') }}">
										@error('no_telp')
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
					<div class="table-responsive">
						<table class="table-striped table" id="tabel-users">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama</th>
									<th>Username</th>
									<th>Email</th>
									<th>No. Telpon</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($users as $user)
									<tr>
										<td>
											@switch($user->role)
												@case('ADMIN')
													<small class="badge text-bg-primary">{{ $user->role }}</small>
												@break
	
												@case('PENGAWAS')
													<small class="badge text-bg-secondary">{{ $user->role }}</small>
												@break
	
												@default
													<small class="badge text-bg-light">{{ $user->role }}</small>
											@endswitch
										</td>
										<td>{{ $user->name }}</td>
										<td>{{ $user->username }}</td>
										<td>{{ $user->email }}</td>
										<td>{{ $user->no_telp }}</td>
										<td>
											{{-- <a href="{{ route('dashboard.edit', $user->uuid) }}" class="btn btn-primary btn-sm">
												<i class="bi bi-pencil-fill"></i>
											</a> --}}
											<!-- Button trigger modal -->
											<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $user->uuid }}">
												<i class="bi bi-pencil-fill"></i>
											</button>
											<div class="modal fade" id="editModal-{{ $user->uuid }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $user->uuid }}" aria-hidden="true">
												<div class="modal-dialog">
													<form action="{{ route('dashboard.users.update', $user->uuid) }}" method="POST" class="modal-content">
														@csrf
														@method('PUT')
														<div class="modal-header">
															<h1 class="modal-title fs-5" id="editModalLabel-{{ $user->uuid }}">Edit Data {{ $user->name }}</h1>
															<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
														</div>
														<div class="modal-body">
															<div class="mb-3">
																<label for="role-{{ $user->uuid }}" class="form-label">Role</label>
																<select name="role" id="role-{{ $user->uuid }}" class="form-select">
																	@foreach ($roles as $role)
																		<option value="{{ $role->role }}" {{ $role->role == $user->role ? 'selected' : '' }}>{{ $role->role }}</option>
																	@endforeach
																</select>
																@error('role')
																	<div class="invalid-feedback">{{ $message }}</div>
																@enderror
															</div>
															<div class="mb-3">
																<label for="name-{{ $user->uuid }}" class="form-label">Nama</label>
																<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name-{{ $user->uuid }}" value="{{ $user->name }}">
																@error('name')
																	<div class="invalid-feedback">{{ $message }}</div>
																@enderror
															</div>
															<div class="mb-3">
																<label for="username-{{ $user->uuid }}" class="form-label">Username</label>
																<input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username-{{ $user->uuid }}" value="{{ $user->username }}">
																@error('username')
																	<div class="invalid-feedback">{{ $message }}</div>
																@enderror
															</div>
															<div class="mb-3">
																<label for="email-{{ $user->uuid }}" class="form-label">Email</label>
																<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email-{{ $user->uuid }}" value="{{ $user->email }}">
																@error('email')
																	<div class="invalid-feedback">{{ $message }}</div>
																@enderror
															</div>
															<div>
																<label for="no_telp-{{ $user->uuid }}" class="form-label">No. Telpon</label>
																<input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" id="no_telp-{{ $user->uuid }}" value="{{ $user->no_telp }}">
																@error('no_telp')
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
											{{-- <form action="{{ route('dashboard.delete', $user->uuid) }}" method="POST" class="d-inline">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
													<i class="bi bi-trash-fill"></i>
												</button>
											</form> --}}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@push('scripts')
	<script src="{{ asset('js/extensions/simple-datatables.js') }}"></script>
	<script>
		let dataTable = new simpleDatatables.DataTable(
			document.getElementById("tabel-users")
		)

		function adaptPageDropdown() {
			const selector = dataTable.wrapper.querySelector(".dataTable-selector")
			selector.parentNode.parentNode.insertBefore(selector, selector.parentNode)
			selector.classList.add("form-select")
		}

		function adaptPagination() {
			const paginations = dataTable.wrapper.querySelectorAll(
				"ul.dataTable-pagination-list"
			)

			for (const pagination of paginations) {
				pagination.classList.add(...["pagination", "pagination-primary"])
			}

			const paginationLis = dataTable.wrapper.querySelectorAll(
				"ul.dataTable-pagination-list li"
			)

			for (const paginationLi of paginationLis) {
				paginationLi.classList.add("page-item")
			}

			const paginationLinks = dataTable.wrapper.querySelectorAll(
				"ul.dataTable-pagination-list li a"
			)

			for (const paginationLink of paginationLinks) {
				paginationLink.classList.add("page-link")
			}
		}

		const refreshPagination = () => {
			adaptPagination()
		}

		dataTable.on("datatable.init", () => {
			adaptPageDropdown()
			refreshPagination()
		})
		dataTable.on("datatable.update", refreshPagination)
		dataTable.on("datatable.sort", refreshPagination)

		dataTable.on("datatable.page", adaptPagination)
	</script>
@endpush
