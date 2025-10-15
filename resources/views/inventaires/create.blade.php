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
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 30px rgba(255, 193, 7, 0.2);
        position: relative;
    }

    .inventory-card {
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border-radius: 15px;
        overflow: hidden;
        background: white;
        transition: transform 0.3s ease;
    }

    .inventory-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background: var(--uts-dark);
        color: white;
        padding: 1.5rem 2rem;
        border: none;
    }

    .form-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #dee2e6;
        border-left: 4px solid var(--uts-yellow);
        transition: all 0.3s ease;
    }

    .form-section:hover {
        border-left-color: var(--uts-green);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.1);
    }

    .section-title {
        color: var(--uts-dark);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        color: var(--uts-yellow);
        margin-right: 0.8rem;
        font-size: 1.2rem;
    }

    .form-floating {
        margin-bottom: 1.2rem;
    }

    .form-floating .form-control,
    .form-floating .form-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        color: var(--uts-dark);
    }

    .form-floating .form-control:focus,
    .form-floating .form-select:focus {
        border-color: var(--uts-green);
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
        outline: none;
    }

    .form-floating > label {
        color: var(--uts-dark);
        font-weight: 600;
        padding-left: 1rem;
    }

    .required-field::after {
        content: " *";
        color: var(--uts-red);
        font-weight: bold;
    }

    .form-helper {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.5rem;
        padding: 0.6rem 0.8rem;
        background: var(--uts-light);
        border-radius: 6px;
        border-left: 3px solid var(--uts-yellow);
    }

    .btn-group-custom {
        background: var(--uts-light);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        margin-top: 1.5rem;
    }

    .btn {
        border-radius: 8px;
        font-weight: 700;
        padding: 0.8rem 2rem;
        font-size: 0.95rem;
        text-transform: uppercase;
        transition: all 0.3s ease;
        margin: 0.25rem;
    }

    .btn-success {
        background: var(--uts-green);
        border-color: var(--uts-green);
        color: white;
    }

    .btn-success:hover {
        background: #218838;
        border-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(40, 167, 69, 0.3);
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
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        flex-shrink: 0;
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

    .quantity-display {
        background: rgba(40, 167, 69, 0.05);
        border: 2px solid rgba(40, 167, 69, 0.2);
        border-radius: 10px;
        padding: 1.2rem;
        text-align: center;
        margin-top: 1rem;
    }

    .quantity-value {
        font-size: 1.6rem;
        font-weight: bold;
        color: var(--uts-green);
    }

    .alert-info {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.3);
        border-left: 4px solid var(--uts-yellow);
        border-radius: 8px;
        color: var(--uts-dark);
        padding: 1rem;
    }

    .stock-info {
        background: rgba(255, 193, 7, 0.05);
        border: 1px solid rgba(255, 193, 7, 0.2);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .stock-detail {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.4rem 0.6rem;
        background: white;
        border-radius: 6px;
        margin-bottom: 0.4rem;
        font-weight: 600;
        color: var(--uts-dark);
        font-size: 0.9rem;
    }

    .is-invalid {
        border-color: var(--uts-red) !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15) !important;
    }

    .invalid-feedback {
        color: var(--uts-red);
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-success {
        background: var(--uts-green);
        color: white;
    }

    .badge-warning {
        background: var(--uts-yellow);
        color: var(--uts-dark);
    }

    .badge-danger {
        background: var(--uts-red);
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        .page-header p {
            font-size: 0.9rem;
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            margin-right: 1rem;
        }

        .form-section {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .section-title i {
            font-size: 1rem;
            margin-right: 0.5rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-floating .form-control,
        .form-floating .form-select {
            padding: 0.8rem;
            font-size: 0.9rem;
        }

        .form-helper {
            font-size: 0.8rem;
            padding: 0.5rem 0.6rem;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            font-size: 0.85rem;
            margin: 0.2rem;
            width: 100%;
        }

        .btn-group-custom {
            padding: 1rem;
        }

        .quantity-display {
            padding: 1rem;
        }

        .quantity-value {
            font-size: 1.4rem;
        }

        .stock-detail {
            font-size: 0.85rem;
            padding: 0.3rem 0.5rem;
        }

        .card-header {
            padding: 1rem 1.5rem;
        }

        .card-header h4 {
            font-size: 1.2rem;
        }

        .inventory-card {
            margin: 0.5rem 0;
        }

        .col-md-6 {
            margin-bottom: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding: 0.5rem;
        }

        .page-header {
            padding: 1rem;
            border-radius: 10px;
        }

        .page-header .d-flex {
            flex-direction: column;
            text-align: center;
        }

        .icon-circle {
            margin: 0 auto 1rem auto;
        }

        .form-section {
            padding: 0.8rem;
            border-radius: 8px;
        }

        .inventory-card {
            border-radius: 10px;
        }

        .card-header {
            padding: 0.8rem 1rem;
        }

        .btn {
            padding: 0.6rem 1rem;
            font-size: 0.8rem;
        }

        .form-floating .form-control,
        .form-floating .form-select {
            padding: 0.7rem;
            font-size: 0.85rem;
        }

        .form-floating > label {
            font-size: 0.85rem;
            padding-left: 0.7rem;
        }

        .quantity-display {
            padding: 0.8rem;
        }

        .quantity-value {
            font-size: 1.2rem;
        }

        .alert-info {
            padding: 0.8rem;
            font-size: 0.85rem;
        }
    }

    @media (max-width: 360px) {
        .section-title {
            font-size: 0.9rem;
        }

        .form-floating .form-control,
        .form-floating .form-select {
            padding: 0.6rem;
            font-size: 0.8rem;
        }

        .form-floating > label {
            font-size: 0.8rem;
            padding-left: 0.6rem;
        }

        .form-helper {
            font-size: 0.75rem;
            padding: 0.4rem 0.5rem;
        }

        .btn {
            padding: 0.5rem 0.8rem;
            font-size: 0.75rem;
        }

        .quantity-value {
            font-size: 1.1rem;
        }
    }

    /* Animation optimisée pour mobile */
    @media (prefers-reduced-motion: reduce) {
        .inventory-card:hover,
        .form-section:hover,
        .btn:hover {
            transform: none;
        }

        .form-section,
        .inventory-card {
            transition: none;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="page-header">
        <div class="progress-indicator">
            <div class="progress-bar-custom" id="formProgress"></div>
        </div>

        <div class="d-flex align-items-center">
            <div class="icon-circle">
                <i class="bi bi-clipboard-data fs-2 text-dark"></i>
            </div>
            <div>
                <h1 class="fw-bold mb-2">Nouvel Inventaire</h1>
                <p class="mb-0">Enregistrement des quantités et suivi des stocks</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11 col-md-12">
            <!-- Information importante -->
            <div class="alert alert-info mb-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                    <div>
                        <strong>Information :</strong>
                        Vérifiez les quantités saisies. Cet inventaire mettra à jour le stock système.
                    </div>
                </div>
            </div>

            <!-- Formulaire principal -->
            <div class="inventory-card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-box-seam me-2"></i>
                        Détails de l'Inventaire
                    </h4>
                </div>

                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('inventaires.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <!-- Section Matériel -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-gear-fill"></i>
                                Sélection du Matériel
                            </h5>

                            <div class="form-floating">
                                <select name="materiel_id" id="materiel_id"
                                        class="form-select @error('materiel_id') is-invalid @enderror" required>
                                    <option value="">-- Sélectionnez un matériel --</option>
                                    @foreach ($materiels as $materiel)
                                        <option value="{{ $materiel->id }}"
                                                data-stock="{{ $materiel->quantite ?? 0 }}"
                                                data-nom="{{ $materiel->nom }}"
                                                {{ old('materiel_id') == $materiel->id ? 'selected' : '' }}>
                                            {{ $materiel->nom }} (Stock: {{ $materiel->quantite ?? 0 }})
                                        </option>
                                    @endforeach
                                </select>
                                <label for="materiel_id" class="required-field">
                                    <i class="bi bi-box me-2"></i>Matériel
                                </label>
                                @error('materiel_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-helper">
                                Choisissez le matériel à inventorier dans la liste
                            </div>

                            <!-- Info matériel -->
                            <div class="stock-info" id="materielInfo" style="display: none;">
                                <h6 class="mb-2 fw-bold"><i class="bi bi-info-circle me-2"></i>Informations Stock</h6>
                                <div class="stock-detail">
                                    <span>Matériel :</span>
                                    <strong id="materielNom">-</strong>
                                </div>
                                <div class="stock-detail">
                                    <span>Stock Actuel :</span>
                                    <strong id="stockActuel" style="color: var(--uts-green);">0</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Section Quantités -->
                        <div class="form-section">
                            <h5 class="section-title">
                                <i class="bi bi-calculator"></i>
                                Gestion des Quantités
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="quantite_disponible" id="quantite_disponible"
                                               class="form-control @error('quantite_disponible') is-invalid @enderror"
                                               value="{{ old('quantite_disponible') }}" min="0" required>
                                        <label for="quantite_disponible" class="required-field">
                                            <i class="bi bi-archive me-2"></i>Quantité Disponible
                                        </label>
                                        @error('quantite_disponible')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-helper">
                                        Unités actuellement disponibles
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="quantite_utilisee" id="quantite_utilisee"
                                               class="form-control @error('quantite_utilisee') is-invalid @enderror"
                                               value="{{ old('quantite_utilisee') }}" min="0" required>
                                        <label for="quantite_utilisee" class="required-field">
                                            <i class="bi bi-check-circle me-2"></i>Quantité Utilisée
                                        </label>
                                        @error('quantite_utilisee')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-helper">
                                        Unités attribuées ou consommées
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="quantite_defaillante" id="quantite_defaillante"
                                               class="form-control @error('quantite_defaillante') is-invalid @enderror"
                                               value="{{ old('quantite_defaillante', 0) }}" min="0">
                                        <label for="quantite_defaillante">
                                            <i class="bi bi-exclamation-triangle me-2"></i>Quantité Défaillante
                                        </label>
                                        @error('quantite_defaillante')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-helper">
                                        Unités endommagées ou hors service
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="quantite_perdue" id="quantite_perdue"
                                               class="form-control @error('quantite_perdue') is-invalid @enderror"
                                               value="{{ old('quantite_perdue', 0) }}" min="0">
                                        <label for="quantite_perdue">
                                            <i class="bi bi-question-circle me-2"></i>Quantité Perdue
                                        </label>
                                        @error('quantite_perdue')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-helper">
                                        Unités manquantes ou non localisées
                                    </div>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="quantity-display" id="totalDisplay" style="display: none;">
                                <div class="mb-2 fw-bold text-dark">Quantité Totale Inventoriée</div>
                                <div class="quantity-value" id="totalQuantity">0</div>
                                <small class="text-muted">Disponible + Utilisée + Défaillante + Perdue</small>
                                <div id="ecartInfo" class="mt-2" style="display: none;">
                                    <span class="badge" id="ecartBadge">Écart: <span id="ecartValue">0</span></span>
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
                                               value="{{ old('date_inventaire', date('Y-m-d')) }}" required>
                                        <label for="date_inventaire" class="required-field">
                                            <i class="bi bi-calendar-check me-2"></i>Date Inventaire
                                        </label>
                                        @error('date_inventaire')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-helper">
                                        Date de l'inventaire physique
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <textarea name="observations" id="observations"
                                                  class="form-control @error('observations') is-invalid @enderror"
                                                  style="min-height: 58px;">{{ old('observations') }}</textarea>
                                        <label for="observations">
                                            <i class="bi bi-chat-text me-2"></i>Observations
                                        </label>
                                        @error('observations')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-helper">
                                        Notes et commentaires (optionnel)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="btn-group-custom">
                            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-floppy me-2"></i>
                                    Enregistrer
                                </button>

                                <a href="{{ route('inventaires.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Retour
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
(function() {
    'use strict';

    const form = document.querySelector('.needs-validation');
    const progressBar = document.getElementById('formProgress');
    const totalDisplay = document.getElementById('totalDisplay');
    const totalQuantity = document.getElementById('totalQuantity');
    const materielSelect = document.getElementById('materiel_id');
    const materielInfo = document.getElementById('materielInfo');
    const ecartInfo = document.getElementById('ecartInfo');
    const ecartBadge = document.getElementById('ecartBadge');
    const ecartValue = document.getElementById('ecartValue');

    // Validation du formulaire
    form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    // Affichage info matériel
    materielSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        if (this.value) {
            const stock = selectedOption.dataset.stock || 0;
            const nom = selectedOption.dataset.nom || '';

            document.getElementById('materielNom').textContent = nom;
            document.getElementById('stockActuel').textContent = stock;
            materielInfo.style.display = 'block';
        } else {
            materielInfo.style.display = 'none';
            ecartInfo.style.display = 'none';
        }
        calculateTotal();
    });

    // Progression
    function updateProgress() {
        const fields = form.querySelectorAll('input[required], select[required]');
        let completed = 0;

        fields.forEach(field => {
            if (field.value.trim() !== '') completed++;
        });

        const progress = (completed / fields.length) * 100;
        progressBar.style.width = progress + '%';
    }

    // Calcul total et écart
    function calculateTotal() {
        const disponible = parseInt(document.getElementById('quantite_disponible').value) || 0;
        const utilisee = parseInt(document.getElementById('quantite_utilisee').value) || 0;
        const defaillante = parseInt(document.getElementById('quantite_defaillante').value) || 0;
        const perdue = parseInt(document.getElementById('quantite_perdue').value) || 0;
        const total = disponible + utilisee + defaillante + perdue;

        const selectedOption = materielSelect.options[materielSelect.selectedIndex];
        const stockSysteme = parseInt(selectedOption.dataset?.stock) || 0;
        const ecart = total - stockSysteme;

        if (total > 0 || materielSelect.value) {
            totalDisplay.style.display = 'block';
            totalQuantity.textContent = total;

            if (materielSelect.value) {
                ecartInfo.style.display = 'block';
                ecartValue.textContent = ecart;

                if (ecart === 0) {
                    ecartBadge.className = 'badge badge-success';
                    ecartBadge.innerHTML = 'Parfait: ' + ecart;
                } else if (ecart > 0) {
                    ecartBadge.className = 'badge badge-warning';
                    ecartBadge.innerHTML = 'Surplus: +' + ecart;
                } else {
                    ecartBadge.className = 'badge badge-danger';
                    ecartBadge.innerHTML = 'Manque: ' + ecart;
                }
            }
        } else {
            totalDisplay.style.display = 'none';
            ecartInfo.style.display = 'none';
        }
    }

    // Events
    form.addEventListener('input', updateProgress);
    form.addEventListener('change', updateProgress);

    ['quantite_disponible', 'quantite_utilisee', 'quantite_defaillante', 'quantite_perdue'].forEach(id => {
        document.getElementById(id).addEventListener('input', calculateTotal);
    });

    // Validation quantités
    ['quantite_disponible', 'quantite_utilisee', 'quantite_defaillante', 'quantite_perdue'].forEach(id => {
        document.getElementById(id).addEventListener('input', function() {
            if (this.value < 0) {
                this.setCustomValidity('La quantité ne peut pas être négative');
            } else {
                this.setCustomValidity('');
            }
        });
    });

    // Focus initial et mise à jour
    materielSelect.focus();
    updateProgress();

})();
</script>
@endpush

@endsection
