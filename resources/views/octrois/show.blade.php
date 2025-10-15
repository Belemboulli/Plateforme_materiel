@extends('layouts.app')

@section('title', 'Détails de l'Octroi')

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
        background: linear-gradient(135deg, var(--uts-yellow) 0%, #FFB300 100%);
        color: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(255, 193, 7, 0.3);
    }

    .details-card {
        border: none;
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .details-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: var(--uts-dark);
        color: white;
        padding: 1.5rem 2rem;
        border: none;
    }

    .info-row {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--uts-green);
        transition: all 0.3s ease;
    }

    .info-row:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .info-label {
        font-weight: 600;
        color: var(--uts-dark);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1.1rem;
        color: #495057;
        margin: 0;
    }

    .badge {
        font-size: 1rem;
        padding: 0.6em 1em;
        border-radius: 8px;
        font-weight: 500;
    }

    .bg-success {
        background-color: var(--uts-green) !important;
    }

    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-secondary {
        background: var(--uts-dark);
        border-color: var(--uts-dark);
        color: white;
    }

    .btn-secondary:hover {
        background: #1a252f;
        border-color: #1a252f;
        transform: translateY(-2px);
    }

    .btn-warning {
        background: var(--uts-yellow);
        border-color: var(--uts-yellow);
        color: #333;
    }

    .btn-warning:hover {
        background: #e0a800;
        border-color: #e0a800;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: var(--uts-red);
        border-color: var(--uts-red);
    }

    .btn-danger:hover {
        background: #c82333;
        border-color: #c82333;
        transform: translateY(-2px);
    }

    .status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--uts-green);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }

    .actions-section {
        background: var(--uts-light);
        border-radius: 12px;
        padding: 2rem;
        margin-top: 2rem;
        text-align: center;
    }

    .timeline-item {
        border-left: 3px solid var(--uts-green);
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--uts-green);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="icon-circle">
                    <i class="bi bi-eye-fill fs-4"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-1">Octroi #{{ $octroi->id }}</h2>
                    <p class="mb-0 opacity-75">Détails de l'attribution</p>
                </div>
            </div>
            <a href="{{ route('octrois.index') }}" class="btn btn-secondary btn-lg">
                <i class="bi bi-arrow-left me-2"></i>
                Retour à la liste
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10">
            <!-- Carte principale -->
            <div class="details-card position-relative">
                <span class="status-badge">
                    <i class="bi bi-check-circle me-1"></i>
                    Actif
                </span>

                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Informations Principales
                    </h4>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Informations principales -->
                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-tag-fill me-1"></i>
                                    Nom de l'Octroi
                                </div>
                                <p class="info-value">{{ $octroi->name ?? $octroi->materiel->nom ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-building me-1"></i>
                                    Structure Bénéficiaire
                                </div>
                                <p class="info-value">
                                    <span class="badge bg-light text-dark">
                                        {{ $octroi->structure->nom ?? '—' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-box-seam me-1"></i>
                                    Matériel Attribué
                                </div>
                                <p class="info-value">{{ $octroi->materiel->nom ?? '—' }}</p>
                                @if($octroi->materiel->code ?? false)
                                    <small class="text-muted">Code: {{ $octroi->materiel->code }}</small>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-row">
                                <div class="info-label">
                                    <i class="bi bi-123 me-1"></i>
                                    Quantité Attribuée
                                </div>
                                <p class="info-value">
                                    <span class="badge bg-success fs-6">{{ $octroi->quantite }} unités</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="mt-5">
                        <h5 class="mb-4">
                            <i class="bi bi-clock-history me-2"></i>
                            Historique
                        </h5>

                        <div class="timeline-item">
                            <div class="info-label">
                                <i class="bi bi-plus-circle me-1"></i>
                                Date de Création
                            </div>
                            <p class="info-value">{{ $octroi->created_at->format('d/m/Y à H:i') }}</p>
                            <small class="text-muted">{{ $octroi->created_at->diffForHumans() }}</small>
                        </div>

                        @if($octroi->updated_at != $octroi->created_at)
                        <div class="timeline-item">
                            <div class="info-label">
                                <i class="bi bi-pencil-square me-1"></i>
                                Dernière Modification
                            </div>
                            <p class="info-value">{{ $octroi->updated_at->format('d/m/Y à H:i') }}</p>
                            <small class="text-muted">{{ $octroi->updated_at->diffForHumans() }}</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="actions-section">
                <h5 class="mb-4">
                    <i class="bi bi-gear me-2"></i>
                    Actions Disponibles
                </h5>

                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('octrois.edit', $octroi->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-2"></i>
                        Modifier
                    </a>

                    <form action="{{ route('octrois.destroy', $octroi->id) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('⚠️ Confirmer la suppression ?\n\nCette action est irréversible.');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>
                            Supprimer
                        </button>
                    </form>

                    <a href="{{ route('octrois.index') }}" class="btn btn-secondary">
                        <i class="bi bi-list me-2"></i>
                        Voir tous les octrois
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Animation d'entrée des éléments
document.addEventListener('DOMContentLoaded', function() {
    const infoRows = document.querySelectorAll('.info-row');
    const timelineItems = document.querySelectorAll('.timeline-item');

    // Animation des cartes d'information
    infoRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(30px)';

        setTimeout(() => {
            row.style.transition = 'all 0.6s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Animation de la timeline
    timelineItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-30px)';

        setTimeout(() => {
            item.style.transition = 'all 0.6s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, (infoRows.length * 100) + (index * 150));
    });
});

// Confirmation de suppression améliorée pour tous les formulaires DELETE
document.querySelectorAll('form[method="POST"]').forEach(form => {
    if (form.querySelector('input[name="_method"][value="DELETE"]')) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Récupération du nom de l'octroi à supprimer
            const octroiName = '{{ $octroi->materiel->nom ?? $octroi->name ?? "cet octroi" }}';

            if (confirm(`⚠️ Supprimer l'octroi "${octroiName}" ?\n\nCette action est définitive et irréversible.`)) {
                this.submit();
            }
        });
    }
});
</script>
@endpush

@endsection
