@extends('layouts.app')

@section('title', 'Modifier la Structure')

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
        background: linear-gradient(135deg, var(--uts-yellow), var(--uts-yellow-dark)) !important;
        border-bottom: 3px solid var(--uts-green);
        color: var(--uts-dark) !important;
        border-radius: 12px 12px 0 0;
    }

    .structure-icon {
        background: var(--uts-green);
        border-radius: 50%;
        padding: 0.75rem;
        border: 3px solid var(--uts-cream);
        box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
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

    .btn-warning {
        background: linear-gradient(135deg, var(--uts-green), var(--uts-green-light)) !important;
        border: 2px solid var(--uts-yellow) !important;
        color: var(--uts-cream) !important;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 10px;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, var(--uts-green-dark), var(--uts-green)) !important;
        border-color: var(--uts-yellow-dark) !important;
        color: var(--uts-cream) !important;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--uts-sage) !important;
        border: 2px solid var(--uts-green) !important;
        color: var(--uts-green) !important;
        font-weight: 500;
        padding: 0.75rem 2rem;
        border-radius: 10px;
    }

    .btn-secondary:hover {
        background: var(--uts-green) !important;
        border-color: var(--uts-green-dark) !important;
        color: var(--uts-cream) !important;
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

    .input-icon {
        color: var(--uts-green);
        margin-right: 0.5rem;
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
                <a href="{{ route('structures.index') }}">Structures</a>
            </li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="structure-icon me-3">
                            <i class="bi bi-pencil-square fs-4" style="color: var(--uts-cream);"></i>
                        </div>
                        <div class="text-center">
                            <h4 class="mb-1 fw-bold">Modifier la Structure</h4>
                            <p class="mb-0 opacity-75">{{ $structure->nom }}</p>
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

                    <form action="{{ route('structures.update', $structure) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nom -->
                            <div class="col-12 mb-4">
                                <label for="nom" class="form-label required-field">
                                    <i class="bi bi-building input-icon"></i>Nom de la structure
                                </label>
                                <input type="text"
                                       name="nom"
                                       id="nom"
                                       class="form-control @error('nom') is-invalid @enderror"
                                       value="{{ old('nom', $structure->nom) }}"
                                       placeholder="Ex: Direction des Ressources Humaines"
                                       required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Nom officiel de la structure</div>
                            </div>

                            <!-- Type -->
                            <div class="col-md-6 mb-4">
                                <label for="type" class="form-label">
                                    <i class="bi bi-tags input-icon"></i>Type de structure
                                </label>
                                <select name="type"
                                        id="type"
                                        class="form-select @error('type') is-invalid @enderror">
                                    <option value="">Sélectionner un type</option>
                                    <option value="Direction" {{ old('type', $structure->type) == 'Direction' ? 'selected' : '' }}>Direction</option>
                                    <option value="Département" {{ old('type', $structure->type) == 'Département' ? 'selected' : '' }}>Département</option>
                                    <option value="Service" {{ old('type', $structure->type) == 'Service' ? 'selected' : '' }}>Service</option>
                                    <option value="Bureau" {{ old('type', $structure->type) == 'Bureau' ? 'selected' : '' }}>Bureau</option>
                                    <option value="Unité" {{ old('type', $structure->type) == 'Unité' ? 'selected' : '' }}>Unité</option>
                                    <option value="Division" {{ old('type', $structure->type) == 'Division' ? 'selected' : '' }}>Division</option>
                                    <option value="Autre" {{ old('type', $structure->type) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Code -->
                            <div class="col-md-6 mb-4">
                                <label for="code" class="form-label">
                                    <i class="bi bi-qr-code input-icon"></i>Code structure
                                </label>
                                <input type="text"
                                       name="code"
                                       id="code"
                                       class="form-control @error('code') is-invalid @enderror"
                                       value="{{ old('code', $structure->code ?? '') }}"
                                       placeholder="Ex: DIR-RH">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Code d'identification unique</div>
                            </div>

                            <!-- Responsable -->
                            <div class="col-md-6 mb-4">
                                <label for="responsable" class="form-label">
                                    <i class="bi bi-person-badge input-icon"></i>Responsable
                                </label>
                                <input type="text"
                                       name="responsable"
                                       id="responsable"
                                       class="form-control @error('responsable') is-invalid @enderror"
                                       value="{{ old('responsable', $structure->responsable) }}"
                                       placeholder="Ex: M. Jean DUPONT">
                                @error('responsable')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact -->
                            <div class="col-md-6 mb-4">
                                <label for="contact" class="form-label">
                                    <i class="bi bi-telephone input-icon"></i>Contact
                                </label>
                                <input type="text"
                                       name="contact"
                                       id="contact"
                                       class="form-control @error('contact') is-invalid @enderror"
                                       value="{{ old('contact', $structure->contact) }}"
                                       maxlength="8"
                                       pattern="\d{8}"
                                       placeholder="Ex: 70123456">
                                @error('contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Numéro de téléphone (8 chiffres)</div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope input-icon"></i>Email
                                </label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $structure->email ?? '') }}"
                                       placeholder="Ex: contact@structure.bf">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div class="col-md-6 mb-4">
                                <label for="statut" class="form-label">
                                    <i class="bi bi-check-circle input-icon"></i>Statut
                                </label>
                                <select name="statut"
                                        id="statut"
                                        class="form-select @error('statut') is-invalid @enderror">
                                    <option value="active" {{ old('statut', $structure->statut ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('statut', $structure->statut ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="en_cours" {{ old('statut', $structure->statut ?? '') == 'en_cours' ? 'selected' : '' }}>En cours de création</option>
                                </select>
                                @error('statut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12 mb-4">
                                <label for="description" class="form-label">
                                    <i class="bi bi-card-text input-icon"></i>Description
                                </label>
                                <textarea name="description"
                                          id="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Décrivez les missions, objectifs et activités de la structure...">{{ old('description', $structure->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Informations détaillées sur la structure (optionnel)</div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-3 pt-3 border-top">
                            <a href="{{ route('structures.index') }}"
                               class="btn btn-secondary d-flex align-items-center justify-content-center">
                                <i class="bi bi-arrow-left me-2"></i>
                                Retour à la liste
                            </a>

                            <div class="d-flex gap-2">
                                <a href="{{ route('structures.show', $structure) }}"
                                   class="btn btn-outline-info"
                                   style="border: 2px solid var(--uts-green); color: var(--uts-green); background: var(--uts-sage);">
                                    <i class="bi bi-eye me-1"></i>
                                    Voir
                                </a>
                                <button type="submit" class="btn btn-warning">
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

// Validation contact en temps réel
document.getElementById('contact').addEventListener('input', function() {
    const value = this.value;
    if (value && (!/^\d{8}$/.test(value))) {
        this.setCustomValidity('Le contact doit contenir exactement 8 chiffres');
    } else {
        this.setCustomValidity('');
    }
});

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
