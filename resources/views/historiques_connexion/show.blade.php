@extends('layouts.app')

@section('title', 'Détail Historique de Connexion')

@section('content')
<div class="container mt-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Connexion #{{ $historiqueConnexion->id }}
                    </h1>
                    <p class="text-muted mb-0">Détails de la session utilisateur</p>
                </div>
                <div>
                    @if($historiqueConnexion->etat == 'success')
                        <span class="badge bg-success fs-6">
                            <i class="fas fa-check me-1"></i>Connexion Réussie
                        </span>
                    @else
                        <span class="badge bg-danger fs-6">
                            <i class="fas fa-times me-1"></i>Connexion Échouée
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informations Utilisateur -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Utilisateur</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar avatar-lg rounded-circle bg-gradient-primary text-white me-3">
                            {{ strtoupper(substr($historiqueConnexion->user->name, 0, 2)) }}
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $historiqueConnexion->user->name }}</h6>
                            <small class="text-muted">{{ $historiqueConnexion->user->email }}</small>
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col-6">
                            <div class="p-2 border-end">
                                <div class="text-muted small">Rôle</div>
                                <strong>{{ $historiqueConnexion->user->role ?? 'Utilisateur' }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2">
                                <div class="text-muted small">Statut</div>
                                <span class="badge bg-success">Actif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations Techniques -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-desktop me-2"></i>Informations Techniques</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            <strong>Adresse IP :</strong>
                        </div>
                        <span class="badge bg-light text-dark">{{ $historiqueConnexion->ip_address }}</span>
                        @if($historiqueConnexion->pays)
                            <br><small class="text-muted mt-1">{{ $historiqueConnexion->ville }}, {{ $historiqueConnexion->pays }}</small>
                        @endif
                    </div>

                    <div class="row g-0">
                        <div class="col-6">
                            <div class="p-2 border-end">
                                @php
                                    $browserIcon = match(strtolower($historiqueConnexion->navigateur)) {
                                        'chrome' => 'fab fa-chrome text-warning',
                                        'firefox' => 'fab fa-firefox-browser text-danger',
                                        'safari' => 'fab fa-safari text-primary',
                                        'edge' => 'fab fa-edge text-info',
                                        default => 'fas fa-globe text-secondary'
                                    };
                                @endphp
                                <div class="text-muted small">Navigateur</div>
                                <div><i class="{{ $browserIcon }} me-1"></i>{{ $historiqueConnexion->navigateur }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2">
                                @php
                                    $osIcon = match(strtolower($historiqueConnexion->os)) {
                                        'windows' => 'fab fa-windows text-primary',
                                        'macos', 'mac' => 'fab fa-apple text-secondary',
                                        'linux' => 'fab fa-linux text-dark',
                                        'android' => 'fab fa-android text-success',
                                        default => 'fas fa-desktop text-secondary'
                                    };
                                @endphp
                                <div class="text-muted small">Système</div>
                                <div><i class="{{ $osIcon }} me-1"></i>{{ $historiqueConnexion->os }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Détails de la Session -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Détails de la Session</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center p-3 border-end">
                                <i class="fas fa-calendar-day fa-2x text-primary mb-2"></i>
                                <div class="text-muted small">Date de Connexion</div>
                                <strong>{{ $historiqueConnexion->connecte_le->format('d/m/Y') }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3 border-end">
                                <i class="fas fa-clock fa-2x text-info mb-2"></i>
                                <div class="text-muted small">Heure</div>
                                <strong>{{ $historiqueConnexion->connecte_le->format('H:i:s') }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <i class="fas fa-hourglass-half fa-2x text-warning mb-2"></i>
                                <div class="text-muted small">Durée Session</div>
                                <strong>
                                    @if($historiqueConnexion->duree_session)
                                        {{ $historiqueConnexion->duree_session }} min
                                    @else
                                        En cours...
                                    @endif
                                </strong>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-info">
                            <i class="fas fa-info-circle me-1"></i>
                            {{ $historiqueConnexion->connecte_le->diffForHumans() }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('historiques_connexion.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i>Retour à la liste
        </a>

        <div class="btn-group">
            @can('update', $historiqueConnexion)
            <button class="btn btn-warning btn-sm" onclick="toggleEdit()">
                <i class="fas fa-edit me-1"></i>Modifier
            </button>
            @endcan
            @can('delete', $historiqueConnexion)
            <form action="{{ route('historiques_connexion.destroy', $historiqueConnexion) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette connexion ?')">
                    <i class="fas fa-trash me-1"></i>Supprimer
                </button>
            </form>
            @endcan
        </div>
    </div>
</div>

<style>
.avatar-lg { width: 3.5rem; height: 3.5rem; font-size: 1.1rem; font-weight: 600; }
.bg-gradient-primary { background: linear-gradient(45deg, #4e73df, #224abe); }
.card { border: none; }
.card-header { border: none; font-weight: 600; }
</style>
@endsection
