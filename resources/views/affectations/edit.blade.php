@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <!-- En-tête -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-2 text-gray-800 fw-bold">
                        <i class="fas fa-edit text-warning me-2"></i>Modifier l'affectation
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Tableau de bord</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('affectations.index') }}" class="text-decoration-none">Affectations</a></li>
                            <li class="breadcrumb-item active">Modifier #{{ $affectation->id ?? 'N/A' }}</li>
                        </ol>
                    </nav>
                </div>
                <span class="badge bg-primary fs-6 px-3 py-2">
                    <i class="fas fa-info-circle me-1"></i>{{ $affectation->statut ?? 'N/A' }}
                </span>
            </div>

            <!-- Gestion des erreurs -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4">
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
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Formulaire -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-warning text-white py-3">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i class="fas fa-clipboard-check me-2"></i>Modification de l'affectation
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('affectations.update', $affectation->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Matériel -->
                            <div class="col-md-6">
                                <label for="materiel_id" class="form-label fw-semibold">
                                    <i class="fas fa-laptop text-primary me-2"></i>Matériel *
                                </label>
                                <select name="materiel_id" id="materiel_id" class="form-select form-select-lg border-2" required>
                                    <option value="">-- Sélectionner un matériel --</option>
                                    @foreach($materiels as $materiel)
                                        <option value="{{ $materiel->id }}"
                                            {{ ($affectation->materiel_id ?? old('materiel_id')) == $materiel->id ? 'selected' : '' }}>
                                            {{ $materiel->nom ?? $materiel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Numéro d'affectation -->
                            <div class="col-md-6">
                                <label for="numero_affectation" class="form-label fw-semibold">
                                    <i class="fas fa-hashtag text-primary me-2"></i>Numéro d'affectation
                                </label>
                                <input type="text" name="numero_affectation" id="numero_affectation"
                                       class="form-control form-control-lg border-2"
                                       value="{{ $affectation->numero_affectation ?? old('numero_affectation', 'AFF-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT)) }}">
                            </div>

                            <!-- Utilisateur -->
                            <div class="col-md-6">
                                <label for="user_id" class="form-label fw-semibold">
                                    <i class="fas fa-user text-info me-2"></i>Utilisateur
                                </label>
                                <select name="user_id" id="user_id" class="form-select form-select-lg border-2">
                                    <option value="">-- Sélectionner un utilisateur --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ ($affectation->user_id ?? old('user_id')) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Service -->
                            <div class="col-md-6">
                                <label for="service_id" class="form-label fw-semibold">
                                    <i class="fas fa-building text-info me-2"></i>Service
                                </label>
                                <select name="service_id" id="service_id" class="form-select form-select-lg border-2">
                                    <option value="">-- Sélectionner un service --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ ($affectation->service_id ?? old('service_id')) == $service->id ? 'selected' : '' }}>
                                            {{ $service->nom ?? $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date d'affectation -->
                            <div class="col-md-4">
                                <label for="date_affectation" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-check text-success me-2"></i>Date d'affectation *
                                </label>
                                <input type="date" name="date_affectation" id="date_affectation"
                                       class="form-control form-control-lg border-2"
                                       value="{{ $affectation->date_affectation ?? old('date_affectation') }}" required>
                            </div>

                            <!-- Date de retour prévue -->
                            <div class="col-md-4">
                                <label for="date_retour_prevue" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-times text-warning me-2"></i>Date retour prévue
                                </label>
                                <input type="date" name="date_retour_prevue" id="date_retour_prevue"
                                       class="form-control form-control-lg border-2"
                                       value="{{ $affectation->date_retour_prevue ?? old('date_retour_prevue') }}">
                            </div>

                            <!-- Date de retour -->
                            <div class="col-md-4">
                                <label for="date_retour" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-check text-danger me-2"></i>Date retour effective
                                </label>
                                <input type="date" name="date_retour" id="date_retour"
                                       class="form-control form-control-lg border-2"
                                       value="{{ $affectation->date_retour ?? old('date_retour') }}">
                            </div>

                            <!-- Statut -->
                            <div class="col-md-6">
                                <label for="statut" class="form-label fw-semibold">
                                    <i class="fas fa-tasks text-primary me-2"></i>Statut
                                </label>
                                <select name="statut" id="statut" class="form-select form-select-lg border-2">
                                    <option value="en cours" {{ ($affectation->statut ?? old('statut')) == 'en cours' ? 'selected' : '' }}>
                                        🟢 En cours
                                    </option>
                                    <option value="en attente" {{ ($affectation->statut ?? old('statut')) == 'en attente' ? 'selected' : '' }}>
                                        🟡 En attente
                                    </option>
                                    <option value="terminé" {{ ($affectation->statut ?? old('statut')) == 'terminé' ? 'selected' : '' }}>
                                        🔵 Terminé
                                    </option>
                                    <option value="annulé" {{ ($affectation->statut ?? old('statut')) == 'annulé' ? 'selected' : '' }}>
                                        🔴 Annulé
                                    </option>
                                </select>
                            </div>

                            <!-- Priorité -->
                            <div class="col-md-6">
                                <label for="priorite" class="form-label fw-semibold">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>Priorité
                                </label>
                                <select name="priorite" id="priorite" class="form-select form-select-lg border-2">
                                    <option value="normale" {{ ($affectation->priorite ?? old('priorite', 'normale')) == 'normale' ? 'selected' : '' }}>
                                        🟢 Normale
                                    </option>
                                    <option value="urgente" {{ ($affectation->priorite ?? old('priorite')) == 'urgente' ? 'selected' : '' }}>
                                        🔴 Urgente
                                    </option>
                                    <option value="faible" {{ ($affectation->priorite ?? old('priorite')) == 'faible' ? 'selected' : '' }}>
                                        🔵 Faible
                                    </option>
                                </select>
                            </div>

                            <!-- Lieu d'utilisation -->
                            <div class="col-md-6">
                                <label for="lieu_utilisation" class="form-label fw-semibold">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>Lieu d'utilisation
                                </label>
                                <input type="text" name="lieu_utilisation" id="lieu_utilisation"
                                       class="form-control form-control-lg border-2"
                                       value="{{ $affectation->lieu_utilisation ?? old('lieu_utilisation') }}"
                                       placeholder="Ex: Bureau 201, Bâtiment A">
                            </div>

                            <!-- Responsable validation -->
                            <div class="col-md-6">
                                <label for="responsable_validation" class="form-label fw-semibold">
                                    <i class="fas fa-user-check text-success me-2"></i>Responsable validation
                                </label>
                                <input type="text" name="responsable_validation" id="responsable_validation"
                                       class="form-control form-control-lg border-2"
                                       value="{{ $affectation->responsable_validation ?? old('responsable_validation') }}"
                                       placeholder="Nom du responsable">
                            </div>

                            <!-- Commentaire -->
                            <div class="col-12">
                                <label for="commentaire" class="form-label fw-semibold">
                                    <i class="fas fa-comment text-secondary me-2"></i>Commentaire / Notes
                                </label>
                                <textarea name="commentaire" id="commentaire"
                                          class="form-control border-2" rows="4"
                                          placeholder="Ajoutez des commentaires ou des modifications...">{{ $affectation->commentaire ?? old('commentaire') }}</textarea>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between align-items-center pt-4 mt-4 border-top">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="envoyer_notification" id="envoyer_notification">
                                <label class="form-check-label text-muted" for="envoyer_notification">
                                    <i class="fas fa-envelope me-1"></i>Notifier les changements par email
                                </label>
                            </div>

                            <div class="btn-group">
                                <a href="{{ route('affectations.index') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-warning btn-lg px-4">
                                    <i class="fas fa-save me-2"></i>Mettre à jour
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="card-title text-muted">
                                <i class="fas fa-info-circle me-2"></i>Informations
                            </h6>
                            <p class="mb-1"><strong>Créée le:</strong> {{ $affectation->created_at ?? 'N/A' }}</p>
                            <p class="mb-0"><strong>Modifiée le:</strong> {{ $affectation->updated_at ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="card-title text-muted">
                                <i class="fas fa-history me-2"></i>Historique
                            </h6>
                            <p class="mb-0 text-muted">Modification en cours...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-warning {
    background: linear-gradient(45deg, #ffc107, #e0a800);
}

.form-control:focus, .form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
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

.border-2 {
    border-width: 2px !important;
}

@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
}
</style>

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
});
</script>
@endsection
