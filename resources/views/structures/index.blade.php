@extends('layouts.app')

@section('title', 'Liste des Structures')

@push('styles')
<style>
    :root {
        --uts-yellow: #FFD700;
        --uts-yellow-dark: #F57C00;
        --uts-green: #2E7D32;
        --uts-green-light: #66BB6A;
        --uts-green-dark: #1B5E20;
        --uts-red: #D32F2F;
        --uts-dark: #2C3E50;
        --uts-cream: #FFF8E1;
        --uts-sage: #E8F5E8;
        --uts-warm: #FFFDE7;
    }

    .breadcrumb {
        background: var(--uts-sage);
        border: 2px solid var(--uts-yellow);
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }

    .breadcrumb-item a {
        color: var(--uts-green);
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-item a:hover {
        color: var(--uts-yellow-dark);
    }

    .card {
        border: 3px solid var(--uts-yellow);
        background: linear-gradient(135deg, var(--uts-cream), var(--uts-warm));
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.15);
        border-radius: 15px;
    }

    .card-header {
        background: linear-gradient(135deg, var(--uts-green), var(--uts-green-light));
        border-bottom: 3px solid var(--uts-yellow);
        color: var(--uts-cream);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--uts-yellow), var(--uts-yellow-dark)) !important;
        border: 2px solid var(--uts-green) !important;
        color: var(--uts-dark) !important;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--uts-yellow-dark), var(--uts-yellow)) !important;
        border-color: var(--uts-green-dark) !important;
        color: var(--uts-dark) !important;
        transform: translateY(-1px);
    }

    .alert-success {
        background: linear-gradient(135deg, var(--uts-sage), var(--uts-cream));
        border: 2px solid var(--uts-green);
        border-left: 5px solid var(--uts-green);
        color: var(--uts-green-dark);
    }

    .table-header {
        background: var(--uts-sage) !important;
        color: var(--uts-dark) !important;
        border-bottom: 2px solid var(--uts-green) !important;
    }

    .table-hover tbody tr:hover {
        background-color: var(--uts-warm) !important;
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    .btn-info {
        background: var(--uts-sage);
        border: 2px solid var(--uts-green);
        color: var(--uts-green);
    }

    .btn-info:hover {
        background: var(--uts-green);
        border-color: var(--uts-green-dark);
        color: var(--uts-cream);
    }

    .btn-warning {
        background: var(--uts-warm);
        border: 2px solid var(--uts-yellow-dark);
        color: var(--uts-yellow-dark);
    }

    .btn-warning:hover {
        background: var(--uts-yellow-dark);
        border-color: var(--uts-yellow);
        color: var(--uts-dark);
    }

    .btn-danger {
        background: rgba(211, 47, 47, 0.1);
        border: 2px solid var(--uts-red);
        color: var(--uts-red);
    }

    .btn-danger:hover {
        background: var(--uts-red);
        border-color: #b71c1c;
        color: var(--uts-cream);
    }

    .stats-card {
        border: 2px solid var(--uts-yellow);
        background: linear-gradient(135deg, var(--uts-cream), var(--uts-warm));
        transition: transform 0.2s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);
    }

    .form-control {
        background: var(--uts-warm);
        border: 2px solid var(--uts-sage);
    }

    .form-control:focus {
        background: var(--uts-cream);
        border-color: var(--uts-green);
        box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.15);
    }

    .badge {
        border-radius: 10px;
        padding: 0.5rem 1rem;
        font-weight: 600;
    }

    .badge-type {
        background: var(--uts-sage);
        color: var(--uts-green);
        border: 1px solid var(--uts-green);
    }

    .badge-status-active {
        background: var(--uts-green);
        color: var(--uts-cream);
    }

    .badge-status-inactive {
        background: var(--uts-red);
        color: var(--uts-cream);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-house-door"></i> Accueil
                </a>
            </li>
            <li class="breadcrumb-item active">Structures</li>
        </ol>
    </nav>

    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                <div>
                    <h1 class="h3 mb-1 text-dark fw-bold d-flex align-items-center">
                        <div class="bg-primary bg-gradient rounded-3 p-2 me-3" style="background: linear-gradient(135deg, var(--uts-green), var(--uts-green-light)) !important; border: 2px solid var(--uts-yellow);">
                            <i class="bi bi-building text-white fs-5"></i>
                        </div>
                        Gestion des Structures
                    </h1>
                    <p class="text-muted mb-0 small">Gérez les structures organisationnelles et leurs responsables</p>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm d-flex align-items-center" onclick="window.print()" style="border: 2px solid var(--uts-green); color: var(--uts-green); background: var(--uts-sage);">
                        <i class="bi bi-printer me-1"></i>
                        <span class="d-none d-sm-inline">Imprimer</span>
                    </button>
                    <a href="{{ route('structures.create') }}" class="btn btn-primary shadow-sm d-flex align-items-center">
                        <i class="bi bi-plus-circle me-2"></i>
                        <span>Nouvelle Structure</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-2 me-3" style="background: var(--uts-green); color: var(--uts-cream);">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="flex-grow-1">
                            <strong>Succès !</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-6 col-md-3">
            <div class="stats-card border-0 shadow-sm h-100 rounded-3 p-3">
                <div class="text-center">
                    <div class="mb-2" style="color: var(--uts-green);">
                        <i class="bi bi-building fs-4"></i>
                    </div>
                    <h6 class="mb-1 fw-bold">{{ $structures->count() }}</h6>
                    <small class="text-muted">Structures Total</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stats-card border-0 shadow-sm h-100 rounded-3 p-3">
                <div class="text-center">
                    <div class="mb-2" style="color: var(--uts-yellow-dark);">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <h6 class="mb-1 fw-bold">{{ $structures->whereNotNull('responsable')->count() }}</h6>
                    <small class="text-muted">Avec Responsable</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau principal -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold text-white">
                            <i class="bi bi-list-ul me-2"></i>
                            Liste des Structures
                        </h5>
                        <div class="d-flex gap-2">
                            <div class="input-group input-group-sm" style="max-width: 250px;">
                                <span class="input-group-text" style="background: var(--uts-yellow); border: 2px solid var(--uts-green); color: var(--uts-dark);">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Rechercher..." id="searchInput">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="structuresTable">
                            <thead class="table-header">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold">
                                        <i class="bi bi-hash me-1"></i> ID
                                    </th>
                                    <th class="py-3 fw-semibold">
                                        <i class="bi bi-building me-1"></i> Structure
                                    </th>
                                    <th class="py-3 fw-semibold d-none d-md-table-cell">
                                        <i class="bi bi-tags me-1"></i> Type
                                    </th>
                                    <th class="py-3 fw-semibold d-none d-lg-table-cell">
                                        <i class="bi bi-person-badge me-1"></i> Responsable
                                    </th>
                                    <th class="py-3 fw-semibold d-none d-xl-table-cell">
                                        <i class="bi bi-telephone me-1"></i> Contact
                                    </th>
                                    <th class="py-3 fw-semibold text-center">
                                        <i class="bi bi-gear me-1"></i> Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($structures as $structure)
                                    <tr class="structure-row">
                                        <td class="px-4 py-3">
                                            <span class="badge px-3 py-2 fw-medium" style="background: var(--uts-yellow); color: var(--uts-dark); border: 2px solid var(--uts-green);">
                                                #{{ str_pad($structure->id, 3, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle p-2 me-3 flex-shrink-0" style="background: var(--uts-sage); border: 2px solid var(--uts-yellow);">
                                                    <i class="bi bi-building" style="color: var(--uts-green);"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold text-dark structure-name">{{ $structure->nom }}</h6>
                                                    <small class="text-muted">Structure organisationnelle</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 d-none d-md-table-cell">
                                            @if($structure->type)
                                                <span class="badge badge-type px-2 py-1">
                                                    {{ $structure->type }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 d-none d-lg-table-cell">
                                            <span class="text-dark">{{ $structure->responsable ?? '-' }}</span>
                                        </td>
                                        <td class="py-3 d-none d-xl-table-cell">
                                            @if($structure->contact)
                                                <span class="badge px-2 py-1" style="background: var(--uts-warm); color: var(--uts-dark); border: 1px solid var(--uts-yellow);">
                                                    <i class="bi bi-telephone me-1"></i>{{ $structure->contact }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('structures.show', $structure) }}"
                                                   class="btn btn-sm btn-info rounded-pill px-3"
                                                   title="Voir les détails"
                                                   data-bs-toggle="tooltip">
                                                    <i class="bi bi-eye"></i>
                                                    <span class="d-none d-lg-inline ms-1">Voir</span>
                                                </a>

                                                <a href="{{ route('structures.edit', $structure) }}"
                                                   class="btn btn-sm btn-warning rounded-pill px-3"
                                                   title="Modifier"
                                                   data-bs-toggle="tooltip">
                                                    <i class="bi bi-pencil"></i>
                                                    <span class="d-none d-lg-inline ms-1">Modifier</span>
                                                </a>

                                                <button type="button"
                                                        class="btn btn-sm btn-danger rounded-pill px-3"
                                                        title="Supprimer"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $structure->id }}">
                                                    <i class="bi bi-trash"></i>
                                                    <span class="d-none d-lg-inline ms-1">Supprimer</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal de suppression -->
                                    <div class="modal fade" id="deleteModal{{ $structure->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow" style="border: 3px solid var(--uts-yellow); background: linear-gradient(135deg, var(--uts-cream), var(--uts-warm));">
                                                <div class="modal-header" style="border-bottom: 2px solid var(--uts-green);">
                                                    <h5 class="modal-title fw-bold text-dark">
                                                        <i class="bi bi-exclamation-triangle me-2" style="color: var(--uts-red);"></i>
                                                        Confirmer la suppression
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="mb-0">Êtes-vous sûr de vouloir supprimer la structure <strong>"{{ $structure->nom }}"</strong> ?</p>
                                                    <small class="text-muted">Cette action est irréversible.</small>
                                                </div>
                                                <div class="modal-footer" style="border-top: 2px solid var(--uts-green);">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: var(--uts-sage); border: 2px solid var(--uts-green); color: var(--uts-green);">
                                                        Annuler
                                                    </button>
                                                    <form action="{{ route('structures.destroy', $structure) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-trash me-1"></i> Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="py-4">
                                                <div class="rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; background: var(--uts-sage); border: 3px solid var(--uts-yellow); display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                                </div>
                                                <h5 class="text-muted mb-2">Aucune structure trouvée</h5>
                                                <p class="text-muted mb-3">Commencez par créer votre première structure</p>
                                                <a href="{{ route('structures.create') }}" class="btn btn-primary">
                                                    <i class="bi bi-plus-circle me-2"></i>
                                                    Créer une structure
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
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Recherche
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#structuresTable .structure-row');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            tableRows.forEach(row => {
                const structureName = row.querySelector('.structure-name').textContent.toLowerCase();
                const isVisible = structureName.includes(searchTerm);
                row.style.display = isVisible ? '' : 'none';
            });
        });
    }
});
</script>
@endpush
@endsection
