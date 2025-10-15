<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - 404</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --uts-yellow: #FFD700;
            --uts-yellow-light: #FFEB3B;
            --uts-yellow-dark: #F57C00;
            --uts-green: #2E7D32;
            --uts-green-light: #66BB6A;
            --uts-green-dark: #1B5E20;
            --uts-cream: #FFF8E1;
            --uts-sage: #E8F5E8;
            --uts-warm: #FFFDE7;
            --uts-dark: #2C3E50;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .floating-animation {
            animation: float 3s ease-in-out infinite;
        }

        .pulse-animation {
            animation: pulse-glow 2s infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(255, 215, 0, 0.4);
                background: rgba(255, 215, 0, 0.1);
            }
            50% {
                box-shadow: 0 0 40px rgba(255, 215, 0, 0.7);
                background: rgba(255, 215, 0, 0.2);
            }
        }

        .gradient-bg {
            background: linear-gradient(135deg, var(--uts-green) 0%, var(--uts-green-dark) 50%, var(--uts-yellow-dark) 100%);
            position: relative;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 20%, rgba(255, 215, 0, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(46, 125, 50, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .glass-effect {
            backdrop-filter: blur(16px);
            background: linear-gradient(135deg, var(--uts-cream) 0%, var(--uts-warm) 100%);
            border: 2px solid var(--uts-yellow);
            box-shadow: 0 25px 50px rgba(46, 125, 50, 0.3);
        }

        .text-404 {
            background: linear-gradient(45deg, var(--uts-yellow), var(--uts-green), var(--uts-yellow-light));
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-move 3s ease infinite;
            opacity: 0.3;
        }

        @keyframes gradient-move {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .icon-circle {
            background: linear-gradient(135deg, var(--uts-yellow), var(--uts-yellow-dark));
            border: 3px solid var(--uts-green);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--uts-yellow), var(--uts-yellow-dark));
            color: var(--uts-dark);
            border: 2px solid var(--uts-green);
            box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--uts-yellow-dark), var(--uts-yellow));
            box-shadow: 0 12px 30px rgba(255, 215, 0, 0.5);
            border-color: var(--uts-green-dark);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--uts-green), var(--uts-green-light));
            color: var(--uts-cream);
            border: 2px solid var(--uts-yellow);
            box-shadow: 0 8px 20px rgba(46, 125, 50, 0.3);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, var(--uts-green-dark), var(--uts-green));
            box-shadow: 0 12px 30px rgba(46, 125, 50, 0.5);
            border-color: var(--uts-yellow-dark);
        }

        .suggestion-link {
            color: var(--uts-green);
            transition: all 0.3s ease;
        }

        .suggestion-link:hover {
            color: var(--uts-yellow-dark);
            transform: scale(1.05);
        }

        .particle-yellow {
            background: linear-gradient(45deg, var(--uts-yellow), var(--uts-yellow-light));
            opacity: 0.6;
        }

        .particle-green {
            background: linear-gradient(45deg, var(--uts-green), var(--uts-green-light));
            opacity: 0.4;
        }

        .border-divider {
            border-color: var(--uts-green);
            opacity: 0.3;
        }

        .title-text {
            color: var(--uts-dark);
            font-weight: 700;
        }

        .description-text {
            color: var(--uts-dark);
            opacity: 0.8;
        }

        .helper-text {
            color: var(--uts-green);
            opacity: 0.8;
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Container Principal -->
    <div class="glass-effect rounded-3xl p-8 md:p-12 max-w-2xl w-full text-center shadow-2xl">

        <!-- Icône 404 Animée -->
        <div class="floating-animation mb-8">
            <div class="relative">
                <div class="text-8xl md:text-9xl font-black text-404 select-none">404</div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="icon-circle rounded-full p-6 pulse-animation">
                        <i class="fas fa-search text-4xl md:text-5xl" style="color: var(--uts-dark);"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Titre Principal -->
        <h1 class="text-3xl md:text-4xl font-bold title-text mb-4">
            Page introuvable
        </h1>

        <!-- Description -->
        <p class="text-lg description-text mb-8 max-w-md mx-auto">
            Désolé, la page que vous recherchez semble avoir disparu dans le cyberespace.
        </p>

        <!-- Actions -->
        <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
            <!-- Bouton Retour Accueil -->
            <a href="{{ route('home') }}"
               class="inline-flex items-center justify-center gap-3 btn-primary px-6 py-3 rounded-xl font-semibold transform hover:scale-105 transition-all duration-300 min-w-[200px]">
                <i class="fas fa-home text-lg"></i>
                <span>Retour à l'accueil</span>
            </a>

            <!-- Bouton Retour Précédent -->
            <button onclick="history.back()"
                    class="inline-flex items-center justify-center gap-3 btn-secondary px-6 py-3 rounded-xl font-semibold transform hover:scale-105 transition-all duration-300 min-w-[200px]">
                <i class="fas fa-arrow-left text-lg"></i>
                <span>Page précédente</span>
            </button>
        </div>

        <!-- Suggestions -->
        <div class="mt-12 pt-8 border-t-2 border-divider">
            <p class="text-sm helper-text mb-4 font-semibold">Que souhaitez-vous faire ?</p>
            <div class="flex flex-wrap justify-center gap-6">
                <a href="#" class="flex items-center gap-2 suggestion-link text-sm font-medium">
                    <i class="fas fa-envelope"></i>
                    <span>Contact</span>
                </a>
                <a href="#" class="flex items-center gap-2 suggestion-link text-sm font-medium">
                    <i class="fas fa-question-circle"></i>
                    <span>Aide</span>
                </a>
                <a href="#" class="flex items-center gap-2 suggestion-link text-sm font-medium">
                    <i class="fas fa-sitemap"></i>
                    <span>Plan du site</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Particles Background -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute top-1/4 left-1/4 w-4 h-4 particle-yellow rounded-full floating-animation" style="animation-delay: -1s;"></div>
        <div class="absolute top-3/4 right-1/4 w-6 h-6 particle-green rounded-full floating-animation" style="animation-delay: -2s;"></div>
        <div class="absolute bottom-1/4 left-1/3 w-3 h-3 particle-yellow rounded-full floating-animation" style="animation-delay: -3s;"></div>
        <div class="absolute top-1/2 right-1/3 w-5 h-5 particle-green rounded-full floating-animation" style="animation-delay: -0.5s;"></div>
        <div class="absolute top-1/6 right-1/6 w-2 h-2 particle-yellow rounded-full floating-animation" style="animation-delay: -2.5s;"></div>
        <div class="absolute bottom-1/3 right-2/3 w-4 h-4 particle-green rounded-full floating-animation" style="animation-delay: -1.5s;"></div>
    </div>

    <script>
        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.glass-effect');
            container.style.opacity = '0';
            container.style.transform = 'scale(0.9) translateY(20px)';

            setTimeout(() => {
                container.style.transition = 'all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1)';
                container.style.opacity = '1';
                container.style.transform = 'scale(1) translateY(0)';
            }, 100);
        });

        // Effet parallax léger au scroll
        window.addEventListener('mousemove', function(e) {
            const particles = document.querySelectorAll('.floating-animation');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            particles.forEach((particle, index) => {
                const speed = (index + 1) * 0.3;
                const moveX = (x - 0.5) * speed;
                const moveY = (y - 0.5) * speed;

                particle.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });

        // Animation du logo UTS au survol des boutons
        const buttons = document.querySelectorAll('button, a');
        const iconCircle = document.querySelector('.icon-circle');

        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                iconCircle.style.transform = 'rotate(10deg) scale(1.1)';
            });

            button.addEventListener('mouseleave', () => {
                iconCircle.style.transform = 'rotate(0deg) scale(1)';
            });
        });
    </script>
</body>
</html>
