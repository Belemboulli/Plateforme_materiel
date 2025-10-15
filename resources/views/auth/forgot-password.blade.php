<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - UTS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }

        /* Couleurs UTS */
        .gradient-bg {
            background: linear-gradient(135deg, #ffc107 0%, #ff8f00 50%, #28a745 100%);
        }

        .glass-card {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        .pulse-glow {
            animation: pulse 2s infinite;
        }

        /* Animations avec couleurs UTS */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 20px rgba(255, 193, 7, 0.4); }
            50% { box-shadow: 0 0 30px rgba(255, 193, 7, 0.7); }
        }

        .slide-in {
            animation: slideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Personnalisation des couleurs UTS */
        .btn-primary {
            background: linear-gradient(135deg, #ffc107, #ff8f00);
            color: #000;
            font-weight: 700;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #e0a800, #d39e00);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
        }

        .text-primary {
            color: #ffc107 !important;
        }

        .border-primary {
            border-color: #ffc107 !important;
        }

        .ring-primary {
            --tw-ring-color: rgba(255, 193, 7, 0.3) !important;
        }

        .border-success {
            border-color: #28a745 !important;
        }

        .ring-success {
            --tw-ring-color: rgba(40, 167, 69, 0.3) !important;
        }

        .logo-circle {
            background: linear-gradient(135deg, #ffc107, #ff8f00);
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Container Principal -->
    <div class="glass-card rounded-2xl shadow-2xl p-8 w-full max-w-md slide-in">

        <!-- Header avec Logo UTS -->
        <div class="text-center mb-8">
            <div class="logo-circle rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 pulse-glow">
                <i class="fas fa-graduation-cap text-black text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Mot de passe oublié ?</h1>
            <p class="text-gray-600 text-sm">Pas de souci ! Entrez votre email pour recevoir un lien de réinitialisation</p>
        </div>

        <!-- Message de Succès -->
        @if (session('status'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                <i class="fas fa-check-circle text-green-500"></i>
                <span class="text-sm">{{ session('status') }}</span>
            </div>
        @endif

        <!-- Formulaire -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Champ Email -->
            <div class="space-y-2">
                <label for="email" class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <i class="fas fa-envelope text-primary"></i>
                    Adresse e-mail
                </label>
                <div class="relative">
                    @error('email')
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               placeholder="votre@email.com"
                               class="w-full px-4 py-3 pl-12 border-2 border-red-400 rounded-xl focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-300">
                    @else
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               placeholder="votre@email.com"
                               class="w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:outline-none border-primary focus:ring-4 ring-primary transition-all duration-300">
                    @enderror
                    <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('email')
                    <div class="flex items-center gap-2 text-red-500 text-sm mt-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Bouton Submit -->
            <button type="submit"
                    class="btn-primary w-full font-semibold py-3 px-6 rounded-xl focus:outline-none focus:ring-4 ring-primary transform hover:scale-[1.02] transition-all duration-200 shadow-lg">
                <i class="fas fa-paper-plane mr-2"></i>
                Envoyer le lien de réinitialisation
            </button>
        </form>

        <!-- Divider -->
        <div class="flex items-center my-6">
            <div class="flex-1 border-t border-gray-200"></div>
            <span class="px-4 text-sm text-gray-500">ou</span>
            <div class="flex-1 border-t border-gray-200"></div>
        </div>

        <!-- Actions Alternatives -->
        <div class="space-y-3">
            <a href="{{ route('login') }}"
               class="w-full flex items-center justify-center gap-2 bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium py-3 px-4 rounded-xl transition-colors border border-gray-200">
                <i class="fas fa-arrow-left"></i>
                Retour à la connexion
            </a>

            <a href="{{ route('register') }}"
               class="btn-secondary w-full flex items-center justify-center gap-2 text-white font-medium py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-[1.02]">
                <i class="fas fa-user-plus"></i>
                Créer un nouveau compte
            </a>
        </div>

        <!-- Section UTS -->
        <div class="text-center mt-6 p-4 bg-yellow-50 rounded-xl border border-yellow-200">
            <div class="flex items-center justify-center gap-2 mb-2">
                <i class="fas fa-graduation-cap text-primary"></i>
                <span class="font-bold text-gray-800">UTS</span>
            </div>
            <p class="text-xs text-gray-600">
                Université Technologique et Scientifique
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 pt-4 border-t border-gray-100">
            <p class="text-xs text-gray-500 flex items-center justify-center gap-1">
                <i class="fas fa-shield-alt text-primary"></i>
                Vos données sont protégées et sécurisées
            </p>
            <p class="text-xs text-gray-400 mt-2">
                © {{ date('Y') }} UTS. Tous droits réservés.
            </p>
        </div>
    </div>

    <!-- Particules Flottantes avec couleurs UTS -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute top-1/4 left-1/4 w-3 h-3 bg-yellow-200 opacity-30 rounded-full floating" style="animation-delay: -1s;"></div>
        <div class="absolute top-3/4 right-1/4 w-4 h-4 bg-green-200 opacity-20 rounded-full floating" style="animation-delay: -2s;"></div>
        <div class="absolute bottom-1/4 left-1/3 w-2 h-2 bg-yellow-300 opacity-25 rounded-full floating" style="animation-delay: -3s;"></div>
        <div class="absolute top-1/2 right-1/3 w-3 h-3 bg-green-300 opacity-20 rounded-full floating" style="animation-delay: -0.5s;"></div>
        <div class="absolute top-1/3 left-1/2 w-2 h-2 bg-yellow-400 opacity-15 rounded-full floating" style="animation-delay: -4s;"></div>
    </div>

    <script>
        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            // Focus automatique avec délai pour l'animation
            setTimeout(() => {
                document.getElementById('email').focus();
            }, 600);
        });

        // Validation en temps réel avec couleurs UTS
        const emailInput = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        emailInput.addEventListener('input', function() {
            // Réinitialiser toutes les classes de bordure
            this.classList.remove('border-red-400', 'border-green-400', 'border-primary');

            if (this.value) {
                if (emailRegex.test(this.value)) {
                    this.classList.add('border-green-400');
                    this.classList.remove('ring-primary');
                    this.classList.add('ring-success');
                } else {
                    this.classList.add('border-red-400');
                    this.classList.remove('ring-success');
                    this.classList.add('ring-red');
                }
            } else {
                this.classList.add('border-gray-200');
                this.classList.remove('ring-success', 'ring-red');
                this.classList.add('ring-primary');
            }
        });

        // Animation de soumission
        document.querySelector('form').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Envoi en cours...';
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75');

            // Réactiver après 5 secondes (sécurité)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-75');
            }, 5000);
        });

        // Animation au survol des boutons
        const buttons = document.querySelectorAll('button, a');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                if (!this.disabled) {
                    this.style.transform = 'translateY(-1px)';
                }
            });

            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>
