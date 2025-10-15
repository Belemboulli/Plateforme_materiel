@extends('layouts.public')

@section('content')
<div class="login-container">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6 col-lg-5 col-xl-4">

                <!-- Logo/Brand Section -->
                <div class="text-center mb-4">
                    <div class="logo-wrapper">
                        <div class="logo-circle">
                            <img src="/images/university-logo.png" alt="Logo UTS" class="custom-logo">
                        </div>
                    </div>
                    <h1 class="brand-title">UTS</h1>
                    <h2 class="page-title">Connexion</h2>
                    <p class="page-subtitle">Accédez à votre espace personnel</p>
                </div>

                <!-- Login Card -->
                <div class="login-card">
                    <div class="card-body">

                        <!-- Error Message -->
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Adresse email
                                </label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="votre@email.com"
                                       required
                                       autofocus>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Mot de passe
                                </label>
                                <div class="password-wrapper">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="••••••••"
                                           required>
                                    <button type="button" class="password-toggle" id="togglePassword">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="form-options">
                                <div class="form-check">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           id="remember"
                                           name="remember"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Se souvenir de moi
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="forgot-link">
                                    Mot de passe oublié ?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Se connecter
                            </button>

                            <!-- Register Link -->
                            <div class="register-section">
                                <p>Pas encore de compte ?</p>
                                <a href="{{ route('register') }}" class="btn-register">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Créer un compte
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <div class="login-footer">
                    <p>&copy; {{ date('Y') }} UTS. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/*
IMPORTANT: Pour ajouter votre image d'arrière-plan, remplacez cette ligne :
background-image: url('chemin/vers/votre/image.jpg');
*/
.login-container {
    /* Remplacez 'votre-image.jpg' par le chemin de votre image */
    background-image: linear-gradient(rgba(255, 193, 7, 0.8), rgba(40, 167, 69, 0.8)),
                      url('/images/Materiel2.png');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    min-height: 100vh;
    position: relative;
}

/* Logo et branding */
.logo-wrapper {
    margin-bottom: 1rem;
}

.logo-circle {
    width: 90px;
    height: 90px;
    background: linear-gradient(135deg, #ffc107, #ff8f00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
    overflow: hidden;
    position: relative;
}

.custom-logo {
    width: 85px;
    height: 85px;
    object-fit: cover;
    border-radius: 50%;
    animation: rotate 15s linear infinite;
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.brand-title {
    font-size: 2.2rem;
    font-weight: 900;
    color: #fff; /* blanc pur */
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    margin: 1rem 0 0.5rem;
    letter-spacing: 2px;
}

.page-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #fff;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: rgba(255, 255, 255, 0.9);
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    margin-bottom: 0;
}

/* Card de connexion */
.login-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.card-body {
    padding: 2rem;
}

/* Form styling */
.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.form-control {
    height: 45px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

/* Password field avec toggle */
.password-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    z-index: 10;
}

.password-toggle:hover {
    color: #ffc107;
}

/* Options du formulaire */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.form-check-input:checked {
    background-color: #ffc107;
    border-color: #ffc107;
}

.forgot-link {
    color: #28a745;
    text-decoration: none;
    font-weight: 500;
}

.forgot-link:hover {
    color: #1e7e34;
}

/* Boutons */
.btn-login {
    width: 100%;
    height: 45px;
    background: linear-gradient(135deg, #ffc107, #ff8f00);
    border: none;
    border-radius: 8px;
    color: #000;
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4);
}

.register-section {
    text-align: center;
    border-top: 1px solid #e9ecef;
    padding-top: 1.5rem;
}

.register-section p {
    margin-bottom: 1rem;
    color: #666;
}

.btn-register {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
}

.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    color: white;
}

/* Alerts */
.alert {
    border: none;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.alert-danger {
    background-color: rgba(220, 53, 69, 0.1);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.alert-success {
    background-color: rgba(40, 167, 69, 0.1);
    color: #155724;
    border-left: 4px solid #28a745;
}

/* Footer */
.login-footer {
    text-align: center;
    color: rgba(255, 255, 255, 0.8);
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .login-container {
        background-attachment: scroll;
        padding: 1rem;
    }

    .brand-title {
        font-size: 1.8rem;
    }

    .page-title {
        font-size: 1.4rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .form-options {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .logo-circle {
        width: 80px;
        height: 80px;
    }

    .custom-logo {
        width: 75px;
        height: 75px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    }
});
</script>
@endsection
