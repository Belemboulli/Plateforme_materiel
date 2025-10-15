@extends('layouts.app')

@section('title', 'Modifier Permission')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Breadcrumb et En-tête -->
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item">
                    <a href="{{ route('permissions.index') }}" class="text-warning text-decoration-none">
                        <i class="fas fa-shield-alt me-1"></i>Permissions
                    </a>
                </li>
                <li class="breadcrumb-item active text-muted">Modifier {{ $permission->name }}</li>
            </ol>
        </nav>
        <h1 class="h3 mb-0 text-dark fw-bold">
            <i class="fas fa-edit text-warning me-2"></i>
            Modifier la permission
        </h1>
        <p class="text-muted small mb-0">Modifiez les informations de la permission "{{ $permission->name }}"</p>
    </div>

    <div class="row">
        <!-- Formulaire principal -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-20 p-3 me-3">
                            <i class="fas fa-key text-warning fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-semibold text-dark">Permission : {{ $permission->name }}</h5>
                            <small class="text-muted">
                                Créée le {{ \Carbon\Carbon::parse($permission->created_at)->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nom de la permission -->
                        <div class="mb-4">
                            <label for="name" class="form-label text-dark fw-semibold mb-2">
                                <i class="fas fa-tag text-warning me-2"></i>
                                Nom de la permission
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-warning bg-opacity-10 border-warning border-opacity-50">
                                    <i class="fas fa-signature text-warning"></i>
                                </span>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control border-warning border-opacity-50 @error('name') is-invalid @enderror"
                                       value="{{ old('name', $permission->name) }}"
                                       required>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @else
                                <small class="form-text text-muted">
                                    Le nom doit être unique dans le système
                                </small>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label text-dark fw-semibold mb-2">
                                <i class="fas fa-align-left text-warning me-2"></i>
                                Description
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-warning bg-opacity-10 border-warning border-opacity-50 align-items-start pt-3">
                                    <i class="fas fa-comment text-warning"></i>
                                </span>
                                <textarea name="description"
                                          id="description"
                                          class="form-control border-warning border-opacity-50 @error('description') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Décrivez brièvement cette permission...">{{ old('description', $permission->description) }}</textarea>
                            </div>
                            @error('description')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @else
                                <small class="form-text text-muted">
                                    La description aide à comprendre l'utilité de cette permission
                                </small>
                            @enderror
                        </div>

                        <!-- Avertissement de modification -->
                        <div class="alert alert-warning border-warning border-opacity-50 bg-warning bg-opacity-10" role="alert">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-exclamation-triangle text-warning me-3 mt-1"></i>
                                <div>
                                    <h6 class="alert-heading text-warning mb-2">Attention</h6>
                                    <p class="mb-2 small text-dark">
                                        La modification de cette permission peut affecter tous les utilisateurs et rôles qui l'utilisent.
                                    </p>
                                    <small class="text-muted">
                                        Assurez-vous que les changements sont compatibles avec les fonctionnalités existantes.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-warning shadow-sm">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Informations de la permission -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-info-circle text-warning me-2"></i>
                        Informations de la permission
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">ID Permission</span>
                                <span class="fw-medium">#{{ $permission->id }}</span>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Nom actuel</span>
                                <code class="bg-warning bg-opacity-20 text-warning px-2 py-1 rounded">{{ $permission->name }}</code>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Créée le</span>
                                <span class="fw-medium">{{ \Carbon\Carbon::parse($permission->created_at)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Dernière MAJ</span>
                                <span class="fw-medium">{{ \Carbon\Carbon::parse($permission->updated_at)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Statut</span>
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rôles utilisant cette permission -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-users text-success me-2"></i>
                        Rôles associés
                    </h6>
                </div>
                <div class="card-body">
                    @if($permission->roles && $permission->roles->count() > 0)
                        @foreach($permission->roles as $role)
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle bg-success bg-opacity-20 p-2 me-2">
                                    <i class="fas fa-user-tag text-success small"></i>
                                </div>
                                <span class="text-dark">{{ $role->name }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-user-slash text-muted fs-2 mb-2 opacity-50"></i>
                            <p class="text-muted small mb-0">Aucun rôle associé</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-bolt text-danger me-2"></i>
                        Actions rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                    onclick="return confirm('Confirmer la suppression de cette permission ?')">
                                <i class="fas fa-trash-alt me-2"></i>Supprimer cette permission
                            </button>
                        </form>
                    </div>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                        Cette action est irréversible
                    </small>
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
    transform: translateY(-2px);
}

.btn {
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.input-group-text {
    transition: all 0.2s ease;
}

.breadcrumb-item a:hover {
    color: #e0a800 !important;
}

/* Couleurs UTS */
.text-warning { color: #ffc107 !important; }
.bg-warning { background-color: #ffc107 !important; }
.border-warning { border-color: #ffc107 !important; }
.btn-warning { background-color: #ffc107; border-color: #ffc107; color: #000; }
.btn-warning:hover { background-color: #e0a800; border-color: #d39e00; }

/* Amélioration du focus */
.form-control:focus + .input-group-text {
    border-color: #ffc107;
    background-color: rgba(255, 193, 7, 0.15);
}

/* Code styling */
code {
    font-size: 0.875rem;
}
</style>
@endsection
