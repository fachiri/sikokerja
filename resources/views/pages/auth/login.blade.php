@extends('layouts.auth')
@section('title', 'Login')
@section('content')
	<h1>Login Sikokerja</h1>
	<p class="auth-subtitle mb-5">Sistem Informasi Koordinator Pekerja.</p>
	<form action="{{ route('auth.login') }}" method="POST">
    @csrf
		<div class="form-group position-relative has-icon-left mb-4">
			<input type="text" name="username" class="form-control form-control-xl @error('username') border-danger @enderror" placeholder="Username">
			<div class="form-control-icon">
				<i class="bi bi-person"></i>
			</div>
		</div>
		<div class="form-group position-relative has-icon-left mb-4">
			<input type="password" name="password" class="form-control form-control-xl @error('password') border-danger @enderror" placeholder="Password">
			<div class="form-control-icon">
				<i class="bi bi-shield-lock"></i>
			</div>
		</div>
		<button class="btn btn-primary btn-block btn-lg mt-5 shadow-lg">Login</button>
	</form>
@endsection
