@extends('layouts.app')

@section('title', 'Créer Permission')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Breadcrumb et En-tête -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('permissions.index') }}" class="text-warning text-decoration-none">
                        <i class="fas fa-shield-alt me-1"></i>Permissions
                    </a>
                </li>
                <li class="breadcrumb-item active text-muted">Nouvelle permission</li>
            </ol>
        </nav>
        <h1 class="h3 mb-0 text-dark fw-bold">
            <i class="fas fa-plus-circle text-success me-2"></i>
            Créer une nouvelle permission
        </h1>
        <p class="text-muted small mb-0">Définissez les droits d'accès pour votre système</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <!-- Formulaire principal -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-20 p-3 me-3">
                            <i class="fas fa-key text-success fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-semibold text-dark">Nouvelle Permission</h5>
                            <small class="text-muted">Remplissez les informations ci-dessous</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf

                        <!-- Nom de la permission -->
                        <div class="mb-4">
                            <label for="name" class="form-label text-dark fw-semibold mb-2">
                                <i class="fas fa-tag text-warning me-2"></i>
                                Nom de la permission
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-warning bg-opacity-10 border-warning border-opacity-50">
                                    <i class="fas fa-signature text-warning"></i>
                                </span>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control border-warning border-opacity-50 @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}"
                                       placeholder="Ex: manage-users, create-posts..."
                                       required>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @else
                                <small class="form-text text-muted">
                                    Utilisez des tirets pour séparer les mots (ex: manage-inventory)
                                </small>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label text-dark fw-semibold mb-2">
                                <i class="fas fa-align-left text-warning me-2"></i>
                                Description
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-warning bg-opacity-10 border-warning border-opacity-50 align-items-start pt-3">
                                    <i class="fas fa-comment text-warning"></i>
                                </span>
                                <textarea name="description"
                                          id="description"
                                          class="form-control border-warning border-opacity-50 @error('description') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Décrivez brièvement cette permission et son utilité...">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @else
                                <small class="form-text text-muted">
                                    Expliquez à quoi sert cette permission pour faciliter la gestion
                                </small>
                            @enderror
                        </div>

                        <!-- Aide contextuelle -->
                        <div class="alert alert-warning border-warning border-opacity-50 bg-warning bg-opacity-10" role="alert">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-lightbulb text-warning me-3 mt-1"></i>
                                <div>
                                    <h6 class="alert-heading text-warning mb-2">Conseils pour nommer vos permissions</h6>
                                    <ul class="mb-0 small text-dark">
                                        <li>Utilisez des noms clairs et explicites</li>
                                        <li>Préférez le format : <code>action-ressource</code></li>
                                        <li>Exemples : <code>view-inventory</code>, <code>edit-users</code>, <code>delete-reports</code></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-success shadow-sm">
                                <i class="fas fa-check me-2"></i>Créer la permission
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light py-3">
                    <h6 class="mb-0 text-dark fw-semibold">
                        <i class="fas fa-info-circle text-warning me-2"></i>
                        À propos des permissions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-success bg-opacity-20 p-2 me-3 mt-1">
                                    <i class="fas fa-users text-success small"></i>
                                </div>
                                <div>
                                    <h6 class="text-success mb-1">Attribution aux rôles</h6>
                                    <small class="text-muted">Les permissions peuvent être attribuées à plusieurs rôles</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-warning bg-opacity-20 p-2 me-3 mt-1">
                                    <i class="fas fa-cog text-warning small"></i>
                                </div>
                                <div>
                                    <h6 class="text-warning mb-1">Configuration système</h6>
                                    <small class="text-muted">Certaines permissions sont critiques pour le système</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-danger bg-opacity-20 p-2 me-3 mt-1">
                                    <i class="fas fa-shield-alt text-danger small"></i>
                                </div>
                                <div>
                                    <h6 class="text-danger mb-1">Sécurité</h6>
                                    <small class="text-muted">Soyez prudent avec les permissions sensibles</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-secondary bg-opacity-20 p-2 me-3 mt-1">
                                    <i class="fas fa-edit text-secondary small"></i>
                                </div>
                                <div>
                                    <h6 class="text-secondary mb-1">Modification</h6>
                                    <small class="text-muted">Les permissions peuvent être modifiées ultérieurement</small>
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
/* Animations */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.btn {
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.input-group-text {
    transition: all 0.2s ease;
}

.breadcrumb-item a:hover {
    color: #e0a800 !important;
}

/* Couleurs UTS */
.text-warning { color: #ffc107 !important; }
.bg-warning { background-color: #ffc107 !important; }
.border-warning { border-color: #ffc107 !important; }
.btn-outline-warning { border-color: #ffc107; color: #ffc107; }
.btn-outline-warning:hover { background-color: #ffc107; color: #000; }

/* Amélioration du focus */
.form-control:focus + .input-group-text {
    border-color: #ffc107;
    background-color: rgba(255, 193, 7, 0.15);
}
</style>
@endsection
