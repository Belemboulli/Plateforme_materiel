@extends('layouts.app')

@section('title', 'Modifier la Catégorie')

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
                    <li class="breadcrumb-item active">Modifier</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- En-tête --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-gradient rounded-3 p-3 me-3">
                        <i class="bi bi-pencil-square text-white fs-4"></i>
                    </div>
                    <div>
                        <h1 class="h3 mb-0 fw-bold text-dark">Modifier la Catégorie</h1>
                        <p class="text-muted mb-0">Modifiez les informations de la catégorie "{{ $categorie->nom }}"</p>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('categories.show', $categorie->id) }}"
                       class="btn btn-outline-info btn-sm d-flex align-items-center">
                        <i class="bi bi-eye me-1"></i>
                        <span class="d-none d-sm-inline">Voir détails</span>
                    </a>
                    <a href="{{ route('categories.index') }}"
                       class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-arrow-left-circle me-2"></i>
                        <span>Retour à la liste</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Messages d'erreur --}}
    @if ($errors->any())
        <div class="row mb-4">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="alert alert-danger border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-start">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3 flex-shrink-0">
                            <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-2">Erreurs de validation</h6>
                            <p class="mb-2">Veuillez corriger les erreurs suivantes :</p>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $erreur)
                                    <li class="mb-1">{{ $erreur }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Formulaire principal --}}
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card border-0 shadow-lg rounded-4">
                {{-- En-tête du formulaire --}}
                <div class="card-header bg-light border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-tag text-primary fs-5"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-semibold text-dark">Informations de la Catégorie</h4>
                            <small class="text-muted">Modifiez les détails ci-dessous</small>
                        </div>
                    </div>
                </div>

                {{-- Corps du formulaire --}}
                <div class="card-body p-4">
                    <form action="{{ route('categories.update', $categorie->id) }}" method="POST" id="editCategoryForm">
                        @csrf
                        @method('PUT')

                        {{-- Nom de la catégorie --}}
                        <div class="mb-4">
                            <label for="nom" class="form-label fw-semibold text-dark d-flex align-items-center">
                                <i class="bi bi-tag-fill text-primary me-2"></i>
                                Nom de la catégorie
                                <span class="text-danger ms-1">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-type text-muted"></i>
                                </span>
                                <input type="text"
                                       name="nom"
                                       id="nom"
                                       class="form-control border-start-0 @error('nom') is-invalid @enderror"
                                       value="{{ old('nom', $categorie->nom) }}"
                                       placeholder="Ex: Électronique, Mobilier..."
                                       required>
                                @error('nom')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Le nom doit être unique et descriptif
                            </small>
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold text-dark d-flex align-items-center">
                                <i class="bi bi-file-text text-secondary me-2"></i>
                                Description
                                <span class="text-muted ms-1">(optionnel)</span>
                            </label>
                            <div class="position-relative">
                                <textarea name="description"
                                          id="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Décrivez cette catégorie et son utilisation..."
                                          style="resize: vertical;">{{ old('description', $categorie->description) }}</textarea>
                                <div class="position-absolute top-0 end-0 p-2">
                                    <small class="text-muted" id="charCount">0/500</small>
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-lightbulb me-1"></i>
                                Une description claire aide à organiser vos matériels
                            </small>
                        </div>

                        {{-- Informations existantes --}}
                        <div class="bg-light rounded-3 p-3 mb-4">
                            <h6 class="fw-semibold text-dark mb-2">
                                <i class="bi bi-info-circle text-info me-2"></i>
                                Informations actuelles
                            </h6>
                            <div class="row g-3 small">
                                <div class="col-sm-6">
                                    <strong>Créée le :</strong><br>
                                    <span class="text-muted">{{ $categorie->created_at->format('d/m/Y à H:i') }}</span>
                                </div>
                                @if($categorie->updated_at != $categorie->created_at)
                                    <div class="col-sm-6">
                                        <strong>Modifiée le :</strong><br>
                                        <span class="text-muted">{{ $categorie->updated_at->format('d/m/Y à H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="d-grid d-sm-flex gap-3 justify-content-sm-end">
                            <a href="{{ route('categories.index') }}"
                               class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                <i class="bi bi-x-circle me-2"></i>
                                Annuler
                            </a>
                            <button type="button"
                                    class="btn btn-outline-info d-flex align-items-center justify-content-center"
                                    onclick="resetForm()">
                                <i class="bi bi-arrow-clockwise me-2"></i>
                                Réinitialiser
                            </button>
                            <button type="submit"
                                    class="btn btn-warning d-flex align-items-center justify-content-center shadow-sm"
                                    id="submitBtn">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status"></span>
                                <i class="bi bi-check-circle me-2"></i>
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Informations supplémentaires --}}
            <div class="card border-0 shadow-sm rounded-3 mt-4">
                <div class="card-body">
                    <h6 class="fw-semibold text-dark mb-3">
                        <i class="bi bi-lightbulb text-warning me-2"></i>
                        Conseils pour une bonne catégorie
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <i class="bi bi-check-circle text-success me-2 mt-1 flex-shrink-0"></i>
                                <small>Utilisez des noms courts et descriptifs</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <i class="bi bi-check-circle text-success me-2 mt-1 flex-shrink-0"></i>
                                <small>Évitez les doublons de catégories</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <i class="bi bi-check-circle text-success me-2 mt-1 flex-shrink-0"></i>
                                <small>Ajoutez une description claire</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <i class="bi bi-check-circle text-success me-2 mt-1 flex-shrink-0"></i>
                                <small>Organisez logiquement vos matériels</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editCategoryForm');
    const submitBtn = document.getElementById('submitBtn');
    const descriptionTextarea = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    const nomInput = document.getElementById('nom');

    // Compteur de caractères pour la description
    function updateCharCount() {
        const current = descriptionTextarea.value.length;
        const max = 500;
        charCount.textContent = `${current}/${max}`;
        charCount.className = current > max ? 'text-danger' : 'text-muted';
    }

    if (descriptionTextarea && charCount) {
        updateCharCount();
        descriptionTextarea.addEventListener('input', updateCharCount);
    }

    // Animation du formulaire
    const card = document.querySelector('.card');
    if (card) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100);
    }

    // Gestion de la soumission
    form.addEventListener('submit', function(e) {
        const spinner = submitBtn.querySelector('.spinner-border');
        const icon = submitBtn.querySelector('.bi-check-circle');

        spinner.classList.remove('d-none');
        icon.classList.add('d-none');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Mise à jour...';
    });

    // Auto-focus sur le premier champ
    if (nomInput) {
        nomInput.focus();
        nomInput.setSelectionRange(nomInput.value.length, nomInput.value.length);
    }
});

