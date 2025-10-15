@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-2 text-gray-800 fw-bold">
                        <i class="fas fa-eye text-info me-2"></i>
                        Détails de l'affectation #{{ $affectation->id }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Tableau de bord</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('affectations.index') }}" class="text-decoration-none">Affectations</a></li>
                            <li class="breadcrumb-item active">Détails #{{ $affectation->id }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    @php
                        $statusColors = [
                            'en cours' => 'success',
                            'terminé' => 'primary',
                            'annulé' => 'danger',
                            'en attente' => 'warning'
                        ];
                        $statusIcons = [
                            'en cours' => 'play-circle',
                            'terminé' => 'check-circle',
                            'annulé' => 'times-circle',
                            'en attente' => 'pause-circle'
                        ];
                    @endphp
                    <span class="badge bg-{{ $statusColors[$affectation->statut] ?? 'secondary' }} fs-5 px-3 py-2">
                        <i class="fas fa-{{ $statusIcons[$affectation->statut] ?? 'question-circle' }} me-1"></i>
                        {{ ucfirst($affectation->statut) }}
                    </span>
                </div>
            </div>

            <!-- Informations principales -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i class="fas fa-info-circle me-2"></i>Informations de l'affectation
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Matériel -->
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded bg-light border-start border-4 border-primary">
                                        <label class="text-muted small fw-bold text-uppercase mb-1">
                                            <i class="fas fa-laptop text-primary me-1"></i>Matériel
                                        </label>
                                        <div class="h6 mb-1">{{ $affectation->materiel->nom ?? $affectation->materiel->name ?? '-' }}</div>
                                        <small class="text-muted">{{ $affectation->numero_affectation ?? 'N/A' }}</small>
                                    </div>
                                </div>

                                <!-- Utilisateur -->
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded bg-light border-start border-4 border-info">
                                        <label class="text-muted small fw-bold text-uppercase mb-1">
                                            <i class="fas fa-user text-info me-1"></i>Utilisateur assigné
                                        </label>
                                        <div class="h6 mb-1">{{ $affectation->user->name ?? 'Non assigné' }}</div>
                                        <small class="text-muted">{{ $affectation->user->email ?? '' }}</small>
                                    </div>
                                </div>

                                <!-- Service -->
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded bg-light border-start border-4 border-success">
                                        <label class="text-muted small fw-bold text-uppercase mb-1">
                                            <i class="fas fa-building text-success me-1"></i>Service
                                        </label>
                                        <div class="h6 mb-0">{{ $affectation->service->nom ?? $affectation->service->name ?? 'Non spécifié' }}</div>
                                    </div>
                                </div>

                                <!-- Priorité -->
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded bg-light border-start border-4 border-warning">
                                        <label class="text-muted small fw-bold text-uppercase mb-1">
                                            <i class="fas fa-flag text-warning me-1"></i>Priorité
                                        </label>
                                        <div class="h6 mb-0">{{ ucfirst($affectation->priorite ?? 'normale') }}</div>
                                    </div>
                                </div>

                                <!-- Lieu d'utilisation -->
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded bg-light border-start border-4 border-danger">
                                        <label class="text-muted small fw-bold text-uppercase mb-1">
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i>Lieu d'utilisation
                                        </label>
                                        <div class="h6 mb-0">{{ $affectation->lieu_utilisation ?? 'Non spécifié' }}</div>
                                    </div>
                                </div>

                                <!-- Responsable -->
                                <div class="col-md-6">
                                    <div class="info-item p-3 rounded bg-light border-start border-4 border-secondary">
                                        <label class="text-muted small fw-bold text-uppercase mb-1">
                                            <i class="fas fa-user-check text-secondary me-1"></i>Responsable validation
                                        </label>
                                        <div class="h6 mb-0">{{ $affectation->responsable_validation ?? 'Non défini' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Commentaire -->
                            <div class="mt-4">
                                <div class="info-item p-3 rounded bg-light border-start border-4 border-dark">
                                    <label class="text-muted small fw-bold text-uppercase mb-2">
                                        <i class="fas fa-comment text-dark me-1"></i>Commentaire / Notes
                                    </label>
                                    <div class="text-dark">
                                        {{ $affectation->commentaire ?? 'Aucun commentaire disponible.' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panneau latéral -->
                <div class="col-lg-4">
                    <!-- Chronologie -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="card-title mb-0 fw-bold text-uppercase">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>Chronologie
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Date d'affectation</h6>
                                        <p class="mb-1 fw-bold text-success">
                                            {{ $affectation->date_affectation ? $affectation->date_affectation->format('d/m/Y') : 'Non définie' }}
                                        </p>
                                        <small class="text-muted">Début de l'affectation</small>
                                    </div>
                                </div>

                                @if($affectation->date_retour_prevue)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Retour prévu</h6>
                                        <p class="mb-1 fw-bold text-warning">
                                            {{ $affectation->date_retour_prevue->format('d/m/Y') }}
                                        </p>
                                        <small class="text-muted">Date de retour planifiée</small>
                                    </div>
                                </div>
                                @endif

                                @if($affectation->date_retour)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Retour effectif</h6>
                                        <p class="mb-1 fw-bold text-primary">
                                            {{ $affectation->date_retour->format('d/m/Y') }}
                                        </p>
                                        <small class="text-muted">Date de retour réelle</small>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light py-3">
                            <h6 class="card-title mb-0 fw-bold text-uppercase">
                                <i class="fas fa-bolt text-warning me-2"></i>Actions rapides
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-grid gap-2">
                                <a href="{{ route('affectations.edit', $affectation->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit me-2"></i>Modifier l'affectation
                                </a>
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-print me-2"></i>Imprimer le rapport
                                </button>
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-envelope me-2"></i>Envoyer par email
                                </button>
                                <button class="btn btn-secondary btn-sm">
                                    <i class="fas fa-copy me-2"></i>Dupliquer
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Informations système -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light py-3">
                            <h6 class="card-title mb-0 fw-bold text-uppercase">
                                <i class="fas fa-cog text-secondary me-2"></i>Informations système
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-2 text-sm">
                                <div class="col-12">
                                    <strong>ID:</strong> #{{ $affectation->id }}<br>
                                    <strong>Créé le:</strong> {{ $affectation->created_at ? $affectation->created_at->format('d/m/Y H:i') : 'N/A' }}<br>
                                    <strong>Modifié le:</strong> {{ $affectation->updated_at ? $affectation->updated_at->format('d/m/Y H:i') : 'N/A' }}<br>
                                    @if($affectation->created_at && $affectation->date_affectation)
                                        <strong>Durée:</strong>
                                        {{ $affectation->date_affectation->diffForHumans($affectation->date_retour ?: now(), true) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions principales -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Dernière modification: {{ $affectation->updated_at ? $affectation->updated_at->diffForHumans() : 'Inconnue' }}</small>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('affectations.index') }}" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                                    </a>
                                    <a href="{{ route('affectations.edit', $affectation->id) }}" class="btn btn-warning btn-lg">
                                        <i class="fas fa-edit me-2"></i>Modifier
                                    </a>
                                    <button class="btn btn-outline-primary btn-lg dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Dupliquer</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Imprimer</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Exporter PDF</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('affectations.destroy', $affectation->id) }}" method="POST"
                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cette affectation ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-item {
    transition: all 0.3s ease;
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content h6 {
    font-size: 0.9rem;
    margin-bottom: 5px;
}

.btn:hover {
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }

    .timeline {
        padding-left: 20px;
    }

    .timeline-marker {
        left: -18px;
    }
}
</style>
@endsection
