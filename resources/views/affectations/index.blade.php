@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- En-tête avec statistiques -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-2 text-gray-800 fw-bold">
                        <i class="fas fa-clipboard-list text-primary me-2"></i>
                        Gestion des affectations
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Affectations</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-success fs-6 px-3 py-2">
                        <i class="fas fa-list me-1"></i>{{ $affectations->total() ?? count($affectations) }} Total
                    </span>
                </div>
            </div>

            <!-- Messages de succès -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Succès !</strong>
                    </div>
                    <p class="mb-0 mt-1">{{ session('success') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle text-danger me-2"></i>
                        <strong>Erreur !</strong>
                    </div>
                    <p class="mb-0 mt-1">{{ session('error') }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Barre d'outils -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('affectations.create') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus me-2"></i>Nouvelle affectation
                                </a>
                                <a href="{{ route('affectations.export.excel') }}" class="btn btn-outline-success btn-lg">
                                    <i class="fas fa-file-excel me-2"></i>Exporter Excel
                                </a>
                                <a href="{{ route('affectations.export.pdf') }}" class="btn btn-outline-danger btn-lg">
                                    <i class="fas fa-file-pdf me-2"></i>Exporter PDF
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2 justify-content-md-end flex-wrap">
                                <!-- Filtres rapides -->
                                <select class="form-select" id="filterStatus" style="max-width: 200px;">
                                    <option value="">Tous les statuts</option>
                                    <option value="en cours">En cours</option>
                                    <option value="terminé">Terminé</option>
                                    <option value="annulé">Annulé</option>
                                    <option value="en attente">En attente</option>
                                </select>
                                <div class="input-group" style="max-width: 300px;">
                                    <input type="text" class="form-control" placeholder="Rechercher..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm bg-primary text-white">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-uppercase mb-1">En cours</div>
                                    <div class="h5 mb-0 fw-bold">{{ $affectations->where('statut', 'en cours')->count() ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-play-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm bg-success text-white">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-uppercase mb-1">Terminées</div>
                                    <div class="h5 mb-0 fw-bold">{{ $affectations->where('statut', 'terminé')->count() ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm bg-warning text-white">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-uppercase mb-1">En attente</div>
                                    <div class="h5 mb-0 fw-bold">{{ $affectations->where('statut', 'en attente')->count() ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-pause-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm bg-danger text-white">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs fw-bold text-uppercase mb-1">Annulées</div>
                                    <div class="h5 mb-0 fw-bold">{{ $affectations->where('statut', 'annulé')->count() ?? 0 }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des affectations -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-semibold">
                            <i class="fas fa-table me-2"></i>Liste des affectations
                        </h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-light" id="toggleView">
                                <i class="fas fa-th-large me-1"></i>Vue carte
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="affectationsTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-bold text-uppercase text-xs">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th class="border-0 fw-bold text-uppercase text-xs">ID</th>
                                    <th class="border-0 fw-bold text-uppercase text-xs">
                                        <i class="fas fa-laptop me-1"></i>Matériel
                                    </th>
                                    <th class="border-0 fw-bold text-uppercase text-xs">
                                        <i class="fas fa-user me-1"></i>Utilisateur
                                    </th>
                                    <th class="border-0 fw-bold text-uppercase text-xs">
                                        <i class="fas fa-building me-1"></i>Service
                                    </th>
                                    <th class="border-0 fw-bold text-uppercase text-xs">
                                        <i class="fas fa-calendar me-1"></i>Date affectation
                                    </th>
                                    <th class="border-0 fw-bold text-uppercase text-xs">
                                        <i class="fas fa-calendar-times me-1"></i>Date retour
                                    </th>
                                    <th class="border-0 fw-bold text-uppercase text-xs">
                                        <i class="fas fa-flag me-1"></i>Statut
                                    </th>
                                    <th class="border-0 fw-bold text-uppercase text-xs">
                                        <i class="fas fa-comment me-1"></i>Commentaire
                                    </th>
                                    <th class="border-0 fw-bold text-uppercase text-xs text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($affectations as $affectation)
                                <tr class="align-middle">
                                    <td>
                                        <input type="checkbox" class="form-check-input row-checkbox" value="{{ $affectation->id }}">
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark fs-6">#{{ $affectation->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-laptop"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $affectation->materiel->nom ?? $affectation->materiel->name ?? '-' }}</div>
                                                <small class="text-muted">{{ $affectation->numero_affectation ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $affectation->user->name ?? '-' }}</div>
                                                <small class="text-muted">{{ $affectation->user->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $affectation->service->nom ?? $affectation->service->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-check text-success me-1"></i>
                                        {{ $affectation->date_affectation ? \Carbon\Carbon::parse($affectation->date_affectation)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td>
                                        @if($affectation->date_retour)
                                            <i class="fas fa-calendar-times text-danger me-1"></i>
                                            {{ \Carbon\Carbon::parse($affectation->date_retour)->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'en cours' => 'success',
                                                'terminé' => 'primary',
                                                'annulé' => 'danger',
                                                'en attente' => 'warning'
                                            ];
                                            $statusIcons = [
                                                'en cours' => 'play-circle',
                                                'terminé' => 'check-circle',
                                                'annulé' => 'times-circle',
                                                'en attente' => 'pause-circle'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$affectation->statut] ?? 'secondary' }} fs-6">
                                            <i class="fas fa-{{ $statusIcons[$affectation->statut] ?? 'question-circle' }} me-1"></i>
                                            {{ ucfirst($affectation->statut) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 150px;" title="{{ $affectation->commentaire ?? 'Aucun commentaire' }}">
                                            {{ $affectation->commentaire ? Str::limit($affectation->commentaire, 30) : '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('affectations.show', $affectation->id) }}"
                                               class="btn btn-sm btn-outline-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('affectations.edit', $affectation->id) }}"
                                               class="btn btn-sm btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('affectations.destroy', $affectation->id) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cette affectation ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <h5>Aucune affectation trouvée</h5>
                                            <p>Commencez par créer votre première affectation.</p>
                                            <a href="{{ route('affectations.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Nouvelle affectation
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Actions groupées -->
                <div class="card-footer bg-light" id="bulkActions" style="display: none;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            <span id="selectedCount">0</span> élément(s) sélectionné(s)
                        </span>
                        <div class="btn-group">
                            <button class="btn btn-outline-success btn-sm" id="bulkTerminer">
                                <i class="fas fa-check me-1"></i>Marquer terminé
                            </button>
                            <button class="btn btn-outline-danger btn-sm" id="bulkSupprimer">
                                <i class="fas fa-trash me-1"></i>Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if(method_exists($affectations, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $affectations->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 14px;
}

.table th {
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.card {
    transition: all 0.3s ease;
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.table-hover tbody tr:hover {
    background-color: #f8f9fc;
}

@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }

    .btn-group {
        flex-direction: column;
        width: 100%;
    }

    .avatar-sm {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // Gestion de la sélection multiple
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
    }

    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const count = checkedBoxes.length;

        if (selectedCount) {
            selectedCount.textContent = count;
        }
        if (bulkActions) {
            bulkActions.style.display = count > 0 ? 'block' : 'none';
        }
    }

    // Actions groupées
    const bulkTerminer = document.getElementById('bulkTerminer');
    const bulkSupprimer = document.getElementById('bulkSupprimer');

    if (bulkTerminer) {
        bulkTerminer.addEventListener('click', function() {
            bulkAction('terminer');
        });
    }

    if (bulkSupprimer) {
        bulkSupprimer.addEventListener('click', function() {
            if (confirm('Voulez-vous vraiment supprimer les affectations sélectionnées ?')) {
                bulkAction('supprimer');
            }
        });
    }

    function bulkAction(action) {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const ids = Array.from(checkedBoxes).map(cb => cb.value);

        if (ids.length === 0) {
            alert('Aucune affectation sélectionnée');
            return;
        }

        fetch('{{ route("affectations.bulk") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ ids: ids, action: action })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.error || 'Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de l\'action groupée');
        });
    }

    // Recherche en temps réel
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');

    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }
    if (filterStatus) {
        filterStatus.addEventListener('change', filterTable);
    }

    function filterTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const statusFilter = filterStatus ? filterStatus.value : '';
        const rows = document.querySelectorAll('#affectationsTable tbody tr:not(:last-child)');

        rows.forEach(row => {
            // Skip si c'est la ligne vide
            if (row.querySelector('.fas.fa-inbox')) return;

            const text = row.textContent.toLowerCase();
            const statusCell = row.querySelector('td:nth-child(8)');
            const status = statusCell ? statusCell.textContent.toLowerCase().trim() : '';

            const matchesSearch = text.includes(searchTerm);
            const matchesStatus = !statusFilter || status.includes(statusFilter);

            row.style.display = matchesSearch && matchesStatus ? '' : 'none';
        });
    }

    // Auto-masquer les alertes après 5 secondes
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = bootstrap.Alert.getInstance(alert) || new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endsection
