@extends('layouts.app')

@section('title', 'Créer un nouveau rôle')

@push('styles')
<style>
    .uts-primary { color: #2E7D32; }
    .uts-warning { color: #FFA000; }
    .uts-danger { color: #d32f2f; }
    .bg-uts-primary { background-color: #2E7D32; }
    .bg-uts-warning { background-color: #FFA000; }
    .bg-uts-light { background-color: #f8f9fa; }
    .border-uts { border-color: #2E7D32; }

    .form-card {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(46, 125, 50, 0.1);
        border: 1px solid rgba(46, 125, 50, 0.2);
    }

    .form-control:focus {
        border-color: #2E7D32;
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.25);
    }

    .btn-uts {
        background: linear-gradient(45deg, #2E7D32, #4CAF50);
        border: none;
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-uts:hover {
        background: linear-gradient(45deg, #1B5E20, #2E7D32);
        color: white;
        transform: translateY(-1px);
    }

    .priority-option {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        background: white;
    }

    .priority-option:hover { border-color: #FFA000; }
    .priority-option.selected {
        border-color: #2E7D32;
        background-color: rgba(46, 125, 50, 0.1);
        color: #2E7D32;
        font-weight: 600;
    }

    .color-choice {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        cursor: pointer;
        border: 3px solid transparent;
        transition: all 0.3s;
    }

    .color-choice.selected {
        border-color: #2E7D32;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- En-tête -->
            <div class="bg-uts-primary text-white text-center py-4 mb-4 rounded-3">
                <i class="fas fa-user-shield fa-2x mb-2"></i>
                <h2 class="mb-1">Nouveau Rôle</h2>
                <p class="mb-0">Université Thomas Sankara</p>
            </div>

            <!-- Messages d'erreur -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Erreurs détectées :</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Messages de succès/erreur depuis la session -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <!-- Formulaire -->
            <div class="card form-card">
                <div class="card-body p-4">
                    <form action="{{ route('roles.store') }}" method="POST" id="roleForm">
                        @csrf

                        <!-- Nom du rôle -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tag uts-primary me-2"></i>Nom du rôle <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="roleName"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Ex: Administrateur, Gestionnaire..."
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-align-left uts-primary me-2"></i>Description
                            </label>
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Décrivez les responsabilités de ce rôle...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Priorité -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-sort-numeric-up uts-warning me-2"></i>Niveau de priorité <span class="text-danger">*</span>
                            </label>
                            <div class="row g-2 mt-1">
                                <div class="col">
                                    <div class="priority-option" data-value="1">
                                        <div class="fw-bold">1</div>
                                        <small>Très élevé</small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="priority-option" data-value="2">
                                        <div class="fw-bold">2</div>
                                        <small>Élevé</small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="priority-option" data-value="3">
                                        <div class="fw-bold">3</div>
                                        <small>Moyen</small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="priority-option" data-value="4">
                                        <div class="fw-bold">4</div>
                                        <small>Faible</small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="priority-option" data-value="5">
                                        <div class="fw-bold">5</div>
                                        <small>Très faible</small>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="priority_level" id="priority_level" value="{{ old('priority_level') }}">
                            @error('priority_level')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-toggle-on uts-primary me-2"></i>Statut
                            </label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Rôle actif
                                </label>
                            </div>
                        </div>

                        <!-- Couleur (SUPPRESSION DU BLEU) -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-palette uts-warning me-2"></i>Couleur
                            </label>
                            <div class="d-flex gap-2 mt-2">
                                <div class="color-choice selected" style="background-color: #2E7D32;" data-color="#2E7D32" title="Vert UTS"></div>
                                <div class="color-choice" style="background-color: #FFA000;" data-color="#FFA000" title="Jaune UTS"></div>
                                <div class="color-choice" style="background-color: #4CAF50;" data-color="#4CAF50" title="Vert clair UTS"></div>
                                <div class="color-choice" style="background-color: #d32f2f;" data-color="#d32f2f" title="Rouge"></div>
                                <div class="color-choice" style="background-color: #6c757d;" data-color="#6c757d" title="Gris"></div>
                            </div>
                            <input type="hidden" name="color" id="color" value="{{ old('color', '#2E7D32') }}">
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-uts" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Créer le rôle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('roleForm');
    const priorityOptions = document.querySelectorAll('.priority-option');
    const priorityInput = document.getElementById('priority_level');
    const submitBtn = document.getElementById('submitBtn');

    // Gestion des priorités
    if (priorityInput.value) {
        priorityOptions.forEach(option => {
            if (option.dataset.value === priorityInput.value) {
                option.classList.add('selected');
            }
        });
    }

    priorityOptions.forEach(option => {
        option.addEventListener('click', function() {
            priorityOptions.forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            priorityInput.value = this.dataset.value;
            console.log('Priorité sélectionnée:', this.dataset.value);
        });
    });

    // Gestion des couleurs
    const colorChoices = document.querySelectorAll('.color-choice');
    const colorInput = document.getElementById('color');

    const selectedColor = colorInput.value;
    colorChoices.forEach(choice => {
        if (choice.dataset.color === selectedColor) {
            colorChoices.forEach(c => c.classList.remove('selected'));
            choice.classList.add('selected');
        }
    });

    colorChoices.forEach(choice => {
        choice.addEventListener('click', function() {
            colorChoices.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            colorInput.value = this.dataset.color;
            console.log('Couleur sélectionnée:', this.dataset.color);
        });
    });

    // Validation simplifiée
    form.addEventListener('submit', function(e) {
        const name = document.getElementById('roleName').value.trim();
        const priority = priorityInput.value;

        console.log('Validation - Nom:', name, 'Priorité:', priority);

        if (!name) {
            e.preventDefault();
            alert('Veuillez saisir le nom du rôle.');
            document.getElementById('roleName').focus();
            return false;
        }

        if (!priority) {
            e.preventDefault();
            alert('Veuillez sélectionner un niveau de priorité.');
            return false;
        }

        // Animation du bouton seulement si validation OK
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Création...';
        submitBtn.disabled = true;

        console.log('Formulaire soumis avec succès');
        return true;
    });
});
</script>
@endpush
