@extends('layouts.app')

@section('title', 'Ajouter un Octroi')

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

    .form-card {
        border: none;
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .form-card:hover {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: var(--uts-dark);
        color: white;
        padding: 1.5rem 2rem;
        border: none;
    }

    .form-floating {
        margin-bottom: 1.5rem;
    }

    .form-floating .form-control:focus,
    .form-floating .form-select:focus {
        border-color: var(--uts-green);
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
        background-color: rgba(40, 167, 69, 0.02);
    }

    .form-floating > label {
        color: var(--uts-dark);
        font-weight: 500;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 1rem;
        transition: all 0.3s ease;
        background-color: #fafbfc;
    }

    .form-control:focus,
    .form-select:focus {
        background-color: white;
        transform: translateY(-2px);
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.75rem 2rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .btn-primary {
        background: var(--uts-green);
        border-color: var(--uts-green);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-primary:hover {
        background: #218838;
        border-color: #218838;
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(40, 167, 69, 0.4);
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

    .alert {
        border: none;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        border-left: 4px solid var(--uts-green);
        color: #155724;
    }

    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        border-left: 4px solid var(--uts-red);
        color: #721c24;
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
    }

    .input-group-text {
        background: var(--uts-green);
        border: none;
        color: white;
        border-radius: 10px 0 0 10px;
    }

    .form-section {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .form-section:hover {
        border-color: var(--uts-green);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        color: var(--uts-dark);
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--uts-green);
        display: inline-block;
    }

    .required-field::after {
        content: " *";
        color: var(--uts-red);
        font-weight: bold;
    }

    .form-helper {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

    .actions-section {
        background: var(--uts-light);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        margin-top: 2rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="page-header">
        <div class="d-flex align-items-center">
            <div class="icon-circle">
                <i class="bi bi-plus-circle-fill fs-3"></i>
            </div>
            <div>
                <h1 class="fw-bold mb-2">Nouveau Octroi</h1>
                <p class="mb-0 opacity-75">Attribution de matériel à un bénéficiaire</p>
            </div>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5 mt-1"></i>
                <div>
                    <strong>Erreurs détectées :</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <!-- Formulaire -->
            <div class="form-card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-clipboard-data me-2"></i>
                        Informations de l'Octroi
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('octrois.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <!-- Section Bénéficiaire -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-person me-2"></i>
                                Informations Bénéficiaire
                            </h5>

                            <div class="form-floating">
                                <input type="text" name="beneficiaire" id="beneficiaire"
                                       class="form-control @error('beneficiaire') is-invalid @enderror"
                                       value="{{ old('beneficiaire') }}" required>
                                <label for="beneficiaire" class="required-field">
                                    <i class="bi bi-person-fill me-2"></i>Nom du Bénéficiaire
                                </label>
                                <div class="form-helper">Nom complet de la personne qui recevra le matériel</div>
                                @error('beneficiaire')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Section Matériel -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-box-seam me-2"></i>
                                Détails du Matériel
                            </h5>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-floating">
                                        <input type="text" name="materiel" id="materiel"
                                               class="form-control @error('materiel') is-invalid @enderror"
                                               value="{{ old('materiel') }}" required>
                                        <label for="materiel" class="required-field">
                                            <i class="bi bi-box me-2"></i>Nom du Matériel
                                        </label>
                                        <div class="form-helper">Désignation précise du matériel à octroyer</div>
                                        @error('materiel')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" name="quantite" id="quantite"
                                               class="form-control @error('quantite') is-invalid @enderror"
                                               value="{{ old('quantite') }}" min="1" required>
                                        <label for="quantite" class="required-field">
                                            <i class="bi bi-123 me-2"></i>Quantité
                                        </label>
                                        <div class="form-helper">Nombre d'unités</div>
                                        @error('quantite')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Date -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-calendar me-2"></i>
                                Date d'Attribution
                            </h5>

                            <div class="form-floating">
                                <input type="date" name="date_octroi" id="date_octroi"
                                       class="form-control @error('date_octroi') is-invalid @enderror"
                                       value="{{ old('date_octroi', date('Y-m-d')) }}" required>
                                <label for="date_octroi" class="required-field">
                                    <i class="bi bi-calendar-event me-2"></i>Date d'Octroi
                                </label>
                                <div class="form-helper">Date à laquelle le matériel sera remis</div>
                                @error('date_octroi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="actions-section">
                            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-lg me-2"></i>
                                    Enregistrer l'Octroi
                                </button>

                                <a href="{{ route('octrois.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="bi bi-x-lg me-2"></i>
                                    Annuler
                                </a>
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
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
})();

// Animation des sections au chargement
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.form-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';

        setTimeout(() => {
            section.style.transition = 'all 0.6s ease';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, index * 150);
    });
});

// Auto-focus sur le premier champ
document.getElementById('beneficiaire').focus();

// Validation dynamique des quantités
document.getElementById('quantite').addEventListener('input', function() {
    if (this.value < 1) {
        this.setCustomValidity('La quantité doit être au moins 1');
    } else {
        this.setCustomValidity('');
    }
});
</script>
@endpush

@endsection
