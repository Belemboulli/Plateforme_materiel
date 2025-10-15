@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- En-tête avec breadcrumb -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-2 text-gray-800 fw-bold">
                        <i class="fas fa-plus-circle text-primary me-2"></i>
                        Créer une nouvelle affectation
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Tableau de bord</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('affectations.index') }}" class="text-decoration-none">Affectations</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nouvelle affectation</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Gestion des erreurs -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                        <strong>Erreur !</strong>
                    </div>
                    <p class="mb-2 mt-2">Veuillez corriger les erreurs suivantes :</p>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Formulaire principal -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Informations de l'affectation
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('affectations.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <!-- Section 1: Informations principales -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">
                                    <i class="fas fa-info-circle me-2"></i>Informations principales
                                </h6>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Matériel -->
                            <div class="col-md-6">
                                <label for="materiel_id" class="form-label fw-semibold">
                                    <i class="fas fa-laptop text-primary me-2"></i>Matériel *
                                </label>
                                <select name="materiel_id" id="materiel_id" class="form-select form-select-lg border-2" required>
                                    <option value="">-- Sélectionner un matériel --</option>
                                    @foreach($materiels as $materiel)
                                        <option value="{{ $materiel->id }}" {{ old('materiel_id') == $materiel->id ? 'selected' : '' }}>
                                            {{ $materiel->nom }} ({{ $materiel->reference ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>Sélectionnez le matériel à affecter
                                </div>
                            </div>

                            <!-- Numéro d'affectation -->
                            <div class="col-md-6">
                                <label for="numero_affectation" class="form-label fw-semibold">
                                    <i class="fas fa-hashtag text-primary me-2"></i>Numéro d'affectation
                                </label>
                                <input type="text" name="numero_affectation" id="numero_affectation"
                                       class="form-control form-control-lg border-2"
                                       value="{{ old('numero_affectation', 'AFF-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT)) }}"
                                       placeholder="AFF-2024-0001">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>Numéro unique de l'affectation (généré automatiquement)
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Assignation -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">
                                    <i class="fas fa-users me-2"></i>Assignation
                                </h6>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Utilisateur -->
                            <div class="col-md-6">
                                <label for="user_id" class="form-label fw-semibold">
                                    <i class="fas fa-user text-info me-2"></i>Utilisateur
                                </label>
                                <select name="user_id" id="user_id" class="form-select form-select-lg border-2">
                                    <option value="">-- Sélectionner un utilisateur --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>Utilisateur à qui le matériel sera affecté
                                </div>
                            </div>

                            <!-- Service -->
                            <div class="col-md-6">
                                <label for="service_id" class="form-label fw-semibold">
                                    <i class="fas fa-building text-info me-2"></i>Service
                                </label>
                                <select name="service_id" id="service_id" class="form-select form-select-lg border-2">
                                    <option value="">-- Sélectionner un service --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->nom ?? $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>Service ou département concerné
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Dates et durée -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">
                                    <i class="fas fa-calendar-alt me-2"></i>Dates et durée
                                </h6>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Date d'affectation -->
                            <div class="col-md-4">
                                <label for="date_affectation" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-check text-success me-2"></i>Date d'affectation *
                                </label>
                                <input type="date" name="date_affectation" id="date_affectation"
                                       class="form-control form-control-lg border-2"
                                       value="{{ old('date_affectation', date('Y-m-d')) }}" required>
                            </div>

                            <!-- Date de retour prévue -->
                            <div class="col-md-4">
                                <label for="date_retour_prevue" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-times text-warning me-2"></i>Date de retour prévue
                                </label>
                                <input type="date" name="date_retour_prevue" id="date_retour_prevue"
                                       class="form-control form-control-lg border-2"
                                       value="{{ old('date_retour_prevue') }}"
                                       min="{{ old('date_affectation', date('Y-m-d')) }}">
                            </div>

                            <!-- Date de retour effective -->
                            <div class="col-md-4">
                                <label for="date_retour" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-check text-danger me-2"></i>Date de retour effective
                                </label>
                                <input type="date" name="date_retour" id="date_retour"
                                       class="form-control form-control-lg border-2"
                                       value="{{ old('date_retour') }}"
                                       min="{{ old('date_affectation', date('Y-m-d')) }}">
                            </div>
                        </div>

                        <!-- Section 4: Statut et priorité -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">
                                    <i class="fas fa-flag me-2"></i>Statut et priorité
                                </h6>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Statut -->
                            <div class="col-md-6">
                                <label for="statut" class="form-label fw-semibold">
                                    <i class="fas fa-tasks text-primary me-2"></i>Statut
                                </label>
                                <select name="statut" id="statut" class="form-select form-select-lg border-2">
                                    <option value="en cours" {{ old('statut', 'en cours') == 'en cours' ? 'selected' : '' }}>
                                        <i class="fas fa-play-circle"></i> En cours
                                    </option>
                                    <option value="en attente" {{ old('statut') == 'en attente' ? 'selected' : '' }}>
                                        <i class="fas fa-pause-circle"></i> En attente
                                    </option>
                                    <option value="terminé" {{ old('statut') == 'terminé' ? 'selected' : '' }}>
                                        <i class="fas fa-check-circle"></i> Terminé
                                    </option>
                                    <option value="annulé" {{ old('statut') == 'annulé' ? 'selected' : '' }}>
                                        <i class="fas fa-times-circle"></i> Annulé
                                    </option>
                                </select>
                            </div>

                            <!-- Priorité -->
                            <div class="col-md-6">
                                <label for="priorite" class="form-label fw-semibold">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>Priorité
                                </label>
                                <select name="priorite" id="priorite" class="form-select form-select-lg border-2">
                                    <option value="normale" {{ old('priorite', 'normale') == 'normale' ? 'selected' : '' }}>
                                        🟢 Normale
                                    </option>
                                    <option value="urgente" {{ old('priorite') == 'urgente' ? 'selected' : '' }}>
                                        🔴 Urgente
                                    </option>
                                    <option value="faible" {{ old('priorite') == 'faible' ? 'selected' : '' }}>
                                        🔵 Faible
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Section 5: Informations complémentaires -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-uppercase text-muted fw-bold mb-3 border-bottom pb-2">
                                    <i class="fas fa-sticky-note me-2"></i>Informations complémentaires
                                </h6>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Lieu d'utilisation -->
                            <div class="col-md-6">
                                <label for="lieu_utilisation" class="form-label fw-semibold">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>Lieu d'utilisation
                                </label>
                                <input type="text" name="lieu_utilisation" id="lieu_utilisation"
                                       class="form-control form-control-lg border-2"
                                       value="{{ old('lieu_utilisation') }}"
                                       placeholder="Ex: Bureau 201, Bâtiment A">
                            </div>

                            <!-- Responsable validation -->
                            <div class="col-md-6">
                                <label for="responsable_validation" class="form-label fw-semibold">
                                    <i class="fas fa-user-check text-success me-2"></i>Responsable validation
                                </label>
                                <input type="text" name="responsable_validation" id="responsable_validation"
                                       class="form-control form-control-lg border-2"
                                       placeholder="Nom du responsable">
                            </div>
                        </div>

                        <!-- Commentaire -->
                        <div class="mb-4">
                            <label for="commentaire" class="form-label fw-semibold">
                                <i class="fas fa-comment text-secondary me-2"></i>Commentaire / Notes
                            </label>
                            <textarea name="commentaire" id="commentaire"
                                      class="form-control border-2" rows="4"
                                      placeholder="Ajoutez des commentaires, des instructions spéciales ou des notes importantes...">{{ old('commentaire') }}</textarea>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>Informations additionnelles sur l'affectation
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="envoyer_notification" id="envoyer_notification" value="1" {{ old('envoyer_notification', true) ? 'checked' : '' }}>
                                        <label class="form-check-label text-muted" for="envoyer_notification">
                                            <i class="fas fa-envelope me-1"></i>Envoyer une notification par email
                                        </label>
                                    </div>

                                    <div class="btn-group" role="group">
                                        <a href="{{ route('affectations.index') }}" class="btn btn-outline-secondary btn-lg">
                                            <i class="fas fa-times me-2"></i>Annuler
                                        </a>
                                        <button type="reset" class="btn btn-outline-warning btn-lg">
                                            <i class="fas fa-undo me-2"></i>Réinitialiser
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-lg px-4">
                                            <i class="fas fa-save me-2"></i>Enregistrer l'affectation
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript pour améliorer l'UX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validation Bootstrap
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Références aux champs de date
    const dateAffectation = document.getElementById('date_affectation');
    const dateRetourPrevue = document.getElementById('date_retour_prevue');
    const dateRetour = document.getElementById('date_retour');

    // Mettre à jour les contraintes des dates de retour
    function updateDateConstraints() {
        const affectationDate = dateAffectation.value;

        // Mettre à jour les attributs min des champs de date
        if (affectationDate) {
            dateRetourPrevue.min = affectationDate;
            dateRetour.min = affectationDate;
        }

        // Valider les dates existantes
        if (dateRetourPrevue.value && new Date(dateRetourPrevue.value) < new Date(affectationDate)) {
            dateRetourPrevue.value = affectationDate;
        }

        if (dateRetour.value && new Date(dateRetour.value) < new Date(affectationDate)) {
            dateRetour.value = affectationDate;
        }
    }

    // Calculer la durée entre les dates
    function calculateDuration() {
        if (dateAffectation.value && dateRetourPrevue.value) {
            const start = new Date(dateAffectation.value);
            const end = new Date(dateRetourPrevue.value);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            // Afficher la durée quelque part si nécessaire
            console.log(`Durée prévue: ${diffDays} jour(s)`);
        }
    }

    // Écouter les changements de date
    dateAffectation.addEventListener('change', function() {
        updateDateConstraints();
        calculateDuration();
    });

    dateRetourPrevue.addEventListener('change', calculateDuration);

    // Initialiser les contraintes au chargement
    updateDateConstraints();

    // Améliorer les select avec des icônes
    const selects = document.querySelectorAll('select');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            if (this.value) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.form-control:focus, .form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.card {
    transition: all 0.3s ease;
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.alert {
    border-left: 4px solid #dc3545;
}

.border-2 {
    border-width: 2px !important;
}

.form-text {
    font-size: 0.875em;
    color: #6c757d;
}

@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }

    .btn-group .btn {
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection
