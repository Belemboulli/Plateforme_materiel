@extends('layouts.app')

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
        background: linear-gradient(135deg, var(--uts-yellow) 0%, #E6AC00 100%);
        color: var(--uts-dark);
        border-radius: 15px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 30px rgba(255, 193, 7, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::after {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: rotate(45deg);
    }

    .edit-card {
        border: none;
        box-shadow: 0 12px 45px rgba(0, 0, 0, 0.1);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        position: relative;
    }

    .edit-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: var(--uts-dark);
        color: white;
        padding: 2rem;
        border: none;
        position: relative;
    }

    .current-info {
        background: rgba(40, 167, 69, 0.1);
        border: 2px solid rgba(40, 167, 69, 0.2);
        border-left: 5px solid var(--uts-green);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-badge {
        background: var(--uts-green);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin: 0.2rem;
    }

    .form-section {
        background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
    }

    .form-section:hover {
        border-color: var(--uts-green);
        transform: translateX(8px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.15);
    }

    .form-section::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: var(--uts-green);
        border-radius: 2px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .form-section:hover::before {
        opacity: 1;
    }

    .section-title {
        color: var(--uts-dark);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        position: relative;
    }

    .section-title i {
        color: var(--uts-yellow);
        margin-right: 0.8rem;
    }

    .section-title::after {
        content: '';
        flex: 1;
        height: 2px;
        background: linear-gradient(to right, var(--uts-green), transparent);
        margin-left: 1rem;
    }

    .form-floating {
        margin-bottom: 1.5rem;
    }

    .form-floating .form-control,
    .form-floating .form-select {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1.2rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(248, 249, 250, 0.5);
    }

    .form-floating .form-control:focus,
    .form-floating .form-select:focus {
        border-color: var(--uts-green);
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.15);
        background: white;
        transform: translateY(-3px);
    }

    .form-floating > label {
        color: var(--uts-dark);
        font-weight: 600;
        padding-left: 1.2rem;
    }

    .required-field::after {
        content: " *";
        color: var(--uts-red);
        font-weight: bold;
        font-size: 1.2em;
    }

    .form-helper {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: rgba(40, 167, 69, 0.05);
        border-left: 3px solid var(--uts-green);
        border-radius: 6px;
    }

    .comparison-display {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-top: 1rem;
        padding: 1rem;
        background: rgba(255, 193, 7, 0.05);
        border-radius: 10px;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    .comparison-item {
        text-align: center;
    }

    .comparison-label {
        font-size: 0.8rem;
        color: var(--uts-dark);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .comparison-value {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .old-value {
        color: #6c757d;
    }

    .new-value {
        color: var(--uts-green);
    }

    .btn-group-custom {
        background: var(--uts-light);
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        margin-top: 2rem;
        box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .btn {
        border-radius: 12px;
        font-weight: 700;
        padding: 1rem 2.5rem;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.5s ease;
        z-index: 1;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary {
        background: var(--uts-green);
        border-color: var(--uts-green);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
    }

    .btn-primary:hover {
        background: #218838;
        border-color: #218838;
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(40, 167, 69, 0.4);
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

    .icon-circle {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .progress-indicator {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }

    .progress-bar-custom {
        height: 100%;
        background: var(--uts-green);
        width: 0%;
        transition: width 0.3s ease;
    }

    .alert-warning {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.2);
        border-left: 4px solid var(--uts-yellow);
        border-radius: 10px;
        color: #856404;
    }

    .timestamp-info {
        background: rgba(108, 117, 125, 0.1);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #6c757d;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.3rem;
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            margin-right: 1rem;
        }

        .form-section {
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-floating .form-control,
        .form-floating .form-select {
            padding: 1rem;
            font-size: 0.9rem;
        }

        .form-helper {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }

        .btn {
            padding: 0.8rem 2rem;
            font-size: 0.85rem;
        }

        .btn-group-custom {
            padding: 1.5rem;
        }

        .comparison-display {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }

        .info-badge {
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
        }
    }

    @media (max-width: 576px) {
        .page-header .d-flex {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .icon-circle {
            margin: 0 auto;
        }

        .form-section {
            padding: 1rem;
        }

        .card-header {
            padding: 1rem 1.5rem;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            font-size: 0.8rem;
            width: 100%;
            margin: 0.25rem 0;
        }

        .current-info {
            padding: 1rem;
        }

        .timestamp-info .row {
            flex-direction: column;
            gap: 0.5rem;
        }
    }

    @media (max-width: 400px) {
        .container-fluid {
            padding: 0.5rem;
        }

        .page-header {
            padding: 0.8rem 1rem;
            border-radius: 10px;
        }

        .edit-card {
            border-radius: 10px;
        }

        .form-section {
            padding: 0.8rem;
            border-radius: 8px;
        }

        .form-floating .form-control,
        .form-floating .form-select {
            padding: 0.8rem;
            font-size: 0.85rem;
        }

        .form-floating > label {
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="page-header">
        <div class="progress-indicator">
            <div class="progress-bar-custom" id="editProgress"></div>
        </div>

        <div class="d-flex align-items-center">
            <div class="icon-circle">
                <i class="bi bi-pencil-square fs-2 text-dark"></i>
            </div>
            <div>
                <h1 class="fw-bold mb-2">Modifier l'Inventaire</h1>
                <p class="mb-0 opacity-75">Mise à jour des données d'inventaire #{{ $inventaire->id }}</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10">
            <!-- Informations actuelles -->
            <div class="current-info">
                <div class="d-flex align-items-start">
                    <i class="bi bi-info-circle-fill me-2 text-success mt-1 fs-5"></i>
                    <div>
                        <strong>Inventaire actuel :</strong>
                        <div class="mt-2">
                            <span class="info-badge">{{ $inventaire->materiel->nom ?? 'N/A' }}</span>
                            <span class="info-badge">Disponible: {{ $inventaire->quantite_disponible }}</span>
                            <span class="info-badge">Utilisée: {{ $inventaire->quantite_utilisee }}</span>
                            @if($inventaire->quantite_defaillante)
                                <span class="info-badge" style="background: var(--uts-yellow); color: var(--uts-dark);">Défaillante: {{ $inventaire->quantite_defaillante }}</span>
                            @endif
                            @if($inventaire->quantite_perdue)
                                <span class="info-badge" style="background: var(--uts-red);">Perdue: {{ $inventaire->quantite_perdue }}</span>
                            @endif
                            <span class="info-badge" style="background: var(--uts-dark);">Total: {{ ($inventaire->quantite_disponible + $inventaire->quantite_utilisee + ($inventaire->quantite_defaillante ?? 0) + ($inventaire->quantite_perdue ?? 0)) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information de modification -->
            <div class="alert alert-warning mb-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>
                        <strong>Attention :</strong>
                        La modification de l'inventaire affectera les calculs de stock global.
                    </div>
                </div>
            </div>

            <!-- Formulaire de modification -->
            <div class="edit-card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-gear-fill me-2"></i>
                        Modification des Données
                    </h4>
                </div>

                <div class="card-body p-4">
                    <!-- Informations temporelles -->
                    <div class="timestamp-info">
                        <div class="row text-center">
                            <div class="col-md-6">
                                <small class="text-muted">Créé le</small>
                                <div class="fw-bold">{{ $inventaire->created_at->format('d/m/Y à H:i') }}</div>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Dernière modification</small>
                                <div class="fw-bold">{{ $inventaire->updated_at->format('d/m/Y à H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('inventaires.update', $inventaire->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Section Matériel -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-gear-fill"></i>
                                Sélection du Matériel
                            </h5>

                            <div class="form-floating">
                                <select name="materiel_id" id="materiel_id"
                                        class="form-select @error('materiel_id') is-invalid @enderror" required>
                                    @foreach ($materiels as $materiel)
                                        <option value="{{ $materiel->id }}"
                                                data-stock="{{ $materiel->quantite ?? 0 }}"
                                                {{ $inventaire->materiel_id == $materiel->id ? 'selected' : '' }}>
                                            {{ $materiel->nom }} (Stock: {{ $materiel->quantite ?? 0 }})
                                        </option>
                                    @endforeach
                                </select>
                                <label for="materiel_id" class="required-field">
                                    <i class="bi bi-box me-2"></i>Matériel
                                </label>
                                <div class="form-helper">
                                    Changement de matériel possible si nécessaire
                                </div>
                                @error('materiel_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Section Quantités -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-calculator"></i>
                                Mise à Jour des Quantités
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="quantite_disponible" id="quantite_disponible"
                                               class="form-control @error('quantite_disponible') is-invalid @enderror"
                                               value="{{ old('quantite_disponible', $inventaire->quantite_disponible) }}"
                                               min="0" required>
                                        <label for="quantite_disponible" class="required-field">
                                            <i class="bi bi-archive me-2"></i>Quantité Disponible
                                        </label>
                                        <div class="form-helper">
                                            Ancienne valeur : {{ $inventaire->quantite_disponible }}
                                        </div>
                                        @error('quantite_disponible')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="quantite_utilisee" id="quantite_utilisee"
                                               class="form-control @error('quantite_utilisee') is-invalid @enderror"
                                               value="{{ old('quantite_utilisee', $inventaire->quantite_utilisee) }}"
                                               min="0" required>
                                        <label for="quantite_utilisee" class="required-field">
                                            <i class="bi bi-check-circle me-2"></i>Quantité Utilisée
                                        </label>
                                        <div class="form-helper">
                                            Ancienne valeur : {{ $inventaire->quantite_utilisee }}
                                        </div>
                                        @error('quantite_utilisee')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="quantite_defaillante" id="quantite_defaillante"
                                               class="form-control @error('quantite_defaillante') is-invalid @enderror"
                                               value="{{ old('quantite_defaillante', $inventaire->quantite_defaillante ?? 0) }}"
                                               min="0">
                                        <label for="quantite_defaillante">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Quantité Défaillante
                                        </label>
                                        <div class="form-helper">
                                            Ancienne valeur : {{ $inventaire->quantite_defaillante ?? 0 }}
                                        </div>
                                        @error('quantite_defaillante')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="quantite_perdue" id="quantite_perdue"
                                               class="form-control @error('quantite_perdue') is-invalid @enderror"
                                               value="{{ old('quantite_perdue', $inventaire->quantite_perdue ?? 0) }}"
                                               min="0">
                                        <label for="quantite_perdue">
                                            <i class="bi bi-question-circle me-2"></i>Quantité Perdue
                                        </label>
                                        <div class="form-helper">
                                            Ancienne valeur : {{ $inventaire->quantite_perdue ?? 0 }}
                                        </div>
                                        @error('quantite_perdue')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Comparaison des totaux -->
                            <div class="comparison-display" id="comparisonDisplay">
                                <div class="comparison-item">
                                    <div class="comparison-label">Total Actuel</div>
                                    <div class="comparison-value old-value" id="oldTotal">
                                        {{ ($inventaire->quantite_disponible + $inventaire->quantite_utilisee + ($inventaire->quantite_defaillante ?? 0) + ($inventaire->quantite_perdue ?? 0)) }}
                                    </div>
                                </div>
                                <div class="comparison-item">
                                    <div class="comparison-label">Nouveau Total</div>
                                    <div class="comparison-value new-value" id="newTotal">
                                        {{ ($inventaire->quantite_disponible + $inventaire->quantite_utilisee + ($inventaire->quantite_defaillante ?? 0) + ($inventaire->quantite_perdue ?? 0)) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section Date et Observations -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-calendar-event"></i>
                                Informations Complémentaires
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" name="date_inventaire" id="date_inventaire"
                                               class="form-control @error('date_inventaire') is-invalid @enderror"
                                               value="{{ old('date_inventaire', $inventaire->date_inventaire) }}" required>
                                        <label for="date_inventaire" class="required-field">
                                            <i class="bi bi-calendar-check me-2"></i>Date de l'Inventaire
                                        </label>
                                        <div class="form-helper">
                                            Date originale : {{ \Carbon\Carbon::parse($inventaire->date_inventaire)->format('d/m/Y') }}
                                        </div>
                                        @error('date_inventaire')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <textarea name="observations" id="observations"
                                                  class="form-control @error('observations') is-invalid @enderror"
                                                  style="min-height: 58px;">{{ old('observations', $inventaire->observations) }}</textarea>
                                        <label for="observations">
                                            <i class="bi bi-chat-text me-2"></i>Observations
                                        </label>
                                        <div class="form-helper">
                                            Notes et commentaires (optionnel)
                                        </div>
                                        @error('observations')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="btn-group-custom">
                            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-lg me-2"></i>
                                    Mettre à Jour
                                </button>

                                <a href="{{ route('inventaires.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Retour sans Modifier
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
// Validation et progression
(function() {
    'use strict';

    const form = document.querySelector('.needs-validation');
    const progressBar = document.getElementById('editProgress');
    const oldTotal = parseInt(document.getElementById('oldTotal').textContent);
    const newTotalElement = document.getElementById('newTotal');

    // Validation du formulaire
    form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    // Mise à jour de la barre de progression
    function updateProgress() {
        const fields = form.querySelectorAll('input[required], select[required]');
        let completed = 0;

        fields.forEach(field => {
            if (field.value.trim() !== '') {
                completed++;
            }
        });

        const progress = (completed / fields.length) * 100;
        progressBar.style.width = progress + '%';
    }

    // Comparaison des totaux avec tous les champs
    function updateComparison() {
        const disponible = parseInt(document.getElementById('quantite_disponible').value) || 0;
        const utilisee = parseInt(document.getElementById('quantite_utilisee').value) || 0;
        const defaillante = parseInt(document.getElementById('quantite_defaillante').value) || 0;
        const perdue = parseInt(document.getElementById('quantite_perdue').value) || 0;
        const newTotal = disponible + utilisee + defaillante + perdue;

        // Animation du nouveau total
        let current = parseInt(newTotalElement.textContent);
        const increment = (newTotal - current) / 10;

        const timer = setInterval(() => {
            current += increment;
            if (Math.abs(current - newTotal) < 1) {
                current = newTotal;
                clearInterval(timer);
            }
            newTotalElement.textContent = Math.round(current);
        }, 50);

        // Changement de couleur selon la différence
        if (newTotal > oldTotal) {
            newTotalElement.style.color = 'var(--uts-green)';
        } else if (newTotal < oldTotal) {
            newTotalElement.style.color = 'var(--uts-red)';
        } else {
            newTotalElement.style.color = 'var(--uts-dark)';
        }
    }

    // Écouteurs d'événements
    form.addEventListener('input', updateProgress);
    form.addEventListener('change', updateProgress);

    ['quantite_disponible', 'quantite_utilisee', 'quantite_defaillante', 'quantite_perdue'].forEach(id => {
        document.getElementById(id).addEventListener('input', updateComparison);
    });

    // Animation des sections au chargement
    const sections = document.querySelectorAll('.form-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateX(-30px)';

        setTimeout(() => {
            section.style.transition = 'all 0.6s ease';
            section.style.opacity = '1';
            section.style.transform = 'translateX(0)';
        }, index * 200);
    });

    // Initialisation
    updateProgress();

    // Validation des quantités
    ['quantite_disponible', 'quantite_utilisee', 'quantite_defaillante', 'quantite_perdue'].forEach(id => {
        document.getElementById(id).addEventListener('input', function() {
            if (this.value < 0) {
                this.setCustomValidity('La quantité ne peut pas être négative');
            } else {
                this.setCustomValidity('');
            }
        });
    });
})();
</script>
@endpush

@endsection
