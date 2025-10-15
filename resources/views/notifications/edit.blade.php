@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="fas fa-edit text-warning me-2"></i>
                        Modifier la Notification
                    </h1>
                    <p class="text-muted mb-0">
                        Notification #{{ $notification->id }} -
                        <span class="badge bg-{{ $notification->type == 'success' ? 'success' : ($notification->type == 'error' ? 'danger' : ($notification->type == 'warning' ? 'warning' : 'info')) }}">
                            {{ ucfirst($notification->type) }}
                        </span>
                    </p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notifications</a></li>
                        <li class="breadcrumb-item active">Modifier</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Messages flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Formulaire principal -->
    <div class="card shadow border-0">
        <div class="card-header bg-gradient-warning text-white py-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-bell-slash me-2"></i>
                    <h5 class="mb-0">Modification de Notification</h5>
                </div>
                <div class="text-end">
                    <small>
                        <i class="fas fa-clock me-1"></i>
                        Créée {{ $notification->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('notifications.update', $notification->id) }}" method="POST" id="editNotificationForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Titre -->
                    <div class="col-md-8 mb-3">
                        <label for="title" class="form-label fw-bold">
                            <i class="fas fa-heading text-primary me-1"></i>Titre
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title" id="title"
                            value="{{ old('title', $notification->title) }}"
                            class="form-control form-control-lg @error('title') is-invalid @enderror"
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
                        </label>
                        <select name="type" id="type" class="form-select form-select-lg @error('type') is-invalid @enderror">
                            <option value="info" {{ old('type', $notification->type) == 'info' ? 'selected' : '' }}>
                                📢 Information
                            </option>
                            <option value="warning" {{ old('type', $notification->type) == 'warning' ? 'selected' : '' }}>
                                ⚠️ Avertissement
                            </option>
                            <option value="success" {{ old('type', $notification->type) == 'success' ? 'selected' : '' }}>
                                ✅ Succès
                            </option>
                            <option value="error" {{ old('type', $notification->type) == 'error' ? 'selected' : '' }}>
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
                        maxlength="500" required>{{ old('message', $notification->message) }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text d-flex justify-content-between">
                        <span>Message détaillé pour les utilisateurs</span>
                        <small id="messageCount" class="text-muted">{{ strlen($notification->message) }}/500 caractères</small>
                    </div>
                </div>

                <div class="row">
                    <!-- Priorité -->
                    <div class="col-md-6 mb-3">
                        <label for="priority" class="form-label fw-bold">
                            <i class="fas fa-exclamation-triangle text-primary me-1"></i>Priorité
                        </label>
                        <select name="priority" id="priority" class="form-select">
                            <option value="normal" {{ old('priority', $notification->priority ?? 'normal') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="high" {{ old('priority', $notification->priority ?? 'normal') == 'high' ? 'selected' : '' }}>Élevée</option>
                            <option value="urgent" {{ old('priority', $notification->priority ?? 'normal') == 'urgent' ? 'selected' : '' }}>Urgente</option>
                        </select>
                    </div>

                    <!-- Date d'expiration -->
                    <div class="col-md-6 mb-3">
                        <label for="expires_at" class="form-label fw-bold">
                            <i class="fas fa-calendar-times text-primary me-1"></i>Date d'expiration
                        </label>
                        <input type="datetime-local" name="expires_at" id="expires_at"
                            class="form-control @error('expires_at') is-invalid @enderror"
                            value="{{ old('expires_at', $notification->expires_at ? $notification->expires_at->format('Y-m-d\TH:i') : '') }}"
                            min="{{ now()->format('Y-m-d\TH:i') }}">
                        @error('expires_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- État et statut -->
                <div class="mb-4">
                    <label class="form-label fw-bold mb-3">
                        <i class="fas fa-cogs text-primary me-1"></i>État et Statut
                    </label>
                    <div class="card bg-light border-0">
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <!-- Statut Lu - ✅ CORRIGÉ ICI -->
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_read" id="is_read"
                                            value="1" {{ old('is_read', $notification->is_read) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_read">
                                            <i class="fas fa-eye {{ $notification->is_read ? 'text-success' : 'text-muted' }} me-1"></i>
                                            Marquer comme lu
                                        </label>
                                    </div>
                                </div>

                                <!-- Statut Actif -->
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                            value="1" {{ old('is_active', $notification->is_active ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_active">
                                            <i class="fas fa-toggle-on text-success me-1"></i>
                                            Notification active
                                        </label>
                                    </div>
                                </div>

                                <!-- Épinglé -->
                                <div class="col-md-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_pinned" id="is_pinned"
                                            value="1" {{ old('is_pinned', $notification->is_pinned ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_pinned">
                                            <i class="fas fa-thumbtack text-warning me-1"></i>
                                            Épingler en haut
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations supplémentaires -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-info">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-calendar-plus fa-2x text-info mb-2"></i>
                                <div class="text-muted small">Créée le</div>
                                <strong>{{ $notification->created_at->format('d/m/Y à H:i') }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-body text-center p-3">
                                <i class="fas fa-edit fa-2x text-warning mb-2"></i>
                                <div class="text-muted small">Dernière modification</div>
                                <strong>{{ $notification->updated_at->format('d/m/Y à H:i') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Les modifications seront visibles immédiatement
                    </div>

                    <div class="btn-group">
                        <a href="{{ route('notifications.show', $notification) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-1"></i>Aperçu
                        </a>
                        <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Mettre à jour
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

// Changement de couleur en fonction du type
document.getElementById('type').addEventListener('change', function() {
    const card = document.querySelector('.card-header');
    card.className = card.className.replace(/bg-gradient-\w+/, '');

    switch(this.value) {
        case 'info': card.classList.add('bg-gradient-info'); break;
        case 'warning': card.classList.add('bg-gradient-warning'); break;
        case 'success': card.classList.add('bg-gradient-success'); break;
        case 'error': card.classList.add('bg-gradient-danger'); break;
        default: card.classList.add('bg-gradient-warning');
    }
});

// ✅ CORRIGÉ ICI - Changé 'lu' en 'is_read'
document.getElementById('is_read').addEventListener('change', function() {
    const icon = this.nextElementSibling.querySelector('i');
    icon.className = this.checked ? 'fas fa-eye text-success me-1' : 'fas fa-eye-slash text-muted me-1';
});

document.getElementById('is_active').addEventListener('change', function() {
    const icon = this.nextElementSibling.querySelector('i');
    icon.className = this.checked ? 'fas fa-toggle-on text-success me-1' : 'fas fa-toggle-off text-muted me-1';
});

document.getElementById('is_pinned').addEventListener('change', function() {
    const icon = this.nextElementSibling.querySelector('i');
    icon.className = this.checked ? 'fas fa-thumbtack text-warning me-1' : 'fas fa-thumbtack text-muted me-1';
});
</script>

<style>
.bg-gradient-warning { background: linear-gradient(45deg, #f6c23e, #dda20a); }
.bg-gradient-info { background: linear-gradient(45deg, #36b9cc, #258391); }
.bg-gradient-success { background: linear-gradient(45deg, #1cc88a, #13855c); }
.bg-gradient-danger { background: linear-gradient(45deg, #e74a3b, #c0392b); }

.form-control:focus, .form-select:focus {
    border-color: #f6c23e;
    box-shadow: 0 0 0 0.2rem rgba(246, 194, 62, 0.25);
}

.card { border-radius: 15px; overflow: hidden; }
.form-switch .form-check-input:checked { background-color: #f6c23e; border-color: #f6c23e; }
</style>
@endsection
