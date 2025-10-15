<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Plateforme</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #f59e0b;
            --primary-dark: #d97706;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --background-gradient: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
        }

        body {
            background: var(--background-gradient);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 1rem;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 60px rgba(0, 0, 0, 0.2);
        }

        .auth-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }

        .auth-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
            z-index: 1;
        }

        .auth-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
            position: relative;
            z-index: 1;
        }

        .auth-subtitle {
            opacity: 0.9;
            font-size: 0.95rem;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .auth-body {
            padding: 2.5rem 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: var(--primary-color);
            width: 16px;
            text-align: center;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--secondary-color);
            cursor: pointer;
            padding: 0.25rem;
            transition: color 0.3s ease;
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .password-strength {
            margin-top: 0.5rem;
            padding: 0.5rem;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .strength-bar {
            height: 4px;
            border-radius: 2px;
            background: #e2e8f0;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .strength-fill {
            height: 100%;
            transition: width 0.3s ease, background-color 0.3s ease;
            border-radius: 2px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.025em;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
            background: linear-gradient(135deg, var(--primary-dark), #b45309);
        }

        .auth-footer {
            text-align: center;
            padding: 1.5rem 2rem 2rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .auth-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .success-message {
            color: var(--success-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 576px) {
            .auth-container {
                padding: 1rem;
            }

            .auth-header {
                padding: 2rem 1.5rem 1.5rem;
            }

            .auth-body {
                padding: 2rem 1.5rem;
            }

            .auth-title {
                font-size: 1.5rem;
            }
        }

        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 40px;
            height: 40px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(120deg); }
            66% { transform: translateY(10px) rotate(240deg); }
        }
    </style>
</head>
<body>
    <!-- Floating Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="auth-container">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="auth-icon">
                    <i class="fas fa-user-plus fa-2x"></i>
                </div>
                <h1 class="auth-title">Créer un compte</h1>
                <p class="auth-subtitle">Rejoignez notre plateforme dès aujourd'hui</p>
            </div>

            <!-- Form Body -->
            <div class="auth-body">
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <!-- Success Message -->
                    <div class="alert alert-success d-none" id="successMessage">
                        <i class="fas fa-check-circle me-2"></i>
                        <span>Inscription réussie ! Redirection en cours...</span>
                    </div>

                    <!-- Loading State -->
                    <div class="text-center d-none" id="loadingState">
                        <div class="spinner-border text-warning mb-3" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                        <p class="text-muted">Création de votre compte en cours...</p>
                    </div>

                    <div id="formContent">
                        <!-- Nom complet -->
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-user"></i>
                                Nom complet
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Entrez votre nom complet"
                                value="{{ old('name') }}"
                                required
                                autocomplete="name"
                            >
                            @error('name')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="error-message d-none" id="name-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i>
                                Adresse email
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="votre@email.com"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                            >
                            @error('email')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="error-message d-none" id="email-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>

                        <!-- Mot de passe -->
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i>
                                Mot de passe
                            </label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Créez un mot de passe sécurisé"
                                    required
                                    autocomplete="new-password"
                                >
                                <button type="button" class="password-toggle" id="passwordToggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength d-none" id="passwordStrength">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <small class="strength-text" id="strengthText">Saisissez votre mot de passe</small>
                            </div>
                            @error('password')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="error-message d-none" id="password-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                        </div>

                        <!-- Confirmation mot de passe -->
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock"></i>
                                Confirmer le mot de passe
                            </label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    placeholder="Confirmez votre mot de passe"
                                    required
                                    autocomplete="new-password"
                                >
                                <button type="button" class="password-toggle" id="confirmPasswordToggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="error-message d-none" id="confirmation-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span></span>
                            </div>
                            <div class="success-message d-none" id="confirmation-success">
                                <i class="fas fa-check-circle"></i>
                                <span>Les mots de passe correspondent</span>
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                <i class="fas fa-user-plus me-2"></i>
                                <span id="submitText">Créer mon compte</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <p class="mb-0">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="auth-link">Se connecter</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password visibility toggles
        function setupPasswordToggle(inputId, toggleId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(toggleId);

            toggle.addEventListener('click', function() {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);

                const icon = toggle.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }

        setupPasswordToggle('password', 'passwordToggle');
        setupPasswordToggle('password_confirmation', 'confirmPasswordToggle');

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthDiv = document.getElementById('passwordStrength');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');

        function checkPasswordStrength(password) {
            let score = 0;
            let feedback = [];

            if (password.length >= 8) score += 1;
            else feedback.push('Au moins 8 caractères');

            if (/[a-z]/.test(password)) score += 1;
            else feedback.push('Une minuscule');

            if (/[A-Z]/.test(password)) score += 1;
            else feedback.push('Une majuscule');

            if (/[0-9]/.test(password)) score += 1;
            else feedback.push('Un chiffre');

            if (/[^a-zA-Z0-9]/.test(password)) score += 1;
            else feedback.push('Un caractère spécial');

            const strength = ['Très faible', 'Faible', 'Moyen', 'Fort', 'Très fort'][score];
            const colors = ['#ef4444', '#f59e0b', '#eab308', '#22c55e', '#10b981'];
            const widths = [20, 40, 60, 80, 100];

            return {
                score,
                strength,
                color: colors[score],
                width: widths[score],
                feedback: feedback.length > 0 ? 'Manque: ' + feedback.join(', ') : 'Excellent mot de passe!'
            };
        }

        passwordInput.addEventListener('input', function() {
            const password = this.value;

            if (password.length > 0) {
                strengthDiv.classList.remove('d-none');
                const result = checkPasswordStrength(password);

                strengthFill.style.width = result.width + '%';
                strengthFill.style.backgroundColor = result.color;
                strengthText.textContent = `${result.strength} - ${result.feedback}`;
                strengthText.style.color = result.color;
            } else {
                strengthDiv.classList.add('d-none');
            }
        });

        // Password confirmation checker
        const confirmInput = document.getElementById('password_confirmation');
        const confirmError = document.getElementById('confirmation-error');
        const confirmSuccess = document.getElementById('confirmation-success');

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;

            if (confirm.length > 0) {
                if (password === confirm) {
                    confirmError.classList.add('d-none');
                    confirmSuccess.classList.remove('d-none');
                    confirmInput.classList.remove('is-invalid');
                    confirmInput.classList.add('is-valid');
                } else {
                    confirmSuccess.classList.add('d-none');
                    confirmError.classList.remove('d-none');
                    confirmError.querySelector('span').textContent = 'Les mots de passe ne correspondent pas';
                    confirmInput.classList.add('is-invalid');
                    confirmInput.classList.remove('is-valid');
                }
            } else {
                confirmError.classList.add('d-none');
                confirmSuccess.classList.add('d-none');
                confirmInput.classList.remove('is-invalid', 'is-valid');
            }
        }

        confirmInput.addEventListener('input', checkPasswordMatch);
        passwordInput.addEventListener('input', checkPasswordMatch);

        // Form validation and submission
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const loadingState = document.getElementById('loadingState');
        const formContent = document.getElementById('formContent');
        const successMessage = document.getElementById('successMessage');

        form.addEventListener('submit', function(e) {
            // Don't prevent default - let Laravel handle the submission

            // Show loading state
            showLoadingState();

            // Basic client-side validation
            let isValid = validateForm();

            if (!isValid) {
                hideLoadingState();
                e.preventDefault(); // Only prevent if validation fails
                return false;
            }
        });

        function showLoadingState() {
            submitBtn.disabled = true;
            submitText.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Création en cours...';

            // Optional: Show loading overlay
            setTimeout(() => {
                if (document.getElementById('registerForm')) {
                    formContent.classList.add('d-none');
                    loadingState.classList.remove('d-none');
                }
            }, 500);
        }

        function hideLoadingState() {
            submitBtn.disabled = false;
            submitText.innerHTML = '<i class="fas fa-user-plus me-2"></i>Créer mon compte';
            formContent.classList.remove('d-none');
            loadingState.classList.add('d-none');
        }

        function validateForm() {
            let isValid = true;

            // Validate name
            const name = document.getElementById('name').value.trim();
            if (name.length < 2) {
                showError('name', 'Le nom doit contenir au moins 2 caractères');
                isValid = false;
            } else {
                hideError('name');
            }

            // Validate email
            const email = document.getElementById('email').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showError('email', 'Veuillez saisir une adresse email valide');
                isValid = false;
            } else {
                hideError('email');
            }

            // Validate password
            const password = passwordInput.value;
            if (password.length < 8) {
                showError('password', 'Le mot de passe doit contenir au moins 8 caractères');
                isValid = false;
            } else {
                hideError('password');
            }

            // Validate password confirmation
            if (password !== confirmInput.value) {
                showError('confirmation', 'Les mots de passe ne correspondent pas');
                isValid = false;
            } else {
                hideError('confirmation');
            }

            return isValid;
        }

        // Check if we're redirecting after successful registration
        window.addEventListener('load', function() {
            // Check for success parameter in URL or session
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('registered') === 'success') {
                showSuccessAndRedirect();
            }
        });

        function showSuccessAndRedirect() {
            formContent.classList.add('d-none');
            loadingState.classList.add('d-none');
            successMessage.classList.remove('d-none');

            // Redirect after 2 seconds
            setTimeout(() => {
                window.location.href = '/dashboard'; // Adjust to your dashboard route
            }, 2000);
        }

        function showError(field, message) {
            const errorDiv = document.getElementById(field + '-error');
            const input = document.getElementById(field === 'confirmation' ? 'password_confirmation' : field);

            errorDiv.querySelector('span').textContent = message;
            errorDiv.classList.remove('d-none');
            input.classList.add('is-invalid');
        }

        function hideError(field) {
            const errorDiv = document.getElementById(field + '-error');
            const input = document.getElementById(field === 'confirmation' ? 'password_confirmation' : field);

            errorDiv.classList.add('d-none');
            input.classList.remove('is-invalid');
        }
    </script>
</body>
</html>
