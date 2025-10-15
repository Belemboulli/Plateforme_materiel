@extends('layouts.app')

@push('styles')
<style>
    :root {
        --uts-yellow: #FFC107;
        --uts-green: #28A745;
        --uts-red: #DC3545;
        --uts-dark: #2C3E50;
        --uts-light: #F8F9FA;
    }

    .page-header {
        background: linear-gradient(135deg, var(--uts-yellow) 0%, #E6AC00 100%);
        color: var(--uts-dark);
        border-radius: 15px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 30px rgba(255, 193, 7, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::after {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: rotate(45deg);
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 1rem;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: rgba(44, 62, 80, 0.6);
        font-weight: bold;
    }

    .breadcrumb-item a {
        color: var(--uts-dark);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: #1a252f;
    }

    .main-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
        background: white;
    }

    .main-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .card-header-custom {
        background: var(--uts-dark);
        color: white;
        padding: 2rem;
        border: none;
    }

    .info-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--uts-yellow);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .info-section:hover {
        border-left-color: var(--uts-green);
        transform: translateX(5px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.1);
    }

    .field-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1rem;
        position: relative;
        transition: all 0.3s ease;
    }

    .field-box.success {
        border-color: rgba(40, 167, 69, 0.3);
        background: rgba(40, 167, 69, 0.05);
    }

    .field-box.danger {
        border-color: rgba(220, 53, 69, 0.3);
        background: rgba(220, 53, 69, 0.05);
    }

    .field-box.warning {
        border-color: rgba(255, 193, 7, 0.3);
        background: rgba(255, 193, 7, 0.05);
    }

    .field-box.secondary {
        border-color: rgba(108, 117, 125, 0.3);
        background: rgba(108, 117, 125, 0.05);
    }

    .field-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .field-icon.success {
        background: rgba(40, 167, 69, 0.2);
        color: var(--uts-green);
    }

    .field-icon.danger {
        background: rgba(220, 53, 69, 0.2);
        color: var(--uts-red);
    }

    .field-icon.warning {
        background: rgba(255, 193, 7, 0.2);
        color: var(--uts-yellow);
    }

    .field-icon.secondary {
        background: rgba(108, 117, 125, 0.2);
        color: #6c757d;
    }

    .field-label {
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 0.3rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .field-value {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 0.2rem;
    }

    .field-unit {
        font-size: 0.8rem;
        color: #6c757d;
        font-weight: 500;
    }

    .summary-card {
        background: linear-gradient(135deg, var(--uts-light) 0%, #ffffff 100%);
        border: 2px solid #dee2e6;
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .summary-item {
        text-align: center;
        padding: 1rem;
        border-radius: 10px;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .summary-item:hover {
        transform: translateY(-3px);
    }

    .summary-value {
        font-size: 2rem;
        font-weight: 900;
        margin-bottom: 0.3rem;
    }

    .summary-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .action-buttons {
        background: var(--uts-light);
        border-radius: 15px;
        padding: 2rem;
        border: 2px solid #dee2e6;
    }

    .btn {
        border-radius: 10px;
        font-weight: 700;
        padding: 0.8rem 2rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        margin: 0.3rem;
    }

    .btn-success {
        background: var(--uts-green);
        border-color: var(--uts-green);
        color: white;
    }

    .btn-success:hover {
        background: #218838;
        border-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
    }

    .btn-danger {
        background: var(--uts-red);
        border-color: var(--uts-red);
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
        border-color: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
    }

    .btn-outline-secondary {
        border-color: var(--uts-dark);
        color: var(--uts-dark);
    }

    .btn-outline-secondary:hover {
        background: var(--uts-dark);
        border-color: var(--uts-dark);
        color: white;
        transform: translateY(-2px);
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-excellent {
        background: var(--uts-green);
        color: white;
    }

    .status-warning {
        background: var(--uts-yellow);
        color: var(--uts-dark);
    }

    .status-danger {
        background: var(--uts-red);
        color: white;
    }

    .ecart-display {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.05) 100%);
        border: 2px solid rgba(255, 193, 7, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1rem;
        text-align: center;
    }

    .observations-box {
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.1) 0%, rgba(108, 117, 125, 0.05) 100%);
        border: 2px solid rgba(108, 117, 125, 0.2);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .info-section {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .field-box {
            padding: 1rem;
        }

        .summary-card {
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .summary-value {
            font-size: 1.5rem;
        }

        .action-buttons {
            padding: 1.5rem;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            font-size: 0.8rem;
            width: 100%;
            margin: 0.2rem 0;
        }
    }

    @media (max-width: 576px) {
        .page-header .d-flex {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .field-box .d-flex {
            flex-direction: column;
            text-align: center;
        }

        .field-icon {
            margin: 0 auto 1rem auto;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête avec breadcrumb -->
    <div class="page-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('inventaires.index') }}">
                        <i class="bi bi-boxes me-1"></i>Inventaires
                    </a>
                </li>
                <li class="breadcrumb-item active">Détails #{{ $inventaire->id }}</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold mb-2">
                    <i class="bi bi-eye text-dark me-2"></i>
                    Détails de l'Inventaire
                </h1>
                <p class="mb-0 opacity-75">Consultation complète de l'inventaire #{{ $inventaire->id }}</p>
            </div>
            <a href="{{ route('inventaires.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <div class="main-card card">
                <div class="card-header-custom">
                    <div class="d-flex align-items-center">
                        <div class="field-icon warning me-3">
                            <i class="bi bi-clipboard-data fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">Inventaire #{{ $inventaire->id }}</h4>
                            <small class="opacity-75">
                                Créé le {{ $inventaire->created_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Section Matériel -->
                    <div class="info-section">
                        <h5 class="section-title text-dark fw-bold mb-3">
                            <i class="bi bi-gear-fill text-warning me-2"></i>
                            Informations Matériel
                        </h5>

                        <div class="field-box warning">
                            <div class="d-flex align-items-center">
                                <div class="field-icon warning">
                                    <i class="bi bi-box fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="field-label text-warning">Matériel</div>
                                    <div class="field-value text-dark">{{ $inventaire->materiel->nom ?? 'Matériel non défini' }}</div>
                                    <div class="field-unit">
                                        Réf: {{ $inventaire->materiel->reference ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Calcul écart si stock système disponible -->
                        @if($inventaire->materiel && $inventaire->materiel->quantite !== null)
                            @php
                                $totalInventorie = $inventaire->quantite_disponible + $inventaire->quantite_utilisee +
                                                 ($inventaire->quantite_defaillante ?? 0) + ($inventaire->quantite_perdue ?? 0);
                                $stockSysteme = $inventaire->materiel->quantite;
                                $ecart = $totalInventorie - $stockSysteme;
                            @endphp

                            <div class="ecart-display">
                                <h6 class="text-dark fw-bold mb-2">
                                    <i class="bi bi-calculator me-2"></i>Analyse des Écarts
                                </h6>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <div class="fw-bold fs-5 text-primary">{{ $stockSysteme }}</div>
                                        <small class="text-muted">Stock Système</small>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div class="fw-bold fs-5 text-success">{{ $totalInventorie }}</div>
                                        <small class="text-muted">Total Inventorié</small>
                                    </div>
                                    <div class="col-4 text-center">
                                        <div class="fw-bold fs-5 {{ $ecart == 0 ? 'text-success' : ($ecart > 0 ? 'text-info' : 'text-warning') }}">
                                            {{ $ecart > 0 ? '+' : '' }}{{ $ecart }}
                                        </div>
                                        <small class="text-muted">Écart</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Section Quantités -->
                    <div class="info-section">
                        <h5 class="section-title text-dark fw-bold mb-3">
                            <i class="bi bi-bar-chart text-success me-2"></i>
                            Répartition des Quantités
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="field-box success">
                                    <div class="d-flex align-items-center">
                                        <div class="field-icon success">
                                            <i class="bi bi-archive fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="field-label text-success">Quantité Disponible</div>
                                            <div class="field-value text-success">{{ $inventaire->quantite_disponible }}</div>
                                            <div class="field-unit">unités en stock</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="field-box danger">
                                    <div class="d-flex align-items-center">
                                        <div class="field-icon danger">
                                            <i class="bi bi-check-circle fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="field-label text-danger">Quantité Utilisée</div>
                                            <div class="field-value text-danger">{{ $inventaire->quantite_utilisee }}</div>
                                            <div class="field-unit">unités consommées</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="field-box warning">
                                    <div class="d-flex align-items-center">
                                        <div class="field-icon warning">
                                            <i class="bi bi-exclamation-triangle fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="field-label text-warning">Quantité Défaillante</div>
                                            <div class="field-value text-warning">{{ $inventaire->quantite_defaillante ?? 0 }}</div>
                                            <div class="field-unit">unités défectueuses</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="field-box secondary">
                                    <div class="d-flex align-items-center">
                                        <div class="field-icon secondary">
                                            <i class="bi bi-question-circle fs-5"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="field-label text-muted">Quantité Perdue</div>
                                            <div class="field-value text-muted">{{ $inventaire->quantite_perdue ?? 0 }}</div>
                                            <div class="field-unit">unités manquantes</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Date et Observations -->
                    <div class="info-section">
                        <h5 class="section-title text-dark fw-bold mb-3">
                            <i class="bi bi-calendar3 text-primary me-2"></i>
                            Informations Complémentaires
                        </h5>

                        <div class="field-box">
                            <div class="d-flex align-items-center">
                                <div class="field-icon secondary">
                                    <i class="bi bi-calendar-event fs-5"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="field-label text-muted">Date d'Inventaire</div>
                                    <div class="field-value text-dark">
                                        {{ Carbon\Carbon::parse($inventaire->date_inventaire)->format('d/m/Y') }}
                                    </div>
                                    <div class="field-unit">
                                        {{ Carbon\Carbon::parse($inventaire->date_inventaire)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($inventaire->observations)
                        <div class="observations-box">
                            <h6 class="text-muted fw-bold mb-2">
                                <i class="bi bi-chat-text me-2"></i>Observations
                            </h6>
                            <p class="mb-0 text-dark">{{ $inventaire->observations }}</p>
                        </div>
                        @else
                        <div class="observations-box">
                            <h6 class="text-muted fw-bold mb-2">
                                <i class="bi bi-chat-text me-2"></i>Observations
                            </h6>
                            <p class="mb-0 text-muted fst-italic">Aucune observation enregistrée</p>
                        </div>
                        @endif
                    </div>

                    <!-- Résumé statistique -->
                    <div class="summary-card">
                        <h5 class="text-dark fw-bold mb-4 text-center">
                            <i class="bi bi-pie-chart text-warning me-2"></i>
                            Résumé Statistique
                        </h5>

                        @php
                            $total = $inventaire->quantite_disponible + $inventaire->quantite_utilisee +
                                   ($inventaire->quantite_defaillante ?? 0) + ($inventaire->quantite_perdue ?? 0);
                            $pourcentageUtilise = $total > 0 ? round(($inventaire->quantite_utilisee / $total) * 100, 1) : 0;
                            $pourcentageDisponible = $total > 0 ? round(($inventaire->quantite_disponible / $total) * 100, 1) : 0;
                        @endphp

                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <div class="summary-item">
                                    <div class="summary-value text-primary">{{ $total }}</div>
                                    <div class="summary-label">Total</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="summary-item">
                                    <div class="summary-value text-success">{{ $pourcentageDisponible }}%</div>
                                    <div class="summary-label">Disponible</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="summary-item">
                                    <div class="summary-value text-danger">{{ $pourcentageUtilise }}%</div>
                                    <div class="summary-label">Utilisé</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="summary-item">
                                    <div class="summary-value text-warning">
                                        {{ (($inventaire->quantite_defaillante ?? 0) + ($inventaire->quantite_perdue ?? 0)) }}
                                    </div>
                                    <div class="summary-label">Problèmes</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="action-buttons">
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="{{ route('inventaires.edit', $inventaire->id) }}" class="btn btn-success">
                            <i class="bi bi-pencil me-2"></i>
                            Modifier l'Inventaire
                        </a>
                        <form action="{{ route('inventaires.destroy', $inventaire->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Confirmer la suppression de cet inventaire ?')">
                                <i class="bi bi-trash me-2"></i>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne latérale -->
        <div class="col-lg-4">
            <div class="main-card card h-100">
                <div class="card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Analyse et Statut
                    </h5>
                </div>

                <div class="card-body">
                    <!-- Informations système -->
                    <div class="mb-4">
                        <h6 class="text-dark fw-bold mb-3">Informations Système</h6>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted">ID Inventaire</span>
                            <code class="fw-bold">#{{ $inventaire->id }}</code>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted">Matériel ID</span>
                            <code class="fw-bold">#{{ $inventaire->materiel_id }}</code>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="text-muted">Dernière MAJ</span>
                            <span class="fw-bold">{{ $inventaire->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <!-- Statut du stock -->
                    <div class="mb-4">
                        <h6 class="text-dark fw-bold mb-3">Statut du Stock</h6>
                        <div class="d-flex justify-content-between align-items-center py-2">
                            <span class="text-muted">Niveau de stock</span>
                            @if($inventaire->quantite_disponible > 20)
                                <span class="status-badge status-excellent">Excellent</span>
                            @elseif($inventaire->quantite_disponible > 5)
                                <span class="status-badge status-warning">Moyen</span>
                            @elseif($inventaire->quantite_disponible > 0)
                                <span class="status-badge status-danger">Faible</span>
                            @else
                                <span class="status-badge status-danger">Rupture</span>
                            @endif
                        </div>
                    </div>

                    <!-- Conseil -->
                    <div class="field-box warning">
                        <div class="d-flex align-items-start">
                            <div class="field-icon warning me-3">
                                <i class="bi bi-lightbulb fs-5"></i>
                            </div>
                            <div>
                                <h6 class="text-warning fw-bold mb-2">Conseil UTS</h6>
                                <p class="text-dark mb-0 small">
                                    @if($inventaire->quantite_disponible == 0)
                                        Stock en rupture ! Planifiez un réapprovisionnement urgent.
                                    @elseif($inventaire->quantite_disponible < 5)
                                        Stock faible. Envisagez une commande de réapprovisionnement.
                                    @else
                                        Surveillez l'évolution du stock pour maintenir un niveau optimal.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
