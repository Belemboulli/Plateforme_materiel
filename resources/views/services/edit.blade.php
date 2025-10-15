@extends('layouts.app')

@section('title', 'Modifier un Service')

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

    /* Hero Header */
    .hero-header {
        background: var(--gradient-secondary);
        border-radius: 20px;
        color: var(--uts-dark);
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
        background: radial-gradient(circle, rgba(46, 125, 50, 0.3) 0%, transparent 70%);
        transform: translate(50%, -50%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .hero-icon {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        flex-shrink: 0;
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

    /* Current Info Card */
    .current-info-card {
        background: var(--uts-sage);
        border: 2px solid var(--uts-green);
        border-left: 5px solid var(--uts-green);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .current-info-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(46, 125, 50, 0.1) 0%, transparent 70%);
        transform: translate(50%, -50%);
    }

    .current-info-content {
        position: relative;
        z-index: 2;
    }

    /* Form Wizard */
    .form-wizard {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .form-header {
        background: var(--gradient-primary);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .form-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-secondary);
    }

    .form-section {
        padding: 2rem;
        border-bottom: 1px solid #f1f3f4;
        position: relative;
        transition: all 0.3s ease;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section:hover {
        background: #fafbfc;
        transform: translateX(5px);
        border-left: 4px solid var(--uts-yellow);
    }

    .section-title {
        color: var(--uts-dark);
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--uts-yellow);
    }

    .section-title i {
        color: var(--uts-green);
        margin-right: 1rem;
        font-size: 1.3rem;
        width: 30px;
        text-align: center;
    }

    .form-floating {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .form-floating .form-control,
    .form-floating .form-select {
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 1.2rem 1rem;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        background: white;
        color: var(--uts-dark);
        min-height: 58px;
    }

    .form-floating .form-control:focus,
    .form-floating .form-select:focus {
        border-color: var(--uts-green);
        box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.15);
        background: white;
        outline: none;
        transform: translateY(-1px);
    }

    .form-floating > label {
        color: var(--uts-dark);
        font-weight: 600;
        padding-left: 1rem;
        transition: all 0.2s ease;
    }

    .form-floating > label i {
        margin-right: 0.5rem;
        color: var(--uts-green);
    }

    .required-field::after {
        content: " *";
        color: var(--uts-red);
        font-weight: bold;
        font-size: 1.1rem;
    }

    .form-helper {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 0.5rem;
        padding: 0.5rem 1rem;
        background: var(--uts-sage);
        border-radius: 8px;
        border-left: 3px solid var(--uts-yellow);
        position: relative;
    }

    .form-helper::before {
        content: "💡";
        margin-right: 0.5rem;
    }

    .old-value-indicator {
        font-size: 0.8rem;
        color: #6b7280;
        font-style: italic;
        margin-top: 0.5rem;
        padding: 0.4rem 0.8rem;
        background: rgba(255, 215, 0, 0.1);
        border-radius: 6px;
        border-left: 3px solid var(--uts-yellow-dark);
        position: relative;
    }

    .old-value-indicator::before {
        content: "📝";
        margin-right: 0.5rem;
    }

    /* Character Counter */
    .char-counter {
        position: absolute;
        bottom: 0.5rem;
        right: 1rem;
        font-size: 0.75rem;
        color: #9ca3af;
        background: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        z-index: 10;
    }

    /* Comparison Section */
    .comparison-section {
        background: var(--uts-warm);
        border: 1px solid var(--uts-yellow);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .comparison-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        background: white;
        border-radius: 8px;
        border-left: 4px solid var(--uts-green);
    }

    .comparison-item:last-child {
        margin-bottom: 0;
    }

    .comparison-label {
        font-weight: 600;
        color: var(--uts-dark);
    }

    .comparison-value {
        font-weight: 500;
        color: #6b7280;
    }

    /* Timestamp Info */
    .timestamp-info {
        background: rgba(108, 117, 125, 0.05);
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-left: 4px solid #6c757d;
    }

    /* Actions Section */
    .actions-section {
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 0 0 20px 20px;
    }

    .btn {
        border-radius: 15px;
        font-weight: 700;
        padding: 1rem 2rem;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        margin: 0.25rem;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: var(--gradient-primary);
        border: 2px solid var(--uts-green);
        color: white;
    }

    .btn-primary:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.4);
    }

    .btn-outline-secondary {
        border: 2px solid var(--uts-dark);
        color: var(--uts-dark);
        background: white;
    }

    .btn-outline-secondary:hover {
        background: var(--uts-dark);
        border-color: var(--uts-dark);
        color: white;
        transform: translateY(-2px);
    }

    .btn-outline-warning {
        border: 2px solid var(--uts-yellow-dark);
        color: var(--uts-yellow-dark);
        background: white;
    }

    .btn-outline-warning:hover {
        background: var(--gradient-secondary);
        border-color: var(--uts-yellow-dark);
        color: var(--uts-dark);
        transform: translateY(-2px);
    }

    .btn-outline-info {
        border: 2px solid #17a2b8;
        color: #17a2b8;
        background: white;
    }

    .btn-outline-info:hover {
        background: #17a2b8;
        border-color: #17a2b8;
        color: white;
        transform: translateY(-2px);
    }

    /* Error States */
    .alert-danger {
        background: rgba(220, 53, 69, 0.1);
        border: 2px solid var(--uts-red);
        border-left: 5px solid var(--uts-red);
        border-radius: 15px;
        color: var(--uts-red);
        font-weight: 600;
        margin-bottom: 2rem;
    }

    .is-invalid {
        border-color: var(--uts-red) !important;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15) !important;
        animation: shake 0.5s ease-in-out;
    }

    .invalid-feedback {
        color: var(--uts-red);
        font-weight: 600;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        padding: 0.5rem;
        background: rgba(220, 53, 69, 0.1);
        border-radius: 8px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .hero-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .form-section {
            padding: 1.5rem;
        }

        .actions-section {
            padding: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.85rem;
            width: 100%;
            margin: 0.25rem 0;
        }

        .comparison-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .form-section {
            padding: 1rem;
        }

        .hero-header {
            padding: 1.5rem;
        }

        .char-counter {
            position: static;
            text-align: right;
            margin-top: 0.25rem;
            font-size: 0.7rem;
        }
    }

    /* Animations */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-section {
        animation: fadeInUp 0.6s ease forwards;
    }

    .form-section:nth-child(1) { animation-delay: 0.1s; }
    .form-section:nth-child(2) { animation-delay: 0.2s; }
    .form-section:nth-child(3) { animation-delay: 0.3s; }
    .form-section:nth-child(4) { animation-delay: 0.4s; }

    /* Utilities */
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
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
            <li class="breadcrumb-item">
                <a href="{{ route('services.index') }}">Services</a>
            </li>
            <li class="breadcrumb-item active fw-semibold">Modifier {{ $service->name }}</li>
        </ol>
    </nav>

    {{-- Hero Header --}}
    <div class="hero-header">
        <div class="hero-content">
            <div class="hero-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div>
                <h1 class="display-6 fw-bold mb-2">Modifier le Service</h1>
                <p class="fs-5 opacity-90 mb-0">Mise à jour des informations de "{{ $service->name }}"</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            {{-- Informations actuelles --}}
            <div class="current-info-card">
                <div class="current-info-content d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-3 text-success fs-4"></i>
                    <div>
                        <h5 class="mb-1 fw-bold">Service actuel : "{{ $service->name }}"</h5>
                        <p class="mb-0 text-muted">
                            <i class="bi bi-clock me-1"></i>
                            Dernière modification : {{ $service->updated_at->format('d/m/Y à H:i') }}
                            <span class="ms-2 text-info">({{ $service->updated_at->diffForHumans() }})</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Messages d'erreur --}}
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <div class="d-flex">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Erreurs détectées :</strong>
                            <ul class="mb-0 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Formulaire principal --}}
            <div class="form-wizard">
                <div class="form-header">
                    <h3 class="fw-bold mb-2">
                        <i class="bi bi-gear-wide-connected me-2"></i>
                        Formulaire de Modification
                    </h3>
                    <p class="mb-0 opacity-75">Modifiez les informations du service ci-dessous</p>
                </div>

                <form action="{{ route('services.update', $service->id) }}" method="POST" class="needs-validation" novalidate id="editServiceForm">
                    @csrf
                    @method('PUT')

                    {{-- Section 1: Informations de base --}}
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="bi bi-info-circle"></i>
                            Informations de Base
                        </h4>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $service->name) }}"
                                           placeholder="Nom du service"
                                           maxlength="100"
                                           required>
                                    <label for="name" class="required-field">
                                        <i class="bi bi-gear"></i>Nom du Service
                                    </label>
                                    <div class="char-counter">
                                        <span id="name-count">{{ strlen(old('name', $service->name)) }}</span>/100
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="old-value-indicator">
                                    Valeur actuelle : {{ $service->name }}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="text"
                                           name="code_service"
                                           id="code_service"
                                           class="form-control @error('code_service') is-invalid @enderror"
                                           value="{{ old('code_service', $service->code_service) }}"
                                           placeholder="Code du service"
                                           maxlength="10"
                                           style="text-transform: uppercase;">
                                    <label for="code_service">
                                        <i class="bi bi-hash"></i>Code Service
                                    </label>
                                    <div class="char-counter">
                                        <span id="code-count">{{ strlen(old('code_service', $service->code_service ?? '')) }}</span>/10
                                    </div>
                                    @error('code_service')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="old-value-indicator">
                                    Valeur actuelle : {{ $service->code_service ?? 'Non défini' }}
                                </div>
                            </div>
                        </div>

                        <div class="form-floating">
                            <textarea name="description"
                                      id="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      style="height: 120px;"
                                      maxlength="500"
                                      placeholder="Description détaillée du service">{{ old('description', $service->description) }}</textarea>
                            <label for="description">
                                <i class="bi bi-card-text"></i>Description du Service
                            </label>
                            <div class="char-counter">
                                <span id="desc-count">{{ strlen(old('description', $service->description ?? '')) }}</span>/500
                            </div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-helper">
                            Modifiez la description des activités et fonctionnalités du service
                        </div>
                    </div>

                    {{-- Section 2: Gestion et Capacité --}}
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="bi bi-sliders"></i>
                            Gestion et Capacité
                        </h4>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-floating">
                                    <input type="number"
                                           name="quantite"
                                           id="quantite"
                                           class="form-control @error('quantite') is-invalid @enderror"
                                           value="{{ old('quantite', $service->quantite) }}"
                                           placeholder="Capacité"
                                           min="1"
                                           max="9999"
                                           required>
                                    <label for="quantite" class="required-field">
                                        <i class="bi bi-speedometer"></i>Capacité
                                    </label>
                                    @error('quantite')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="old-value-indicator">
                                    Valeur actuelle : {{ $service->quantite }}
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-floating">
                                    <select name="statut"
                                            id="statut"
                                            class="form-select @error('statut') is-invalid @enderror">
                                        <option value="">-- Sélectionnez le statut --</option>
                                        <option value="actif" {{ old('statut', $service->statut) == 'actif' ? 'selected' : '' }}>
                                            ✅ Actif
                                        </option>
                                        <option value="inactif" {{ old('statut', $service->statut) == 'inactif' ? 'selected' : '' }}>
                                            ❌ Inactif
                                        </option>
                                        <option value="maintenance" {{ old('statut', $service->statut) == 'maintenance' ? 'selected' : '' }}>
                                            🔧 En Maintenance
                                        </option>
                                    </select>
                                    <label for="statut">
                                        <i class="bi bi-toggle-on"></i>Statut du Service
                                    </label>
                                    @error('statut')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="old-value-indicator">
                                    Valeur actuelle : {{ ucfirst($service->statut ?? 'Non défini') }}
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-floating">
                                    <select name="priorite"
                                            id="priorite"
                                            class="form-select @error('priorite') is-invalid @enderror">
                                        <option value="">-- Sélectionnez la priorité --</option>
                                        <option value="haute" {{ old('priorite', $service->priorite) == 'haute' ? 'selected' : '' }}>
                                            🔴 Haute Priorité
                                        </option>
                                        <option value="moyenne" {{ old('priorite', $service->priorite) == 'moyenne' ? 'selected' : '' }}>
                                            🟡 Priorité Moyenne
                                        </option>
                                        <option value="basse" {{ old('priorite', $service->priorite) == 'basse' ? 'selected' : '' }}>
                                            🟢 Basse Priorité
                                        </option>
                                    </select>
                                    <label for="priorite">
                                        <i class="bi bi-flag"></i>Niveau de Priorité
                                    </label>
                                    @error('priorite')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="old-value-indicator">
                                    Valeur actuelle : {{ ucfirst($service->priorite ?? 'Non définie') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Contact et Localisation --}}
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="bi bi-people"></i>
                            Contact et Localisation
                        </h4>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="text"
                                           name="responsable"
                                           id="responsable"
                                           class="form-control @error('responsable') is-invalid @enderror"
                                           value="{{ old('responsable', $service->responsable) }}"
                                           placeholder="Nom du responsable"
                                           maxlength="100">
                                    <label for="responsable">
                                        <i class="bi bi-person"></i>Responsable du Service
                                    </label>
                                    @error('responsable')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="old-value-indicator">
                                    Valeur actuelle : {{ $service->responsable ?? 'Non défini' }}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="email"
                                           name="email_contact"
                                           id="email_contact"
                                           class="form-control @error('email_contact') is-invalid @enderror"
                                           value="{{ old('email_contact', $service->email_contact) }}"
                                           placeholder="email@exemple.com">
                                    <label for="email_contact">
                                        <i class="bi bi-envelope"></i>Email de Contact
                                    </label>
                                    @error('email_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="old-value-indicator">
                                    Valeur actuelle : {{ $service->email_contact ?? 'Non défini' }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="tel"
                                           name="telephone"
                                           id="telephone"
                                           class="form-control @error('telephone') is-invalid @enderror"
                                           value="{{ old('telephone', $service->telephone) }}"
                                           placeholder="+226 XX XX XX XX">
                                    <label for="telephone">
                                        <i class="bi bi-phone"></i>Téléphone
                                    </label>
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="old-value-indicator">
                                    Valeur actuelle : {{ $service->telephone ?? 'Non défini' }}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="text"
                                           name="localisation"
                                           id="localisation"
                                           class="form-control @error('localisation') is-invalid @enderror"
                                           value="{{ old('localisation', $service->localisation) }}"
                                           placeholder="Bâtiment, étage, bureau..."
                                           maxlength="150">
                                    <label for="localisation">
                                        <i class="bi bi-geo-alt"></i>Localisation
                                    </label>
                                    @error('localisation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="old-value-indicator">
                                    Valeur actuelle : {{ $service->localisation ?? 'Non définie' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section Comparaison des changements --}}
                    <div class="form-section">
                        <h4 class="section-title">
                            <i class="bi bi-arrow-left-right"></i>
                            Résumé des Modifications
                        </h4>

                        <div class="comparison-section">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="bi bi-eye me-2"></i>
                                Aperçu des changements (mis à jour en temps réel)
                            </h6>

                            <div id="changes-summary">
                                <p class="text-muted text-center py-3">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Modifiez les champs ci-dessus pour voir un aperçu des changements
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Informations temporelles --}}
                    <div class="timestamp-info">
                        <h6 class="text-muted fw-bold mb-3">
                            <i class="bi bi-clock-history me-2"></i>
                            Historique des Modifications
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-plus me-2 text-success"></i>
                                    <div>
                                        <small class="text-muted d-block">Créé le</small>
                                        <strong>{{ $service->created_at->format('d/m/Y à H:i') }}</strong>
                                        <small class="text-muted">({{ $service->created_at->diffForHumans() }})</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-check me-2 text-warning"></i>
                                    <div>
                                        <small class="text-muted d-block">Dernière modification</small>
                                        <strong>{{ $service->updated_at->format('d/m/Y à H:i') }}</strong>
                                        <small class="text-muted">({{ $service->updated_at->diffForHumans() }})</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="actions-section">
                        <div class="text-center">
                            <h5 class="text-gradient fw-bold mb-3">Finaliser les Modifications</h5>
                            <p class="text-muted mb-4">Vérifiez vos modifications avant de sauvegarder</p>

                            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                                <a href="{{ route('services.index') }}"
                                   class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Retour à la Liste
                                </a>

                                <a href="{{ route('services.show', $service->id) }}"
                                   class="btn btn-outline-info">
                                    <i class="bi bi-eye me-2"></i>
                                    Voir Détails
                                </a>

                                <button type="reset"
                                        class="btn btn-outline-warning"
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler toutes les modifications ?')">
                                    <i class="bi bi-arrow-clockwise me-2"></i>
                                    Réinitialiser
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-2"></i>
                                    Mettre à Jour
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus sur le premier champ
    document.getElementById('name').focus();

    // Compteurs de caractères
    function setupCharCounter(inputId, counterId) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);

        function updateCounter() {
            const length = input.value.length;
            const maxLength = input.getAttribute('maxlength') || 0;
            counter.textContent = length;

            // Changer la couleur selon le pourcentage
            if (maxLength > 0) {
                const percentage = (length / maxLength) * 100;
                if (percentage > 90) {
                    counter.style.color = '#dc3545';
                } else if (percentage > 75) {
                    counter.style.color = '#ffc107';
                } else {
                    counter.style.color = '#28a745';
                }
            }
        }

        input.addEventListener('input', updateCounter);
        updateCounter(); // Initial count
    }

    // Setup character counters
    setupCharCounter('name', 'name-count');
    setupCharCounter('code_service', 'code-count');
    setupCharCounter('description', 'desc-count');

    // Validation Bootstrap
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();

                        // Scroll vers le premier champ invalide
                        const firstInvalid = form.querySelector('.is-invalid, :invalid');
                        if (firstInvalid) {
                            firstInvalid.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            firstInvalid.focus();
                        }

                        showToast('Veuillez corriger les erreurs dans le formulaire', 'error');
                    } else {
                        // Animation de chargement sur le bouton
                        const submitBtn = form.querySelector('button[type="submit"]');
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mise à jour en cours...';
                        submitBtn.disabled = true;

                        showToast('Mise à jour du service en cours...', 'info');
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Validations en temps réel
    document.getElementById('quantite').addEventListener('input', function() {
        if (this.value < 1) {
            this.setCustomValidity('La capacité doit être supérieure à 0');
        } else if (this.value > 9999) {
            this.setCustomValidity('La capacité ne peut pas dépasser 9999');
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('email_contact').addEventListener('input', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (this.value && !emailRegex.test(this.value)) {
            this.setCustomValidity('Veuillez entrer une adresse email valide');
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('telephone').addEventListener('input', function() {
        const phoneRegex = /^[\d\s\-\+\(\)]{8,}$/;
        if (this.value && !phoneRegex.test(this.value)) {
            this.setCustomValidity('Veuillez entrer un numéro de téléphone valide (minimum 8 caractères)');
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('name').addEventListener('input', function() {
        const nameRegex = /^[a-zA-Z0-9\s\-_àáâãäåæçèéêëìíîïñòóôõöùúûüýÿ]+$/;
        if (this.value && !nameRegex.test(this.value)) {
            this.setCustomValidity('Le nom ne peut contenir que des lettres, chiffres, espaces et tirets');
        } else if (this.value.length < 3) {
            this.setCustomValidity('Le nom doit contenir au moins 3 caractères');
        } else {
            this.setCustomValidity('');
        }
    });

    // Système de suivi des changements
    const originalValues = {
        name: '{{ $service->name }}',
        code_service: '{{ $service->code_service ?? "" }}',
        description: '{{ $service->description ?? "" }}',
        quantite: {{ $service->quantite }},
        statut: '{{ $service->statut ?? "" }}',
        priorite: '{{ $service->priorite ?? "" }}',
        responsable: '{{ $service->responsable ?? "" }}',
        email_contact: '{{ $service->email_contact ?? "" }}',
        telephone: '{{ $service->telephone ?? "" }}',
        localisation: '{{ $service->localisation ?? "" }}'
    };

    function updateChangesSummary() {
        const changesSummary = document.getElementById('changes-summary');
        const changes = [];

        // Vérifier chaque champ pour les changements
        Object.keys(originalValues).forEach(field => {
            const input = document.getElementById(field);
            if (input && input.value !== originalValues[field]) {
                const fieldName = getFieldDisplayName(field);
                changes.push({
                    field: fieldName,
                    old: originalValues[field] || 'Non défini',
                    new: input.value || 'Vide'
                });
            }
        });

        if (changes.length === 0) {
            changesSummary.innerHTML = `
                <p class="text-muted text-center py-3">
                    <i class="bi bi-check-circle me-2 text-success"></i>
                    Aucune modification détectée
                </p>
            `;
        } else {
            let html = `
                <div class="alert alert-info">
                    <strong><i class="bi bi-exclamation-circle me-2"></i>${changes.length} modification(s) détectée(s) :</strong>
                </div>
            `;

            changes.forEach(change => {
                html += `
                    <div class="comparison-item">
                        <div>
                            <strong class="comparison-label">${change.field}</strong>
                            <div class="small text-muted">
                                Ancien : "${change.old}" → Nouveau : "${change.new}"
                            </div>
                        </div>
                    </div>
                `;
            });

            changesSummary.innerHTML = html;
        }
    }

    function getFieldDisplayName(field) {
        const names = {
            name: 'Nom du Service',
            code_service: 'Code Service',
            description: 'Description',
            quantite: 'Capacité',
            statut: 'Statut',
            priorite: 'Priorité',
            responsable: 'Responsable',
            email_contact: 'Email Contact',
            telephone: 'Téléphone',
            localisation: 'Localisation'
        };
        return names[field] || field;
    }

    // Écouter les changements sur tous les champs
    Object.keys(originalValues).forEach(field => {
        const input = document.getElementById(field);
        if (input) {
            input.addEventListener('input', updateChangesSummary);
            input.addEventListener('change', updateChangesSummary);
        }
    });

    // Initialisation
    updateChangesSummary();

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
        const alertClass = type === 'error' ? 'alert-danger' :
                          type === 'info' ? 'alert-info' : 'alert-success';
        toast.className = `alert ${alertClass} alert-dismissible fade show shadow-lg`;
        toast.style.cssText = `
            border: none;
            border-radius: 15px;
            animation: slideInRight 0.3s ease;
        `;

        const iconClass = type === 'error' ? 'exclamation-triangle-fill' :
                         type === 'info' ? 'info-circle-fill' : 'check-circle-fill';

        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-${iconClass} me-2"></i>
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
        // Ctrl/Cmd + S pour soumettre le formulaire
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            const form = document.getElementById('editServiceForm');
            const submitEvent = new Event('submit', {
                bubbles: true,
                cancelable: true
            });
            form.dispatchEvent(submitEvent);
        }

        // Ctrl/Cmd + R pour réinitialiser (avec confirmation)
        if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
            e.preventDefault();
            if (confirm('Êtes-vous sûr de vouloir annuler toutes les modifications ?')) {
                document.getElementById('editServiceForm').reset();
                updateChangesSummary();
                showToast('Formulaire réinitialisé', 'info');
            }
        }
    });

    // Gestion des états de chargement
    const form = document.getElementById('editServiceForm');
    form.addEventListener('submit', function() {
        this.classList.add('submitted');
    });

    // Animation d'apparition progressive des sections
    const sections = document.querySelectorAll('.form-section');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const sectionObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        sectionObserver.observe(section);
    });

    // Nettoyage avant fermeture de page
    window.addEventListener('beforeunload', function(e) {
        // Vérifier s'il y a des changements non sauvegardés
        let hasChanges = false;
        Object.keys(originalValues).forEach(field => {
            const input = document.getElementById(field);
            if (input && input.value !== originalValues[field]) {
                hasChanges = true;
            }
        });

        if (hasChanges && !form.classList.contains('submitted')) {
            e.preventDefault();
            e.returnValue = 'Vous avez des modifications non sauvegardées. Êtes-vous sûr de vouloir quitter ?';
        }
    });

    console.log('✨ Service edit form initialized with change tracking');
});

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

    /* Style pour les champs modifiés */
    .form-control.modified {
        border-color: var(--uts-yellow-dark) !important;
        background-color: rgba(255, 215, 0, 0.05) !important;
    }

    /* Style pour les champs valides */
    .form-control:valid:not(:placeholder-shown) {
        border-color: var(--uts-green) !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.8.8 3.9-3.9-.8-.8L3 5.65l-1.1-1.1-.8.8z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    /* Responsive improvements */
    @media (max-width: 576px) {
        .char-counter {
            position: static;
            text-align: right;
            margin-top: 0.25rem;
            font-size: 0.7rem;
        }

        .comparison-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .old-value-indicator {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection
