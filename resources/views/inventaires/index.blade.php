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
    }

    .stats-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .stats-card.warning {
        border-left: 4px solid var(--uts-yellow);
        background: rgba(255, 193, 7, 0.05);
    }

    .stats-card.success {
        border-left: 4px solid var(--uts-green);
        background: rgba(40, 167, 69, 0.05);
    }

    .stats-card.danger {
        border-left: 4px solid var(--uts-red);
        background: rgba(220, 53, 69, 0.05);
    }

    .main-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-header-custom {
        background: var(--uts-dark);
        color: white;
        padding: 1.5rem 2rem;
        border: none;
    }

    .table-container {
        background: white;
    }

    .table thead th {
        background: var(--uts-light);
        border: none;
        color: var(--uts-dark);
        font-weight: 700;
        padding: 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background: rgba(255, 193, 7, 0.05);
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
        color: var(--uts-dark);
    }

    .material-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 193, 7, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.8rem;
        flex-shrink: 0;
    }

    .badge-custom {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-success {
        background: var(--uts-green);
        color: white;
    }

    .badge-danger {
        background: var(--uts-red);
        color: white;
    }

    .badge-warning {
        background: var(--uts-yellow);
        color: var(--uts-dark);
    }

    .btn-group .btn {
        border-radius: 6px;
        margin: 0 2px;
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    .btn-outline-warning {
        border-color: var(--uts-yellow);
        color: var(--uts-yellow);
    }

    .btn-outline-warning:hover {
        background: var(--uts-yellow);
        color: var(--uts-dark);
        border-color: var(--uts-yellow);
    }

    .btn-outline-success {
        border-color: var(--uts-green);
        color: var(--uts-green);
    }

    .btn-outline-success:hover {
        background: var(--uts-green);
        color: white;
        border-color: var(--uts-green);
    }

    .btn-outline-danger {
        border-color: var(--uts-red);
        color: var(--uts-red);
    }

    .btn-outline-danger:hover {
        background: var(--uts-red);
        color: white;
        border-color: var(--uts-red);
    }

    .btn-success {
        background: var(--uts-green);
        border-color: var(--uts-green);
    }

    .btn-success:hover {
        background: #218838;
        border-color: #218838;
        transform: translateY(-2px);
    }

    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.3rem;
        }

        .page-header .btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.85rem;
        }

        .stats-card .card-body {
            padding: 1rem;
        }

        .stats-card h5 {
            font-size: 1.2rem;
        }

        .stats-card i {
            font-size: 1.5rem !important;
        }

        .card-header-custom {
            padding: 1rem 1.5rem;
        }

        .card-header-custom h5 {
            font-size: 1rem;
        }

        .table {
            font-size: 0.8rem;
        }

        .table thead th {
            padding: 0.6rem 0.3rem;
            font-size: 0.7rem;
        }

        .table td {
            padding: 0.6rem 0.3rem;
        }

        .material-icon {
            width: 30px;
            height: 30px;
        }

        .btn-group .btn {
            padding: 0.3rem 0.5rem;
            font-size: 0.7rem;
            margin: 0 1px;
        }

        .badge-custom {
            padding: 0.3rem 0.6rem;
            font-size: 0.7rem;
        }

        /* Masquer certaines colonnes sur mobile */
        .table th:nth-child(5),
        .table td:nth-child(5),
        .table th:nth-child(6),
        .table td:nth-child(6),
        .table th:nth-child(9),
        .table td:nth-child(9) {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .page-header .d-flex {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .stats-card {
            margin-bottom: 1rem;
        }

        .table {
            font-size: 0.75rem;
        }

        .table thead th {
            padding: 0.5rem 0.2rem;
            font-size: 0.65rem;
        }

        .table td {
            padding: 0.5rem 0.2rem;
        }

        .material-icon {
            width: 25px;
            height: 25px;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .btn-group .btn {
            padding: 0.25rem 0.4rem;
            font-size: 0.65rem;
        }

        .empty-state {
            padding: 2rem 1rem;
        }

        .empty-state i {
            font-size: 2rem;
        }

        /* Masquer plus de colonnes sur très petit écran */
        .table th:nth-child(7),
        .table td:nth-child(7) {
            display: none;
        }
    }

    @media (max-width: 400px) {
        .container-fluid {
            padding: 0.5rem;
        }

        .page-header {
            padding: 0.8rem 1rem;
            border-radius: 10px;
        }

        .main-card {
            border-radius: 10px;
        }

        .table {
            font-size: 0.7rem;
        }

        .badge-custom {
            padding: 0.2rem 0.4rem;
            font-size: 0.6rem;
        }

        /* Afficher uniquement les colonnes essentielles */
        .table th:nth-child(8),
        .table td:nth-child(8) {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold mb-2">
                    <i class="bi bi-boxes text-dark me-2"></i>
                    Gestion des Inventaires
                </h1>
                <p class="mb-0 opacity-75">Suivi et contrôle des stocks matériels</p>
            </div>
            <a href="{{ route('inventaires.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle me-2"></i>
                Nouvel Inventaire
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stats-card warning card h-100">
                <div class="card-body text-center py-3">
                    <i class="bi bi-archive text-warning fs-2 mb-2"></i>
                    <h5 class="text-warning fw-bold mb-1">{{ $inventaires->count() }}</h5>
                    <small class="text-muted">Total Inventaires</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card success card h-100">
                <div class="card-body text-center py-3">
                    <i class="bi bi-check-circle text-success fs-2 mb-2"></i>
                    <h5 class="text-success fw-bold mb-1">{{ $inventaires->sum('quantite_disponible') }}</h5>
                    <small class="text-muted">Stock Disponible</small>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card danger card h-100">
                <div class="card-body text-center py-3">
                    <i class="bi bi-exclamation-triangle text-danger fs-2 mb-2"></i>
                    <h5 class="text-danger fw-bold mb-1">
                        {{ $inventaires->sum('quantite_defaillante') + $inventaires->sum('quantite_perdue') }}
                    </h5>
                    <small class="text-muted">Défaillant + Perdu</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau principal -->
    <div class="main-card card">
        <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-list-ul me-2"></i>
                    Liste des Inventaires
                </h5>
                <span class="badge badge-warning">{{ $inventaires->count() }} éléments</span>
            </div>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th><i class="bi bi-gear-fill text-warning me-2"></i>Matériel</th>
                            <th class="text-center"><i class="bi bi-archive text-success me-1"></i>Dispo</th>
                            <th class="text-center"><i class="bi bi-minus-circle text-danger me-1"></i>Utilisé</th>
                            <th class="text-center"><i class="bi bi-exclamation-triangle text-warning me-1"></i>Défaillante</th>
                            <th class="text-center"><i class="bi bi-question-circle text-danger me-1"></i>Perdue</th>
                            <th class="text-center"><i class="bi bi-calculator text-warning me-1"></i>Total</th>
                            <th><i class="bi bi-calendar3 text-warning me-1"></i>Date</th>
                            <th><i class="bi bi-chat-text text-warning me-1"></i>Observations</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventaires as $inventaire)
                            <tr>
                                <td class="text-center fw-bold text-warning">#{{ $inventaire->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="material-icon">
                                            <i class="bi bi-box text-warning"></i>
                                        </div>
                                        <div>
                                            <span class="fw-medium d-block">{{ $inventaire->materiel->nom ?? 'Matériel non défini' }}</span>
                                            <small class="text-muted">Réf: {{ $inventaire->materiel->reference ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-custom badge-success">
                                        {{ $inventaire->quantite_disponible }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-custom badge-danger">
                                        {{ $inventaire->quantite_utilisee }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-custom badge-warning">
                                        {{ $inventaire->quantite_defaillante ?? 0 }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-custom" style="background: #6c757d; color: white;">
                                        {{ $inventaire->quantite_perdue ?? 0 }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-dark bg-light rounded px-2 py-1">
                                        {{ ($inventaire->quantite_disponible + $inventaire->quantite_utilisee + ($inventaire->quantite_defaillante ?? 0) + ($inventaire->quantite_perdue ?? 0)) }}
                                    </span>
                                </td>
                                <td class="text-muted">
                                    <i class="bi bi-calendar3 text-warning me-1"></i>
                                    {{ \Carbon\Carbon::parse($inventaire->date_inventaire)->format('d/m/Y') }}
                                </td>
                                <td class="text-muted">
                                    @if($inventaire->observations)
                                        <span class="text-truncate d-inline-block" style="max-width: 120px;" title="{{ $inventaire->observations }}">
                                            {{ $inventaire->observations }}
                                        </span>
                                    @else
                                        <em class="text-muted small">Aucune</em>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('inventaires.show', $inventaire->id) }}"
                                           class="btn btn-outline-warning" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('inventaires.edit', $inventaire->id) }}"
                                           class="btn btn-outline-success" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('inventaires.destroy', $inventaire->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"
                                                    title="Supprimer"
                                                    onclick="return confirm('Confirmer la suppression de cet inventaire ?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="empty-state">
                                        <i class="bi bi-box-seam"></i>
                                        <h6 class="text-muted mb-2">Aucun inventaire trouvé</h6>
                                        <p class="text-muted small mb-3">Commencez par créer votre premier inventaire</p>
                                        <a href="{{ route('inventaires.create') }}" class="btn btn-success btn-sm">
                                            <i class="bi bi-plus me-2"></i>Créer un inventaire
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
