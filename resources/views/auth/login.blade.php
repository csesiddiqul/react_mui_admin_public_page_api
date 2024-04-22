<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Include CSRF token -->
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form id="loginForm">
                        @csrf <!-- Add CSRF token field -->

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                            </div>
                        </div>


                        <div style="margin-top: 10px; margin-bottom: 10px" >
                            <a href="{{url('api/forgot-password')}}" class="btn btn-link">{{ __('Forgot Your Password?') }}</a> <br>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        var formData = new FormData(this); // Get form data
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Get CSRF token value

        fetch("{{ url('api/login') }}", { // Make a fetch request to the login route
            method: 'POST',
            headers: {
                'Accept': 'application/json', // Set the Accept header to application/json
                'X-CSRF-TOKEN': csrfToken // Pass CSRF token in headers
            },
            body: formData // Pass form data as the request body
        })
            .then(response => response.json()) // Parse response as JSON
            .then(data => {
                console.log(data); // Log response data
                // Handle response as needed (e.g., redirect, display messages)
            })
            .catch(error => console.error('Error:', error)); // Log any errors
    });
</script>
</body>
</html>
