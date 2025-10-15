@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="fas fa-plus-circle text-primary me-2"></i>
                        Créer une Notification
                    </h1>
                    <p class="text-muted mb-0">Diffuser un message aux utilisateurs</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notifications</a></li>
                        <li class="breadcrumb-item active">Créer</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Messages flash -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Formulaire principal -->
    <div class="card shadow border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-bell me-2"></i>
                <h5 class="mb-0">Nouvelle Notification</h5>
            </div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('notifications.store') }}" method="POST" id="notificationForm">
                @csrf

                <div class="row">
                    <!-- Titre -->
                    <div class="col-md-8 mb-3">
                        <label for="title" class="form-label fw-bold">
                            <i class="fas fa-heading text-primary me-1"></i>Titre
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title" id="title"
                            class="form-control form-control-lg @error('title') is-invalid @enderror"
                            value="{{ old('title') }}"
                            placeholder="Ex: Maintenance programmée ce soir"
                            maxlength="100" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Maximum 100 caractères</div>
                    </div>

                    <!-- Type -->
                    <div class="col-md-4 mb-3">
                        <label for="type" class="form-label fw-bold">
                            <i class="fas fa-tag text-primary me-1"></i>Type
                            <span class="text-danger">*</span>
                        </label>
                        <select name="type" id="type" class="form-select form-select-lg @error('type') is-invalid @enderror" required>
                            <option value="">-- Choisir le type --</option>
                            <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>
                                📢 Information
                            </option>
                            <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>
                                ⚠️ Avertissement
                            </option>
                            <option value="success" {{ old('type') == 'success' ? 'selected' : '' }}>
                                ✅ Succès
                            </option>
                            <option value="error" {{ old('type') == 'error' ? 'selected' : '' }}>
                                ❌ Erreur
                            </option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Message -->
                <div class="mb-3">
                    <label for="message" class="form-label fw-bold">
                        <i class="fas fa-comment-dots text-primary me-1"></i>Message
                        <span class="text-danger">*</span>
                    </label>
                    <textarea name="message" id="message" rows="5"
                        class="form-control @error('message') is-invalid @enderror"
                        placeholder="Rédigez votre message ici..."
                        maxlength="500" required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text d-flex justify-content-between">
                        <span>Message détaillé pour les utilisateurs</span>
                        <small id="messageCount" class="text-muted">0/500 caractères</small>
                    </div>
                </div>

                <div class="row">
                    <!-- Priorité -->
                    <div class="col-md-6 mb-3">
                        <label for="priority" class="form-label fw-bold">
                            <i class="fas fa-exclamation-triangle text-primary me-1"></i>Priorité
                        </label>
                        <select name="priority" id="priority" class="form-select">
                            <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Élevée</option>
                            <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgente</option>
                        </select>
                        <div class="form-text">Définit l'ordre d'affichage</div>
                    </div>

                    <!-- Expiration -->
                    <div class="col-md-6 mb-3">
                        <label for="expires_at" class="form-label fw-bold">
                            <i class="fas fa-calendar-times text-primary me-1"></i>Date d'expiration
                        </label>
                        <input type="datetime-local" name="expires_at" id="expires_at"
                            class="form-control @error('expires_at') is-invalid @enderror"
                            value="{{ old('expires_at') }}"
                            min="{{ now()->format('Y-m-d\TH:i') }}">
                        @error('expires_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Optionnel - La notification sera masquée après cette date</div>
                    </div>
                </div>

                <!-- Ciblage -->
                <div class="mb-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-users text-primary me-1"></i>Destinataires
                    </label>
                    <div class="card bg-light border-0">
                        <div class="card-body p-3">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="target"
                                            id="target_all" value="all" {{ old('target', 'all') == 'all' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold text-success" for="target_all">
                                            <i class="fas fa-globe me-1"></i>Tous les utilisateurs
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="target"
                                            id="target_admins" value="admins" {{ old('target') == 'admins' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold text-warning" for="target_admins">
                                            <i class="fas fa-crown me-1"></i>Administrateurs
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="target"
                                            id="target_users" value="users" {{ old('target') == 'users' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold text-info" for="target_users">
                                            <i class="fas fa-user me-1"></i>Utilisateurs
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires
                    </div>

                    <div class="btn-group">
                        <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>Créer la notification
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Compteur de caractères pour le message
document.getElementById('message').addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('messageCount').textContent = count + '/500 caractères';
    document.getElementById('messageCount').className =
        count > 450 ? 'text-danger' : count > 400 ? 'text-warning' : 'text-muted';
});

// Aperçu du type de notification
document.getElementById('type').addEventListener('change', function() {
    const card = document.querySelector('.card-header');
    const classes = ['bg-gradient-primary', 'bg-gradient-info', 'bg-gradient-warning', 'bg-gradient-success', 'bg-gradient-danger'];

    card.className = card.className.replace(/bg-gradient-\w+/, '');

    switch(this.value) {
        case 'info': card.classList.add('bg-gradient-info'); break;
        case 'warning': card.classList.add('bg-gradient-warning'); break;
        case 'success': card.classList.add('bg-gradient-success'); break;
        case 'error': card.classList.add('bg-gradient-danger'); break;
        default: card.classList.add('bg-gradient-primary');
    }
});
</script>

<style>
.bg-gradient-primary { background: linear-gradient(45deg, #4e73df, #224abe); }
.bg-gradient-info { background: linear-gradient(45deg, #36b9cc, #258391); }
.bg-gradient-warning { background: linear-gradient(45deg, #f6c23e, #dda20a); }
.bg-gradient-success { background: linear-gradient(45deg, #1cc88a, #13855c); }
.bg-gradient-danger { background: linear-gradient(45deg, #e74a3b, #c0392b); }

.form-control:focus, .form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.card { border-radius: 15px; overflow: hidden; }
.form-check-input:checked { background-color: #4e73df; border-color: #4e73df; }
</style>
@endsection
