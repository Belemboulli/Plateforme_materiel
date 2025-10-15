@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <!-- En-tête avec statistiques -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="fas fa-bell text-primary me-2"></i>
                        Gestion des Notifications
                    </h1>
                    <p class="text-muted mb-0">Administration des messages système</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-filter me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('notifications.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>Nouvelle notification
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Notifications
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $notifications->total() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bell fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Actives
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $notifications->where('is_active', true)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Non Lues
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{-- ✅ CORRIGÉ ICI - Changé 'lu' en 'is_read' --}}
                                {{ $notifications->where('is_read', false)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye-slash fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Urgentes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $notifications->where('priority', 'urgent')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
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

    <!-- Tableau principal -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Liste des Notifications
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow">
                    <a class="dropdown-item" href="{{ route('notifications.index', ['sort' => 'recent']) }}">
                        <i class="fas fa-clock fa-sm fa-fw mr-2 text-gray-400"></i>Plus récentes
                    </a>
                    <a class="dropdown-item" href="{{ route('notifications.index', ['sort' => 'unread']) }}">
                        <i class="fas fa-eye-slash fa-sm fa-fw mr-2 text-gray-400"></i>Non lues
                    </a>
                    <a class="dropdown-item" href="{{ route('notifications.index', ['sort' => 'urgent']) }}">
                        <i class="fas fa-exclamation-triangle fa-sm fa-fw mr-2 text-gray-400"></i>Urgentes
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center"><i class="fas fa-hashtag"></i></th>
                            <th><i class="fas fa-heading me-1"></i>Titre</th>
                            <th><i class="fas fa-comment me-1"></i>Message</th>
                            <th><i class="fas fa-tag me-1"></i>Type</th>
                            <th><i class="fas fa-flag me-1"></i>Priorité</th>
                            <th><i class="fas fa-eye me-1"></i>Statut</th>
                            <th><i class="fas fa-calendar me-1"></i>Créée le</th>
                            <th class="text-center"><i class="fas fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notification)
                        {{-- ✅ CORRIGÉ ICI - Changé 'lu' en 'is_read' --}}
                        <tr class="{{ !$notification->is_read ? 'table-warning' : '' }}">
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $notification->id }}</span>
                                @if($notification->is_pinned ?? false)
                                    <i class="fas fa-thumbtack text-warning ms-1" title="Épinglée"></i>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($notification->priority == 'urgent')
                                        <i class="fas fa-exclamation-circle text-danger me-2" title="Urgent"></i>
                                    @elseif($notification->priority == 'high')
                                        <i class="fas fa-exclamation text-warning me-2" title="Priorité élevée"></i>
                                    @endif
                                    <div>
                                        <strong>{{ Str::limit($notification->title, 30) }}</strong>
                                        @if(strlen($notification->title) > 30)
                                            <i class="fas fa-info-circle text-muted ms-1" title="{{ $notification->title }}"></i>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="message-preview" title="{{ $notification->message }}">
                                    {{ Str::limit($notification->message, 50) }}
                                    @if(strlen($notification->message) > 50)
                                        <button class="btn btn-link btn-sm p-0 ms-1" onclick="toggleMessage({{ $notification->id }})">
                                            <i class="fas fa-expand-alt text-info"></i>
                                        </button>
                                    @endif
                                </div>
                                <div id="fullMessage{{ $notification->id }}" class="d-none">
                                    {{ $notification->message }}
                                    <button class="btn btn-link btn-sm p-0 ms-1" onclick="toggleMessage({{ $notification->id }})">
                                        <i class="fas fa-compress-alt text-info"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                @php
                                    $typeConfig = [
                                        'info' => ['bg-info', 'fas fa-info-circle', 'Info'],
                                        'warning' => ['bg-warning', 'fas fa-exclamation-triangle', 'Attention'],
                                        'success' => ['bg-success', 'fas fa-check-circle', 'Succès'],
                                        'error' => ['bg-danger', 'fas fa-times-circle', 'Erreur'],
                                    ];
                                    $config = $typeConfig[$notification->type] ?? ['bg-secondary', 'fas fa-bell', 'N/A'];
                                @endphp
                                <span class="badge {{ $config[0] }}">
                                    <i class="{{ $config[1] }} me-1"></i>{{ $config[2] }}
                                </span>
                            </td>
                            <td>
                                @if($notification->priority == 'urgent')
                                    <span class="badge bg-danger">🔥 Urgent</span>
                                @elseif($notification->priority == 'high')
                                    <span class="badge bg-warning">⚡ Élevée</span>
                                @else
                                    <span class="badge bg-light text-dark">➖ Normal</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    {{-- ✅ CORRIGÉ ICI - Changé 'lu' en 'is_read' --}}
                                    @if($notification->is_read)
                                        <span class="badge bg-success"><i class="fas fa-eye me-1"></i>Lu</span>
                                    @else
                                        <span class="badge bg-warning"><i class="fas fa-eye-slash me-1"></i>Non lu</span>
                                    @endif

                                    @if($notification->is_active ?? true)
                                        <span class="badge bg-info"><i class="fas fa-play me-1"></i>Actif</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="fas fa-pause me-1"></i>Inactif</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $notification->created_at->format('d/m/Y') }}</strong>
                                    <br><small class="text-muted">{{ $notification->created_at->format('H:i') }}</small>
                                    <br><small class="text-info">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('notifications.show', $notification) }}"
                                       class="btn btn-info btn-sm" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('notifications.edit', $notification) }}"
                                       class="btn btn-warning btn-sm" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Supprimer cette notification ?')"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-bell-slash fa-3x mb-3"></i>
                                    <h5>Aucune notification trouvée</h5>
                                    <p>Créez votre première notification pour commencer.</p>
                                    <a href="{{ route('notifications.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i>Créer une notification
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Affichage de {{ $notifications->firstItem() }} à {{ $notifications->lastItem() }}
                    sur {{ $notifications->total() }} résultats
                </div>
                {{ $notifications->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function toggleMessage(id) {
    const preview = document.querySelector(`tr:has(#fullMessage${id}) .message-preview`);
    const full = document.getElementById(`fullMessage${id}`);

    if (full.classList.contains('d-none')) {
        preview.classList.add('d-none');
        full.classList.remove('d-none');
    } else {
        preview.classList.remove('d-none');
        full.classList.add('d-none');
    }
}

// Auto-masquer les alertes après 5 secondes
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>

<style>
.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
.border-left-danger { border-left: 0.25rem solid #e74a3b !important; }

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
}

.btn-group .btn {
    margin-right: 2px;
}

.message-preview {
    cursor: help;
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
    border-left: 3px solid #ffc107;
}
</style>
@endsection
