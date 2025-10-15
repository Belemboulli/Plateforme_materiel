@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Breadcrumb et Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item">
                        <a href="{{ route('permissions.index') }}" class="text-warning text-decoration-none">
                            <i class="fas fa-shield-alt me-1"></i>Permissions
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-muted">Détails #{{ $permission->id }}</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0 text-dark fw-bold">
                <i class="fas fa-key text-warning me-2"></i>
                Détails de la permission
            </h1>
        </div>
        <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    <!-- Contenu principal -->
    <div class="row">
        <div class="col-lg-8 col-xl-6">
            <!-- Carte principale -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 me-3
                            @if(str_contains($permission->name, 'view-') || str_contains($permission->name, 'read-'))
                                bg-success bg-opacity-20
                            @elseif(str_contains($permission->name, 'delete-') || str_contains($permission->name, 'destroy-'))
                                bg-danger bg-opacity-20
                            @else
                                bg-warning bg-opacity-20
                            @endif
                        ">
                            @if(str_contains($permission->name, 'view-') || str_contains($permission->name, 'read-'))
                                <i class="fas fa-eye text-success fs-4"></i>
                            @elseif(str_contains($permission->name, 'create-') || str_contains($permission->name, 'store-'))
                                <i class="fas fa-plus text-warning fs-4"></i>
                            @elseif(str_contains($permission->name, 'edit-') || str_contains($permission->name, 'update-'))
                                <i class="fas fa-edit text-warning fs-4"></i>
                            @elseif(str_contains($permission->name, 'delete-') || str_contains($permission->name, 'destroy-'))
                                <i class="fas fa-trash text-danger fs-4"></i>
                            @else
                                <i class="fas fa-key text-warning fs-4"></i>
                            @endif
                        </div>
                        <div>
                            <h5 class="mb-0 fw-semibold text-dark">{{ $permission->name }}</h5>
                            <small class="text-muted">
                                Permission #{{ $permission->id }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Informations détaillées -->
                    <div class="row g-4">
                        <!-- ID -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-start p-3 rounded-3 bg-warning bg-opacity-10 border border-warning border-opacity-25">
                                <div class="rounded-circle bg-warning bg-opacity-30 p-2 me-3 mt-1">
                                    <i class="fas fa-hashtag text-warning"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label text-warning fw-semibold mb-1">ID Permission</label>
                                    <p class="mb-0 fs-5 fw-bold text-dark">#{{ $permission->id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Type de permission -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-start p-3 rounded-3 bg-light border">
                                <div class="rounded-circle bg-secondary bg-opacity-20 p-2 me-3 mt-1">
                                    <i class="fas fa-tag text-secondary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label text-secondary fw-semibold mb-1">Type</label>
                                    @if(str_contains($permission->name, 'view-') || str_contains($permission->name, 'read-'))
                                        <span class="badge bg-success fs-6 px-3 py-2">
                                            <i class="fas fa-eye me-1"></i>Lecture
                                        </span>
                                    @elseif(str_contains($permission->name, 'create-') || str_contains($permission->name, 'store-'))
                                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                            <i class="fas fa-plus me-1"></i>Création
                                        </span>
                                    @elseif(str_contains($permission->name, 'edit-') || str_contains($permission->name, 'update-'))
                                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                            <i class="fas fa-edit me-1"></i>Modification
                                        </span>
                                    @elseif(str_contains($permission->name, 'delete-') || str_contains($permission->name, 'destroy-'))
                                        <span class="badge bg-danger fs-6 px-3 py-2">
                                            <i class="fas fa-trash me-1"></i>Suppression
                                        </span>
                                    @else
                                        <span class="badge bg-secondary fs-6 px-3 py-2">
                                            <i class="fas fa-cog me-1"></i>Système
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Nom complet -->
                        <div class="col-12">
                            <div class="d-flex align-items-start p-3 rounded-3 bg-success bg-opacity-10 border border-success border-opacity-25">
                                <div class="rounded-circle bg-success bg-opacity-30 p-2 me-3 mt-1">
                                    <i class="fas fa-signature text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label text-success fw-semibold mb-1">Nom de la permission</label>
                                    <code class="d-block bg-success bg-opacity-10 text-success p-2 rounded fs-5 fw-medium">
                                        {{ $permission->name }}
                                    </code>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($permission->description)
                        <div class="col-12">
                            <div class="d-flex align-items-start p-3 rounded-3 bg-light border">
                                <div class="rounded-circle bg-secondary bg-opacity-20 p-2 me-3 mt-1">
                                    <i class="fas fa-align-left text-secondary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label text-secondary fw-semibold mb-1">Description</label>
                                    <p class="mb-0 text-dark">{{ $permission->description }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Dates -->
                        <div class="col-md-6">
                            <div class="d-flex align-items-start p-3 rounded-3 bg-light border">
                                <div class="rounded-circle bg-secondary bg-opacity-20 p-2 me-3 mt-1">
                                    <i class="fas fa-calendar-plus text-secondary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label text-secondary fw-semibold mb-1">Créée le</label>
                                    <p class="mb-0 fw-medium text-dark">
                                        {{ $permission->created_at->format('d/m/Y à H:i') }}
                                    </p>
                                    <small class="text-muted">
                                        {{ $permission->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-start p-3 rounded-3 bg-light border">
                                <div class="rounded-circle bg-secondary bg-opacity-20 p-2 me-3 mt-1">
                                    <i class="fas fa-calendar-check text-secondary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <label class="form-label text-secondary fw-semibold mb-1">Modifiée le</label>
                                    <p class="mb-0 fw-medium text-dark">
                                        {{ $permission->updated_at->format('d/m/Y à H:i') }}
                                    </p>
                                    <small class="text-muted">
                                        {{ $permission->updated_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Confirmer la suppression de la permission « {{ $permission->name }} » ?')">
                                <i class="fas fa-trash-alt me-2"></i>Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations supplémentaires -->
        <div class="col-lg-4 col-xl-6">
            <!-- Rôles utilisant cette permission -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-users text-success me-2"></i>
                        Rôles associés
                    </h6>
                </div>
                <div class="card-body">
                    @if($permission->roles && $permission->roles->count() > 0)
                        @foreach($permission->roles as $role)
                            <div class="d-flex align-items-center mb-3 p-2 rounded bg-success bg-opacity-10">
                                <div class="rounded-circle bg-success bg-opacity-30 p-2 me-3">
                                    <i class="fas fa-user-tag text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 text-dark">{{ $role->name }}</h6>
                                    <small class="text-muted">
                                        {{ $role->users_count ?? 0 }} utilisateur(s)
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-slash text-muted fs-2 mb-3 opacity-50"></i>
                            <h6 class="text-muted mb-2">Aucun rôle associé</h6>
                            <p class="text-muted small mb-0">Cette permission n'est assignée à aucun rôle</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informations système -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-cog text-warning me-2"></i>
                        Informations système
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Statut</span>
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Guard</span>
                                <code class="text-dark">web</code>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Niveau de risque</span>
                                @if(str_contains($permission->name, 'delete-') || str_contains($permission->name, 'destroy-'))
                                    <span class="badge bg-danger">Élevé</span>
                                @elseif(str_contains($permission->name, 'edit-') || str_contains($permission->name, 'update-') || str_contains($permission->name, 'create-'))
                                    <span class="badge bg-warning text-dark">Moyen</span>
                                @else
                                    <span class="badge bg-success">Faible</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-3 border border-warning border-opacity-25 rounded-3 bg-warning bg-opacity-10">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-lightbulb text-warning me-2"></i>
                            <small class="text-dark fw-medium">Conseil de sécurité</small>
                        </div>
                        <small class="text-muted mt-1 d-block">
                            @if(str_contains($permission->name, 'delete-') || str_contains($permission->name, 'destroy-'))
                                Accordez cette permission avec prudence car elle permet la suppression de données.
                            @elseif(str_contains($permission->name, 'edit-') || str_contains($permission->name, 'update-'))
                                Cette permission permet la modification de données. Vérifiez les droits d'accès.
                            @else
                                Permission à faible risque, peut être accordée selon les besoins fonctionnels.
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Animations */
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-1px);
}

.badge {
    font-weight: 500;
}

.breadcrumb-item a:hover {
    color: #e0a800 !important;
}

code {
    font-size: 0.95rem;
}

/* Couleurs UTS */
.text-warning { color: #ffc107 !important; }
.bg-warning { background-color: #ffc107 !important; }
.border-warning { border-color: #ffc107 !important; }
.btn-warning { background-color: #ffc107; border-color: #ffc107; color: #000; }
.btn-warning:hover { background-color: #e0a800; border-color: #d39e00; }

/* Amélioration des éléments */
.rounded-circle {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection
