<!-- resources/views/auth/forgot-password.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
<div>
    <h2>Forgot Password</h2>

    <div id="status-message"></div>

    <form id="forgot-password-form">
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div>
            <button type="submit">Send Password Reset Link</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('forgot-password-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // Get form data
        const formData = new FormData(this);

        // Send AJAX request
        fetch('{{ url("api/forgot-password") }}', {
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
