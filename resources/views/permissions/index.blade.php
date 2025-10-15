@extends('layouts.app')

@section('title', 'Permissions')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- En-tête avec design UTS -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark fw-bold">
                <i class="fas fa-shield-alt text-warning me-2"></i>
                Gestion des Permissions
            </h1>
            <p class="text-muted small mb-0">Contrôlez les droits d'accès de votre système</p>
        </div>
        <a href="{{ route('permissions.create') }}" class="btn btn-success btn-lg shadow-sm">
            <i class="fas fa-plus-circle me-2"></i>
            Nouvelle Permission
        </a>
    </div>

    <!-- Messages de succès -->
    @if(session('success'))
        <div class="alert alert-success border-success border-opacity-50 bg-success bg-opacity-10 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle text-success me-3"></i>
                <div>
                    <h6 class="alert-heading text-success mb-1">Succès !</h6>
                    <p class="mb-0 text-dark">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                <div class="card-body text-center py-3">
                    <i class="fas fa-key text-warning fs-2 mb-2"></i>
                    <h5 class="text-warning fw-bold">{{ $permissions->count() }}</h5>
                    <small class="text-muted">Total Permissions</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                <div class="card-body text-center py-3">
                    <i class="fas fa-check-shield text-success fs-2 mb-2"></i>
                    <h5 class="text-success fw-bold">{{ $permissions->where('name', 'like', 'view-%')->count() }}</h5>
                    <small class="text-muted">Permissions Lecture</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-danger bg-opacity-10">
                <div class="card-body text-center py-3">
                    <i class="fas fa-user-shield text-danger fs-2 mb-2"></i>
                    <h5 class="text-danger fw-bold">{{ $permissions->where('name', 'like', 'manage-%')->count() }}</h5>
                    <small class="text-muted">Permissions Admin</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-secondary bg-opacity-10">
                <div class="card-body text-center py-3">
                    <i class="fas fa-cog text-secondary fs-2 mb-2"></i>
                    <h5 class="text-secondary fw-bold">{{ $permissions->where('name', 'like', 'create-%')->count() }}</h5>
                    <small class="text-muted">Permissions Création</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau principal -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-dark fw-semibold">
                    <i class="fas fa-list text-warning me-2"></i>
                    Liste des Permissions
                </h5>
                <span class="badge bg-warning text-dark">{{ $permissions->count() }} permissions</span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 fw-semibold text-dark py-3 px-4">#</th>
                            <th class="border-0 fw-semibold text-dark py-3">
                                <i class="fas fa-tag text-warning me-2"></i>Nom de la permission
                            </th>
                            <th class="border-0 fw-semibold text-dark py-3">
                                <i class="fas fa-align-left text-warning me-2"></i>Description
                            </th>
                            <th class="border-0 fw-semibold text-dark py-3 text-center">
                                <i class="fas fa-tools text-warning me-2"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <tr class="border-bottom">
                                <td class="py-3 px-4 fw-bold text-warning">#{{ $permission->id }}</td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle p-2 me-3
                                            @if(str_contains($permission->name, 'view-') || str_contains($permission->name, 'read-'))
                                                bg-success bg-opacity-20
                                            @elseif(str_contains($permission->name, 'delete-') || str_contains($permission->name, 'destroy-'))
                                                bg-danger bg-opacity-20
                                            @else
                                                bg-warning bg-opacity-20
                                            @endif
                                        ">
                                            @if(str_contains($permission->name, 'view-') || str_contains($permission->name, 'read-'))
                                                <i class="fas fa-eye text-success"></i>
                                            @elseif(str_contains($permission->name, 'create-') || str_contains($permission->name, 'store-'))
                                                <i class="fas fa-plus text-warning"></i>
                                            @elseif(str_contains($permission->name, 'edit-') || str_contains($permission->name, 'update-'))
                                                <i class="fas fa-edit text-warning"></i>
                                            @elseif(str_contains($permission->name, 'delete-') || str_contains($permission->name, 'destroy-'))
                                                <i class="fas fa-trash text-danger"></i>
                                            @else
                                                <i class="fas fa-key text-warning"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="fw-medium text-dark">{{ $permission->name }}</span>
                                            <br>
                                            <small class="text-muted">
                                                @if(str_contains($permission->name, 'view-') || str_contains($permission->name, 'read-'))
                                                    <span class="badge bg-success bg-opacity-20 text-success">Lecture</span>
                                                @elseif(str_contains($permission->name, 'create-') || str_contains($permission->name, 'store-'))
                                                    <span class="badge bg-warning bg-opacity-20 text-warning">Création</span>
                                                @elseif(str_contains($permission->name, 'edit-') || str_contains($permission->name, 'update-'))
                                                    <span class="badge bg-warning bg-opacity-20 text-warning">Modification</span>
                                                @elseif(str_contains($permission->name, 'delete-') || str_contains($permission->name, 'destroy-'))
                                                    <span class="badge bg-danger bg-opacity-20 text-danger">Suppression</span>
                                                @else
                                                    <span class="badge bg-secondary bg-opacity-20 text-secondary">Système</span>
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <p class="mb-0 text-dark">
                                        {{ $permission->description ?? 'Aucune description' }}
                                    </p>
                                    @if(!$permission->description)
                                        <small class="text-muted fst-italic">Description non renseignée</small>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('permissions.show', $permission->id) }}"
                                           class="btn btn-outline-success btn-sm"
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('permissions.edit', $permission->id) }}"
                                           class="btn btn-outline-warning btn-sm"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('permissions.destroy', $permission->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Confirmer la suppression de la permission « {{ $permission->name }} » ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-shield-alt text-muted fs-1 mb-3 opacity-50"></i>
                                        <h6 class="text-muted mb-2">Aucune permission trouvée</h6>
                                        <p class="text-muted small mb-3">Commencez par créer votre première permission</p>
                                        <a href="{{ route('permissions.create') }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-plus me-2"></i>Créer une permission
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

    <!-- Guide des permissions -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-light py-3">
            <h6 class="mb-0 text-dark fw-semibold">
                <i class="fas fa-info-circle text-warning me-2"></i>
                Guide des types de permissions
            </h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-20 p-2 me-3">
                            <i class="fas fa-eye text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-success mb-0">Lecture</h6>
                            <small class="text-muted">view-, read-</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-20 p-2 me-3">
                            <i class="fas fa-plus text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-warning mb-0">Création</h6>
                            <small class="text-muted">create-, store-</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-20 p-2 me-3">
                            <i class="fas fa-edit text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-warning mb-0">Modification</h6>
                            <small class="text-muted">edit-, update-</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-20 p-2 me-3">
                            <i class="fas fa-trash text-danger"></i>
                        </div>
                        <div>
                            <h6 class="text-danger mb-0">Suppression</h6>
                            <small class="text-muted">delete-, destroy-</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Animations et améliorations */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.btn {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: rgba(255, 193, 7, 0.05);
}

.btn-group .btn {
    margin: 0 2px;
}

.badge {
    font-weight: 500;
    font-size: 0.75rem;
}

.alert {
    border-radius: 0.5rem;
}

/* Couleurs UTS personnalisées */
.text-warning { color: #ffc107 !important; }
.bg-warning { background-color: #ffc107 !important; }
.btn-outline-warning { border-color: #ffc107; color: #ffc107; }
.btn-outline-warning:hover { background-color: #ffc107; color: #000; }
.border-warning { border-color: #ffc107 !important; }

/* Amélioration des icônes contextuelles */
.rounded-circle {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection
