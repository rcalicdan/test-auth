<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GuitarLyrics</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/auth.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <!-- Login Section -->
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="auth-card">
                        <h2 class="auth-title">Welcome Back</h2>

                        <!-- Session Alerts -->
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route_to('login.post') }}">
                            @csrf

                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="Enter your email address" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field with Toggle -->
                            <div class="form-group" x-data="{ showPassword: false }">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <div class="password-container">
                                    <input :type="showPassword ? 'text' : 'password'"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        name="password" placeholder="Enter your password" required>
                                    <button type="button" class="password-toggle" @click="showPassword = !showPassword"
                                        :title="showPassword ? 'Hide password' : 'Show password'">
                                        <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="forgot-password">
                                    <a href="{{ route_to('password.request') }}" class="auth-link">
                                        <i class="fas fa-key me-1"></i>Forgot Password?
                                    </a>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember"
                                    value="1">
                                <label class="form-check-label" for="remember">
                                    <i class="fas fa-heart me-1"></i>Remember me
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>

                            <!-- Footer -->
                            <div class="auth-footer">
                                <p>Don't have an account?
                                    <a href="{{ route_to('register') }}" class="auth-link">
                                        <i class="fas fa-user-plus me-1"></i>Create Account
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
