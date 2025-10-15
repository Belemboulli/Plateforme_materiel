@extends('layouts.app')

@section('title', 'Modifier l'Octroi')

@push('styles')
<style>
    :root {
        --uts-yellow: #FFC107;
        --uts-green: #28A745;
        --uts-red: #DC3545;
        --uts-dark: #2C3E50;
        --uts-light: #F8F9FA;
    }

    .card {
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, var(--uts-yellow) 0%, #FFB300 100%);
        border: none;
        padding: 2rem;
    }

    .form-floating .form-control:focus,
    .form-floating .form-select:focus {
        border-color: var(--uts-green);
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
    }

    .btn-primary {
        background: var(--uts-green);
        border-color: var(--uts-green);
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #218838;
        border-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
    }

    .btn-outline-secondary {
        border-color: var(--uts-dark);
        color: var(--uts-dark);
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-outline-warning {
        border-color: var(--uts-yellow);
        color: #856404;
        border-radius: 8px;
    }

    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.2);
        border-left: 4px solid var(--uts-red);
        border-radius: 8px;
    }

    .form-floating > label {
        color: var(--uts-dark);
        font-weight: 500;
    }

    .breadcrumb-item.active {
        color: var(--uts-green);
    }

    .breadcrumb-item a {
        color: var(--uts-dark);
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: var(--uts-green);
    }

    .header-icon {
        background: rgba(255, 255, 255, 0.2);
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .invalid-feedback {
        color: var(--uts-red);
    }

    .is-invalid {
        border-color: var(--uts-red);
    }

    .current-info {
        background: rgba(40, 167, 69, 0.1);
        border: 1px solid rgba(40, 167, 69, 0.2);
        border-left: 4px solid var(--uts-green);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-house-door"></i> Accueil
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('octrois.index') }}">Octrois</a>
            </li>
            <li class="breadcrumb-item active">Modifier</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="header-icon me-3">
                            <i class="bi bi-pencil-square fs-4 text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-white mb-1 fw-bold">Modifier l'Octroi</h3>
                            <p class="text-white mb-0 opacity-75">Mise à jour des informations d'attribution</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Informations actuelles -->
                    <div class="current-info">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-info-circle-fill me-2 text-success mt-1"></i>
                            <div>
                                <strong>Octroi actuel :</strong>
                                <div class="mt-1 small">
                                    <span class="badge bg-light text-dark me-2">{{ $octroi->materiel->nom ?? 'N/A' }}</span>
                                    <span class="badge bg-light text-dark me-2">{{ $octroi->structure->name ?? 'N/A' }}</span>
                                    <span class="badge bg-success">Qté: {{ $octroi->quantite }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages d'erreur -->
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-exclamation-triangle-fill me-2 text-danger mt-1"></i>
                                <div>
                                    <strong>Erreurs détectées :</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Formulaire -->
                    <form action="{{ route('octrois.update', $octroi->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Matériel -->
                        <div class="mb-4">
                            <div class="form-floating">
                                <select name="materiel_id" id="materiel_id"
                                        class="form-select @error('materiel_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionnez un matériel --</option>
                                    @foreach($materiels as $materiel)
                                        <option value="{{ $materiel->id }}"
                                                {{ old('materiel_id', $octroi->materiel_id) == $materiel->id ? 'selected' : '' }}>
                                            {{ $materiel->nom }} (Stock: {{ $materiel->quantite }})
                                        </option>
                                    @endforeach
                                </select>
                                <label for="materiel_id">
                                    <i class="bi bi-box-seam me-2"></i>Matériel
                                </label>
                                @error('materiel_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Structure -->
                        <div class="mb-4">
                            <div class="form-floating">
                                <select name="structure_id" id="structure_id"
                                        class="form-select @error('structure_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionnez un structure --</option>
                                    @foreach($structures as $structure)
                                        <option value="{{ $structure->id }}"
                                                {{ old('structure_id', $octroi->structure_id) == $structure->id ? 'selected' : '' }}>
                                            {{ $structure->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="structure_id">
                                    <i class="bi bi-building me-2"></i>Structure
                                </label>
                                @error('structure_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Quantité -->
                        <div class="mb-4">
                            <div class="form-floating">
                                <input type="number" name="quantite" id="quantite"
                                       class="form-control @error('quantite') is-invalid @enderror"
                                       value="{{ old('quantite', $octroi->quantite) }}" min="1" required>
                                <label for="quantite">
                                    <i class="bi bi-123 me-2"></i>Quantité
                                </label>
                                @error('quantite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                            <a href="{{ route('octrois.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>

                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-outline-warning">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-2"></i>Mettre à jour
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

// Contrôle stock pour modification
document.getElementById('materiel_id').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const stockText = selected.textContent.match(/Stock: (\d+)/);
    const quantiteInput = document.getElementById('quantite');

    if (stockText) {
        const stock = parseInt(stockText[1]);
        quantiteInput.setAttribute('max', stock);
        quantiteInput.placeholder = `Max disponible: ${stock}`;
    }
});
</script>
@endpush

@endsection
