@extends('layouts.app')

@section('title', 'Gestion des Services')

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
        --shadow-yellow: rgba(255, 215, 0, 0.3);
        --shadow-green: rgba(46, 125, 50, 0.3);
        --gradient-primary: linear-gradient(135deg, var(--uts-green), var(--uts-green-light));
        --gradient-secondary: linear-gradient(135deg, var(--uts-yellow), var(--uts-yellow-light));
    }

    body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Header Hero Section */
    .hero-section {
        background: var(--gradient-primary);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .hero-section::before {
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
        padding: 2rem;
    }

    .hero-title {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .hero-subtitle {
        color: rgba(255,255,255,0.9);
        font-size: 1rem;
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

    /* Stats Cards Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-secondary);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
    }

    .stat-icon.primary {
        background: linear-gradient(135deg, var(--uts-green), var(--uts-green-light));
        color: white;
    }

    .stat-icon.secondary {
        background: linear-gradient(135deg, var(--uts-yellow), var(--uts-yellow-dark));
        color: var(--uts-dark);
    }

    .stat-icon.tertiary {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
    }

    .stat-icon.quaternary {
        background: linear-gradient(135deg, #f59e0b, #f97316);
        color: white;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: var(--uts-dark);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #6b7280;
        font-weight: 500;
        font-size: 0.9rem;
    }

    /* Services Grid/List Toggle */
    .view-toggle {
        background: white;
        border-radius: 15px;
        padding: 0.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .view-toggle .btn {
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        margin: 0 0.25rem;
        transition: all 0.3s ease;
    }

    .view-toggle .btn.active {
        background: var(--gradient-primary);
        color: white;
        box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
    }

    /* Services Cards Grid */
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
    }

    .service-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.08);
        position: relative;
    }

    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }

    .service-card-header {
        background: var(--gradient-primary);
        padding: 1.5rem;
        color: white;
        position: relative;
    }

    .service-card-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-secondary);
    }

    .service-id {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 0.25rem 0.75rem;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .service-name {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .service-type {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .service-card-body {
        padding: 1.5rem;
    }

    .service-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .detail-item {
        text-align: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        transition: background 0.3s ease;
    }

    .detail-item:hover {
        background: var(--uts-sage);
    }

    .detail-label {
        font-size: 0.8rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .detail-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--uts-dark);
    }

    .quantity-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .quantity-high {
        background: linear-gradient(135deg, var(--uts-green), var(--uts-green-light));
        color: white;
    }

    .quantity-medium {
        background: linear-gradient(135deg, var(--uts-yellow), var(--uts-yellow-light));
        color: var(--uts-dark);
    }

    .quantity-low {
        background: linear-gradient(135deg, var(--uts-red), #ff6b6b);
        color: white;
    }

    /* Actions */
    .service-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .action-btn {
        flex: 1;
        min-width: 100px;
        border: none;
        border-radius: 10px;
        padding: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        font-size: 0.9rem;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .btn-view {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }

    .btn-view:hover {
        color: white;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    .btn-edit {
        background: linear-gradient(135deg, var(--uts-yellow), var(--uts-yellow-dark));
        color: var(--uts-dark);
    }

    .btn-edit:hover {
        color: var(--uts-dark);
        box-shadow: 0 8px 25px var(--shadow-yellow);
    }

    .btn-delete {
        background: linear-gradient(135deg, var(--uts-red), #dc2626);
        color: white;
    }

    .btn-delete:hover {
        color: white;
        box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
    }

    /* Search et Filters */
    .search-filters {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .search-input {
        border: 2px solid #e5e7eb;
        border-radius: 15px;
        padding: 1rem 1rem 1rem 3rem;
        background: #f9fafb;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .search-input:focus {
        border-color: var(--uts-green);
        box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
        background: white;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1.1rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--gradient-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        font-size: 3rem;
        color: var(--uts-dark);
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
    @media (max-width: 1200px) {
        .services-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 1.5rem;
        }

        .hero-content {
            padding: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-card {
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .services-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .service-details {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }

        .service-actions {
            flex-direction: column;
        }

        .action-btn {
            min-width: auto;
        }

        .search-filters {
            padding: 1rem;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .view-toggle .btn {
            padding: 0.5rem 1rem;
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

    .service-card {
        animation: fadeInUp 0.6s ease forwards;
    }

    .service-card:nth-child(1) { animation-delay: 0.1s; }
    .service-card:nth-child(2) { animation-delay: 0.2s; }
    .service-card:nth-child(3) { animation-delay: 0.3s; }
    .service-card:nth-child(4) { animation-delay: 0.4s; }

    /* Utilities */
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .btn-gradient-primary {
        background: var(--gradient-primary);
        border: none;
        color: white;
        border-radius: 15px;
        padding: 1rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-gradient-primary:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(46, 125, 50, 0.4);
    }
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
            <li class="breadcrumb-item active fw-semibold">Gestion des Services</li>
        </ol>
    </nav>

    {{-- Hero Section --}}
    <div class="hero-section">
        <div class="hero-content d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h1 class="hero-title mb-0">
                    <i class="bi bi-tools me-3"></i>
                    Gestion des Services
                </h1>
                <p class="hero-subtitle mb-0">
                    Gérez efficacement vos services et suivez leurs disponibilités
                </p>
            </div>
            <div class="d-flex gap-2 mt-3 mt-lg-0">
                <button class="btn btn-light btn-sm" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>
                    Imprimer
                </button>
                <a href="{{ route('services.create') }}" class="btn btn-gradient-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    Nouveau Service
                </a>
            </div>
        </div>
    </div>

    {{-- Messages flash --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <div class="stat-icon primary me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="flex-grow-1">
                    <strong>Succès !</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistiques --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="bi bi-tools"></i>
            </div>
            <div class="stat-number">{{ $services->count() }}</div>
            <div class="stat-label">Services Total</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon secondary">
                <i class="bi bi-boxes"></i>
            </div>
            <div class="stat-number">{{ $services->sum('quantite') }}</div>
            <div class="stat-label">Quantité Totale</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon tertiary">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div class="stat-number">{{ $services->where('quantite', '>', 10)->count() }}</div>
            <div class="stat-label">Stock Élevé</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon quaternary">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-number">{{ $services->where('quantite', '<=', 5)->count() }}</div>
            <div class="stat-label">Stock Faible</div>
        </div>
    </div>

    {{-- Recherche et filtres --}}
    <div class="search-filters">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-3 mb-md-0 text-gradient fw-bold">
                    <i class="bi bi-list-ul me-2"></i>
                    Liste des Services ({{ $services->count() }})
                </h5>
            </div>
            <div class="col-md-6">
                <div class="position-relative">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="form-control search-input"
                           placeholder="Rechercher un service..."
                           id="searchInput">
                </div>
            </div>
        </div>
    </div>

    {{-- Services Grid --}}
    <div class="services-grid" id="servicesContainer">
        @forelse ($services as $service)
            <div class="service-card" data-service-name="{{ strtolower($service->name) }}">
                <div class="service-card-header">
                    <div class="service-id">
                        #{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="service-name">{{ $service->name }}</div>
                    <div class="service-type">
                        <i class="bi bi-wrench me-1"></i>
                        Service Professionnel
                    </div>
                </div>

                <div class="service-card-body">
                    {{-- Informations de base --}}
                    <div class="service-details">
                        <div class="detail-item">
                            <div class="detail-label">Code Service</div>
                            <div class="detail-value">
                                <i class="bi bi-hash me-1"></i>
                                {{ $service->code_service ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Capacité</div>
                            <div class="detail-value">
                                @if($service->quantite > 10)
                                    <span class="quantity-badge quantity-high">
                                        <i class="bi bi-check-circle"></i>
                                        {{ $service->quantite }}
                                    </span>
                                @elseif($service->quantite > 5)
                                    <span class="quantity-badge quantity-medium">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        {{ $service->quantite }}
                                    </span>
                                @else
                                    <span class="quantity-badge quantity-low">
                                        <i class="bi bi-x-circle"></i>
                                        {{ $service->quantite }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Gestion et statut --}}
                    <div class="service-details">
                        <div class="detail-item">
                            <div class="detail-label">Statut</div>
                            <div class="detail-value">
                                @if($service->statut == 'actif')
                                    <span class="badge" style="background: var(--gradient-primary); color: white;">
                                        <i class="bi bi-check-circle me-1"></i>Actif
                                    </span>
                                @elseif($service->statut == 'inactif')
                                    <span class="badge" style="background: var(--uts-red); color: white;">
                                        <i class="bi bi-x-circle me-1"></i>Inactif
                                    </span>
                                @elseif($service->statut == 'maintenance')
                                    <span class="badge" style="background: var(--gradient-secondary); color: var(--uts-dark);">
                                        <i class="bi bi-tools me-1"></i>Maintenance
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-question-circle me-1"></i>Non défini
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Priorité</div>
                            <div class="detail-value">
                                @if($service->priorite == 'haute')
                                    <span class="badge" style="background: var(--uts-red); color: white;">
                                        <i class="bi bi-flag-fill me-1"></i>Haute
                                    </span>
                                @elseif($service->priorite == 'moyenne')
                                    <span class="badge" style="background: var(--gradient-secondary); color: var(--uts-dark);">
                                        <i class="bi bi-flag me-1"></i>Moyenne
                                    </span>
                                @elseif($service->priorite == 'basse')
                                    <span class="badge" style="background: var(--uts-green); color: white;">
                                        <i class="bi bi-flag me-1"></i>Basse
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-question-circle me-1"></i>Non définie
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if($service->description)
                        <div class="mb-3">
                            <div class="detail-label mb-2">Description</div>
                            <p class="text-muted small mb-0">{{ Str::limit($service->description, 100) }}</p>
                        </div>
                    @endif

                    {{-- Responsable et contact --}}
                    @if($service->responsable || $service->email_contact || $service->telephone)
                        <div class="service-details">
                            @if($service->responsable)
                                <div class="detail-item">
                                    <div class="detail-label">Responsable</div>
                                    <div class="detail-value">
                                        <i class="bi bi-person me-1"></i>
                                        {{ $service->responsable }}
                                    </div>
                                </div>
                            @endif

                            @if($service->email_contact)
                                <div class="detail-item">
                                    <div class="detail-label">Email</div>
                                    <div class="detail-value">
                                        <i class="bi bi-envelope me-1"></i>
                                        <small>{{ $service->email_contact }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Téléphone et localisation --}}
                    @if($service->telephone || $service->localisation)
                        <div class="service-details">
                            @if($service->telephone)
                                <div class="detail-item">
                                    <div class="detail-label">Téléphone</div>
                                    <div class="detail-value">
                                        <i class="bi bi-phone me-1"></i>
                                        {{ $service->telephone }}
                                    </div>
                                </div>
                            @endif

                            @if($service->localisation)
                                <div class="detail-item">
                                    <div class="detail-label">Localisation</div>
                                    <div class="detail-value">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $service->localisation }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Dates de création et modification --}}
                    <div class="service-details">
                        <div class="detail-item">
                            <div class="detail-label">Créé le</div>
                            <div class="detail-value">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $service->created_at->format('d/m/Y') }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Modifié le</div>
                            <div class="detail-value">
                                <i class="bi bi-calendar-check me-1"></i>
                                {{ $service->updated_at->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="service-actions">
                        <a href="{{ route('services.show', $service->id) }}"
                           class="action-btn btn-view">
                            <i class="bi bi-eye me-1"></i>
                            Voir
                        </a>
                        <a href="{{ route('services.edit', $service->id) }}"
                           class="action-btn btn-edit">
                            <i class="bi bi-pencil me-1"></i>
                            Modifier
                        </a>
                        <button type="button"
                                class="action-btn btn-delete"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $service->id }}">
                            <i class="bi bi-trash me-1"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>

            {{-- Modal de suppression --}}
            <div class="modal fade" id="deleteModal{{ $service->id }}" tabindex="-1">
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
                            <div class="empty-icon mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                <i class="bi bi-trash"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Supprimer "{{ $service->name }}" ?</h6>
                            <p class="text-muted mb-0">Cette action est définitive et ne peut pas être annulée.</p>
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
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h4 class="text-gradient fw-bold mb-3">Aucun service trouvé</h4>
                    <p class="text-muted mb-4">
                        Commencez par créer votre premier service pour gérer votre activité.
                    </p>
                    <a href="{{ route('services.create') }}" class="btn btn-gradient-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>
                        Créer mon premier service
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Fonctionnalité de recherche améliorée
    const searchInput = document.getElementById('searchInput');
    const serviceCards = document.querySelectorAll('.service-card');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let visibleCount = 0;

            serviceCards.forEach(card => {
                const serviceName = card.getAttribute('data-service-name');
                const isVisible = serviceName.includes(searchTerm);

                if (isVisible) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.3s ease forwards';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Afficher un message si aucun résultat
            const container = document.getElementById('servicesContainer');
            const noResults = document.querySelector('.no-results-message');

            if (visibleCount === 0 && searchTerm !== '') {
                if (!noResults) {
                    const message = document.createElement('div');
                    message.className = 'col-12 no-results-message';
                    message.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-search"></i>
                            </div>
                            <h5 class="text-muted mb-2">Aucun service trouvé</h5>
                            <p class="text-muted mb-0">
                                Aucun service ne correspond à votre recherche "<strong>${searchTerm}</strong>"
                            </p>
                        </div>
                    `;
                    container.appendChild(message);
                }
            } else if (noResults) {
                noResults.remove();
            }
        });
    }

    // Animation au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observer les cartes de services
    serviceCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });

    // Effet de survol sur les statistiques
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Confirmation avant suppression
    const deleteButtons = document.querySelectorAll('[data-bs-target^="#deleteModal"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const serviceName = this.closest('.service-card').querySelector('.service-name').textContent;
            const modalId = this.getAttribute('data-bs-target');
            const modal = document.querySelector(modalId);
            if (modal) {
                const serviceNameSpan = modal.querySelector('.modal-body h6');
                if (serviceNameSpan) {
                    serviceNameSpan.innerHTML = `Supprimer "<strong>${serviceName}</strong>" ?`;
                }
            }
        });
    });

    // Ajout d'effets de parallax légers sur le hero
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero-section');
        if (hero) {
            const speed = scrolled * 0.2;
            hero.style.transform = `translateY(${speed}px)`;
        }
    });

    // Compteur animé pour les statistiques
    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.ceil(current);
            }
        }, 20);
    }

    // Observer les compteurs statistiques
    const statNumbers = document.querySelectorAll('.stat-number');
    const statsObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.textContent);
                animateCounter(entry.target, target);
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    statNumbers.forEach(number => {
        statsObserver.observe(number);
    });

    // Smooth scroll pour les ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Gestion des états de chargement pour les boutons
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(button => {
        if (button.tagName === 'A') {
            button.addEventListener('click', function() {
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Chargement...';
                this.classList.add('disabled');

                // Restaurer après un délai (simulation)
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.classList.remove('disabled');
                }, 1000);
            });
        }
    });

    // Raccourcis clavier
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K pour focus sur la recherche
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }

        // Escape pour effacer la recherche
        if (e.key === 'Escape' && document.activeElement === searchInput) {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
            searchInput.blur();
        }
    });

    // Ajout d'un indicateur de recherche active
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('search-active');
        });

        searchInput.addEventListener('blur', function() {
            if (this.value === '') {
                this.parentElement.classList.remove('search-active');
            }
        });
    }

    // Notification toast personnalisée pour les actions
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

        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
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

    // Style pour l'animation du toast
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

        .search-active {
            transform: scale(1.02);
            transition: transform 0.2s ease;
        }

        .search-active .search-input {
            border-color: var(--uts-green) !important;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1) !important;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.6;
        }

        /* Animation pour les cartes au hover */
        .service-card {
            transform-origin: center;
        }

        .service-card:hover .service-card-header::after {
            animation: shimmer 1s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Responsive touch improvements */
        @media (max-width: 768px) {
            .service-card:active {
                transform: scale(0.98);
            }

            .stat-card:active {
                transform: scale(0.95);
            }
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .service-card {
                border: 2px solid currentColor;
            }

            .stat-card {
                border: 2px solid currentColor;
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            .service-card,
            .stat-card,
            .btn,
            * {
                animation: none !important;
                transition: none !important;
                transform: none !important;
            }
        }

        /* Dark mode support (if needed) */
        @media (prefers-color-scheme: dark) {
            :root {
                --uts-cream: #2a2a2a;
                --uts-sage: #1a1a1a;
                --uts-warm: #333;
                --uts-dark: #fff;
            }
        }
    `;
    document.head.appendChild(style);

    console.log('✨ Services management page initialized with modern features');
});
</script>
@endpush
@endsection