// Fonction de réinitialisation
function resetForm() {
    if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ?')) {
        document.getElementById('editCategoryForm').reset();
        // Restaurer les valeurs d'origine
        document.getElementById('nom').value = '{{ $categorie->nom }}';
        document.getElementById('description').value = '{{ $categorie->description }}';

        // Mettre à jour le compteur de caractères
        const event = new Event('input');
        document.getElementById('description').dispatchEvent(event);
    }
}
</script>
@endpush

@push('styles')
<style>
/* Tailles de police optimisées */
.h3 {
    font-size: 1.5rem !important;
}

h4 {
    font-size: 1.2rem !important;
}

h6 {
    font-size: 1rem !important;
}

.form-label {
    font-size: 0.95rem !important;
}

.form-control {
    font-size: 0.9rem !important;
}

.btn {
    font-size: 0.9rem !important;
}

/* Animations et transitions */
.card {
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    transform: translateY(-1px);
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

.input-group-text {
    transition: all 0.2s ease;
}

.form-control:focus + .input-group-text,
.form-control:focus ~ .input-group-text {
    border-color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.1);
}

/* Styles responsives */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    .h3 {
        font-size: 1.3rem !important;
    }

    h4 {
        font-size: 1.1rem !important;
    }

    .card-body {
        padding: 1.5rem !important;
    }

    .btn {
        font-size: 0.85rem !important;
    }
}

/* Style pour les badges de validation */
.is-valid {
    border-color: #198754;
}

.is-invalid {
    border-color: #dc3545;
}

/* Animation de focus */
@keyframes focusGlow {
    0% { box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0); }
    50% { box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25); }
    100% { box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1); }
}

.form-control:focus {
    animation: focusGlow 0.3s ease;
}
</style>
@endpush
@endsection
