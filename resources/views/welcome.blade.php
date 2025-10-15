@extends('layouts.public')

@section('content')
<style>
    :root {
        --uts-yellow: #FFD700;
        --uts-yellow-light: #FFF176;
        --uts-yellow-dark: #F9A825;
        --uts-green: #2E7D32;
        --uts-green-light: #4CAF50;
        --uts-green-dark: #1B5E20;
        --uts-red: #D32F2F;
        --uts-red-light: #F44336;
        --uts-dark: #263238;
        --uts-dark-light: #37474F;
        --uts-light: #FAFAFA;
        --uts-white: #FFFFFF;
        --uts-blue: #1976D2;
        --uts-blue-light: #42A5F5;
        --accent-orange: #FF8F00;
        --accent-purple: #7B1FA2;
        --shadow-light: rgba(0, 0, 0, 0.1);
        --shadow-medium: rgba(0, 0, 0, 0.15);
        --shadow-dark: rgba(0, 0, 0, 0.25);
    }

    body {
        background: linear-gradient(135deg, var(--uts-light) 0%, #E3F2FD 50%, #F3E5F5 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .hero-section {
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    .university-logo {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 1000;
        width: 80px;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 20px var(--shadow-medium);
        border: 3px solid var(--uts-white);
        background: var(--uts-white);
        padding: 8px;
    }

    .welcome-text {
        font-size: 3.5rem;
        font-weight: 700;
        background: linear-gradient(45deg, var(--uts-green), var(--uts-blue), var(--uts-green-light));
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: gradientMove 4s ease infinite, slideInFromLeft 2s ease-out;
        text-shadow: none;
        margin-bottom: 2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        z-index: 10;
    }

    .welcome-text:hover {
        transform: scale(1.05);
        filter: brightness(1.1);
    }

    .welcome-text.paused {
        animation-play-state: paused;
        transform: scale(1.1);
        background: linear-gradient(45deg, var(--uts-yellow), var(--accent-orange));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes slideInFromLeft {
        0% { transform: translateX(-100%); opacity: 0; }
        50% { transform: translateX(10%); opacity: 0.7; }
        100% { transform: translateX(0); opacity: 1; }
    }

    .carousel-container {
        position: relative;
        max-width: 800px;
        height: 400px;
        margin: 0 auto 3rem;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px var(--shadow-dark);
        border: 4px solid var(--uts-white);
    }

    .carousel-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .carousel-slide.active {
        opacity: 1;
    }

    .carousel-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, var(--uts-dark));
        color: var(--uts-white);
        padding: 25px;
        text-align: center;
    }

    .carousel-overlay h4 {
        color: var(--uts-yellow);
        font-weight: 600;
        margin-bottom: 8px;
    }

    .description-text {
        font-size: 1.3rem;
        color: var(--uts-dark);
        margin-bottom: 3rem;
        line-height: 1.7;
        max-width: 650px;
        margin-left: auto;
        margin-right: auto;
        font-weight: 400;
    }

    .btn-custom {
        padding: 16px 45px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin: 0 15px;
        box-shadow: 0 8px 25px var(--shadow-medium);
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
    }

    .btn-login {
        background: linear-gradient(45deg, var(--uts-green), var(--uts-green-light));
        color: var(--uts-white);
        border-color: var(--uts-green);
    }

    .btn-login:hover {
        background: linear-gradient(45deg, var(--uts-green-dark), var(--uts-green));
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(46, 125, 50, 0.4);
        color: var(--uts-white);
        border-color: var(--uts-green-dark);
    }

    .btn-register {
        background: linear-gradient(45deg, var(--uts-yellow), var(--uts-yellow-light));
        color: var(--uts-dark);
        border-color: var(--uts-yellow-dark);
    }

    .btn-register:hover {
        background: linear-gradient(45deg, var(--uts-yellow-dark), var(--uts-yellow));
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(255, 215, 0, 0.4);
        color: var(--uts-dark);
        border-color: var(--accent-orange);
    }

    .features-section {
        background: linear-gradient(135deg, var(--uts-white) 0%, rgba(255, 255, 255, 0.95) 100%);
        border-radius: 25px;
        padding: 3rem 2rem;
        margin: 4rem 0;
        backdrop-filter: blur(15px);
        border: 2px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 15px 50px var(--shadow-light);
    }

    .feature-card {
        background: linear-gradient(135deg, var(--uts-white) 0%, #F8F9FA 100%);
        border-radius: 20px;
        padding: 2rem 1.5rem;
        margin: 1rem 0;
        box-shadow: 0 8px 30px var(--shadow-light);
        transition: all 0.3s ease;
        border-left: 5px solid var(--uts-green);
        border-top: 1px solid rgba(255, 255, 255, 0.8);
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--uts-green), var(--uts-blue), var(--uts-yellow));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px var(--shadow-medium);
        border-left-color: var(--uts-blue);
    }

    .feature-card:hover::before {
        opacity: 1;
    }

    .feature-card:nth-child(2) {
        border-left-color: var(--uts-blue);
    }

    .feature-card:nth-child(2):hover {
        border-left-color: var(--accent-orange);
    }

    .feature-card:nth-child(3) {
        border-left-color: var(--accent-orange);
    }

    .feature-card:nth-child(3):hover {
        border-left-color: var(--accent-purple);
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(45deg, var(--uts-green), var(--uts-green-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        font-size: 1.8rem;
        color: var(--uts-white);
        box-shadow: 0 8px 20px rgba(46, 125, 50, 0.3);
        transition: all 0.3s ease;
    }

    .feature-card:nth-child(2) .feature-icon {
        background: linear-gradient(45deg, var(--uts-blue), var(--uts-blue-light));
        box-shadow: 0 8px 20px rgba(25, 118, 210, 0.3);
    }

    .feature-card:nth-child(3) .feature-icon {
        background: linear-gradient(45deg, var(--accent-orange), var(--uts-yellow));
        box-shadow: 0 8px 20px rgba(255, 143, 0, 0.3);
    }

    .feature-card:hover .feature-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .feature-card h5 {
        color: var(--uts-dark);
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.3rem;
    }

    .feature-card p {
        color: var(--uts-dark-light);
        line-height: 1.6;
        font-weight: 400;
    }

    @media (max-width: 768px) {
        .welcome-text {
            font-size: 2.5rem;
        }

        .carousel-container {
            height: 250px;
            margin: 0 1rem 2rem;
            border-width: 2px;
        }

        .university-logo {
            width: 60px;
            top: 15px;
            left: 15px;
            padding: 6px;
            border-width: 2px;
        }

        .btn-custom {
            padding: 14px 35px;
            font-size: 1rem;
            margin: 10px;
        }

        .features-section {
            margin: 2rem 1rem;
            padding: 2rem 1rem;
        }

        .feature-card {
            margin: 1rem;
            padding: 1.5rem;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }
    }
</style>

<div class="hero-section">
    <!-- Logo de l'université -->
    <img src="{{ asset('images/university-logo.png') }}" alt="Logo Université" class="university-logo">

    <div class="container text-center py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <!-- Texte de bienvenue animé -->
                <h1 class="welcome-text" id="welcomeText">
                    Bienvenue sur l'Application de Gestion de Matériel de l'Universite Thomas SANKARA
                </h1>

                <!-- Carrousel d'images -->
                <div class="carousel-container" id="imageCarousel">
                    <div class="carousel-slide active" style="background-image: url('{{ asset('images/materiel1.jpg') }}')">
                        <div class="carousel-overlay">
                            <h4>Gestion Moderne des Équipements</h4>
                            <p>Technologie de pointe pour vos ressources</p>
                        </div>
                    </div>
                    <div class="carousel-slide" style="background-image: url('{{ asset('images/materiel2.png') }}')">
                        <div class="carousel-overlay">
                            <h4>Suivi en Temps Réel</h4>
                            <p>Contrôlez vos inventaires efficacement</p>
                        </div>
                    </div>
                    <div class="carousel-slide" style="background-image: url('{{ asset('images/materiel3.png') }}')">
                        <div class="carousel-overlay">
                            <h4>Rapports Détaillés</h4>
                            <p>Analyses complètes de vos données</p>
                        </div>
                    </div>
                    <div class="carousel-slide" style="background-image: url('{{ asset('images/materiel4.png') }}')">
                        <div class="carousel-overlay">
                            <h4>Interface Intuitive</h4>
                            <p>Simplicité et performance réunies</p>
                        </div>
                    </div>
                    <div class="carousel-slide" style="background-image: url('{{ asset('images/materiel5.png') }}')">
                        <div class="carousel-overlay">
                            <h4>Sécurité Maximale</h4>
                            <p>Protection avancée de vos données</p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <p class="description-text">
                    Gérez facilement vos ressources, vos utilisateurs et vos rapports en toute simplicité.
                    Notre plateforme offre une solution complète et intuitive pour optimiser la gestion de votre matériel.
                </p>

                <!-- Boutons d'action -->
                <div class="d-flex justify-content-center flex-wrap">
                    <a href="{{ route('login') }}" class="btn-custom btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Se Connecter
                    </a>
                    <a href="{{ route('register') }}" class="btn-custom btn-register">
                        <i class="fas fa-user-plus me-2"></i>S'inscrire
                    </a>
                </div>

                <!-- Section des fonctionnalités -->
                <div class="features-section">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <h5>Gestion Avancée</h5>
                                <p>Outils puissants pour une gestion optimale de vos ressources matérielles.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h5>Rapports Intelligents</h5>
                                <p>Analyses détaillées et tableaux de bord interactifs pour vos décisions.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h5>Sécurité Renforcée</h5>
                                <p>Protection maximale de vos données avec les dernières technologies.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du carrousel d'images
    const slides = document.querySelectorAll('.carousel-slide');
    let currentSlide = 0;

    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    // Change d'image toutes les 3 secondes
    setInterval(nextSlide, 3000);

    // Gestion du texte de bienvenue animé
    const welcomeText = document.getElementById('welcomeText');
    let animationPaused = false;

    welcomeText.addEventListener('click', function() {
        if (!animationPaused) {
            // Pause l'animation et change le style
            this.style.animationPlayState = 'paused';
            this.classList.add('paused');
            animationPaused = true;

            // Repart après 2 secondes
            setTimeout(() => {
                this.style.animationPlayState = 'running';
                this.classList.remove('paused');
                animationPaused = false;
            }, 2000);
        }
    });

    // Animation d'entrée pour les cartes de fonctionnalités
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.feature-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>

<!-- Inclusion de Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection
