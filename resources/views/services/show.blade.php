@extends('layouts.app')

@section('title', 'Détails du Service')

@push('styles')
<style>
    :root {
        --uts-yellow: #FFD700;
        --uts-yellow-light: #FFEB3B;
        --uts-yellow-dark: #F57C00;
        --uts-green: #2E7D32;
        --uts-green-light: #66BB6A;
        --uts-green-dark: #1B5E20;
        --uts-red: #D32F2F;
        --uts-dark: #2C3E50;
        --uts-cream: #FFF8E1;
        --uts-sage: #E8F5E8;
        --uts-warm: #FFFDE7;
        --gradient-primary: linear-gradient(135deg, var(--uts-green), var(--uts-green-light));
        --gradient-secondary: linear-gradient(135deg, var(--uts-yellow), var(--uts-yellow-light));
    }

    body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Breadcrumb moderne */
    .modern-breadcrumb {
        background: white;
        border: none;
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .breadcrumb-item a {
        color: var(--uts-green);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: var(--uts-yellow-dark);
        transform: translateX(3px);
    }

    /* Hero Header */
    .hero-header {
        background: var(--gradient-primary);
        border-radius: 20px;
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .hero-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,215,0,0.3) 0%, transparent 70%);
        transform: translate(50%, -50%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .service-id-badge {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
    }

    /* Cards Grid */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .detail-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .detail-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .detail-card-header {
        background: var(--gradient-secondary);
        padding: 1.5rem;
        color: var(--uts-dark);
        position: relative;
    }

    .detail-card-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }

    .detail-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .detail-card-title i {
        margin-right: 0.75rem;
        font-size: 1.2rem;
    }

    .detail-card-body {
        padding: 2rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f3f4;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 600;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--uts-dark);
    }

    /* Status Badges */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-actif {
        background: var(--gradient-primary);
        color: white;
    }

    .status-inactif {
        background: linear-gradient(135deg, var(--uts-red), #ff6b6b);
        color: white;
    }

    .status-maintenance {
        background: var(--gradient-secondary);
        color: var(--uts-dark);
    }

    .priority-haute {
        background: linear-gradient(135deg, var(--uts-red), #ff6b6b);
        color: white;
    }

    .priority-moyenne {
        background: var(--gradient-secondary);
        color: var(--uts-dark);
    }

    .priority-basse {
        background: var(--gradient-primary);
        color: white;
    }

    .quantity-display {
        text-align: center;
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 15px;
        margin: 1rem 0;
    }

    .quantity-number {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .quantity-high {
        color: var(--uts-green);
    }

    .quantity-medium {
        color: var(--uts-yellow-dark);
    }

    .quantity-low {
        color: var(--uts-red);
    }

    /* Description Section */
    .description-section {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .description-content {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
        border-left: 4px solid var(--uts-yellow);
        margin-top: 1rem;
    }

    .empty-description {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }

    .empty-description i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Actions Section */
    .actions-section {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .action-btn {
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .btn-edit {
        background: var(--gradient-secondary);
        color: var(--uts-dark);
        border: 2px solid var(--uts-yellow-dark);
    }

    .btn-edit:hover {
        color: var(--uts-dark);
        box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
    }

    .btn-delete {
        background: linear-gradient(135deg, var(--uts-red), #dc2626);
        color: white;
        border: 2px solid var(--uts-red);
    }

    .btn-delete:hover {
        color: white;
        box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
    }

    .btn-back {
        background: var(--gradient-primary);
        color: white;
        border: 2px solid var(--uts-green);
    }

    .btn-back:hover {
        color: white;
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.4);
    }

    /* Modal Improvements */
    .modal-content {
        border: none;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.25);
        overflow: hidden;
    }

    .modal-header {
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: 2rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        padding: 1.5rem 2rem 2rem;
        border: none;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .details-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .hero-header {
            padding: 1.5rem;
        }

        .detail-card-body {
            padding: 1.5rem;
        }

        .quantity-number {
            font-size: 2rem;
        }

        .action-btn {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .detail-card {
        animation: fadeInUp 0.6s ease forwards;
    }

    .detail-card:nth-child(1) { animation-delay: 0.1s; }
    .detail-card:nth-child(2) { animation-delay: 0.2s; }
    .detail-card:nth-child(3) { animation-delay: 0.3s; }
    .detail-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">
    {{-- Breadcrumb moderne --}}
    <nav aria-label="breadcrumb" class="modern-breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-house-door me-1"></i> Accueil
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('services.index') }}">Services</a>
            </li>
            <li class="breadcrumb-item active fw-semibold">Détails du Service</li>
        </ol>
    </nav>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="me-3" style="width: 40px; height: 40px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-check-circle-fill text-white"></i>
                </div>
                <div class="flex-grow-1">
                    <strong>Succès !</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Hero Header --}}
    <div class="hero-header">
        <div class="hero-content text-center">
            <div class="service-id-badge">
                #{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
            </div>
            <h1 class="display-5 fw-bold mb-2">{{ $service->name }}</h1>
            <p class="fs-5 opacity-90 mb-0">Informations détaillées du service</p>
        </div>
    </div>

    {{-- Grille des détails --}}
    <div class="details-grid">
        {{-- Informations de base --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <h3 class="detail-card-title">
                    <i class="bi bi-info-circle"></i>
                    Informations de Base
                </h3>
            </div>
            <div class="detail-card-body">
                <div class="info-item">
                    <span class="info-label">Nom du Service</span>
                    <span class="info-value">{{ $service->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Code Service</span>
                    <span class="info-value">
                        @if($service->code_service)
                            <code class="bg-light px-2 py-1 rounded">{{ $service->code_service }}</code>
                        @else
                            <span class="text-muted">Non défini</span>
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Capacité</span>
                    <div class="quantity-display">
                        <div class="quantity-number
                            @if($service->quantite > 10) quantity-high
                            @elseif($service->quantite > 5) quantity-medium
                            @else quantity-low @endif">
                            {{ $service->quantite }}
                        </div>
                        <div class="fw-medium">
                            @if($service->quantite > 10)
                                <span class="text-success">Stock Élevé</span>
                            @elseif($service->quantite > 5)
                                <span class="text-warning">Stock Moyen</span>
                            @else
                                <span class="text-danger">Stock Faible</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gestion et Statut --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <h3 class="detail-card-title">
                    <i class="bi bi-gear-wide-connected"></i>
                    Gestion et Statut
                </h3>
            </div>
            <div class="detail-card-body">
                <div class="info-item">
                    <span class="info-label">Statut</span>
                    <span class="info-value">
                        @if($service->statut == 'actif')
                            <span class="status-badge status-actif">
                                <i class="bi bi-check-circle"></i>Actif
                            </span>
                        @elseif($service->statut == 'inactif')
                            <span class="status-badge status-inactif">
                                <i class="bi bi-x-circle"></i>Inactif
                            </span>
                        @elseif($service->statut == 'maintenance')
                            <span class="status-badge status-maintenance">
                                <i class="bi bi-tools"></i>Maintenance
                            </span>
                        @else
                            <span class="text-muted">Non défini</span>
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Priorité</span>
                    <span class="info-value">
                        @if($service->priorite == 'haute')
                            <span class="status-badge priority-haute">
                                <i class="bi bi-flag-fill"></i>Haute
                            </span>
                        @elseif($service->priorite == 'moyenne')
                            <span class="status-badge priority-moyenne">
                                <i class="bi bi-flag"></i>Moyenne
                            </span>
                        @elseif($service->priorite == 'basse')
                            <span class="status-badge priority-basse">
                                <i class="bi bi-flag"></i>Basse
                            </span>
                        @else
                            <span class="text-muted">Non définie</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Contact et Responsable --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <h3 class="detail-card-title">
                    <i class="bi bi-people"></i>
                    Contact et Responsable
                </h3>
            </div>
            <div class="detail-card-body">
                <div class="info-item">
                    <span class="info-label">Responsable</span>
                    <span class="info-value">
                        @if($service->responsable)
                            <i class="bi bi-person me-1"></i>{{ $service->responsable }}
                        @else
                            <span class="text-muted">Non défini</span>
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email Contact</span>
                    <span class="info-value">
                        @if($service->email_contact)
                            <a href="mailto:{{ $service->email_contact }}" class="text-decoration-none">
                                <i class="bi bi-envelope me-1"></i>{{ $service->email_contact }}
                            </a>
                        @else
                            <span class="text-muted">Non défini</span>
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value">
                        @if($service->telephone)
                            <a href="tel:{{ $service->telephone }}" class="text-decoration-none">
                                <i class="bi bi-phone me-1"></i>{{ $service->telephone }}
                            </a>
                        @else
                            <span class="text-muted">Non défini</span>
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Localisation</span>
                    <span class="info-value">
                        @if($service->localisation)
                            <i class="bi bi-geo-alt me-1"></i>{{ $service->localisation }}
                        @else
                            <span class="text-muted">Non définie</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Dates et Historique --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <h3 class="detail-card-title">
                    <i class="bi bi-clock-history"></i>
                    Dates et Historique
                </h3>
            </div>
            <div class="detail-card-body">
                <div class="info-item">
                    <span class="info-label">Créé le</span>
                    <span class="info-value">
                        <i class="bi bi-calendar-plus me-1"></i>
                        {{ $service->created_at->format('d/m/Y à H:i') }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Modifié le</span>
                    <span class="info-value">
                        <i class="bi bi-calendar-check me-1"></i>
                        {{ $service->updated_at->format('d/m/Y à H:i') }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Dernière modification</span>
                    <span class="info-value">
                        <small class="text-muted">
                            {{ $service->updated_at->diffForHumans() }}
                        </small>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Description --}}
    <div class="description-section">
        <h3 class="fw-bold mb-0 d-flex align-items-center">
            <i class="bi bi-file-text me-2"></i>
            Description du Service
        </h3>
        <div class="description-content">
            @if($service->description)
                <p class="mb-0 lh-lg">{{ $service->description }}</p>
            @else
                <div class="empty-description">
                    <i class="bi bi-file-earmark-x"></i>
                    <h5 class="text-muted">Aucune description disponible</h5>
                    <p class="text-muted mb-0">Ce service n'a pas encore de description détaillée.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Actions --}}
    <div class="actions-section">
        <h3 class="fw-bold mb-4 d-flex align-items-center">
            <i class="bi bi-lightning me-2"></i>
            Actions Disponibles
        </h3>

        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('services.index') }}" class="action-btn btn-back w-100">
                    <i class="bi bi-arrow-left-circle"></i>
                    Retour à la Liste
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('services.edit', $service->id) }}" class="action-btn btn-edit w-100">
                    <i class="bi bi-pencil-square"></i>
                    Modifier le Service
                </a>
            </div>
            <div class="col-md-4">
                <button type="button" class="action-btn btn-delete w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i>
                    Supprimer le Service
                </button>
            </div>
        </div>

        <hr class="my-4">

        <div class="row g-2">
            <div class="col-4">
                <button class="btn btn-outline-secondary w-100" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>
                    <span class="d-none d-md-inline">Imprimer</span>
                </button>
            </div>
            <div class="col-4">
                <button class="btn btn-outline-info w-100" onclick="shareService()">
                    <i class="bi bi-share me-1"></i>
                    <span class="d-none d-md-inline">Partager</span>
                </button>
            </div>
            <div class="col-4">
                <button class="btn btn-outline-success w-100" onclick="exportService()">
                    <i class="bi bi-download me-1"></i>
                    <span class="d-none d-md-inline">Exporter</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal de suppression --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3" style="width: 80px; height: 80px; background: var(--gradient-secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-size: 2rem; color: var(--uts-dark);">
                    <i class="bi bi-trash"></i>
                </div>
                <h6 class="fw-bold mb-2">Supprimer "{{ $service->name }}" ?</h6>
                <p class="text-muted mb-0">Cette action est définitive et ne peut pas être annulée.</p>

                <div class="alert alert-warning mt-3" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-info-circle me-2 mt-1"></i>
                        <div class="text-start small">
                            <strong>Informations qui seront supprimées :</strong>
                            <ul class="mb-0 mt-1">
                                <li>Service : {{ $service->name }}</li>
                                <li>Capacité : {{ $service->quantite }} unités</li>
                                @if($service->responsable)
                                    <li>Responsable : {{ $service->responsable }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Annuler
                </button>
                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée pour les cartes
    const cards = document.querySelectorAll('.detail-card, .description-section, .actions-section');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Fonction de partage
function shareService() {
    if (navigator.share) {
        navigator.share({
            title: 'Service: {{ $service->name }}',
            text: 'Détails du service {{ $service->name }} - Capacité: {{ $service->quantite }}',
            url: window.location.href
        });
    } else {
        // Fallback: copier l'URL
        navigator.clipboard.writeText(window.location.href).then(() => {
            showToast('Lien copié dans le presse-papier !', 'success');
        });
    }
}

// Fonction d'export
function exportService() {
    const serviceData = {
        id: {{ $service->id }},
        nom: '{{ $service->name }}',
        code_service: '{{ $service->code_service ?? "" }}',
        quantite: {{ $service->quantite }},
        statut: '{{ $service->statut ?? "" }}',
        priorite: '{{ $service->priorite ?? "" }}',
        responsable: '{{ $service->responsable ?? "" }}',
        email_contact: '{{ $service->email_contact ?? "" }}',
        telephone: '{{ $service->telephone ?? "" }}',
        localisation: '{{ $service->localisation ?? "" }}',
        description: '{{ str_replace(["\r", "\n", "'"], ["", " ", "\'"], $service->description ?? "") }}',
        created_at: '{{ $service->created_at->format("d/m/Y H:i") }}',
        updated_at: '{{ $service->updated_at->format("d/m/Y H:i") }}'
    };

    const dataStr = JSON.stringify(serviceData, null, 2);
    const dataBlob = new Blob([dataStr], {type: 'application/json'});
    const url = URL.createObjectURL(dataBlob);

    const link = document.createElement('a');
    link.href = url;
    link.download = 'service_{{ $service->id }}_{{ $service->name }}.json';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);

    showToast('Service exporté avec succès !', 'success');
}

// Fonction pour afficher des notifications toast
function showToast(message, type = 'success') {
    const toastContainer = document.createElement('div');
    toastContainer.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
    `;

    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show shadow-lg`;
    toast.style.cssText = `
        border: none;
        border-radius: 15px;
        animation: slideInRight 0.3s ease;
    `;

    const icon = type === 'success' ? 'check-circle-fill' : 'info-circle-fill';

    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi bi-${icon} me-2"></i>
            <span>${message}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    `;

    toastContainer.appendChild(toast);
    document.body.appendChild(toastContainer);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toastContainer.parentNode) {
            toastContainer.remove();
        }
    }, 5000);
}

// Raccourcis clavier
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + E pour modifier
    if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
        e.preventDefault();
        window.location.href = '{{ route("services.edit", $service->id) }}';
    }

    // Ctrl/Cmd + Backspace pour retour
    if ((e.ctrlKey || e.metaKey) && e.key === 'Backspace') {
        e.preventDefault();
        window.location.href = '{{ route("services.index") }}';
    }
});

// Animation pour les badges au survol
document.querySelectorAll('.status-badge').forEach(badge => {
    badge.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.05)';
        this.style.transition = 'transform 0.2s ease';
    });

    badge.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });
});

// Animation pour la section quantité
const quantityDisplay = document.querySelector('.quantity-display');
if (quantityDisplay) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const number = entry.target.querySelector('.quantity-number');
                const targetValue = parseInt(number.textContent);
                animateCounter(number, targetValue);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    observer.observe(quantityDisplay);
}

// Fonction pour animer les compteurs
function animateCounter(element, target) {
    let current = 0;
    const increment = target / 30;
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.ceil(current);
        }
    }, 50);
}

// Style pour les animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .quantity-number:hover {
        animation: pulse 0.8s infinite;
        cursor: pointer;
    }

    /* Style d'impression */
    @media print {
        .actions-section,
        .breadcrumb,
        .btn,
        .modal {
            display: none !important;
        }

        .detail-card,
        .description-section {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            break-inside: avoid;
        }

        .hero-header {
            background: #f8f9fa !important;
            color: #000 !important;
        }

        body {
            background: white !important;
        }
    }

    /* Mode sombre support */
    @media (prefers-color-scheme: dark) {
        .detail-card {
            background: #2d3748 !important;
            color: white !important;
        }

        .info-label {
            color: #a0aec0 !important;
        }

        .info-value {
            color: white !important;
        }
    }

    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        .detail-card,
        .status-badge,
        .action-btn,
        * {
            animation: none !important;
            transition: none !important;
        }
    }

    /* High contrast mode */
    @media (prefers-contrast: high) {
        .detail-card {
            border: 2px solid currentColor !important;
        }

        .status-badge {
            border: 2px solid currentColor !important;
        }
    }
`;
document.head.appendChild(style);

console.log('✨ Service details page initialized with complete information display');
</script>
@endpush
@endsection
