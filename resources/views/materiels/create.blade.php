@extends('layouts.app')

@section('title', 'Ajouter un Matériel')

@push('styles')
<style>
    .form-floating .form-control:focus,
    .form-floating .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: box-shadow 0.15s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 0.75rem 2rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-bottom: none;
        padding: 1.5rem;
    }

    .alert-danger {
        border: none;
        border-left: 4px solid #dc3545;
        background-color: #f8d7da;
    }

    .form-floating > label {
        color: #6c757d;
        font-weight: 500;
    }

    .breadcrumb-item a {
        text-decoration: none;
        color: #6c757d;
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
            <li class="breadcrumb-item active">Ajouter</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                            <i class="bi bi-plus-circle-fill fs-5"></i>
                        </div>
                        <div>
                            <h4 class="text-white mb-1 fw-bold">Nouveau Matériel</h4>
                            <p class="text-white-50 mb-0 small">Ajoutez un matériel à votre inventaire</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Messages d'erreur -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4" role="alert">
                            <div class="d-flex">
                                <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>
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

                    <!-- Formulaire -->
                    <form action="{{ route('materiels.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <div class="row">
                            <!-- Nom du matériel -->
                            <div class="col-md-12 mb-4">
                                <div class="form-floating">
                                    <input type="text"
                                           name="nom"
                                           id="nom"
                                           class="form-control @error('nom') is-invalid @enderror"
                                           value="{{ old('nom') }}"
                                           placeholder="Nom du matériel"
                                           required>
                                    <label for="nom"><i class="bi bi-tag me-1"></i> Nom du Matériel</label>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Catégorie -->
                            <div class="col-md-12 mb-4">
                                <div class="form-floating">
                                    <select name="categorie_id"
                                            id="categorie_id"
                                            class="form-select @error('categorie_id') is-invalid @enderror"
                                            required>
                                        <option value="">Choisissez une catégorie</option>
                                        @foreach($categories as $categorie)
                                            <option value="{{ $categorie->id }}"
                                                {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                                {{ $categorie->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="categorie_id"><i class="bi bi-collection me-1"></i> Catégorie</label>
                                    @error('categorie_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Quantité -->
                            <div class="col-md-12 mb-4">
                                <div class="form-floating">
                                    <input type="number"
                                           name="quantite"
                                           id="quantite"
                                           class="form-control @error('quantite') is-invalid @enderror"
                                           value="{{ old('quantite') }}"
                                           placeholder="Quantité"
                                           min="1"
                                           required>
                                    <label for="quantite"><i class="bi bi-123 me-1"></i> Quantité</label>
                                    @error('quantite')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-4">
                                <div class="form-floating">
                                    <textarea name="description"
                                              id="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              style="height: 120px;"
                                              placeholder="Description du matériel">{{ old('description') }}</textarea>
                                    <label for="description"><i class="bi bi-card-text me-1"></i> Description (optionnelle)</label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-3 pt-3 border-top">
                            <a href="{{ route('materiels.index') }}"
                               class="btn btn-outline-secondary d-flex align-items-center justify-content-center">
                                <i class="bi bi-arrow-left me-2"></i>
                                Retour à la liste
                            </a>

                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-outline-warning">
                                    <i class="bi bi-arrow-clockwise me-1"></i>
                                    Réinitialiser
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-2"></i>
                                    Enregistrer le matériel
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
</script>
@endpush

@endsection
