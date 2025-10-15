@extends('layouts.app')

@section('title', 'Tableau de bord - Utilisateur')

@push('styles')
<style>
    .user-dashboard {
        background: linear-gradient(135deg, #fff8e1 0%, #f5f5f5 100%);
        min-height: 100vh;
        padding-bottom: 2rem;
    }

    .welcome-header {
        background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
        color: #000;
        padding: 3rem 0;
        margin: -1.5rem -15px 2rem -15px;
        border-radius: 0 0 30px 30px;
        position: relative;
        overflow: hidden;
    }

    .welcome-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><linearGradient id="a" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="%23ffffff" stop-opacity="0.15"/><stop offset="1" stop-color="%23ffffff" stop-opacity="0"/></linearGradient></defs><rect width="100" height="20" fill="url(%23a)"/></svg>') repeat-x;
        opacity: 0.2;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .welcome-title {
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        animation: fadeInUp 1s ease-out;
        color: #000;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        opacity: 0.85;
        animation: fadeInUp 1s ease-out 0.2s both;
        color: #333;
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 4px solid rgba(0,0,0,0.1);
        margin-bottom: 1rem;
        animation: fadeInUp 1s ease-out 0.1s both;
    }

    .stats-card {
        background: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--card-gradient);
    }

    /* Couleurs UTS pour les cartes */
    .stats-card.yellow::before {
        --card-gradient: linear-gradient(90deg, #ffc107, #ffb300);
    }

    .stats-card.green::before {
        --card-gradient: linear-gradient(90deg, #28a745, #20c997);
    }

    .stats-card.blue::before {
        --card-gradient: linear-gradient(90deg, #007bff, #0056b3);
    }

    .stats-card.red::before {
        --card-gradient: linear-gradient(90deg, #dc3545, #c82333);
    }

    .card-body {
        padding: 2rem 1.5rem;
        text-align: center;
    }

    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: white;
    }

    /* Icônes avec couleurs UTS */
    .card-icon.yellow { background: linear-gradient(135deg, #ffc107, #ffb300); }
    .card-icon.green { background: linear-gradient(135deg, #28a745, #20c997); }
    .card-icon.blue { background: linear-gradient(135deg, #007bff, #0056b3); }
    .card-icon.red { background: linear-gradient(135deg, #dc3545, #c82333); }

    .card-number {
        font-size: 2.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
        animation: countUp 2s ease-out;
    }

    .card-title {
        font-size: 1rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
        font-weight: 600;
    }

    .chart-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-top: 2rem;
        position: relative;
        overflow: hidden;
    }

    .chart-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #ffc107, #28a745, #007bff, #dc3545);
    }

    .chart-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .chart-title {
        font-size: 1.6rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .chart-subtitle {
        color: #666;
        font-size: 1rem;
    }

    .quick-actions {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-top: 2rem;
    }

    .action-btn {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #000;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0.25rem;
        font-weight: 600;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
        color: #000;
        background: linear-gradient(135deg, #e0a800, #d39e00);
    }

    .action-btn:nth-child(2) {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .action-btn:nth-child(2):hover {
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
        background: linear-gradient(135deg, #218838, #1e7e34);
        color: white;
    }

    .action-btn:nth-child(3) {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
    }

    .action-btn:nth-child(3):hover {
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
        background: linear-gradient(135deg, #0069d9, #004085);
        color: white;
    }

    .action-btn:nth-child(4) {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .action-btn:nth-child(4):hover {
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
        background: linear-gradient(135deg, #c82333, #a02622);
        color: white;
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.95);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        z-index: 10;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #ffc107;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes countUp {
        from { opacity: 0; transform: scale(0.8); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    /* Couleurs pour les icônes dans le titre */
    .chart-title .fas {
        color: #ffc107;
    }

    .quick-actions h4 .fas {
        color: #ffc107;
    }

    @media (max-width: 768px) {
        .welcome-header {
            padding: 2rem 0;
            margin: -1rem -15px 1.5rem -15px;
        }

        .welcome-title {
            font-size: 2rem;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
        }

        .card-number {
            font-size: 1.8rem;
        }

        .chart-container, .quick-actions {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="user-dashboard">
    <!-- En-tête de bienvenue -->
    <div class="welcome-header">
        <div class="container">
            <div class="welcome-content">
                @if(auth()->user()->avatar ?? false)
                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="user-avatar">
                @else
                    <div class="user-avatar d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.1);">
                        <i class="fas fa-user" style="font-size: 2rem; color: #333;"></i>
                    </div>
                @endif
                <h1 class="welcome-title">
                    <i class="fas fa-home me-2"></i>
                    Bienvenue, {{ auth()->user()->name ?? 'Utilisateur' }} !
                </h1>
                <p class="welcome-subtitle">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd DD MMMM YYYY') }}
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Cartes statistiques -->
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="stats-card yellow" style="animation-delay: 0.1s;">
                    <div class="card-body">
                        <div class="card-icon yellow">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="card-number" data-target="{{ $totalMateriels ?? 0 }}">0</div>
                        <div class="card-title">Matériels</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="stats-card green" style="animation-delay: 0.2s;">
                    <div class="card-body">
                        <div class="card-icon green">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="card-number" data-target="{{ $totalCategories ?? 0 }}">0</div>
                        <div class="card-title">Catégories</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="stats-card blue" style="animation-delay: 0.3s;">
                    <div class="card-body">
                        <div class="card-icon blue">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="card-number" data-target="{{ $totalServices ?? 0 }}">0</div>
                        <div class="card-title">Services</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="stats-card red" style="animation-delay: 0.4s; position: relative;">
                    <div class="card-body">
                        <div class="card-icon red">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="card-number" data-target="{{ $totalNotifications ?? 0 }}">0</div>
                        <div class="card-title">Notifications</div>
                        @if(($totalNotifications ?? 0) > 0)
                            <div class="notification-badge">{{ min($totalNotifications ?? 0, 99) }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphique des statistiques -->
        <div class="row">
            <div class="col-12">
                <div class="chart-container">
                    <div class="loading-overlay" id="chartLoading">
                        <div class="text-center">
                            <div class="spinner"></div>
                            <p class="mt-2 mb-0">Chargement des données...</p>
                        </div>
                    </div>

                    <div class="chart-header">
                        <h3 class="chart-title">
                            <i class="fas fa-chart-bar me-2"></i>
                            Répartition des Matériels
                        </h3>
                        <p class="chart-subtitle">Nombre de matériels par catégorie</p>
                    </div>

                    <div style="position: relative; height: 400px;">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="row">
            <div class="col-12">
                <div class="quick-actions">
                    <h4 class="mb-4">
                        <i class="fas fa-bolt me-2"></i>
                        Actions Rapides
                    </h4>
                    <div class="text-center">
                        <a href="{{ route('materiels.index') ?? '#' }}" class="action-btn">
                            <i class="fas fa-plus"></i>
                            Ajouter Matériel
                        </a>
                        <a href="{{ route('categories.index') ?? '#' }}" class="action-btn">
                            <i class="fas fa-list"></i>
                            Voir Catégories
                        </a>
                        <a href="{{ route('services.index') ?? '#' }}" class="action-btn">
                            <i class="fas fa-tools"></i>
                            Gérer Services
                        </a>
                        <a href="{{ route('rapports.index') ?? '#' }}" class="action-btn">
                            <i class="fas fa-file-alt"></i>
                            Rapports
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des compteurs
    function animateCounters() {
        const counters = document.querySelectorAll('.card-number[data-target]');

        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000;
            const step = target / duration * 16;
            let current = 0;

            const updateCounter = () => {
                if (current < target) {
                    current += step;
                    if (current > target) current = target;
                    counter.textContent = Math.floor(current).toLocaleString();
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            };

            setTimeout(updateCounter, parseInt(counter.parentElement.parentElement.style.animationDelay.replace('s', '')) * 1000);
        });
    }

    // Initialisation du graphique
    function initChart() {
        console.log('Initialisation du graphique...');

        const categoriesLabels = @json($categoriesLabels ?? ['Aucune catégorie']);
        const materielsCounts = @json($materielsCounts ?? [0]);

        console.log('Labels:', categoriesLabels);
        console.log('Counts:', materielsCounts);

        const ctx = document.getElementById('userChart');
        if (!ctx) {
            console.error('Canvas element not found');
            document.getElementById('chartLoading').innerHTML = `
                <div class="text-center">
                    <i class="fas fa-times text-danger" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-0">Élément canvas non trouvé</p>
                </div>
            `;
            return;
        }

        if (typeof Chart === 'undefined') {
            console.error('Chart.js not loaded');
            document.getElementById('chartLoading').innerHTML = `
                <div class="text-center">
                    <i class="fas fa-times text-danger" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-0">Bibliothèque Chart.js non chargée</p>
                </div>
            `;
            return;
        }

        const finalLabels = categoriesLabels.length > 0 ? categoriesLabels : ['Aucune donnée'];
        const finalCounts = materielsCounts.length > 0 ? materielsCounts : [0];

        try {
            // Couleurs UTS pour le graphique
            const utsColors = [
                'rgba(255, 193, 7, 0.8)',   // Jaune UTS
                'rgba(40, 167, 69, 0.8)',   // Vert UTS
                'rgba(0, 123, 255, 0.8)',   // Bleu complémentaire
                'rgba(220, 53, 69, 0.8)',   // Rouge UTS
                'rgba(255, 179, 0, 0.8)',   // Jaune variant
                'rgba(32, 201, 151, 0.8)',  // Vert variant
                'rgba(0, 86, 179, 0.8)',    // Bleu variant
                'rgba(200, 35, 51, 0.8)'    // Rouge variant
            ];

            const borderColors = [
                'rgba(255, 193, 7, 1)',
                'rgba(40, 167, 69, 1)',
                'rgba(0, 123, 255, 1)',
                'rgba(220, 53, 69, 1)',
                'rgba(255, 179, 0, 1)',
                'rgba(32, 201, 151, 1)',
                'rgba(0, 86, 179, 1)',
                'rgba(200, 35, 51, 1)'
            ];

            const backgroundColors = finalCounts.map((_, index) => utsColors[index % utsColors.length]);
            const finalBorderColors = finalCounts.map((_, index) => borderColors[index % borderColors.length]);

            if (window.userChart && typeof window.userChart.destroy === 'function') {
                window.userChart.destroy();
            }

            console.log('Création du graphique...');

            window.userChart = new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: finalLabels,
                    datasets: [{
                        label: 'Nombre de matériels',
                        data: finalCounts,
                        backgroundColor: backgroundColors,
                        borderColor: finalBorderColors,
                        borderWidth: 3,
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(0, 0, 0, 0.9)',
                            titleColor: '#ffc107',
                            bodyColor: 'white',
                            borderColor: '#ffc107',
                            borderWidth: 2,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                title: function(context) {
                                    return context[0].label;
                                },
                                label: function(context) {
                                    const value = context.parsed.y;
                                    return `Matériels: ${value}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#666',
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : '';
                                }
                            },
                            grid: {
                                color: 'rgba(255, 193, 7, 0.1)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                color: '#666',
                                maxRotation: 45,
                                minRotation: 0
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    animation: {
                        duration: 1200,
                        easing: 'easeOutQuart',
                        onComplete: function() {
                            console.log('Animation du graphique terminée');
                            document.getElementById('chartLoading').style.display = 'none';
                        }
                    }
                }
            });

            console.log('Graphique créé avec succès');

        } catch (error) {
            console.error('Erreur lors de la création du graphique:', error);
            document.getElementById('chartLoading').innerHTML = `
                <div class="text-center">
                    <i class="fas fa-times text-danger" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-0">Erreur: ${error.message}</p>
                    <small class="text-muted">Consultez la console pour plus de détails</small>
                </div>
            `;
        }
    }

    // Animation d'entrée pour les cartes
    function animateCards() {
        const cards = document.querySelectorAll('.stats-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.animation = `slideIn 0.6s ease forwards`;
        });
    }

    // Initialisation
    console.log('DOM chargé, initialisation en cours...');

    function waitForChart() {
        if (typeof Chart !== 'undefined') {
            console.log('Chart.js est chargé');
            animateCounters();
            animateCards();
            setTimeout(initChart, 100);
        } else {
            console.log('En attente de Chart.js...');
            setTimeout(waitForChart, 100);
        }
    }

    waitForChart();

    // Actualisation périodique des notifications (optionnel)
    setInterval(() => {
        // Code pour actualiser les notifications via AJAX si nécessaire
    }, 60000);
});

// Gestion des erreurs
window.addEventListener('error', function(e) {
    console.error('Erreur JavaScript:', e.error);
});
</script>
@endpush
