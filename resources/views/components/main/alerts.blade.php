<script>
	const success = @json(session('success'));
	const errors = @json($errors->any());
	const errorMessages = @json($errors->all());

	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	})

	if (success) {
		Toast.fire({
			icon: 'success',
			title: success
		})
	}

	if (errors) {
		errorMessages.forEach(error => {
			Toast.fire({
				icon: 'error',
				title: error,
			});
		});
	}
</script>
