@extends('layouts.app')

@section('title', 'Tableau de bord - Administrateur')

@push('styles')
<style>
    .dashboard-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .card-icon {
        font-size: 2.5rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .card-number {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        line-height: 1;
    }

    .card-label {
        font-size: 0.9rem;
        opacity: 0.95;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .chart-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
        color: #000;
        padding: 2rem 0;
        margin: -1.5rem -15px 2rem -15px;
        border-radius: 0 0 20px 20px;
    }

    .dashboard-title {
        font-size: 2.2rem;
        font-weight: 600;
        margin: 0;
        text-align: center;
        color: #000;
    }

    .dashboard-subtitle {
        text-align: center;
        opacity: 0.8;
        margin-top: 0.5rem;
        color: #333;
    }

    /* Couleurs UTS principales */
    .bg-gradient-yellow {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        color: #000;
    }

    .bg-gradient-green {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }

    .bg-gradient-red {
        background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
        color: white;
    }

    /* Couleur complémentaire - Bleu UTS */
    .bg-gradient-blue {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
    }

    .stats-row {
        margin-bottom: 2rem;
    }

    .chart-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .loading-spinner {
        display: none;
        text-align: center;
        padding: 2rem;
    }

    .error-message {
        display: none;
        background: #f8d7da;
        color: #721c24;
        padding: 1rem;
        border-radius: 8px;
        margin: 1rem 0;
    }

    /* Couleurs pour les sections supplémentaires */
    .card-header.bg-light {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        border-bottom: 2px solid #ffc107;
    }

    .text-primary {
        color: #ffc107 !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .border-primary {
        border-color: #ffc107 !important;
    }

    .spinner-border.text-primary {
        color: #ffc107 !important;
    }

    @media (max-width: 768px) {
        .dashboard-header {
            margin: -1rem -15px 1.5rem -15px;
            padding: 1.5rem 0;
        }

        .dashboard-title {
            font-size: 1.8rem;
        }

        .card-number {
            font-size: 1.5rem;
        }

        .card-icon {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- En-tête du tableau de bord -->
    <div class="dashboard-header">
        <div class="container">
            <h1 class="dashboard-title">
                <i class="fas fa-tachometer-alt me-2"></i>
                Tableau de Bord Administrateur
            </h1>
            <p class="dashboard-subtitle">Vue d'ensemble du système UTS</p>
        </div>
    </div>

    <div class="container">
        <!-- Message d'erreur -->
        <div class="error-message" id="errorMessage">
            Une erreur s'est produite lors du chargement des données.
        </div>

        <!-- Cartes statistiques principales -->
        <div class="row stats-row">
            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="card dashboard-card text-white bg-gradient-yellow">
                    <div class="card-body text-center py-4">
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <p class="card-number">{{ number_format($totalUsers ?? 0) }}</p>
                        <p class="card-label">Utilisateurs</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="card dashboard-card text-white bg-gradient-green">
                    <div class="card-body text-center py-4">
                        <div class="card-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <p class="card-number">{{ number_format($totalRoles ?? 0) }}</p>
                        <p class="card-label">Rôles</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="card dashboard-card text-white bg-gradient-blue">
                    <div class="card-body text-center py-4">
                        <div class="card-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <p class="card-number">{{ number_format($totalOctrois ?? 0) }}</p>
                        <p class="card-label">Octrois</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="card dashboard-card text-white bg-gradient-red">
                    <div class="card-body text-center py-4">
                        <div class="card-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <p class="card-number">{{ number_format($totalRapports ?? 0) }}</p>
                        <p class="card-label">Rapports</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section graphique -->
        <div class="row">
            <div class="col-12">
                <div class="chart-container">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>
                        Répartition des Matériels par Catégorie
                    </h3>

                    <!-- Spinner de chargement -->
                    <div class="loading-spinner" id="loadingSpinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                        <p class="mt-2">Chargement du graphique...</p>
                    </div>

                    <!-- Canvas pour le graphique -->
                    <div style="position: relative; height: 400px;">
                        <canvas id="adminChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section statistiques supplémentaires -->
        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-clock me-2 text-primary"></i>
                            Activités Récentes
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($recentActivities) && count($recentActivities) > 0)
                            @foreach($recentActivities as $activity)
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-3">
                                        <i class="fas fa-circle text-primary" style="font-size: 0.5rem;"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">{{ $activity->created_at ?? 'N/A' }}</small>
                                        <p class="mb-0">{{ $activity->description ?? 'Activité récente' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center mb-0">Aucune activité récente</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card dashboard-card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Informations Système
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 border-end border-primary">
                                <h4 class="text-primary mb-1">{{ $systemInfo['uptime'] ?? '99.9%' }}</h4>
                                <small class="text-muted">Disponibilité</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success mb-1">{{ $systemInfo['version'] ?? 'v1.0.0' }}</h4>
                                <small class="text-muted">Version</small>
                            </div>
                        </div>
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
    // Données pour le graphique
    const categoriesLabels = @json($categoriesLabels ?? ['Aucune catégorie']);
    const materielsCounts = @json($materielsCounts ?? [0]);

    // Vérification des données
    if (!categoriesLabels.length || !materielsCounts.length) {
        document.getElementById('loadingSpinner').style.display = 'none';
        document.getElementById('errorMessage').style.display = 'block';
        return;
    }

    // Configuration du graphique
    const ctx = document.getElementById('adminChart');
    if (!ctx) {
        console.error('Canvas element not found');
        return;
    }

    try {
        // Affichage du spinner
        document.getElementById('loadingSpinner').style.display = 'block';

        // Couleurs UTS pour le graphique
        const utsColors = [
            'rgba(255, 193, 7, 0.8)',   // Jaune UTS principal
            'rgba(40, 167, 69, 0.8)',   // Vert UTS
            'rgba(220, 53, 69, 0.8)',   // Rouge UTS
            'rgba(0, 123, 255, 0.8)',   // Bleu complémentaire
            'rgba(255, 179, 0, 0.8)',   // Jaune variant
            'rgba(32, 201, 151, 0.8)',  // Vert variant
            'rgba(231, 76, 60, 0.8)',   // Rouge variant
            'rgba(108, 117, 125, 0.8)'  // Gris neutre
        ];

        const borderColors = [
            'rgba(255, 193, 7, 1)',
            'rgba(40, 167, 69, 1)',
            'rgba(220, 53, 69, 1)',
            'rgba(0, 123, 255, 1)',
            'rgba(255, 179, 0, 1)',
            'rgba(32, 201, 151, 1)',
            'rgba(231, 76, 60, 1)',
            'rgba(108, 117, 125, 1)'
        ];

        const adminChart = new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: categoriesLabels,
                datasets: [{
                    label: 'Nombre de matériels',
                    data: materielsCounts,
                    backgroundColor: utsColors.slice(0, categoriesLabels.length),
                    borderColor: borderColors.slice(0, categoriesLabels.length),
                    borderWidth: 3,
                    hoverOffset: 15,
                    hoverBorderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 13,
                                weight: '500'
                            },
                            color: '#333'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        },
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        titleColor: '#ffc107',
                        bodyColor: 'white',
                        borderColor: '#ffc107',
                        borderWidth: 2,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1200,
                    easing: 'easeInOutQuart',
                    onComplete: function() {
                        document.getElementById('loadingSpinner').style.display = 'none';
                    }
                }
            }
        });

        // Animation des cartes au chargement
        const cards = document.querySelectorAll('.dashboard-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';

            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 150);
        });

    } catch (error) {
        console.error('Erreur lors de la création du graphique:', error);
        document.getElementById('loadingSpinner').style.display = 'none';
        document.getElementById('errorMessage').style.display = 'block';
        document.getElementById('errorMessage').textContent = 'Erreur lors du chargement du graphique: ' + error.message;
    }
});

// Fonction pour actualiser les données (optionnelle)
function refreshDashboard() {
    console.log('Actualisation du tableau de bord...');
}

// Gestion des erreurs globales
window.addEventListener('error', function(e) {
    console.error('Erreur JavaScript:', e.error);
});
</script>
@endpush
