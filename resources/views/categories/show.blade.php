@extends('layouts.app')

@section('title', 'Détails de la Catégorie')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    {{-- Breadcrumb --}}
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none">
                            <i class="bi bi-house-door"></i> Accueil
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('categories.index') }}" class="text-decoration-none">Catégories</a>
                    </li>
                    <li class="breadcrumb-item active">Détails</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="row mb-4">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-check-circle-fill text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <strong>Succès !</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif

    {{-- Contenu principal --}}
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            {{-- En-tête --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-gradient rounded-3 p-3 me-3">
                        <i class="bi bi-eye-fill text-white fs-4"></i>
                    </div>
                    <div>
                        <h1 class="h3 mb-0 fw-bold text-dark">Détails de la Catégorie</h1>
                        <p class="text-muted mb-0">Informations complètes de la catégorie</p>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                            onclick="window.print()">
                        <i class="bi bi-printer me-1"></i>
                        <span class="d-none d-sm-inline">Imprimer</span>
                    </button>
                    <a href="{{ route('categories.index') }}"
                       class="btn btn-outline-primary d-flex align-items-center shadow-sm">
                        <i class="bi bi-arrow-left-circle me-2"></i>
                        <span>Retour à la liste</span>
                    </a>
                </div>
            </div>

            {{-- Card principale --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                {{-- En-tête de la card --}}
                <div class="card-header bg-gradient text-white border-0 py-4"
                     style="background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);">
                    <div class="text-center">
                        <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-folder2-open fs-2 text-white"></i>
                        </div>
                        <h2 class="mb-0 fw-bold">{{ $categorie->nom }}</h2>
                        <small class="opacity-75">Catégorie #{{ str_pad($categorie->id, 4, '0', STR_PAD_LEFT) }}</small>
                    </div>
                </div>

                {{-- Corps de la card --}}
                <div class="card-body p-0">
                    {{-- Image de la catégorie si disponible --}}
                    @if(!empty($categorie->image))
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $categorie->image) }}"
                                 alt="Image de la catégorie {{ $categorie->nom }}"
                                 class="w-100"
                                 style="height: 250px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 end-0 bg-gradient"
                                 style="background: linear-gradient(transparent, rgba(0,0,0,0.6)); height: 60px;"></div>
                        </div>
                    @endif

                    {{-- Informations principales --}}
                    <div class="row g-0">
                        <div class="col-md-6 p-4 {{ !empty($categorie->image) ? 'border-end' : '' }}">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="bi bi-info-circle text-info fs-5"></i>
                                </div>
                                <h4 class="mb-0 fw-semibold text-dark">Informations Générales</h4>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Nom de la catégorie</small>
                                <h5 class="fw-bold text-primary mb-0">{{ $categorie->nom }}</h5>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Date de création</small>
                                <span class="fw-medium">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $categorie->created_at->format('d/m/Y à H:i') }}
                                </span>
                            </div>

                            @if($categorie->updated_at != $categorie->created_at)
                                <div>
                                    <small class="text-muted d-block">Dernière modification</small>
                                    <span class="fw-medium">
                                        <i class="bi bi-pencil me-1"></i>
                                        {{ $categorie->updated_at->format('d/m/Y à H:i') }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        @if(!empty($categorie->image))
                            <div class="col-md-6 p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-image text-secondary fs-5"></i>
                                    </div>
                                    <h4 class="mb-0 fw-semibold text-dark">Image</h4>
                                </div>

                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $categorie->image) }}"
                                         alt="Image de la catégorie {{ $categorie->nom }}"
                                         class="img-fluid rounded-3 shadow-sm"
                                         style="max-height: 150px; object-fit: cover;">
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Description --}}
                    <div class="border-top p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-file-text text-secondary fs-5"></i>
                            </div>
                            <h4 class="mb-0 fw-semibold text-dark">Description</h4>
                        </div>

                        <div class="bg-light rounded-3 p-4">
                            @if($categorie->description)
                                <p class="mb-0 text-dark lh-lg fs-6">{{ $categorie->description }}</p>
                            @else
                                <div class="text-center py-3">
                                    <i class="bi bi-file-earmark-x text-muted fs-1 d-block mb-2"></i>
                                    <p class="text-muted mb-0 fs-6">Aucune description disponible pour cette catégorie</p>
                                    <small class="text-muted">Vous pouvez ajouter une description en modifiant la catégorie</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistiques et matériels associés --}}
            @if(isset($materiels_count))
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-light border-0">
                        <h4 class="mb-0 fw-semibold text-dark d-flex align-items-center">
                            <i class="bi bi-bar-chart me-2 text-success"></i>
                            Statistiques
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="p-3">
                                    <div class="text-success mb-2">
                                        <i class="bi bi-box-seam fs-1"></i>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-1">{{ $materiels_count ?? 0 }}</h3>
                                    <small class="text-muted">Matériels associés</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3">
                                    <div class="text-info mb-2">
                                        <i class="bi bi-calendar-week fs-1"></i>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-1">{{ $categorie->created_at->diffInDays(now()) }}</h3>
                                    <small class="text-muted">Jours depuis création</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3">
                                    <div class="text-warning mb-2">
                                        <i class="bi bi-clock-history fs-1"></i>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-1">{{ $categorie->updated_at->diffInDays($categorie->created_at) }}</h3>
                                    <small class="text-muted">Jours depuis modification</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Actions --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-light border-0">
                    <h4 class="mb-0 fw-semibold text-dark d-flex align-items-center">
                        <i class="bi bi-gear-wide-connected me-2 text-primary"></i>
                        Actions disponibles
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <a href="{{ route('categories.edit', $categorie->id) }}"
                               class="btn btn-warning btn-lg w-100 d-flex align-items-center justify-content-center shadow-sm">
                                <i class="bi bi-pencil-square me-2 fs-4"></i>
                                <div class="text-start">
                                    <div class="fw-bold fs-6">Modifier</div>
                                    <small class="opacity-75">Éditer les informations</small>
                                </div>
                            </a>
                        </div>

                        <div class="col-sm-6">
                            <button type="button"
                                    class="btn btn-danger btn-lg w-100 d-flex align-items-center justify-content-center shadow-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal">
                                <i class="bi bi-trash me-2 fs-4"></i>
                                <div class="text-start">
                                    <div class="fw-bold fs-6">Supprimer</div>
                                    <small class="opacity-75">Effacer définitivement</small>
                                </div>
                            </button>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Actions secondaires --}}
                    <div class="row g-2">
                        <div class="col-6 col-sm-4">
                            <button class="btn btn-outline-secondary w-100" onclick="window.print()">
                                <i class="bi bi-printer me-1"></i>
                                <span class="d-none d-md-inline fs-7">Imprimer</span>
                            </button>
                        </div>
                        <div class="col-6 col-sm-4">
                            <button class="btn btn-outline-info w-100" onclick="shareCategory()">
                                <i class="bi bi-share me-1"></i>
                                <span class="d-none d-md-inline fs-7">Partager</span>
                            </button>
                        </div>
                        <div class="col-12 col-sm-4">
                            <button class="btn btn-outline-primary w-100" onclick="exportCategory()">
                                <i class="bi bi-download me-1"></i>
                                <span class="d-none d-md-inline fs-7">Exporter</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de confirmation de suppression --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                    </div>
                    <h4 class="modal-title fw-bold text-dark" id="deleteModalLabel">
                        Confirmer la suppression
                    </h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4">
                <div class="alert alert-warning border-0 bg-warning bg-opacity-10">
                    <div class="d-flex">
                        <i class="bi bi-info-circle text-warning me-2 mt-1"></i>
                        <div>
                            <p class="mb-2 fs-6"><strong>Attention !</strong> Vous êtes sur le point de supprimer :</p>
                            <ul class="mb-0">
                                <li><strong>Catégorie :</strong> "{{ $categorie->nom }}"</li>
                                @if($categorie->description)
                                    <li><strong>Description :</strong> {{ Str::limit($categorie->description, 50) }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <p class="mb-0 text-center fs-6">
                    <strong class="text-danger">Cette action est définitive et irréversible.</strong>
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Annuler
                </button>
                <form action="{{ route('categories.destroy', $categorie->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Confirmer la suppression
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });
});

