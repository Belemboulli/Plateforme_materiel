@extends('layouts.app')

@section('title', 'Tableau de bord - UTS')

@push('styles')
<style>
    :root {
        --primary: #1a472a;
        --secondary: #16a34a;
        --accent: #f59e0b;
        --light: #f8fafc;
        --dark: #1f2937;
        --shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border-radius: 15px;
        margin-bottom: 2rem;
    }

    .stat-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow);
        overflow: hidden;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        opacity: 0.1;
        background: radial-gradient(circle, currentColor 30%, transparent 70%);
    }

    .menu-card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow);
        cursor: pointer;
        height: 100%;
    }

    .menu-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(0,0,0,0.1);
    }

    .menu-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .chart-card {
        border: none;
        border-radius: 15px;
        box-shadow: var(--shadow);
    }

    .badge-count {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 20px;
        padding: 0.25rem 0.75rem;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .text-truncate-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête du tableau de bord -->
    <div class="dashboard-header p-4 mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold mb-1">🎯 Tableau de Bord UTS</h2>
                <p class="mb-0 opacity-75">Vue d'ensemble de la gestion des matériels et ressources</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="badge badge-count">
                    📅 {{ date('d/m/Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques complètes -->
    <div class="row g-3 mb-4">
        <!-- Matériels -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card stat-card text-white" style="background: linear-gradient(135deg, #16a34a, #1a472a);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">Matériels</h6>
                            <h4 class="fw-bold mb-0">{{ $totalMateriels ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-desktop fs-4 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Catégories -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card stat-card text-white" style="background: linear-gradient(135deg, #2563eb, #1e40af);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">Catégories</h6>
                            <h4 class="fw-bold mb-0">{{ $totalCategories ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-tags fs-4 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card stat-card text-white" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">Services</h6>
                            <h4 class="fw-bold mb-0">{{ $totalServices ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-cogs fs-4 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Utilisateurs -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card stat-card text-white" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">Utilisateurs</h6>
                            <h4 class="fw-bold mb-0">{{ $totalUsers ?? 0 }}</h4>
                        </div>
                        <i class="fas fa-users fs-4 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Octrois -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card stat-card text-white" style="background: linear-gradient(135deg, #10b981, #059669);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">Octrois</h6>
                            <h4 class="fw-bold mb-0">{{ $totalOctrois ?? 0 }}</h4>
                        </div>
                        <span class="fs-4 opacity-75">📦</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Affectations -->
<div class="col-xl-3 col-lg-4 col-md-6">
    <div class="card stat-card text-white" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">Affectations</h6>
                    <h4 class="fw-bold mb-0">{{ $totalAffectations ?? 0 }}</h4>
                </div>
                <span class="fs-4 opacity-75">📦</span>
            </div>
        </div>
    </div>
</div>


        <!-- Inventaires -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card stat-card text-white" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">Inventaires</h6>
                            <h4 class="fw-bold mb-0">{{ $totalInventaires ?? 0 }}</h4>
                        </div>
                        <span class="fs-4 opacity-75">📋</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card stat-card text-white" style="background: linear-gradient(135deg, #f97316, #ea580c);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase opacity-75 mb-1" style="font-size: 0.7rem;">Notifications</h6>
                            <h4 class="fw-bold mb-0">{{ $totalNotifications ?? 0 }}</h4>
                        </div>
                        <span class="fs-4 opacity-75">🔔</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accès rapide aux modules -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="fw-bold text-dark mb-3">🔗 Accès Rapide</h5>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <a href="{{ route('octrois.index') }}" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body p-3 text-center">
                        <span class="fs-3 mb-2 d-block">📦</span>
                        <h6 class="fw-bold text-dark mb-1">Octrois</h6>
                        <small class="text-muted">Attributions matériels</small>
                    </div>
                </div>
            </a>
        </div>

       <div class="col-lg-3 col-md-6 mb-3">
    <a href="{{ route('affectations.index') }}" class="text-decoration-none">
        <div class="card menu-card h-100">
            <div class="card-body p-3 text-center">
                <span class="fs-3 mb-2 d-block">📌</span>
                <h6 class="fw-bold text-dark mb-1">Affectations</h6>
                <small class="text-muted">Gestion des affectations</small>
            </div>
        </div>
    </a>
</div>

        <div class="col-lg-3 col-md-6 mb-3">
            <a href="{{ route('inventaires.index') }}" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body p-3 text-center">
                        <span class="fs-3 mb-2 d-block">📋</span>
                        <h6 class="fw-bold text-dark mb-1">Inventaires</h6>
                        <small class="text-muted">États des stocks</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <a href="{{ route('permissions.index') }}" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body p-3 text-center">
                        <span class="fs-3 mb-2 d-block">🔐</span>
                        <h6 class="fw-bold text-dark mb-1">Permissions</h6>
                        <small class="text-muted">Droits d'accès</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <a href="{{ route('rapports.index') }}" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body p-3 text-center">
                        <span class="fs-3 mb-2 d-block">📊</span>
                        <h6 class="fw-bold text-dark mb-1">Rapports</h6>
                        <small class="text-muted">Analyses</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <a href="{{ route('roles.index') }}" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body p-3 text-center">
                        <span class="fs-3 mb-2 d-block">👥</span>
                        <h6 class="fw-bold text-dark mb-1">Rôles</h6>
                        <small class="text-muted">Utilisateurs</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <a href="{{ route('notifications.index') }}" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body p-3 text-center">
                        <span class="fs-3 mb-2 d-block">🔔</span>
                        <h6 class="fw-bold text-dark mb-1">Notifications</h6>
                        <small class="text-muted">Alertes</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <a href="{{ route('historiques_connexion.index') }}" class="text-decoration-none">
                <div class="card menu-card h-100">
                    <div class="card-body p-3 text-center">
                        <span class="fs-3 mb-2 d-block">📈</span>
                        <h6 class="fw-bold text-dark mb-1">Historique</h6>
                        <small class="text-muted">Connexions</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Graphique -->
    <div class="row">
        <div class="col-12">
            <div class="card chart-card">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">📈 Répartition des Matériels</h5>
                            <p class="text-muted small mb-0">Distribution par catégorie</p>
                        </div>
                        <div class="badge" style="background: var(--primary); color: white;">
                            {{ array_sum($materielsCounts ?? []) }} total
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="materielsChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique
    const ctx = document.getElementById('materielsChart');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($categoriesLabels ?? []),
                datasets: [{
                    label: 'Matériels',
                    data: @json($materielsCounts ?? []),
                    backgroundColor: 'rgba(22, 163, 74, 0.8)',
                    borderColor: '#16a34a',
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(26, 71, 42, 0.9)',
                        titleColor: 'white',
                        bodyColor: 'white'
                    }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Animation des cartes
    document.querySelectorAll('.stat-card, .menu-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush
@endsection
