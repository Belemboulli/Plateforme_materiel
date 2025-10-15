@extends('layouts.app')

@section('title', 'Détails du Matériel')

@push('styles')
<style>
    .hero-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        color: white;
        border: none;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .info-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .btn-action {
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        border: 2px solid transparent;
    }

    .btn-edit {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border: none;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(240, 147, 251, 0.4);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
        border: none;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        color: white;
    }

    .btn-back {
        background: transparent;
        border: 2px solid #6c757d;
        color: #6c757d;
    }

    .btn-back:hover {
        background: #6c757d;
        color: white;
        transform: translateY(-1px);
    }

    .breadcrumb-item a {
        text-decoration: none;
        color: #6c757d;
    }

    .detail-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .meta-info {
        background: #f8f9fa;
        border-left: 4px solid #667eea;
        border-radius: 8px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('materiels.index') }}">Matériels</a></li>
            <li class="breadcrumb-item active">{{ $materiel->nom }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Section principale -->
        <div class="col-lg-8">
            <!-- Carte héro -->
            <div class="hero-card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-box-seam-fill fs-2 me-3"></i>
                                <div>
                                    <h1 class="h2 fw-bold mb-1">{{ $materiel->nom }}</h1>
                                    <span class="detail-badge">
                                        <i class="bi bi-collection me-1"></i>
                                        {{ $materiel->categorie->nom }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('materiels.index') }}" class="btn btn-back btn-action">
                            <i class="bi bi-arrow-left me-2"></i>
                            Retour
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informations détaillées -->
            <div class="info-card">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                        Informations détaillées
                    </h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">Nom du matériel</label>
                            <p class="fs-5 mb-0">{{ $materiel->nom }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">Catégorie</label>
                            <p class="fs-5 mb-0">
                                <span class="badge bg-primary">{{ $materiel->categorie->nom }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Description</label>
                        <div class="border rounded p-3 bg-light">
                            @if($materiel->description)
                                <p class="mb-0 fs-6">{{ $materiel->description }}</p>
                            @else
                                <p class="mb-0 text-muted fst-italic">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    Aucune description disponible
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Actions -->
            <div class="info-card mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="bi bi-gear-fill text-secondary me-2"></i>
                        Actions
                    </h5>

                    <div class="d-grid gap-3">
                        <a href="{{ route('materiels.edit', $materiel->id) }}"
                           class="btn btn-edit btn-action d-flex align-items-center justify-content-center">
                            <i class="bi bi-pencil-square me-2"></i>
                            Modifier le matériel
                        </a>

                        <form action="{{ route('materiels.destroy', $materiel->id) }}"
                              method="POST"
                              onsubmit="return confirm('⚠️ Attention !\n\nÊtes-vous absolument sûr de vouloir supprimer ce matériel ?\n\nCette action est irréversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete btn-action w-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-trash3 me-2"></i>
                                Supprimer le matériel
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="info-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="bi bi-clock-history text-info me-2"></i>
                        Informations système
                    </h5>

                    <div class="meta-info p-3">
                        <div class="mb-2">
                            <small class="text-muted d-block">Créé le</small>
                            <strong>{{ $materiel->created_at->format('d/m/Y à H:i') }}</strong>
                        </div>

                        <div>
                            <small class="text-muted d-block">Dernière modification</small>
                            <strong>{{ $materiel->updated_at->format('d/m/Y à H:i') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Animation d'entrée
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.info-card, .hero-card');
    cards.forEach((card, index) => {
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