// Fonction de partage
function shareCategory() {
    if (navigator.share) {
        navigator.share({
            title: 'Catégorie: {{ $categorie->nom }}',
            text: 'Détails de la catégorie {{ $categorie->nom }}{{ $categorie->description ? " - " . Str::limit($categorie->description, 100) : "" }}',
            url: window.location.href
        });
    } else {
        // Fallback: copier l'URL
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Lien copié dans le presse-papier !');
        });
    }
}

// Fonction d'export
function exportCategory() {
    const categoryData = {
        nom: '{{ $categorie->nom }}',
        description: '{{ $categorie->description ?? "Aucune description" }}',
        creation: '{{ $categorie->created_at->format("d/m/Y H:i") }}',
        modification: '{{ $categorie->updated_at->format("d/m/Y H:i") }}',
        @if(!empty($categorie->image))
        image: '{{ $categorie->image }}',
        @endif
        @if(isset($materiels_count))
        materiels_associes: {{ $materiels_count ?? 0 }}
        @endif
    };

    const dataStr = JSON.stringify(categoryData, null, 2);
    const dataBlob = new Blob([dataStr], {type: 'application/json'});
    const url = URL.createObjectURL(dataBlob);

    const link = document.createElement('a');
    link.href = url;
    link.download = 'categorie_{{ $categorie->id }}.json';
    link.click();

    URL.revokeObjectURL(url);
}
</script>
@endpush

