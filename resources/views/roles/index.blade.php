@extends('layouts.app')

@section('title', 'Gestion des rôles')

@push('styles')
<style>
    .uts-primary { color: #2E7D32; }
    .uts-warning { color: #FFA000; }
    .bg-uts-primary { background-color: #2E7D32; }
    .bg-uts-warning { background-color: #FFA000; }
    .bg-uts-light { background-color: #f8f9fa; }
    .border-uts-primary { border-color: #2E7D32 !important; }
    .border-uts-warning { border-color: #FFA000 !important; }

    .header-section {
        background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        border-radius: 15px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .header-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M20 20c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10zm10 0c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10z'/%3E%3C/g%3E%3C/svg%3E") repeat;
    }

    .stat-card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.15);
    }

    .stat-card.primary {
        border-left: 4px solid #2E7D32;
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.05), rgba(46, 125, 50, 0.02));
    }

    .stat-card.warning {
        border-left: 4px solid #FFA000;
        background: linear-gradient(135deg, rgba(255, 160, 0, 0.05), rgba(255, 160, 0, 0.02));
    }

    .stat-card.success {
        border-left: 4px solid #4CAF50;
        background: linear-gradient(135deg, rgba(76, 175, 80, 0.05), rgba(76, 175, 80, 0.02));
    }

    .stat-card.info {
        border-left: 4px solid #2196F3;
        background: linear-gradient(135deg, rgba(33, 150, 243, 0.05), rgba(33, 150, 243, 0.02));
    }

    .main-card {
        border-radius: 15px;
        border: 1px solid rgba(46, 125, 50, 0.1);
        box-shadow: 0 4px 20px rgba(46, 125, 50, 0.08);
    }

    .table-header {
        background: linear-gradient(135deg, #2E7D32, #4CAF50);
        color: white;
    }

    .role-color-indicator {
        width: 8px;
        height: 25px;
        border-radius: 4px;
        margin-right: 12px;
    }

    .priority-badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
        border-radius: 15px;
        font-weight: 500;
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
        border-radius: 15px;
        font-weight: 500;
    }

    .btn-uts-primary {
        background: linear-gradient(45deg, #2E7D32, #4CAF50);
        border: none;
        color: white;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .btn-uts-primary:hover {
        background: linear-gradient(45deg, #1B5E20, #2E7D32);
        color: white;
        transform: translateY(-1px);
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 2px;
        transition: all 0.3s;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .empty-state {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.05), rgba(255, 160, 0, 0.05));
        border-radius: 12px;
        padding: 3rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section UTS -->
    <div class="header-section p-4 mb-4">
        <div class="position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2 fw-bold">
                        <i class="fas fa-users-cog me-3"></i>Gestion des Rôles
                    </h1>
                    <p class="mb-0 opacity-90">
                        Université Thomas Sankara - Administration des rôles système
                    </p>
                </div>
                <div>
                    <a href="{{ route('roles.create') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-plus me-2"></i>Nouveau rôle
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages de succès -->
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle uts-primary me-3 fa-lg"></i>
                <div>
                    <strong>Succès !</strong> {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3 mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                <div>
                    <strong>Erreur !</strong> {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card primary h-100">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-uppercase fw-bold uts-primary mb-1" style="font-size: 0.75rem;">
                                Total des rôles
                            </div>
                            <div class="h4 mb-0 fw-bold text-dark">{{ $roles->total() }}</div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-users fa-2x uts-primary opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card success h-100">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-uppercase fw-bold text-success mb-1" style="font-size: 0.75rem;">
                                Rôles actifs
                            </div>
                            <div class="h4 mb-0 fw-bold text-dark">
                                {{ $roles->filter(fn($role) => $role->is_active ?? true)->count() }}
                            </div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-check-circle fa-2x text-success opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card warning h-100">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-uppercase fw-bold uts-warning mb-1" style="font-size: 0.75rem;">
                                Rôles système
                            </div>
                            <div class="h4 mb-0 fw-bold text-dark">
                                {{ $roles->filter(fn($role) => ($role->priority_level ?? 5) <= 2)->count() }}
                            </div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-cog fa-2x uts-warning opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card info h-100">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-uppercase fw-bold text-info mb-1" style="font-size: 0.75rem;">
                                Page actuelle
                            </div>
                            <div class="h4 mb-0 fw-bold text-dark">
                                {{ $roles->currentPage() }}/{{ $roles->lastPage() }}
                            </div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-list fa-2x text-info opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau principal -->
    <div class="card main-card">
        <div class="card-header table-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-table me-2"></i>Liste des rôles
                </h6>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-h me-1"></i>Options
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('roles.export') ?? '#' }}">
                            <i class="fas fa-download me-2 uts-primary"></i>Exporter CSV
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">
                            <i class="fas fa-sync me-2 uts-warning"></i>Actualiser
                        </a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 px-4">
                                <span class="fw-bold uts-primary">ID</span>
                            </th>
                            <th class="border-0 py-3">
                                <span class="fw-bold uts-primary">Rôle</span>
                            </th>
                            <th class="border-0 py-3">
                                <span class="fw-bold uts-primary">Description</span>
                            </th>
                            <th class="border-0 py-3">
                                <span class="fw-bold uts-primary">Priorité</span>
                            </th>
                            <th class="border-0 py-3">
                                <span class="fw-bold uts-primary">Statut</span>
                            </th>
                            <th class="border-0 py-3 text-center">
                                <span class="fw-bold uts-primary">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td class="align-middle px-4">
                                    <span class="badge bg-light text-dark border">#{{ $role->id }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="role-color-indicator"
                                             style="background-color: {{ $role->color ?? '#2E7D32' }};"></div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $role->name }}</div>
                                            @if(($role->users_count ?? 0) > 0)
                                                <small class="uts-primary">
                                                    <i class="fas fa-users me-1"></i>{{ $role->users_count }} utilisateur(s)
                                                </small>
                                            @else
                                                <small class="text-muted">Aucun utilisateur</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="text-muted">
                                        {{ Str::limit($role->description ?? 'Aucune description', 60) }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    @if(isset($role->priority_level))
                                        @php
                                            $priorityData = match($role->priority_level) {
                                                1 => ['class' => 'danger', 'label' => 'Très élevé'],
                                                2 => ['class' => 'warning', 'label' => 'Élevé'],
                                                3 => ['class' => 'primary', 'label' => 'Moyen'],
                                                4 => ['class' => 'secondary', 'label' => 'Faible'],
                                                5 => ['class' => 'light text-dark', 'label' => 'Très faible'],
                                                default => ['class' => 'secondary', 'label' => 'Non défini']
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $priorityData['class'] }} priority-badge">
                                            {{ $priorityData['label'] }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($role->is_active ?? true)
                                        <span class="badge bg-success status-badge">
                                            <i class="fas fa-check me-1"></i>Actif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary status-badge">
                                            <i class="fas fa-pause me-1"></i>Inactif
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="{{ route('roles.show', $role) }}"
                                           class="btn btn-outline-info action-btn"
                                           data-bs-toggle="tooltip"
                                           title="Voir détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('roles.edit', $role) }}"
                                           class="btn btn-outline-warning action-btn"
                                           data-bs-toggle="tooltip"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('roles.destroy', $role) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Confirmer la suppression du rôle \'{{ $role->name }}\' ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-outline-danger action-btn"
                                                    data-bs-toggle="tooltip"
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox fa-3x uts-primary opacity-50 mb-3"></i>
                                        <h5 class="uts-primary">Aucun rôle disponible</h5>
                                        <p class="text-muted mb-4">Commencez par créer votre premier rôle pour organiser les permissions.</p>
                                        <a href="{{ route('roles.create') }}" class="btn btn-uts-primary">
                                            <i class="fas fa-plus me-2"></i>Créer un rôle
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($roles->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Affichage de {{ $roles->firstItem() }} à {{ $roles->lastItem() }}
                sur {{ $roles->total() }} résultats
            </div>
            <div>
                {{ $roles->links() }}
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Animation des cartes statistiques
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush
