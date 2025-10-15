@extends('layouts.app')

@section('title', 'Liste des Octrois')

@push('styles')
<style>
    :root {
        --uts-yellow: #FFC107;
        --uts-green: #28A745;
        --uts-red: #DC3545;
        --uts-dark: #2C3E50;
        --uts-light: #F8F9FA;
    }

    .page-header {
        background: linear-gradient(135deg, var(--uts-yellow) 0%, #FFB300 100%);
        color: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .card {
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        overflow: hidden;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(40, 167, 69, 0.1);
        transition: background-color 0.2s ease;
    }

    .table thead th {
        background: var(--uts-dark);
        color: white;
        border: none;
        font-weight: 600;
        padding: 1rem 0.75rem;
    }

    .btn-success {
        background: var(--uts-green);
        border-color: var(--uts-green);
        font-weight: 600;
        border-radius: 8px;
        padding: 0.5rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: #218838;
        border-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-sm {
        font-size: 0.8rem;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-weight: 500;
    }

    .btn-info {
        background: #17A2B8;
        border-color: #17A2B8;
    }

    .btn-warning {
        background: var(--uts-yellow);
        border-color: var(--uts-yellow);
        color: #333;
    }

    .btn-danger {
        background: var(--uts-red);
        border-color: var(--uts-red);
    }

    .badge {
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0.5em 0.75em;
        border-radius: 6px;
    }

    .bg-success {
        background-color: var(--uts-green) !important;
    }

    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        border: 1px solid rgba(40, 167, 69, 0.2);
        border-left: 4px solid var(--uts-green);
        color: #155724;
        border-radius: 8px;
    }

    .stats-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-number {
        font-size: 2rem;
        font-weight: bold;
        color: var(--uts-green);
    }

    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-2">
                    <i class="bi bi-box-seam me-2"></i>
                    Liste des Octrois
                </h2>
                <p class="mb-0 opacity-75">Gestion des attributions de matériel</p>
            </div>
            <a href="{{ route('octrois.create') }}" class="btn btn-success btn-lg">
                <i class="bi bi-plus-circle me-2"></i>
                Nouvel Octroi
            </a>
        </div>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $octrois->total() ?? $octrois->count() }}</div>
                <div class="text-muted">Total Octrois</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $octrois->where('created_at', '>=', now()->startOfMonth())->count() ?? 0 }}</div>
                <div class="text-muted">Ce Mois</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $octrois->sum('quantite') ?? 0 }}</div>
                <div class="text-muted">Qté Totale</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-number">{{ $octrois->groupBy('structure_id')->count() ?? 0 }}</div>
                <div class="text-muted">structures</div>
            </div>
        </div>
    </div>

    <!-- Tableau des octrois -->
    <div class="card">
        <div class="card-body p-0">
            @if($octrois->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="80">#</th>
                                <th>Matériel</th>
                                <th>Structure</th>
                                <th width="100">Quantité</th>
                                <th width="150">Date d'Octroi</th>
                                <th width="200" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($octrois as $octroi)
                                <tr>
                                    <td class="fw-bold">{{ $octroi->id }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $octroi->materiel->nom ?? $octroi->name }}</div>
                                        <small class="text-muted">{{ $octroi->materiel->code ?? '' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $octroi->structure->nom ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $octroi->quantite }}</span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $octroi->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('octrois.show', $octroi->id) }}"
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('octrois.edit', $octroi->id) }}"
                                               class="btn btn-sm btn-warning" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('octrois.destroy', $octroi->id) }}"
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Confirmer la suppression ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if(method_exists($octrois, 'links'))
                    <div class="d-flex justify-content-center p-4 border-top">
                        {{ $octrois->links() }}
                    </div>
                @endif
            @else
                <!-- État vide -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h4 class="text-muted mb-3">Aucun octroi enregistré</h4>
                    <p class="text-muted mb-4">Commencez par créer votre premier octroi</p>
                    <a href="{{ route('octrois.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>
                        Créer un octroi
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Animation au chargement des cartes statistiques
document.addEventListener('DOMContentLoaded', function() {
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Confirmation de suppression améliorée
document.querySelectorAll('form[method="POST"]').forEach(form => {
    if (form.querySelector('input[name="_method"][value="DELETE"]')) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (confirm('⚠️ Confirmer la suppression ?\n\nCette action est irréversible.')) {
                this.submit();
            }
        });
    }
});
</script>
@endpush

@endsection
