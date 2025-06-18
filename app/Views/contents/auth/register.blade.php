<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - GuitarLyrics</title>

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
    <!-- Register Section -->
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="auth-card register-card">
                        <h2 class="auth-title register-title">Create Your Account</h2>

                        <form method="POST" action="{{ route_to('register.post') }}" x-data="{ showPassword: false, showConfirmPassword: false }">
                            @csrf

                            <!-- First Name Field -->
                            <div class="form-group">
                                <label for="first_name" class="form-label">
                                    <i class="fas fa-user me-2"></i>First Name
                                </label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                    id="first_name" name="first_name" placeholder="Enter your first name"
                                    value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Last Name Field -->
                            <div class="form-group">
                                <label for="last_name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Last Name
                                </label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                    id="last_name" name="last_name" placeholder="Enter your last name"
                                    value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Enter your email address"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field with Toggle -->
                            <div class="form-group">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <div class="password-container">
                                    <input :type="showPassword ? 'text' : 'password'"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        name="password" value="{{ old('password') }}"
                                        placeholder="Create a strong password" required>
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
                            </div>

                            <!-- Confirm Password Field with Toggle -->
                            <div class="form-group">
                                <label for="confirm-password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Confirm Password
                                </label>
                                <div class="password-container">
                                    <input :type="showConfirmPassword ? 'text' : 'password'"
                                        class="form-control @error('confirm_password') is-invalid @enderror"
                                        id="confirm-password" name="confirm_password"
                                        value="{{ old('confirm_password') }}" placeholder="Confirm your password"
                                        required>
                                    <button type="button" class="password-toggle"
                                        @click="showConfirmPassword = !showConfirmPassword"
                                        :title="showConfirmPassword ? 'Hide password' : 'Show password'">
                                        <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
                                </div>
                                @error('confirm_password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-rocket me-2"></i>Create Account
                            </button>

                            <!-- Footer -->
                            <div class="auth-footer">
                                <p>Already have an account?
                                    <a href="{{ route_to('login') }}" class="auth-link">
                                        <i class="fas fa-sign-in-alt me-1"></i>Sign In Here
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
