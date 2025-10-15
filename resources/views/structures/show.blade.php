@extends('layouts.app')

@section('title', 'Détails de la Structure')

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
        border-radius: 12px 12px 0 0;
    }

    .structure-icon {
        background: var(--uts-yellow);
        border-radius: 50%;
        padding: 1rem;
        border: 3px solid var(--uts-cream);
        box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
    }

    .info-card {
        background: var(--uts-warm);
        border: 2px solid var(--uts-sage);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(46, 125, 50, 0.15);
    }

    .info-label {
        color: var(--uts-green);
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .info-value {
        color: var(--uts-dark);
        font-size: 1.1rem;
        font-weight: 500;
    }

    .btn-secondary {
        background: var(--uts-sage);
        border: 2px solid var(--uts-green);
        color: var(--uts-green);
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 10px;
    }

    .btn-secondary:hover {
        background: var(--uts-green);
        border-color: var(--uts-green-dark);
        color: var(--uts-cream);
        transform: translateY(-1px);
    }

    .btn-warning {
        background: linear-gradient(135deg, var(--uts-yellow), var(--uts-yellow-dark));
        border: 2px solid var(--uts-green);
        color: var(--uts-dark);
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 10px;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, var(--uts-yellow-dark), var(--uts-yellow));
        border-color: var(--uts-green-dark);
        color: var(--uts-dark);
        transform: translateY(-1px);
    }

    .stats-grid {
        background: var(--uts-sage);
        border: 2px solid var(--uts-yellow);
        border-radius: 15px;
        padding: 1.5rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
    }

    .stat-icon {
        background: var(--uts-yellow);
        color: var(--uts-dark);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        border: 2px solid var(--uts-green);
    }

    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .badge-active {
        background: var(--uts-sage);
        color: var(--uts-green);
        border: 2px solid var(--uts-green);
    }

    .description-box {
        background: var(--uts-cream);
        border: 2px solid var(--uts-yellow);
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .contact-info {
        background: var(--uts-warm);
        border: 2px solid var(--uts-yellow);
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
    }

    .contact-item {
        margin: 0.5rem 0;
    }

    .contact-icon {
        background: var(--uts-green);
        color: var(--uts-cream);
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-house-door"></i> Accueil
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('structures.index') }}">Structures</a>
            </li>
            <li class="breadcrumb-item active">{{ $structure->nom }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- En-tête -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="structure-icon me-4">
                            <i class="bi bi-building fs-3" style="color: var(--uts-dark);"></i>
                        </div>
                        <div class="text-center">
                            <h2 class="text-white mb-1 fw-bold">{{ $structure->nom }}</h2>
                            <p class="text-white mb-0 opacity-75">
                                @if($structure->type)
                                    {{ $structure->type }}
                                    <span class="badge badge-active ms-2">Active</span>
                                @else
                                    Structure organisationnelle
                                    <span class="badge badge-active ms-2">Active</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Informations principales -->
                <div class="col-md-8 mb-4">
                    <h5 class="mb-3" style="color: var(--uts-dark);">
                        <i class="bi bi-info-circle me-2"></i>Informations de la Structure
                    </h5>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="info-card">
                                <span class="info-label">
                                    <i class="bi bi-building me-1"></i>Nom de la structure
                                </span>
                                <div class="info-value">{{ $structure->nom }}</div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <div class="info-card">
                                <span class="info-label">
                                    <i class="bi bi-tags me-1"></i>Type de structure
                                </span>
                                <div class="info-value">
                                    @if($structure->type)
                                        <span class="badge px-3 py-1" style="background: var(--uts-sage); color: var(--uts-green); border: 1px solid var(--uts-green);">
                                            {{ $structure->type }}
                                        </span>
                                    @else
                                        Non spécifié
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(isset($structure->code))
                        <div class="col-sm-6 mb-3">
                            <div class="info-card">
                                <span class="info-label">
                                    <i class="bi bi-qr-code me-1"></i>Code structure
                                </span>
                                <div class="info-value">
                                    <span class="badge px-3 py-1" style="background: var(--uts-yellow); color: var(--uts-dark); border: 1px solid var(--uts-green);">
                                        {{ $structure->code }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-sm-6 mb-3">
                            <div class="info-card">
                                <span class="info-label">
                                    <i class="bi bi-person-badge me-1"></i>Responsable
                                </span>
                                <div class="info-value">{{ $structure->responsable ?? 'Non assigné' }}</div>
                            </div>
                        </div>

                        @if(isset($structure->statut))
                        <div class="col-sm-6 mb-3">
                            <div class="info-card">
                                <span class="info-label">
                                    <i class="bi bi-check-circle me-1"></i>Statut
                                </span>
                                <div class="info-value">
                                    @if($structure->statut == 'active')
                                        <span class="badge px-3 py-1" style="background: var(--uts-green); color: var(--uts-cream);">
                                            <i class="bi bi-check-circle me-1"></i>Active
                                        </span>
                                    @elseif($structure->statut == 'inactive')
                                        <span class="badge px-3 py-1" style="background: var(--uts-red); color: var(--uts-cream);">
                                            <i class="bi bi-x-circle me-1"></i>Inactive
                                        </span>
                                    @else
                                        <span class="badge px-3 py-1" style="background: var(--uts-yellow); color: var(--uts-dark);">
                                            <i class="bi bi-clock me-1"></i>En cours
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Description -->
                    @if($structure->description)
                    <div class="description-box">
                        <h6 style="color: var(--uts-green);" class="mb-2">
                            <i class="bi bi-card-text me-2"></i>Description
                        </h6>
                        <p class="mb-0" style="color: var(--uts-dark);">{{ $structure->description }}</p>
                    </div>
                    @endif
                </div>

                <!-- Informations de contact et métadonnées -->
                <div class="col-md-4">
                    <!-- Contact -->
                    @if($structure->contact || isset($structure->email))
                    <div class="contact-info mb-4">
                        <h6 class="text-center mb-3" style="color: var(--uts-dark);">
                            <i class="bi bi-person-lines-fill me-2"></i>Contact
                        </h6>

                        @if($structure->contact)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <span style="color: var(--uts-dark); font-weight: 500;">{{ $structure->contact }}</span>
                        </div>
                        @endif

                        @if(isset($structure->email) && $structure->email)
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <span style="color: var(--uts-dark); font-weight: 500;">{{ $structure->email }}</span>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Statistiques et métadonnées -->
                    <div class="stats-grid mb-4">
                        <h6 class="text-center mb-3" style="color: var(--uts-dark);">
                            <i class="bi bi-graph-up me-2"></i>Informations
                        </h6>

                        <div class="row">
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <small style="color: var(--uts-green);">Créée le</small>
                                    <div class="fw-bold" style="color: var(--uts-dark); font-size: 0.9rem;">
                                        {{ $structure->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <small style="color: var(--uts-green);">Modifiée le</small>
                                    <div class="fw-bold" style="color: var(--uts-dark); font-size: 0.9rem;">
                                        {{ $structure->updated_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations système -->
                    <div class="info-card">
                        <span class="info-label">
                            <i class="bi bi-shield-check me-1"></i>ID Système
                        </span>
                        <div class="info-value">
                            <span class="badge px-3 py-1" style="background: var(--uts-sage); color: var(--uts-green); border: 1px solid var(--uts-green);">
                                #{{ str_pad($structure->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-3 mt-4">
                <a href="{{ route('structures.index') }}"
                   class="btn btn-secondary d-flex align-items-center justify-content-center">
                    <i class="bi bi-arrow-left me-2"></i>
                    Retour à la liste
                </a>

                <div class="d-flex gap-2">
                    <a href="{{ route('structures.edit', $structure) }}"
                       class="btn btn-warning d-flex align-items-center">
                        <i class="bi bi-pencil me-2"></i>
                        Modifier cette structure
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes d'information
    const infoCards = document.querySelectorAll('.info-card');

    infoCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }, index * 100);
    });
});
</script>
@endpush
@endsection
