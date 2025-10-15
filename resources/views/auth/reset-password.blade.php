<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - {{ config('app.name', 'VotrePlateforme') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }

        .gradient-bg { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #ffffff 100%); }
        .glass-card {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(251, 191, 36, 0.3);
        }
        .slide-in { animation: slideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .strength-bar { transition: all 0.3s ease; }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="glass-card rounded-2xl shadow-2xl p-8 w-full max-w-md slide-in">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-gradient-to-r from-amber-400 to-yellow-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-lock-open text-white text-2xl drop-shadow-sm"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Nouveau mot de passe</h1>
            <p class="text-gray-600 text-sm">Créez un mot de passe sécurisé pour votre compte</p>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6" id="resetForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email Field -->
            <div class="space-y-2">
                <label for="email" class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <i class="fas fa-envelope text-indigo-500"></i>
                    Adresse e-mail
                </label>
                @error('email')
                    <div class="relative">
                        <input id="email" type="email" name="email" value="{{ old('email', $email ?? '') }}" required autofocus
                               placeholder="votre@email.com"
                               class="w-full px-4 py-3 pl-12 border-2 border-red-400 rounded-xl focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-300">
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-red-400"></i>
                    </div>
                    <div class="flex items-center gap-2 text-red-500 text-sm">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @else
                    <div class="relative">
                        <input id="email" type="email" name="email" value="{{ old('email', $email ?? '') }}" required autofocus
                               placeholder="votre@email.com"
                               class="w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-300">
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <label for="password" class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <i class="fas fa-key text-indigo-500"></i>
                    Nouveau mot de passe
                </label>
                @error('password')
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                               placeholder="Minimum 8 caractères"
                               class="w-full px-4 py-3 pl-12 pr-12 border-2 border-red-400 rounded-xl focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-300">
                        <i class="fas fa-key absolute left-4 top-1/2 transform -translate-y-1/2 text-red-400"></i>
                        <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-red-400 hover:text-red-600">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    <div class="flex items-center gap-2 text-red-500 text-sm">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @else
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                               placeholder="Minimum 8 caractères"
                               class="w-full px-4 py-3 pl-12 pr-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-300">
                        <i class="fas fa-key absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-500">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                @enderror

                <!-- Indicateur de force du mot de passe -->
                <div class="space-y-1">
                    <div class="flex gap-1">
                        <div class="strength-bar h-1 flex-1 bg-gray-200 rounded" id="strength1"></div>
                        <div class="strength-bar h-1 flex-1 bg-gray-200 rounded" id="strength2"></div>
                        <div class="strength-bar h-1 flex-1 bg-gray-200 rounded" id="strength3"></div>
                        <div class="strength-bar h-1 flex-1 bg-gray-200 rounded" id="strength4"></div>
                    </div>
                    <p class="text-xs text-gray-500" id="strengthText">Entrez votre mot de passe</p>
                </div>
            </div>

            <!-- Confirm Password Field -->
            <div class="space-y-2">
                <label for="password_confirmation" class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <i class="fas fa-check-double text-indigo-500"></i>
                    Confirmer le mot de passe
                </label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           placeholder="Retapez votre mot de passe"
                           class="w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-300">
                    <i class="fas fa-check-double absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="hidden" id="passwordMatch">
                    <div class="flex items-center gap-2 text-green-500 text-sm">
                        <i class="fas fa-check-circle"></i>
                        <span>Les mots de passe correspondent</span>
                    </div>
                </div>
                <div class="hidden" id="passwordMismatch">
                    <div class="flex items-center gap-2 text-red-500 text-sm">
                        <i class="fas fa-times-circle"></i>
                        <span>Les mots de passe ne correspondent pas</span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="submitBtn"
                    class="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white font-semibold py-3 px-6 rounded-xl hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-green-200 transform hover:scale-[1.02] transition-all duration-200 shadow-lg">
                <i class="fas fa-shield-alt mr-2"></i>
                Réinitialiser le mot de passe
            </button>
        </form>

        <!-- Retour -->
        <div class="text-center mt-6 pt-6 border-t border-gray-100">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition-colors text-sm">
                <i class="fas fa-arrow-left"></i>
                Retour à la connexion
            </a>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Password strength checker
        const password = document.getElementById('password');
        const strengthBars = [
            document.getElementById('strength1'),
            document.getElementById('strength2'),
            document.getElementById('strength3'),
            document.getElementById('strength4')
        ];
        const strengthText = document.getElementById('strengthText');

        password.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;

            if (value.length >= 8) strength++;
            if (/[a-z]/.test(value) && /[A-Z]/.test(value)) strength++;
            if (/\d/.test(value)) strength++;
            if (/[^A-Za-z0-9]/.test(value)) strength++;

            // Reset bars
            strengthBars.forEach(bar => {
                bar.className = 'strength-bar h-1 flex-1 bg-gray-200 rounded';
            });

            // Update bars based on strength
            const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-400'];
            const texts = ['Très faible', 'Faible', 'Moyen', 'Fort'];

            for (let i = 0; i < strength; i++) {
                strengthBars[i].className = `strength-bar h-1 flex-1 ${colors[strength-1]} rounded`;
            }

            strengthText.textContent = value ? texts[strength-1] || 'Très faible' : 'Entrez votre mot de passe';
        });

        // Password confirmation check
        const passwordConfirm = document.getElementById('password_confirmation');
        const matchDiv = document.getElementById('passwordMatch');
        const mismatchDiv = document.getElementById('passwordMismatch');

        function checkPasswordMatch() {
            const pass = password.value;
            const confirm = passwordConfirm.value;

            if (confirm && pass) {
                if (pass === confirm) {
                    matchDiv.classList.remove('hidden');
                    mismatchDiv.classList.add('hidden');
                } else {
                    matchDiv.classList.add('hidden');
                    mismatchDiv.classList.remove('hidden');
                }
            } else {
                matchDiv.classList.add('hidden');
                mismatchDiv.classList.add('hidden');
            }
        }

        password.addEventListener('input', checkPasswordMatch);
        passwordConfirm.addEventListener('input', checkPasswordMatch);

        // Form submission
        document.getElementById('resetForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const original = btn.innerHTML;

            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Réinitialisation...';
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = original;
                btn.disabled = false;
            }, 5000);
        });
    </script>
</body>
</html>
