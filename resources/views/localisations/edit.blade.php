@extends('layouts.app')

@section('title', 'Modifier la Localisation')

@push('styles')
<style>
    :root {
        --uts-yellow: #FFD700;
        --uts-yellow-dark: #F57C00;
        --uts-green: #2E7D32;
        --uts-green-light: #66BB6A;
        --uts-green-dark: #1B5E20;
        --uts-red: #D32F2F;
        --uts-dark: #2C3E50;
        --uts-cream: #FFF8E1;
        --uts-sage: #E8F5E8;
        --uts-warm: #FFFDE7;
    }

    .breadcrumb {
        background: var(--uts-sage);
        border: 2px solid var(--uts-yellow);
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }

    .breadcrumb-item a {
        color: var(--uts-green);
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-item a:hover {
        color: var(--uts-yellow-dark);
    }

    .card {
        border: 3px solid var(--uts-yellow);
        background: linear-gradient(135deg, var(--uts-cream), var(--uts-warm));
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.15);
        border-radius: 15px;
    }

    .card-header {
        background: linear-gradient(135deg, var(--uts-green), var(--uts-green-light));
        border-bottom: 3px solid var(--uts-yellow);
        color: var(--uts-cream);
        border-radius: 12px 12px 0 0;
    }

    .location-icon {
        background: var(--uts-yellow);
        border-radius: 50%;
        padding: 0.75rem;
        border: 3px solid var(--uts-cream);
        box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
    }

    .form-label {
        color: var(--uts-dark);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        background: var(--uts-warm);
        border: 2px solid var(--uts-sage);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        background: var(--uts-cream);
        border-color: var(--uts-green);
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.15);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--uts-green), var(--uts-green-light));
        border: 2px solid var(--uts-yellow);
        color: var(--uts-cream);
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 10px;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, var(--uts-green-dark), var(--uts-green));
        border-color: var(--uts-yellow-dark);
        color: var(--uts-cream);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--uts-sage);
        border: 2px solid var(--uts-green);
        color: var(--uts-green);
        font-weight: 500;
        padding: 0.75rem 2rem;
        border-radius: 10px;
    }

    .btn-secondary:hover {
        background: var(--uts-green);
        border-color: var(--uts-green-dark);
        color: var(--uts-cream);
        transform: translateY(-1px);
    }

    .invalid-feedback {
        color: var(--uts-red);
        font-weight: 500;
    }

    .is-invalid {
        border-color: var(--uts-red) !important;
        box-shadow: 0 0 0 0.2rem rgba(211, 47, 47, 0.15) !important;
    }

    .form-text {
        color: var(--uts-green);
        font-size: 0.85rem;
        font-weight: 500;
    }

    .border-top {
        border-color: var(--uts-green) !important;
        border-width: 2px !important;
    }

    .required-field::after {
        content: " *";
        color: var(--uts-red);
        font-weight: bold;
    }

    .alert-success {
        background: linear-gradient(135deg, var(--uts-sage), var(--uts-cream));
        border: 2px solid var(--uts-green);
        border-left: 5px solid var(--uts-green);
        color: var(--uts-green-dark);
        border-radius: 10px;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-house-door"></i> Accueil
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('localisations.index') }}">Localisations</a>
            </li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="location-icon me-3">
                            <i class="bi bi-pencil-square fs-4" style="color: var(--uts-dark);"></i>
                        </div>
                        <div class="text-center">
                            <h4 class="text-white mb-1 fw-bold">Modifier la Localisation</h4>
                            <p class="text-white mb-0 opacity-75">{{ $localisation->nom }} ({{ $localisation->code }})</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Messages d'erreur -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4" style="border: 2px solid var(--uts-red); background: rgba(211, 47, 47, 0.1); color: var(--uts-red); border-radius: 10px;">
                            <div class="d-flex">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    <strong>Erreurs détectées :</strong>
                                    <ul class="mb-0 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            <div class="d-flex">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('localisations.update', $localisation) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nom de la localisation -->
                            <div class="col-md-6 mb-4">
                                <label for="nom" class="form-label required-field">
                                    <i class="bi bi-building me-1"></i> Nom de la localisation
                                </label>
                                <input type="text"
                                       name="nom"
                                       id="nom"
                                       class="form-control @error('nom') is-invalid @enderror"
                                       value="{{ old('nom', $localisation->nom) }}"
                                       placeholder="Ex: Salle de cours A101"
                                       required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Nom descriptif du lieu</div>
                            </div>

                            <!-- Code de la localisation -->
                            <div class="col-md-6 mb-4">
                                <label for="code" class="form-label required-field">
                                    <i class="bi bi-qr-code me-1"></i> Code localisation
                                </label>
                                <input type="text"
                                       name="code"
                                       id="code"
                                       class="form-control @error('code') is-invalid @enderror"
                                       value="{{ old('code', $localisation->code) }}"
                                       placeholder="Ex: LOC-A101"
                                       required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Code unique d'identification</div>
                            </div>

                            <!-- Bâtiment -->
                            <div class="col-md-6 mb-4">
                                <label for="batiment" class="form-label">
                                    <i class="bi bi-buildings me-1"></i> Bâtiment
                                </label>
                                <input type="text"
                                       name="batiment"
                                       id="batiment"
                                       class="form-control @error('batiment') is-invalid @enderror"
                                       value="{{ old('batiment', $localisation->batiment) }}"
                                       placeholder="Ex: Bâtiment A, Bloc Principal">
                                @error('batiment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Étage -->
                            <div class="col-md-6 mb-4">
                                <label for="etage" class="form-label">
                                    <i class="bi bi-layers me-1"></i> Étage
                                </label>
                                <select name="etage"
                                        id="etage"
                                        class="form-select @error('etage') is-invalid @enderror">
                                    <option value="">Sélectionner un étage</option>
                                    <option value="Sous-sol" {{ old('etage', $localisation->etage) == 'Sous-sol' ? 'selected' : '' }}>Sous-sol</option>
                                    <option value="Rez-de-chaussée" {{ old('etage', $localisation->etage) == 'Rez-de-chaussée' ? 'selected' : '' }}>Rez-de-chaussée</option>
                                    <option value="1er étage" {{ old('etage', $localisation->etage) == '1er étage' ? 'selected' : '' }}>1er étage</option>
                                    <option value="2ème étage" {{ old('etage', $localisation->etage) == '2ème étage' ? 'selected' : '' }}>2ème étage</option>
                                    <option value="3ème étage" {{ old('etage', $localisation->etage) == '3ème étage' ? 'selected' : '' }}>3ème étage</option>
                                    <option value="4ème étage" {{ old('etage', $localisation->etage) == '4ème étage' ? 'selected' : '' }}>4ème étage</option>
                                </select>
                                @error('etage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type de localisation -->
                            <div class="col-md-6 mb-4">
                                <label for="type" class="form-label">
                                    <i class="bi bi-tag me-1"></i> Type de lieu
                                </label>
                                <select name="type"
                                        id="type"
                                        class="form-select @error('type') is-invalid @enderror">
                                    <option value="">Choisir un type</option>
                                    <option value="Salle de cours" {{ old('type', $localisation->type ?? '') == 'Salle de cours' ? 'selected' : '' }}>Salle de cours</option>
                                    <option value="Laboratoire" {{ old('type', $localisation->type ?? '') == 'Laboratoire' ? 'selected' : '' }}>Laboratoire</option>
                                    <option value="Bureau" {{ old('type', $localisation->type ?? '') == 'Bureau' ? 'selected' : '' }}>Bureau</option>
                                    <option value="Amphithéâtre" {{ old('type', $localisation->type ?? '') == 'Amphithéâtre' ? 'selected' : '' }}>Amphithéâtre</option>
                                    <option value="Bibliothèque" {{ old('type', $localisation->type ?? '') == 'Bibliothèque' ? 'selected' : '' }}>Bibliothèque</option>
                                    <option value="Entrepôt" {{ old('type', $localisation->type ?? '') == 'Entrepôt' ? 'selected' : '' }}>Entrepôt</option>
                                    <option value="Autre" {{ old('type', $localisation->type ?? '') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Capacité -->
                            <div class="col-md-6 mb-4">
                                <label for="capacite" class="form-label">
                                    <i class="bi bi-people me-1"></i> Capacité
                                </label>
                                <input type="number"
                                       name="capacite"
                                       id="capacite"
                                       class="form-control @error('capacite') is-invalid @enderror"
                                       value="{{ old('capacite', $localisation->capacite ?? '') }}"
                                       placeholder="Ex: 50"
                                       min="1">
                                @error('capacite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Nombre de places disponibles</div>
                            </div>

                            <!-- Description -->
                            <div class="col-12 mb-4">
                                <label for="description" class="form-label">
                                    <i class="bi bi-card-text me-1"></i> Description
                                </label>
                                <textarea name="description"
                                          id="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Description détaillée de la localisation, équipements disponibles, etc.">{{ old('description', $localisation->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Informations complémentaires (optionnel)</div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-3 pt-3 border-top">
                            <a href="{{ route('localisations.index') }}"
                               class="btn btn-secondary d-flex align-items-center justify-content-center">
                                <i class="bi bi-arrow-left me-2"></i>
                                Retour à la liste
                            </a>

                            <div class="d-flex gap-2">
                                <a href="{{ route('localisations.show', $localisation) }}"
                                   class="btn btn-outline-info"
                                   style="border: 2px solid var(--uts-green); color: var(--uts-green); background: var(--uts-sage);">
                                    <i class="bi bi-eye me-1"></i>
                                    Voir
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-lg me-2"></i>
                                    Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Validation Bootstrap
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Auto-focus premier champ
document.getElementById('nom').focus();

// Animation des champs au focus
document.querySelectorAll('.form-control, .form-select').forEach(function(element) {
    element.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.01)';
        this.parentElement.style.transition = 'transform 0.2s ease';
    });

    element.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });
});
</script>
@endpush
@endsection
