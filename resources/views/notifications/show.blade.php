@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="fas fa-bell text-primary me-2"></i>
                        Détails de la Notification
                    </h1>
                    <p class="text-muted mb-0">Notification #{{ $notification->id }}</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notifications</a></li>
                        <li class="breadcrumb-item active">Détails</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Contenu principal -->
        <div class="col-lg-8">
            <!-- Carte principale -->
            <div class="card shadow-sm border-0 mb-4">
                @php
                    $typeConfig = [
                        'info' => ['bg-gradient-info', 'fas fa-info-circle'],
                        'warning' => ['bg-gradient-warning', 'fas fa-exclamation-triangle'],
                        'success' => ['bg-gradient-success', 'fas fa-check-circle'],
                        'error' => ['bg-gradient-danger', 'fas fa-times-circle'],
                    ];
                    $config = $typeConfig[$notification->type] ?? ['bg-gradient-primary', 'fas fa-bell'];
                @endphp

                <div class="card-header {{ $config[0] }} text-white py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="{{ $config[1] }} fa-2x me-3"></i>
                            <div>
                                <h4 class="mb-1">{{ $notification->title }}</h4>
                                <div class="d-flex align-items-center gap-2">
                                    @if($notification->priority == 'urgent')
                                        <span class="badge bg-danger bg-opacity-75">🔥 URGENT</span>
                                    @elseif($notification->priority == 'high')
                                        <span class="badge bg-warning bg-opacity-75">⚡ PRIORITÉ ÉLEVÉE</span>
                                    @endif

                                    @if($notification->is_pinned ?? false)
                                        <span class="badge bg-warning bg-opacity-75">
                                            <i class="fas fa-thumbtack me-1"></i>ÉPINGLÉE
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            @if($notification->is_active ?? true)
                                <span class="badge bg-success bg-opacity-75 fs-6">
                                    <i class="fas fa-check-circle me-1"></i>ACTIVE
                                </span>
                            @else
                                <span class="badge bg-secondary bg-opacity-75 fs-6">
                                    <i class="fas fa-pause-circle me-1"></i>INACTIVE
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Message principal -->
                    <div class="mb-4">
                        <h5 class="text-dark mb-3">
                            <i class="fas fa-comment-dots text-primary me-2"></i>Message
                        </h5>
                        <div class="bg-light rounded p-4 border-start border-primary border-4">
                            <p class="mb-0 fs-5 text-dark lh-lg">{{ $notification->message }}</p>
                        </div>
                    </div>

                    <!-- Destinataires -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-dark mb-3">
                                <i class="fas fa-users text-primary me-2"></i>Destinataires
                            </h5>
                            <div class="bg-info bg-opacity-10 rounded p-3 border border-info border-opacity-25">
                                @if($notification->target == 'all')
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-globe fa-2x text-info me-3"></i>
                                        <div>
                                            <strong class="text-info fs-5">Tous les utilisateurs</strong>
                                            <p class="text-muted mb-0">Cette notification est visible par tous les utilisateurs connectés</p>
                                        </div>
                                    </div>
                                @elseif($notification->target == 'admins')
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-crown fa-2x text-warning me-3"></i>
                                        <div>
                                            <strong class="text-warning fs-5">Administrateurs uniquement</strong>
                                            <p class="text-muted mb-0">Notification réservée aux administrateurs</p>
                                        </div>
                                    </div>
                                @elseif($notification->target == 'users')
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user fa-2x text-success me-3"></i>
                                        <div>
                                            <strong class="text-success fs-5">Utilisateurs standard</strong>
                                            <p class="text-muted mb-0">Notification pour les utilisateurs non-administrateurs</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-circle fa-2x text-primary me-3"></i>
                                        <div>
                                            <strong class="text-primary fs-5">{{ $notification->user->name ?? 'Utilisateur spécifique' }}</strong>
                                            <p class="text-muted mb-0">Notification personnalisée</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Statut de lecture - ✅ CORRIGÉ ICI -->
                    <div class="mb-4">
                        <h5 class="text-dark mb-3">
                            <i class="fas fa-eye text-primary me-2"></i>Statut de lecture
                        </h5>
                        <div class="row g-2">
                            <div class="col-md-6">
                                @if($notification->is_read)
                                    <div class="alert alert-success border-0 d-flex align-items-center">
                                        <i class="fas fa-check-circle fa-2x me-3"></i>
                                        <div>
                                            <strong>Notification lue</strong>
                                            <p class="mb-0 small">Cette notification a été marquée comme lue</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning border-0 d-flex align-items-center">
                                        <i class="fas fa-eye-slash fa-2x me-3"></i>
                                        <div>
                                            <strong>Notification non lue</strong>
                                            <p class="mb-0 small">Cette notification n'a pas encore été lue</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar avec informations -->
        <div class="col-lg-4">
            <!-- Informations temporelles -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light border-0">
                    <h6 class="mb-0 text-dark">
                        <i class="fas fa-clock text-primary me-2"></i>Informations temporelles
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-calendar-plus text-primary"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Créée le</div>
                            <strong>{{ $notification->created_at->format('d/m/Y à H:i') }}</strong>
                            <div class="text-info small">{{ $notification->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-edit text-warning"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Dernière modification</div>
                            <strong>{{ $notification->updated_at->format('d/m/Y à H:i') }}</strong>
                            <div class="text-info small">{{ $notification->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    @if($notification->expires_at)
                        <div class="d-flex align-items-center">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="fas fa-calendar-times text-danger"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Expire le</div>
                                <strong>{{ $notification->expires_at->format('d/m/Y à H:i') }}</strong>
                                <div class="text-danger small">{{ $notification->expires_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Propriétés -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light border-0">
                    <h6 class="mb-0 text-dark">
                        <i class="fas fa-cog text-primary me-2"></i>Propriétés
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <i class="fas fa-tag fa-2x text-muted mb-1"></i>
                                <div class="text-muted small">Type</div>
                                <strong class="text-capitalize">{{ $notification->type ?? 'N/A' }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <i class="fas fa-flag fa-2x text-muted mb-1"></i>
                                <div class="text-muted small">Priorité</div>
                                <strong class="text-capitalize">{{ $notification->priority ?? 'Normal' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides - ✅ CORRIGÉ ICI -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-0">
                    <h6 class="mb-0 text-dark">
                        <i class="fas fa-tools text-primary me-2"></i>Actions rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('notifications.edit', $notification) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Modifier
                        </a>
                        <button class="btn btn-info" onclick="toggleReadStatus()">
                            @if($notification->is_read)
                                <i class="fas fa-eye-slash me-1"></i>Marquer non lu
                            @else
                                <i class="fas fa-eye me-1"></i>Marquer lu
                            @endif
                        </button>
                        <hr class="my-2">
                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger w-100" onclick="return confirm('Supprimer définitivement cette notification ?')">
                                <i class="fas fa-trash me-1"></i>Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bouton retour -->
    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i>Retour à la liste
            </a>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary { background: linear-gradient(45deg, #4e73df, #224abe); }
.bg-gradient-info { background: linear-gradient(45deg, #36b9cc, #258391); }
.bg-gradient-warning { background: linear-gradient(45deg, #f6c23e, #dda20a); }
.bg-gradient-success { background: linear-gradient(45deg, #1cc88a, #13855c); }
.bg-gradient-danger { background: linear-gradient(45deg, #e74a3b, #c0392b); }

.card { border-radius: 15px; overflow: hidden; }
.rounded-circle { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
</style>

<script>
function toggleReadStatus() {
    // Fonction pour basculer le statut lu/non lu via AJAX
    fetch(`/notifications/{{ $notification->id }}/toggle-read`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endsection
