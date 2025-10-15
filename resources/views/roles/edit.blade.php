@extends('layouts.app')

@section('title', 'Modifier le rôle')

@push('styles')
<style>
    .uts-primary { color: #2E7D32; }
    .uts-warning { color: #FFA000; }
    .uts-danger { color: #d32f2f; }
    .bg-uts-warning { background: linear-gradient(45deg, #FFA000, #FFB74D); }
    .bg-uts-primary { background-color: #2E7D32; }
    .border-uts-warning { border-color: #FFA000; }

    .form-card {
        border-radius: 15px;
        box-shadow: 0 6px 25px rgba(255, 160, 0, 0.15);
        border: 1px solid rgba(255, 160, 0, 0.2);
        overflow: hidden;
    }

    .header-card {
        background: linear-gradient(135deg, #FFA000 0%, #FF8F00 100%);
        border-radius: 15px;
        position: relative;
        overflow: hidden;
    }

    .header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='7' cy='7' r='3'/%3E%3Ccircle cx='53' cy='7' r='3'/%3E%3Ccircle cx='7' cy='53' r='3'/%3E%3Ccircle cx='53' cy='53' r='3'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
    }

    .icon-wrapper {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .form-control:focus {
        border-color: #FFA000;
        box-shadow: 0 0 0 0.2rem rgba(255, 160, 0, 0.25);
        transform: translateY(-1px);
    }

    .form-select:focus {
        border-color: #FFA000;
        box-shadow: 0 0 0 0.2rem rgba(255, 160, 0, 0.25);
    }

    .btn-uts-warning {
        background: linear-gradient(45deg, #FFA000, #FFB74D);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 160, 0, 0.3);
    }

    .btn-uts-warning:hover {
        background: linear-gradient(45deg, #FF8F00, #FFA000);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 160, 0, 0.4);
        color: white;
    }

    .priority-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23FFA000' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    }

    .color-palette {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .color-option {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        border: 3px solid transparent;
        transition: all 0.3s ease;
        position: relative;
    }

    .color-option:hover,
    .color-option.selected {
        border-color: #FFA000;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .color-option.selected::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: bold;
        text-shadow: 0 1px 2px rgba(0,0,0,0.7);
    }

    .info-card {
        background: linear-gradient(135deg, rgba(255, 160, 0, 0.1) 0%, rgba(46, 125, 50, 0.1) 100%);
        border: 2px solid rgba(255, 160, 0, 0.2);
        border-radius: 12px;
    }

    .permissions-card {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.05) 0%, rgba(255, 160, 0, 0.05) 100%);
        border: 1px solid rgba(46, 125, 50, 0.15);
        border-radius: 12px;
    }

    .permission-badge {
        background: linear-gradient(45deg, #2E7D32, #4CAF50);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .status-toggle {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .status-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .status-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 34px;
    }

    .status-slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked + .status-slider {
        background: linear-gradient(45deg, #2E7D32, #4CAF50);
    }

    input:checked + .status-slider:before {
        transform: translateX(26px);
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <!-- En-tête -->
            <div class="header-card text-white text-center py-5 mb-4">
                <div class="position-relative">
                    <div class="icon-wrapper">
                        <i class="fas fa-user-edit fa-2x text-white"></i>
                    </div>
                    <h1 class="fw-bold mb-2">Modifier le Rôle</h1>
                    <p class="mb-0 opacity-90">
                        Université Thomas Sankara - Édition de <strong>"{{ $role->name }}"</strong>
                    </p>
                </div>
            </div>

            <!-- Messages d'erreur -->
            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3 mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3"></i>
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

            <!-- Messages de succès -->
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 mb-4">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <!-- Formulaire -->
            <div class="card form-card">
                <div class="card-body p-5">
                    <form action="{{ route('roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nom du rôle -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tag uts-warning me-2"></i>Nom du rôle <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   value="{{ old('name', $role->name) }}"
                                   placeholder="Ex: Administrateur, Gestionnaire..."
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-align-left uts-warning me-2"></i>Description
                            </label>
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Décrivez les responsabilités de ce rôle...">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Priorité -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-sort-numeric-up uts-primary me-2"></i>Niveau de priorité <span class="text-danger">*</span>
                            </label>
                            <select name="priority_level"
                                    class="form-select priority-select @error('priority_level') is-invalid @enderror"
                                    required>
                                <option value="">Sélectionner un niveau</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('priority_level', $role->priority_level) == $i ? 'selected' : '' }}>
                                        {{ $i }} -
                                        @switch($i)
                                            @case(1) Très élevé @break
                                            @case(2) Élevé @break
                                            @case(3) Moyen @break
                                            @case(4) Faible @break
                                            @case(5) Très faible @break
                                        @endswitch
                                    </option>
                                @endfor
                            </select>
                            @error('priority_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Statut avec toggle moderne -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-3">
                                <i class="fas fa-toggle-on uts-primary me-2"></i>Statut du rôle
                            </label>
                            <div class="d-flex align-items-center">
                                <label class="status-toggle me-3">
                                    <input type="checkbox"
                                           id="is_active"
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', $role->is_active) ? 'checked' : '' }}>
                                    <span class="status-slider"></span>
                                </label>
                                <span class="fw-medium" id="status-text">
                                    {{ old('is_active', $role->is_active) ? 'Rôle actif' : 'Rôle inactif' }}
                                </span>
                            </div>
                        </div>

                        <!-- Couleur avec palette -->
                        <div class="mb-5">
                            <label class="form-label fw-semibold mb-3">
                                <i class="fas fa-palette uts-warning me-2"></i>Couleur du rôle
                            </label>
                            <input type="hidden" name="color" id="color" value="{{ old('color', $role->color ?? '#2E7D32') }}">
                            <div class="color-palette">
                                <div class="color-option {{ old('color', $role->color) == '#2E7D32' ? 'selected' : '' }}"
                                     style="background-color: #2E7D32;"
                                     data-color="#2E7D32"
                                     title="Vert UTS"></div>
                                <div class="color-option {{ old('color', $role->color) == '#FFA000' ? 'selected' : '' }}"
                                     style="background-color: #FFA000;"
                                     data-color="#FFA000"
                                     title="Jaune UTS"></div>
                                <div class="color-option {{ old('color', $role->color) == '#1565C0' ? 'selected' : '' }}"
                                     style="background-color: #1565C0;"
                                     data-color="#1565C0"
                                     title="Bleu"></div>
                                <div class="color-option {{ old('color', $role->color) == '#D32F2F' ? 'selected' : '' }}"
                                     style="background-color: #D32F2F;"
                                     data-color="#D32F2F"
                                     title="Rouge"></div>
                                <div class="color-option {{ old('color', $role->color) == '#455A64' ? 'selected' : '' }}"
                                     style="background-color: #455A64;"
                                     data-color="#455A64"
                                     title="Gris"></div>
                            </div>
                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">Couleur sélectionnée :</span>
                                    <div id="color-preview"
                                         style="width: 30px; height: 30px; border-radius: 50%; background-color: {{ old('color', $role->color ?? '#2E7D32') }}; border: 2px solid #ccc;"></div>
                                    <span class="ms-2 font-monospace" id="color-code">{{ old('color', $role->color ?? '#2E7D32') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Information de modification -->
                        <div class="info-card p-4 mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle uts-warning me-3 fa-lg"></i>
                                <div>
                                    <div class="fw-semibold mb-1">Informations de modification</div>
                                    <small class="text-muted">
                                        <strong>Dernière modification :</strong>
                                        {{ $role->updated_at ? $role->updated_at->format('d/m/Y à H:i') : 'Jamais modifié' }}
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        <strong>Créé le :</strong>
                                        {{ $role->created_at ? $role->created_at->format('d/m/Y à H:i') : 'Date inconnue' }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                            </a>
                            <div class="d-flex gap-2">
                                <a href="{{ route('roles.show', $role) }}" class="btn btn-outline-info">
                                    <i class="fas fa-eye me-2"></i>Voir
                                </a>
                                <button type="submit" class="btn btn-uts-warning" id="updateBtn">
                                    <i class="fas fa-save me-2"></i>Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Permissions Card -->
            @if($role->permissions && $role->permissions->count() > 0)
            <div class="card permissions-card mt-4">
                <div class="card-header border-0 bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-key uts-primary me-2"></i>Permissions actuelles
                        <span class="badge bg-secondary ms-2">{{ $role->permissions->count() }}</span>
                    </h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-2">
                        @foreach($role->permissions as $permission)
                        <div class="col-auto">
                            <span class="permission-badge">{{ $permission->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du toggle de statut
    const statusToggle = document.getElementById('is_active');
    const statusText = document.getElementById('status-text');

    function updateStatusText() {
        statusText.textContent = statusToggle.checked ? 'Rôle actif' : 'Rôle inactif';
        statusText.className = statusToggle.checked ? 'fw-medium text-success' : 'fw-medium text-muted';
    }

    statusToggle.addEventListener('change', updateStatusText);

    // Gestion des couleurs
    const colorOptions = document.querySelectorAll('.color-option');
    const colorInput = document.getElementById('color');
    const colorPreview = document.getElementById('color-preview');
    const colorCode = document.getElementById('color-code');

    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            const color = this.dataset.color;

            // Mise à jour visuelle
            colorOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');

            // Mise à jour des valeurs
            colorInput.value = color;
            colorPreview.style.backgroundColor = color;
            colorCode.textContent = color;
        });
    });

    // Validation du formulaire
    const form = document.querySelector('form');
    const updateBtn = document.getElementById('updateBtn');

    form.addEventListener('submit', function(e) {
        const name = document.querySelector('input[name="name"]').value.trim();
        const priority = document.querySelector('select[name="priority_level"]').value;

        if (!name) {
            e.preventDefault();
            alert('Veuillez saisir le nom du rôle.');
            document.querySelector('input[name="name"]').focus();
            return false;
        }

        if (!priority) {
            e.preventDefault();
            alert('Veuillez sélectionner un niveau de priorité.');
            return false;
        }

        // Animation du bouton
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mise à jour...';
        updateBtn.disabled = true;
    });
});
</script>
@endpush
