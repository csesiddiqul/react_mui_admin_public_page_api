<!-- resources/views/auth/reset-password.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
<div>
    <h2>Reset Password</h2>

    <div id="status-message"></div>

    <form id="reset-password-form">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div>
            <button type="submit">Reset Password</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('reset-password-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // Get form data
        const formData = new FormData(this);

        // Send AJAX request
        fetch('{{ url("api/password.reset") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Network response was not ok.');
            })
            .then(data => {
                // Display success message or handle response
                document.getElementById('status-message').innerHTML = data.message;
            })
            .catch(error => {
                // Display error message or handle error
                document.getElementById('status-message').innerHTML = error.message;
            });
    });
</script>
</body>
</html>