@push('styles')
<style>
/* Tailles de police optimisées pour une excellente visibilité */
.h3 {
    font-size: 1.6rem !important;
}

h2 {
    font-size: 1.5rem !important;
}

h3 {
    font-size: 1.4rem !important;
}

h4 {
    font-size: 1.25rem !important;
}

h5 {
    font-size: 1.1rem !important;
}

.fs-6 {
    font-size: 1rem !important;
}

.fs-7 {
    font-size: 0.9rem !important;
}

/* Textes bien lisibles */
.fw-bold {
    font-weight: 700 !important;
}

.fw-semibold {
    font-weight: 600 !important;
}

.fw-medium {
    font-weight: 500 !important;
}

/* Boutons avec police claire */
.btn {
    font-size: 0.95rem !important;
    font-weight: 500 !important;
}

.btn-lg {
    font-size: 1rem !important;
}

/* Labels et textes secondaires */
small {
    font-size: 0.85rem !important;
}

/* Animations et effets */
.bg-gradient {
    background: linear-gradient(135deg, var(--bs-primary) 0%, var(--bs-purple) 100%) !important;
}

.card {
    transition: all 0.3s ease;
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

/* Améliorations visuelles */
.border-end {
    border-color: rgba(0,0,0,0.1) !important;
}

.lh-lg {
    line-height: 1.8 !important;
}

/* Responsivité avec police adaptée */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    .h3 {
        font-size: 1.4rem !important;
    }

    h2 {
        font-size: 1.3rem !important;
    }

    h3 {
        font-size: 1.2rem !important;
    }

    h4 {
        font-size: 1.1rem !important;
    }

    h5 {
        font-size: 1rem !important;
    }

    .btn {
        font-size: 0.9rem !important;
    }

    .btn-lg {
        padding: 0.75rem 1rem;
        font-size: 0.95rem !important;
    }

    .border-end {
        border-right: none !important;
        border-bottom: 1px solid rgba(0,0,0,0.1) !important;
        padding-bottom: 1.5rem !important;
    }

    .col-md-6:last-child {
        padding-top: 1.5rem !important;
    }
}

@media (max-width: 576px) {
    .h3 {
        font-size: 1.3rem !important;
    }

    h4 {
        font-size: 1rem !important;
    }

    .btn {
        font-size: 0.85rem !important;
    }

    .card-body {
        padding: 1rem !important;
    }
}

/* Animation pour les badges */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.badge:hover {
    animation: pulse 0.8s infinite;
}

/* Amélioration du contraste */
.text-dark {
    color: #212529 !important;
}

.text-muted {
    color: #6c757d !important;
}

/* Style d'impression */
@media print {
    .btn, .breadcrumb, .modal {
        display: none !important;
    }

    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }

    body {
        font-size: 12pt !important;
    }

    h1, h2, h3, h4, h5 {
        color: black !important;
    }
}
</style>
@endpush
@endsection
