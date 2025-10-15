<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion Matériel - UTS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --uts-primary: #1a472a;
            --uts-secondary: #16a34a;
            --uts-accent: #fbbf24;
            --uts-light: #f7fafc;
            --uts-dark: #0f172a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, var(--uts-light) 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Barre horizontale en haut */
        .topbar {
            height: 70px;
            background: linear-gradient(135deg, var(--uts-primary) 0%, var(--uts-secondary) 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: between;
            padding: 0 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            z-index: 1050;
            transition: all 0.3s ease;
        }

        .topbar-brand {
            font-size: 1.3rem;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .topbar-brand .logo-circle {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            margin-right: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .topbar-brand .custom-logo {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 50%;
        }

        /* Menu hamburger */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            margin-left: auto;
        }

        .hamburger:hover {
            background: rgba(255,255,255,0.1);
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: white;
            margin: 3px 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--uts-primary) 0%, var(--uts-dark) 100%);
            color: white;
            position: fixed;
            top: 70px;
            bottom: 0;
            left: 0;
            padding: 1rem 0;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1rem 1.5rem 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }

        .sidebar-header h6 {
            color: var(--uts-accent);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .sidebar a {
            color: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            margin-bottom: 0.25rem;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.1);
            color: var(--uts-accent);
            border-left-color: var(--uts-accent);
            transform: translateX(5px);
        }

        .sidebar a i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        /* Bloc utilisateur connecté */
        .user-block {
            padding: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 1rem;
        }

        .user-block .logout-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px solid #dc3545;
            background: #dc3545;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            padding: 0;
        }

        .user-block .logout-btn:hover {
            background: #c82333;
            border-color: #c82333;
            transform: scale(1.05);
        }

        .user-block .user-image {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .user-block .logout-text {
            font-size: 0.65rem;
            color: white;
            margin-top: 2px;
            text-align: center;
            line-height: 1;
        }

        /* Contenu principal */
        .main-wrapper {
            margin-left: 280px;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        main {
            flex: 1;
            padding: 2rem;
        }

        /* Footer amélioré */
        .footer-uts {
            background: linear-gradient(135deg, var(--uts-primary) 0%, var(--uts-dark) 100%);
            color: white;
            position: relative;
            z-index: 1;
            margin-top: auto;
        }

        .footer-uts::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--uts-secondary), var(--uts-accent), #2563eb);
        }

        .footer-brand {
            font-size: 1.4rem;
            font-weight: bold;
            color: white;
            display: flex;
            align-items: center;
        }

        .footer-logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--uts-accent), #f59e0b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-weight: bold;
            color: var(--uts-primary);
        }

        .footer-motto {
            font-style: italic;
            color: #cbd5e1;
            font-size: 0.95rem;
            border-left: 3px solid var(--uts-accent);
            padding-left: 1rem;
            margin: 1rem 0;
        }

        .footer-quote {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            font-weight: 500;
            color: var(--uts-accent);
            border: 1px solid rgba(251, 191, 36, 0.3);
            margin: 1rem 0;
        }

        .footer-contact {
            list-style: none;
            padding: 0;
        }

        .footer-contact li {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .footer-contact i {
            width: 20px;
            margin-right: 0.75rem;
        }

        .footer-contact a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-contact a:hover {
            color: var(--uts-accent);
        }

        .social-links a {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
            color: white;
            text-decoration: none;
        }

        .social-links a:hover {
            background: var(--uts-accent);
            color: var(--uts-primary);
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hamburger {
                display: flex;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .main-wrapper.sidebar-open {
                margin-left: 0;
            }

            main {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .topbar {
                padding: 0 1rem;
            }

            .topbar-brand {
                font-size: 1.1rem;
            }

            .topbar-brand .logo-circle {
                width: 40px;
                height: 40px;
            }

            .topbar-brand .custom-logo {
                width: 35px;
                height: 35px;
            }

            .footer-uts .container-fluid {
                padding: 0 1rem;
            }

            .footer-uts .row > div {
                margin-bottom: 2rem;
            }

            .user-block .logout-btn {
                width: 50px;
                height: 50px;
            }

            .user-block .user-image {
                width: 28px;
                height: 28px;
            }

            .user-block .logout-text {
                font-size: 0.6rem;
            }
        }

        /* Overlay pour mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Animation d'entrée */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-in {
            animation: slideInRight 0.3s ease-out;
        }

        /* Scroll personnalisé pour la sidebar */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Overlay pour mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Barre horizontale -->
    <div class="topbar">
        <div class="topbar-brand">
            <div class="logo-circle">
                <img src="/images/university-logo.png" alt="Logo UTS" class="custom-logo">
            </div>
            UTS - Gestion du Matériel
        </div>

        <!-- Menu hamburger -->
        <div class="hamburger" id="hamburgerBtn">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h6>Navigation</h6>
        </div>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            Tableau de bord
        </a>
        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i>
            Catégories
        </a>
        <a href="{{ route('materiels.index') }}" class="{{ request()->routeIs('materiels.*') ? 'active' : '' }}">
            <i class="fas fa-desktop"></i>
            Matériels
        </a>
        <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">
            <i class="fas fa-cogs"></i>
            Services
        </a>

        <a href="{{ route('structures.index') }}" class="{{ request()->routeIs('structures.*') ? 'active' : '' }}">
           <i class="fas fa-building"></i>
            Structures
        </a>

        <a href="{{ route('octrois.index') }}" class="{{ request()->routeIs('octrois.*') ? 'active' : '' }}"><i class="fas fa-hand-holding"></i>
        Octrois
    </a>
<a href="{{ route('inventaires.index') }}" class="{{ request()->routeIs('inventaires.*') ? 'active' : '' }}">
    <i class="fas fa-clipboard-list"></i>
    Inventaires
</a>
<a href="{{ route('permissions.index') }}" class="{{ request()->routeIs('permissions.*') ? 'active' : '' }}">
    <i class="fas fa-shield-alt"></i>
    Permissions
</a>
<a href="{{ route('rapports.index') }}"
   class="{{ request()->routeIs('rapports.*') ? 'active' : '' }}">
   <i class="fas fa-file-alt"></i>
   Rapports
</a>
<a href="{{ route('roles.index') }}"
   class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
   <i class="fas fa-user-shield"></i>
   Roles
</a>
<a href="{{ route('notifications.index') }}"
   class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">
    <i class="fas fa-bell"></i> Notifications
</a>
<a href="{{ route('historiques_connexion.index') }}" class="nav-link {{ request()->routeIs('historiques_connexion.*') ? 'active' : '' }}">
            <i class="fas fa-history"></i> Historique_Connexion
        </a>
        <a href="{{ route('affectations.index') }}" class="{{ request()->routeIs('affectations.*') ? 'active' : '' }}">
    <i class="fas fa-tasks"></i> Affectations
</a>
<a href="{{ route('localisations.index') }}"
   class="{{ request()->routeIs('localisations.*') ? 'active' : '' }}">
    <i class="fas fa-map-marker-alt"></i>
    Localisations
</a>

<!-- Dashboard Admin -->
<a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="fas fa-user-shield"></i>
    Dashboard Admin
</a>

<!-- Dashboard User -->
<a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
    <i class="fas fa-user"></i>
    Dashboard User
</a>

<!-- Bloc utilisateur connecté -->
@auth
    <div class="user-block d-flex flex-column align-items-center text-center">
        <!-- Nom de l'utilisateur -->
        <span class="fw-semibold text-white mb-2">{{ Auth::user()->name }}</span>

        <!-- Bouton Déconnexion avec image -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn" title="Déconnexion">
                <img src="{{ asset('images/Harouna.jpg') }}" alt="User" class="user-image">
                <div class="logout-text">Déconnexion</div>
            </button>
        </form>
    </div>
@endauth
    </div>

    <!-- Wrapper principal -->
    <div class="main-wrapper" id="mainWrapper">
        <!-- Contenu principal -->
        <main class="animate-in">
            @yield('content')
        </main>

        <!-- Footer UTS -->
        <footer class="footer-uts py-5">
            <div class="container-fluid">
                <div class="row">
                    <!-- Logo et informations principales -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="footer-brand mb-3">
                            <div class="footer-logo">UTS</div>
                            <div>
                                <div>Université Thomas Sankara</div>
                                <small class="opacity-75">Sciences et Technologies</small>
                            </div>
                        </div>
                        <div class="footer-motto">
                            <i class="fas fa-graduation-cap me-2"></i>
                            <strong>Science - Intégrité - Société</strong>
                        </div>
                        <div class="footer-quote">
                            <i class="fas fa-quote-left me-2"></i>
                            <em>« Oser lutter et savoir vaincre »</em>
                            <i class="fas fa-quote-right ms-2"></i>
                        </div>
                    </div>

                    <!-- Coordonnées -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-address-card me-2"></i>
                            Contact
                        </h5>
                        <ul class="footer-contact">
                            <li>
                                <i class="fas fa-map-marker-alt text-warning"></i>
                                <span>12 BP 417 Ouaga 12-Burkina Faso</span>
                            </li>
                            <li>
                                <i class="fas fa-phone text-success"></i>
                                <a href="tel:+22625408642">+226 25 40 86 42 / 70 44 42 94</a>
                            <li>
                                <i class="fas fa-envelope text-danger"></i>
                                <a href="mailto:contact@uts.bf">contact@uts.bf</a>
                            </li>
                            <li>
                                <i class="fas fa-globe text-primary"></i>
                                <a href="https://www.uts.bf" target="_blank">www.uts.bf</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Développement et liens -->
                    <div class="col-lg-4 col-md-12 mb-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-code me-2"></i>
                            Développeur
                        </h5>
                        <p class="mb-3">
                            <i class="fas fa-user-tie me-2"></i>
                            Développé par <strong class="text-warning">Belemboulli Massahouda</strong>
                        </p>
                        <div class="social-links mb-3">
                            <a href="https://wa.me/22670444294" target="_blank" title="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="#" target="_blank" title="LinkedIn">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="mailto:contact@uts.bf" title="Email">
                                <i class="fas fa-envelope"></i>
                            </a>
                            <a href="https://www.uts.bf" target="_blank" title="Site web">
                                <i class="fas fa-globe"></i>
                            </a>
                        </div>
                        <small class="opacity-75">
                            <i class="fas fa-calendar me-1"></i>
                            Version 1.0 - {{ date('Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar mobile
        document.getElementById('hamburgerBtn').addEventListener('click', function() {
            this.classList.toggle('active');
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        });

        // Fermer sidebar en cliquant sur overlay
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('hamburgerBtn').classList.remove('active');
            document.getElementById('sidebar').classList.remove('active');
            this.classList.remove('active');
        });
    </script>
    @stack('scripts')
</body>
</html>
