@extends('layouts.app')

@section('title', 'Historique des Connexions')

@section('content')
<div class="container-fluid mt-4">
    <!-- En-tête avec statistiques -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="fas fa-history text-primary me-2"></i>
                        Historique des Connexions
                    </h1>
                    <p class="text-muted mb-0">Suivi des connexions utilisateurs</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-filter me-1"></i>Filtrer
                    </button>
                    @can('export', App\Models\HistoriqueConnexion::class)
                    <a href="{{ route('historiques_connexion.export') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-download me-1"></i>Exporter
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Connexions Réussies
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                               {{ $historiques->filter(fn($h) => strtolower($h->etat) === 'succès')->count() }}
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
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Connexions Échouées
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                               {{ $historiques->filter(fn($h) => strtolower($h->etat) === 'échec')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Connexions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $historiques->total() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-info"></i>
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
                                Utilisateurs Uniques
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $historiques->pluck('user_id')->unique()->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-warning"></i>
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

    <!-- Tableau principal -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Connexions</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow">
                    <a class="dropdown-item" href="{{ route('historiques_connexion.index', ['sort' => 'recent']) }}">
                        <i class="fas fa-clock fa-sm fa-fw mr-2 text-gray-400"></i>Plus récents
                    </a>
                    <a class="dropdown-item" href="{{ route('historiques_connexion.index', ['sort' => 'failed']) }}">
                        <i class="fas fa-exclamation-triangle fa-sm fa-fw mr-2 text-gray-400"></i>Échecs seulement
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th><i class="fas fa-user me-1"></i>Utilisateur</th>
                            <th><i class="fas fa-map-marker-alt me-1"></i>Localisation</th>
                            <th><i class="fas fa-globe me-1"></i>Navigateur</th>
                            <th><i class="fas fa-desktop me-1"></i>Système</th>
                            <th><i class="fas fa-info-circle me-1"></i>État</th>
                            <th><i class="fas fa-calendar me-1"></i>Date & Heure</th>
                            <th><i class="fas fa-clock me-1"></i>Durée</th>
                            @can('delete', App\Models\HistoriqueConnexion::class)
                                <th class="text-center"><i class="fas fa-cogs"></i></th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historiques as $historique)
                        <tr>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $historique->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm rounded-circle bg-gradient-primary text-white me-2">
                                        {{ $historique->user ? strtoupper(substr($historique->user->name, 0, 2)) : 'XX' }}
                                    </div>
                                    <div>
                                        <strong>{{ $historique->user->name ?? 'Utilisateur supprimé' }}</strong>
                                        <br><small class="text-muted">{{ $historique->user->email ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <i class="fas fa-map-pin text-muted me-1"></i>
                                    <span>{{ $historique->ip_address }}</span>
                                    @if($historique->pays ?? false)
                                        <br><small class="text-muted">{{ $historique->ville ?? '' }}, {{ $historique->pays ?? '' }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @php
                                        $navigateur = strtolower($historique->navigateur ?? 'inconnu');
                                        $browserIcon = match(true) {
                                            str_contains($navigateur, 'chrome') => 'fab fa-chrome',
                                            str_contains($navigateur, 'firefox') => 'fab fa-firefox-browser',
                                            str_contains($navigateur, 'safari') => 'fab fa-safari',
                                            str_contains($navigateur, 'edge') => 'fab fa-edge',
                                            default => 'fas fa-globe'
                                        };
                                    @endphp
                                    <i class="{{ $browserIcon }} text-muted me-2"></i>
                                    <small>{{ Str::limit($historique->navigateur ?? 'Inconnu', 30) }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @php
                                        $os = strtolower($historique->os ?? 'inconnu');
                                        $osIcon = match(true) {
                                            str_contains($os, 'windows') => 'fab fa-windows',
                                            str_contains($os, 'mac') => 'fab fa-apple',
                                            str_contains($os, 'linux') => 'fab fa-linux',
                                            str_contains($os, 'android') => 'fab fa-android',
                                            default => 'fas fa-desktop'
                                        };
                                    @endphp
                                    <i class="{{ $osIcon }} text-muted me-2"></i>
                                    <small>{{ Str::limit($historique->os ?? 'Inconnu', 15) }}</small>
                                </div>
                            </td>
                            <td>
                                @php
                                    $etat = strtolower($historique->etat ?? 'inconnu');
                                @endphp
                                @if(in_array($etat, ['success', 'succès', 'réussi']))
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Réussi
                                    </span>
                                @elseif(in_array($etat, ['failed', 'échec', 'échoué']))
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times me-1"></i>Échoué
                                    </span>
                                @elseif($etat === 'déconnexion')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-question me-1"></i>{{ ucfirst($historique->etat ?? 'Inconnu') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @php
                                    // ✅ CORRECTION: Gestion sécurisée des dates
                                    $dateConnexion = null;

                                    if ($historique->connecte_le) {
                                        try {
                                            // Si c'est déjà un objet Carbon/DateTime
                                            if ($historique->connecte_le instanceof \Carbon\Carbon) {
                                                $dateConnexion = $historique->connecte_le;
                                            }
                                            // Si c'est une string, la convertir
                                            else {
                                                $dateConnexion = \Carbon\Carbon::parse($historique->connecte_le);
                                            }
                                        } catch (\Exception $e) {
                                            $dateConnexion = null;
                                        }
                                    }
                                @endphp

                                @if($dateConnexion)
                                <div>
                                    <strong>{{ $dateConnexion->format('d/m/Y') }}</strong>
                                    <br><small class="text-muted">{{ $dateConnexion->format('H:i:s') }}</small>
                                    <br><small class="text-info">{{ $dateConnexion->diffForHumans() }}</small>
                                </div>
                                @else
                                <div class="text-muted">
                                    <small>Date non disponible</small>
                                </div>
                                @endif
                            </td>
                            <td>
                                @if($historique->duree_session ?? false)
                                    <span class="badge bg-info">{{ $historique->duree_session }} min</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            @can('delete', $historique)
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $historique->id }}" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <form action="{{ route('historiques_connexion.destroy', $historique) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endcan
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <h5>Aucun historique trouvé</h5>
                                    <p>Il n'y a pas encore d'historique de connexion à afficher.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($historiques->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Affichage de {{ $historiques->firstItem() }} à {{ $historiques->lastItem() }}
                    sur {{ $historiques->total() }} résultats
                </div>
                {{ $historiques->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-danger { border-left: 0.25rem solid #e74a3b !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }

.avatar {
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}

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

.bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
}
</style>
@endsection
