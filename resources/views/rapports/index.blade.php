@extends('layouts.app')

@section('content')
<style>
    /* Couleurs UTS */
    :root {
        --uts-rouge: #DC2626;
        --uts-jaune: #F59E0B;
        --uts-vert: #10B981;
        --uts-orange: #EA580C;
        --uts-blanc: #FFFFFF;
        --uts-gris-clair: #F8F9FA;
        --uts-gris-fonce: #374151;
    }

    .bg-uts-rouge { background-color: var(--uts-rouge) !important; }
    .bg-uts-jaune { background-color: var(--uts-jaune) !important; }
    .bg-uts-vert { background-color: var(--uts-vert) !important; }
    .bg-uts-orange { background-color: var(--uts-orange) !important; }

    .text-uts-rouge { color: var(--uts-rouge) !important; }
    .text-uts-jaune { color: var(--uts-jaune) !important; }
    .text-uts-vert { color: var(--uts-vert) !important; }
    .text-uts-orange { color: var(--uts-orange) !important; }

    .btn-uts-rouge {
        background-color: var(--uts-rouge);
        border-color: var(--uts-rouge);
        color: white;
    }
    .btn-uts-rouge:hover {
        background-color: #B91C1C;
        border-color: #B91C1C;
        color: white;
    }

    .btn-uts-vert {
        background-color: var(--uts-vert);
        border-color: var(--uts-vert);
        color: white;
    }
    .btn-uts-vert:hover {
        background-color: #059669;
        border-color: #059669;
        color: white;
    }

    .btn-uts-orange {
        background-color: var(--uts-orange);
        border-color: var(--uts-orange);
        color: white;
    }
    .btn-uts-orange:hover {
        background-color: #C2410C;
        border-color: #C2410C;
        color: white;
    }

    .btn-uts-jaune {
        background-color: var(--uts-jaune);
        border-color: var(--uts-jaune);
        color: white;
    }
    .btn-uts-jaune:hover {
        background-color: #D97706;
        border-color: #D97706;
        color: white;
    }

    .card-rapport {
        border-left: 4px solid var(--uts-rouge);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    }

    .card-rapport:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .carousel-item .card {
        background: linear-gradient(135deg, var(--uts-blanc) 0%, var(--uts-gris-clair) 100%);
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-radius: 12px;
    }

    .table-modern {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .table-modern thead {
        background: linear-gradient(135deg, var(--uts-rouge) 0%, var(--uts-orange) 100%);
        color: white;
    }

    .table-modern thead th {
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 15px;
    }

    .table-modern tbody tr {
        transition: background-color 0.3s ease;
    }

    .table-modern tbody tr:hover {
        background-color: rgba(16, 185, 129, 0.05);
    }

    .badge-status {
        font-size: 0.75rem;
        padding: 0.5em 0.8em;
        border-radius: 50px;
    }

    .stats-card {
        background: linear-gradient(135deg, var(--uts-blanc) 0%, var(--uts-gris-clair) 100%);
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-3px);
    }

    .header-section {
        background: linear-gradient(135deg, var(--uts-rouge) 0%, var(--uts-orange) 50%, var(--uts-jaune) 100%);
        color: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .action-buttons .btn {
        margin: 0 2px;
        border-radius: 50px;
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
    }

    .search-box {
        border-radius: 50px;
        border: 2px solid var(--uts-gris-clair);
        padding: 0.75rem 1.5rem;
        transition: border-color 0.3s ease;
    }

    .search-box:focus {
        border-color: var(--uts-vert);
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }

    @media (max-width: 768px) {
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .action-buttons .btn {
            width: 100%;
            margin: 2px 0;
        }
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="header-section text-center">
        <h1 class="mb-3">
            <i class="fas fa-file-alt me-3"></i>
            Gestion des Rapports UTS
        </h1>
        <p class="mb-0 opacity-90">Gérez et consultez tous vos rapports de manière efficace</p>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="text-uts-rouge mb-2">
                        <i class="fas fa-file-alt fa-2x"></i>
                    </div>
                    <h4 class="fw-bold">{{ $rapports->total() }}</h4>
                    <small class="text-muted">Total Rapports</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="text-uts-vert mb-2">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <h4 class="fw-bold">{{ $rapports->where('statut', 'validé')->count() ?? 0 }}</h4>
                    <small class="text-muted">Validés</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="text-uts-orange mb-2">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <h4 class="fw-bold">{{ $rapports->where('statut', 'en_attente')->count() ?? 0 }}</h4>
                    <small class="text-muted">En Attente</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stats-card text-center">
                <div class="card-body">
                    <div class="text-uts-jaune mb-2">
                        <i class="fas fa-calendar-day fa-2x"></i>
                    </div>
                    <h4 class="fw-bold">{{ $rapports->where('created_at', '>=', now()->subDays(7))->count() ?? 0 }}</h4>
                    <small class="text-muted">Cette Semaine</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel des 3 derniers rapports -->
    @if($rapports->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-3 text-uts-rouge">
                <i class="fas fa-star me-2"></i>
                Rapports Récents
            </h3>
            <div id="carouselRapports" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-indicators">
                    @foreach($rapports->take(3) as $key => $rapport)
                        <button type="button" data-bs-target="#carouselRapports" data-bs-slide-to="{{ $key }}"
                                class="{{ $key == 0 ? 'active' : '' }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach($rapports->take(3) as $key => $rapport)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div class="card card-rapport mx-auto" style="max-width: 800px;">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 class="card-title text-uts-rouge fw-bold">
                                                <i class="fas fa-file-text me-2"></i>
                                                {{ $rapport->titre }}
                                            </h5>
                                            <div class="mb-3">
                                                <span class="badge bg-uts-vert me-2">
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ $rapport->auteur->name ?? 'Anonyme' }}
                                                </span>
                                                <span class="badge bg-uts-orange">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ \Carbon\Carbon::parse($rapport->date_rapport)->format('d/m/Y') }}
                                                </span>
                                            </div>
                                            <p class="card-text text-muted">
                                                {{ Str::limit($rapport->contenu, 150) }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center justify-content-end">
                                            <a href="{{ route('rapports.show', $rapport) }}"
                                               class="btn btn-uts-rouge">
                                                <i class="fas fa-eye me-2"></i>
                                                Consulter
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselRapports" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselRapports" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Barre d'actions -->
    <div class="row mb-4">
        <div class="col-md-6">
            <a href="{{ route('rapports.create') }}" class="btn btn-uts-vert btn-lg">
                <i class="fas fa-plus-circle me-2"></i>
                Nouveau Rapport
            </a>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-uts-gris-clair border-0">
                    <i class="fas fa-search text-uts-rouge"></i>
                </span>
                <input type="text" class="form-control search-box border-start-0"
                       placeholder="Rechercher un rapport..." id="searchRapport">
            </div>
        </div>
    </div>

    <!-- Tableau des rapports -->
    <div class="table-responsive">
        <table class="table table-modern table-hover align-middle">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag me-2"></i>ID</th>
                    <th><i class="fas fa-file-alt me-2"></i>Titre</th>
                    <th><i class="fas fa-user me-2"></i>Auteur</th>
                    <th><i class="fas fa-calendar me-2"></i>Date</th>
                    <th><i class="fas fa-info-circle me-2"></i>Statut</th>
                    <th><i class="fas fa-tags me-2"></i>Catégorie</th>
                    <th class="text-center"><i class="fas fa-cog me-2"></i>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rapports as $rapport)
                <tr>
                    <td class="fw-bold text-uts-rouge">#{{ $rapport->id }}</td>
                    <td>
                        <div class="fw-bold">{{ $rapport->titre }}</div>
                        <small class="text-muted">{{ Str::limit($rapport->contenu, 50) }}</small>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-uts-vert rounded-circle me-2 d-flex align-items-center justify-content-center"
                                 style="width: 32px; height: 32px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            {{ $rapport->auteur->name ?? 'Anonyme' }}
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-uts-orange">
                            {{ \Carbon\Carbon::parse($rapport->date_rapport)->format('d/m/Y') }}
                        </span>
                    </td>
                    <td>
                        @php
                            $statut = $rapport->statut ?? 'en_attente';
                            $statutColors = [
                                'validé' => 'bg-uts-vert',
                                'en_attente' => 'bg-uts-orange',
                                'rejeté' => 'bg-uts-rouge'
                            ];
                        @endphp
                        <span class="badge {{ $statutColors[$statut] ?? 'bg-secondary' }} badge-status">
                            <i class="fas fa-{{ $statut == 'validé' ? 'check' : ($statut == 'rejeté' ? 'times' : 'clock') }} me-1"></i>
                            {{ ucfirst(str_replace('_', ' ', $statut)) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-uts-jaune">
                            <i class="fas fa-folder me-1"></i>
                            {{ $rapport->categorie ?? 'Général' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons text-center">
                            <a href="{{ route('rapports.show', $rapport) }}"
                               class="btn btn-outline-info btn-sm"
                               title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('rapports.edit', $rapport) }}"
                               class="btn btn-uts-jaune btn-sm"
                               title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button"
                                    class="btn btn-uts-rouge btn-sm"
                                    title="Supprimer"
                                    onclick="confirmDelete({{ $rapport->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                            <a href="#" class="btn btn-outline-secondary btn-sm" title="Télécharger">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>

                        <!-- Formulaire de suppression caché -->
                        <form id="delete-form-{{ $rapport->id }}"
                              action="{{ route('rapports.destroy', $rapport) }}"
                              method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block text-uts-orange"></i>
                            <h5>Aucun rapport trouvé</h5>
                            <p>Commencez par créer votre premier rapport.</p>
                            <a href="{{ route('rapports.create') }}" class="btn btn-uts-vert">
                                <i class="fas fa-plus me-2"></i>Créer un rapport
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($rapports->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Navigation des rapports">
            {{ $rapports->appends(request()->query())->links('pagination::bootstrap-4') }}
        </nav>
    </div>
    @endif
</div>

<!-- Scripts JavaScript -->
<script>
// Fonction de confirmation de suppression
function confirmDelete(rapportId) {
    if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce rapport ?\n\nCette action est irréversible.')) {
        document.getElementById('delete-form-' + rapportId).submit();
    }
}

// Fonction de recherche en temps réel
document.getElementById('searchRapport').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');

    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Animation d'apparition des éléments
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.stats-card, .card-rapport');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Tooltip Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    const tooltips = document.querySelectorAll('[title]');
    tooltips.forEach(tooltip => {
        new bootstrap.Tooltip(tooltip);
    });
});
</script>
@endsection
