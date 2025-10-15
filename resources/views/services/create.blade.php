@extends('layouts.app')

@section('title', 'Créer un Service')

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
        --shadow-professional: 0 8px 40px rgba(46, 125, 50, 0.12);
        --shadow-yellow: 0 4px 20px rgba(255, 215, 0, 0.15);
    }

    body {
        background: linear-gradient(135deg, #f8fffe 0%, #f0f8f5 50%, #e8f5f0 100%);
        font-family: 'Segoe UI', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--uts-dark);
        line-height: 1.6;
    }

    /* Header Navigation professionnelle */
    .professional-header {
        background: white;
        border-bottom: 3px solid var(--uts-yellow);
        padding: 1rem 0;
        margin-bottom: 2rem;
        box-shadow: 0 2px 15px rgba(46, 125, 50, 0.08);
    }

    .uts-logo {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--uts-dark);
    }

    .uts-logo::before {
        content: '';
        width: 40px;
        height: 40px;
        background: var(--gradient-primary);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .uts-logo::after {
        content: 'UTS';
        position: absolute;
        color: white;
        font-weight: 900;
        font-size: 0.7rem;
        letter-spacing: 1px;
    }

    /* Breadcrumb institutionnel */
    .institutional-breadcrumb {
        background: white;
        border: 1px solid #e5e7eb;
        border-left: 4px solid var(--uts-yellow);
        border-radius: 0;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        font-weight: 500;
    }

    .breadcrumb-item a {
        color: var(--uts-green);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .breadcrumb-item a:hover {
        color: var(--uts-yellow-dark);
    }

    .breadcrumb-item.active {
        color: var(--uts-dark);
        font-weight: 700;
    }

    /* Title Section professionnelle */
    .page-title-section {
        background: white;
        border: 1px solid #e5e7eb;
        border-left: 6px solid var(--uts-green);
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
    }

    .page-title-section::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 100%;
        background: linear-gradient(135deg, transparent 0%, rgba(255, 215, 0, 0.05) 100%);
        pointer-events: none;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--uts-dark);
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 1.1rem;
        font-weight: 500;
        margin: 0;
    }

    .institutional-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--uts-yellow);
        color: var(--uts-dark);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Form Container professionnel */
    .professional-form-container {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0;
        box-shadow: var(--shadow-professional);
        overflow: hidden;
    }

    .form-header-professional {
        background: var(--gradient-primary);
        color: white;
        padding: 2rem;
        text-align: left;
        border-bottom: 3px solid var(--uts-yellow);
        position: relative;
    }

    .form-header-professional::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--uts-yellow-dark);
    }

    .form-header-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .form-header-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    /* Progress Tracker professionnel */
    .progress-tracker {
        background: #f9fafb;
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 600px;
        margin: 0 auto;
        position: relative;
    }

    .progress-line {
        position: absolute;
        top: 20px;
        left: 40px;
        right: 40px;
        height: 2px;
        background: #e5e7eb;
        z-index: 1;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .step-number {
        width: 40px;
        height: 40px;
        background: var(--gradient-primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        box-shadow: 0 2px 8px rgba(46, 125, 50, 0.2);
    }

    .step-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--uts-dark);
        text-align: center;
        white-space: nowrap;
    }

    /* Form Sections professionnelles */
    .professional-form-section {
        padding: 2.5rem;
        border-bottom: 1px solid #f3f4f6;
        background: white;
        transition: background-color 0.3s ease;
    }

    .professional-form-section:hover {
        background: #fafbfc;
    }

    .professional-form-section:last-child {
        border-bottom: none;
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f3f4f6;
        position: relative;
    }

    .section-header::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 50px;
        height: 2px;
        background: var(--uts-yellow);
    }

    .section-icon {
        width: 45px;
        height: 45px;
        background: var(--uts-sage);
        border: 2px solid var(--uts-green);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        font-size: 1.2rem;
        color: var(--uts-green);
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--uts-dark);
        margin: 0;
    }

    .section-description {
        color: #6b7280;
        font-size: 0.9rem;
        margin-top: 0.3rem;
        font-weight: 500;
    }

    /* Form Controls professionnels */
    .professional-form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .form-floating .form-control,
    .form-floating .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 1.5rem 1rem 0.75rem;
        font-size: 1rem;
        font-weight: 500;
        background: white;
        color: var(--uts-dark);
        min-height: 65px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-floating .form-control:focus,
    .form-floating .form-select:focus {
        border-color: var(--uts-green);
        box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
        outline: none;
        background: var(--uts-cream);
        transform: none;
    }

    .form-floating > label {
        color: #6b7280;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 1rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .form-floating > label i {
        margin-right: 0.75rem;
        color: var(--uts-green);
        font-size: 1rem;
    }

    .required-field::after {
        content: " *";
        color: var(--uts-red);
        font-weight: 800;
        font-size: 1.1rem;
        margin-left: 0.25rem;
    }

    /* Professional Helper Text */
    .professional-helper {
        background: var(--uts-sage);
        border-left: 4px solid var(--uts-green);
        padding: 1rem;
        margin-top: 0.75rem;
        font-size: 0.85rem;
        color: #4b5563;
        font-weight: 500;
        line-height: 1.5;
    }

    .professional-helper::before {
        content: "ℹ";
        display: inline-block;
        width: 20px;
        height: 20px;
        background: var(--uts-green);
        color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 20px;
        font-size: 0.7rem;
        margin-right: 0.75rem;
        font-weight: 700;
    }

    /* Character Counters professionnels */
    .professional-counter {
        position: absolute;
        bottom: 0.75rem;
        right: 1rem;
        background: var(--uts-yellow);
        color: var(--uts-dark);
        padding: 0.25rem 0.6rem;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 700;
        z-index: 10;
    }

    .counter-warning {
        background: var(--uts-red);
        color: white;
    }

    .counter-medium {
        background: #f59e0b;
        color: white;
    }

    /* Error States professionnels */
    .professional-error {
        background: rgba(220, 53, 69, 0.05);
        border: 2px solid var(--uts-red);
        border-left: 6px solid var(--uts-red);
        border-radius: 8px;
        color: var(--uts-red);
        padding: 1.5rem;
        margin-bottom: 2rem;
        font-weight: 600;
    }

    .professional-error .error-icon {
        width: 40px;
        height: 40px;
        background: var(--uts-red);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
        font-size: 1.1rem;
    }

    .is-invalid {
        border-color: var(--uts-red) !important;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15) !important;
        background: rgba(220, 53, 69, 0.02) !important;
    }

    .invalid-feedback {
        color: var(--uts-red);
        font-weight: 600;
        font-size: 0.85rem;
        margin-top: 0.75rem;
        padding: 0.75rem;
        background: rgba(220, 53, 69, 0.05);
        border-radius: 6px;
        border-left: 3px solid var(--uts-red);
    }

    /* Actions Section professionnelle */
    .professional-actions {
        background: #f9fafb;
        border-top: 3px solid var(--uts-yellow);
        padding: 2.5rem;
        text-align: center;
    }

    .actions-header {
        margin-bottom: 2rem;
    }

    .actions-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--uts-dark);
        margin-bottom: 0.5rem;
    }

    .actions-subtitle {
        color: #6b7280;
        font-size: 1rem;
        font-weight: 500;
    }

    /* Buttons professionnels */
    .professional-btn {
        border-radius: 8px;
        font-weight: 700;
        padding: 1rem 2rem;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin: 0.5rem;
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
        min-width: 160px;
    }

    .professional-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s ease;
    }

    .professional-btn:hover::before {
        left: 100%;
    }

    .btn-primary-professional {
        background: var(--gradient-primary);
        border-color: var(--uts-green);
        color: white;
        box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
    }

    .btn-primary-professional:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(46, 125, 50, 0.4);
        border-color: var(--uts-green-dark);
    }

    .btn-secondary-professional {
        background: white;
        border-color: var(--uts-dark);
        color: var(--uts-dark);
        box-shadow: 0 2px 8px rgba(44, 62, 80, 0.1);
    }

    .btn-secondary-professional:hover {
        background: var(--uts-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(44, 62, 80, 0.3);
    }

    .btn-warning-professional {
        background: var(--gradient-secondary);
        border-color: var(--uts-yellow-dark);
        color: var(--uts-dark);
        box-shadow: 0 2px 8px rgba(245, 124, 0, 0.2);
    }

    .btn-warning-professional:hover {
        background: var(--uts-yellow-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 124, 0, 0.4);
    }

    /* Responsive Design professionnel */
    @media (max-width: 768px) {
        .page-title-section {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .professional-form-section {
            padding: 1.5rem;
        }

        .professional-actions {
            padding: 1.5rem;
        }

        .professional-btn {
            width: 100%;
            margin: 0.25rem 0;
            min-width: auto;
        }

        .progress-steps {
            flex-wrap: wrap;
            gap: 1rem;
        }

        .step-label {
            font-size: 0.75rem;
        }

        .professional-counter {
            position: static;
            display: inline-block;
            margin-top: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .institutional-badge {
            position: static;
            margin-top: 1rem;
            display: inline-block;
        }

        .form-header-title {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .section-header {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
    }

    /* Animation professionnelle */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .professional-form-section {
        animation: slideInUp 0.6s ease forwards;
    }

    .professional-form-section:nth-child(1) { animation-delay: 0.1s; }
    .professional-form-section:nth-child(2) { animation-delay: 0.2s; }
    .professional-form-section:nth-child(3) { animation-delay: 0.3s; }
    .professional-form-section:nth-child(4) { animation-delay: 0.4s; }

    /* Focus indicators accessibles */
    .form-control:focus,
    .form-select:focus,
    .professional-btn:focus {
        outline: 3px solid rgba(46, 125, 50, 0.3);
        outline-offset: 2px;
    }

    /* High contrast mode */
    @media (prefers-contrast: high) {
        .professional-form-container {
            border: 3px solid var(--uts-dark);
        }

        .form-control,
        .form-select {
            border-width: 3px;
        }
    }

    /* Print styles */
    @media print {
        .professional-actions,
        .progress-tracker {
            display: none !important;
        }

        .professional-form-container {
            box-shadow: none !important;
            border: 2px solid #000 !important;
        }
    }
</style>
@endpush

@section('content')
<div class="professional-header">
    <div class="container-fluid px-3 px-lg-4">
        <div class="uts-logo">
            Université Thomas Sankara
        </div>
    </div>
</div>

<div class="container-fluid px-3 px-lg-4 py-4">
    {{-- Breadcrumb institutionnel --}}
    <nav aria-label="breadcrumb" class="institutional-breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="bi bi-house-door me-1"></i> Accueil
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('services.index') }}">Gestion des Services</a>
            </li>
            <li class="breadcrumb-item active">Création d'un Nouveau Service</li>
        </ol>
    </nav>

    {{-- Section titre professionnelle --}}
    <div class="page-title-section">
        <div class="institutional-badge">Service Officiel</div>
        <h1 class="page-title">Création d'un Nouveau Service</h1>
        <p class="page-subtitle">
            Formulaire officiel de déclaration et d'enregistrement d'un service
            au sein de l'Université Thomas Sankara
        </p>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            {{-- Messages d'erreur professionnels --}}
            @if ($errors->any())
                <div class="professional-error">
                    <div class="d-flex">
                        <div class="error-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <h6 class="mb-2 fw-bold">Erreurs de Validation Détectées</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li class="mb-1">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Conteneur de formulaire professionnel --}}
            <div class="professional-form-container">
                {{-- Header du formulaire --}}
                <div class="form-header-professional">
                    <div class="form-header-title">
                        <div class="form-header-icon">
                            <i class="bi bi-plus-square"></i>
                        </div>
                        <div>
                            <div>Formulaire de Création de Service</div>
                            <small class="opacity-90" style="font-size: 0.9rem; font-weight: 400;">
                                Veuillez renseigner tous les champs obligatoires avec précision
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Progress Tracker --}}
                <div class="progress-tracker">
                    <div class="progress-steps">
                        <div class="progress-line"></div>
                        <div class="progress-step">
                            <div class="step-number">1</div>
                            <div class="step-label">Informations</div>
                        </div>
                        <div class="progress-step">
                            <div class="step-number">2</div>
                            <div class="step-label">Gestion</div>
                        </div>
                        <div class="progress-step">
                            <div class="step-number">3</div>
                            <div class="step-label">Contact</div>
                        </div>
                        <div class="progress-step">
                            <div class="step-number">4</div>
                            <div class="step-label">Validation</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('services.store') }}" method="POST" class="needs-validation" novalidate id="professionalServiceForm">
                    @csrf

                    {{-- Section 1: Informations de Base --}}
                    <div class="professional-form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="bi bi-info-circle-fill"></i>
                            </div>
                            <div>
                                <div class="section-title">Informations Générales du Service</div>
                                <div class="section-description">
                                    Identification et description officielle du service
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="professional-form-group">
                                    <div class="form-floating">
                                        <input type="text"
                                               name="name"
                                               id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name') }}"
                                               placeholder="Dénomination officielle du service"
                                               maxlength="100"
                                               required>
                                        <label for="name" class="required-field">
                                            <i class="bi bi-building"></i>
                                            Dénomination Officielle du Service
                                        </label>
                                        <div class="professional-counter">
                                            <span id="name-count">0</span>/100
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="professional-helper">
                                        Dénomination complète et officielle du service tel qu'il apparaîtra
                                        dans les documents administratifs de l'université.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="professional-form-group">
                                    <div class="form-floating">
                                        <input type="text"
                                               name="code_service"
                                               id="code_service"
                                               class="form-control @error('code_service') is-invalid @enderror"
                                               value="{{ old('code_service') }}"
                                               placeholder="Code d'identification"
                                               maxlength="10"
                                               style="text-transform: uppercase;">
                                        <label for="code_service">
                                            <i class="bi bi-upc"></i>
                                            Code d'Identification du Service
                                        </label>
                                        <div class="professional-counter">
                                            <span id="code-count">0</span>/10
                                        </div>
                                        @error('code_service')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="professional-helper">
                                        Code abrégé unique pour l'identification rapide du service
                                        (généré automatiquement si non renseigné).
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="professional-form-group">
                            <div class="form-floating">
                                <textarea name="description"
                                          id="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          style="height: 120px;"
                                          maxlength="500"
                                          placeholder="Description détaillée des missions et activités du service">{{ old('description') }}</textarea>
                                <label for="description">
                                    <i class="bi bi-file-text"></i>
                                    Description des Missions et Activités
                                </label>
                                <div class="professional-counter">
                                    <span id="desc-count">0</span>/500
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="professional-helper">
                                Description complète des missions, objectifs, activités principales
                                et domaines d'intervention du service au sein de l'université.
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Paramètres de Gestion --}}
                    <div class="professional-form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="bi bi-sliders"></i>
                            </div>
                            <div>
                                <div class="section-title">Paramètres de Gestion et d'Organisation</div>
                                <div class="section-description">
                                    Configuration opérationnelle et administrative du service
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="professional-form-group">
                                    <div class="form-floating">
                                        <input type="number"
                                               name="quantite"
                                               id="quantite"
                                               class="form-control @error('quantite') is-invalid @enderror"
                                               value="{{ old('quantite', 1) }}"
                                               placeholder="Capacité opérationnelle"
                                               min="1"
                                               max="9999"
                                               required>
                                        <label for="quantite" class="required-field">
                                            <i class="bi bi-people"></i>
                                            Capacité Opérationnelle
                                        </label>
                                        @error('quantite')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="professional-helper">
                                        Nombre d'unités, de postes de travail ou de ressources humaines
                                        disponibles pour le fonctionnement du service.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="professional-form-group">
                                    <div class="form-floating">
                                        <select name="statut"
                                                id="statut"
                                                class="form-select @error('statut') is-invalid @enderror">
                                            <option value="">-- Sélectionnez le statut opérationnel --</option>
                                            <option value="actif" {{ old('statut', 'actif') == 'actif' ? 'selected' : '' }}>
                                                ✅ Service Actif et Opérationnel
                                            </option>
                                            <option value="inactif" {{ old('statut') == 'inactif' ? 'selected' : '' }}>
                                                ❌ Service Temporairement Inactif
                                            </option>
                                            <option value="maintenance" {{ old('statut') == 'maintenance' ? 'selected' : '' }}>
                                                🔧 Service en Maintenance
                                            </option>
                                        </select>
                                        <label for="statut">
                                            <i class="bi bi-activity"></i>
                                            Statut Opérationnel du Service
                                        </label>
                                        @error('statut')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="professional-helper">
                                        État actuel du service concernant sa disponibilité et son fonctionnement
                                        pour les usagers de l'université.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="professional-form-group">
                                    <div class="form-floating">
                                        <select name="priorite"
                                                id="priorite"
                                                class="form-select @error('priorite') is-invalid @enderror">
                                            <option value="">-- Niveau de priorité institutionnelle --</option>
                                            <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>
                                                🔴 Priorité Stratégique Haute
                                            </option>
                                            <option value="moyenne" {{ old('priorite', 'moyenne') == 'moyenne' ? 'selected' : '' }}>
                                                🟡 Priorité Institutionnelle Moyenne
                                            </option>
                                            <option value="basse" {{ old('priorite') == 'basse' ? 'selected' : '' }}>
                                                🟢 Priorité Opérationnelle Standard
                                            </option>
                                        </select>
                                        <label for="priorite">
                                            <i class="bi bi-flag"></i>
                                            Niveau de Priorité Institutionnelle
                                        </label>
                                        @error('priorite')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="professional-helper">
                                        Degré d'importance stratégique du service dans l'organisation
                                        et le fonctionnement général de l'université.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Informations de Contact et Localisation --}}
                    <div class="professional-form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <div class="section-title">Informations de Contact et Localisation</div>
                                <div class="section-description">
                                    Coordonnées officielles et emplacement physique du service
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="professional-form-group">
                                    <div class="form-floating">
                                        <input type="text"
                                               name="responsable"
                                               id="responsable"
                                               class="form-control @error('responsable') is-invalid @enderror"
                                               value="{{ old('responsable') }}"
                                               placeholder="Nom complet du responsable hiérarchique"
                                               maxlength="100">
                                        <label for="responsable">
                                            <i class="bi bi-person-badge"></i>
                                            Responsable Hiérarchique du Service
                                        </label>
                                        @error('responsable')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="professional-helper">
                                        Nom et prénom complets de la personne en charge de la direction
                                        et de la supervision du service.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="professional-form-group">
                                    <div class="form-floating">
                                        <input type="email"
                                               name="email_contact"
                                               id="email_contact"
                                               class="form-control @error('email_contact') is-invalid @enderror"
                                               value="{{ old('email_contact') }}"
                                               placeholder="adresse.email@uts.edu">
                                        <label for="email_contact">
                                            <i class="bi bi-envelope-at"></i>
                                            Adresse Email Officielle
                                        </label>
                                        @error('email_contact')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="professional-helper">
                                        Adresse email institutionnelle officielle pour les communications
                                        et correspondances avec le service.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="professional-form-group">
                                    <div class="form-floating">
                                        <input type="tel"
                                               name="telephone"
                                               id="telephone"
                                               class="form-control @error('telephone') is-invalid @enderror"
                                               value="{{ old('telephone') }}"
                                               placeholder="+226 XX XX XX XX">
                                        <label for="telephone">
                                            <i class="bi bi-telephone"></i>
                                            Ligne Téléphonique Directe
                                        </label>
                                        @error('telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="professional-helper">
                                        Numéro de téléphone direct du service pour les communications
                                        urgentes et les rendez-vous.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="professional-form-group">
                                    <div class="form-floating">
                                        <input type="text"
                                               name="localisation"
                                               id="localisation"
                                               class="form-control @error('localisation') is-invalid @enderror"
                                               value="{{ old('localisation') }}"
                                               placeholder="Bâtiment, étage, bureau, campus..."
                                               maxlength="150">
                                        <label for="localisation">
                                            <i class="bi bi-building"></i>
                                            Localisation Physique
                                        </label>
                                        @error('localisation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="professional-helper">
                                        Adresse précise et complète de l'emplacement physique du service
                                        au sein du campus universitaire.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section Actions --}}
                    <div class="professional-actions">
                        <div class="actions-header">
                            <div class="actions-title">Validation et Enregistrement Official</div>
                            <div class="actions-subtitle">
                                Vérifiez attentivement toutes les informations avant la soumission définitive
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                                    <a href="{{ route('services.index') }}"
                                       class="professional-btn btn-secondary-professional">
                                        <i class="bi bi-arrow-left me-2"></i>
                                        Retour à la Liste
                                    </a>

                                    <button type="reset"
                                            class="professional-btn btn-warning-professional"
                                            onclick="return confirm('Êtes-vous certain de vouloir effacer toutes les informations saisies ?')">
                                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                                        Réinitialiser le Formulaire
                                    </button>

                                    <button type="submit" class="professional-btn btn-primary-professional">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Enregistrer le Service
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Une fois enregistré, le service sera soumis à validation par l'administration
                                avant sa mise en service officielle.
                            </small>
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
    // Auto-focus professionnel sur le premier champ
    document.getElementById('name').focus();

    // Compteurs de caractères professionnels
    function setupProfessionalCharCounter(inputId, counterId) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);

        function updateCounter() {
            const length = input.value.length;
            const maxLength = input.getAttribute('maxlength') || 0;
            counter.textContent = length;

            // Classes professionnelles selon le pourcentage
            if (maxLength > 0) {
                const percentage = (length / maxLength) * 100;
                counter.className = 'professional-counter';
                if (percentage > 90) {
                    counter.classList.add('counter-warning');
                } else if (percentage > 75) {
                    counter.classList.add('counter-medium');
                }
            }
        }

        input.addEventListener('input', updateCounter);
        updateCounter(); // Comptage initial
    }

    // Configuration des compteurs
    setupProfessionalCharCounter('name', 'name-count');
    setupProfessionalCharCounter('code_service', 'code-count');
    setupProfessionalCharCounter('description', 'desc-count');

    // Génération automatique du code service
    document.getElementById('name').addEventListener('input', function() {
        const codeField = document.getElementById('code_service');
        if (!codeField.value || codeField.hasAttribute('data-auto-generated')) {
            const code = this.value
                .toUpperCase()
                .replace(/[^A-Z0-9]/g, '')
                .substring(0, 6);
            codeField.value = code;
            codeField.setAttribute('data-auto-generated', 'true');

            const counter = document.getElementById('code-count');
            counter.textContent = code.length;
        }
    });

    // Supprimer l'attribut auto-generated si modification manuelle
    document.getElementById('code_service').addEventListener('input', function() {
        this.removeAttribute('data-auto-generated');
    });

    // Validation Bootstrap professionnelle
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

                        showProfessionalNotification('Veuillez corriger les erreurs signalées dans le formulaire', 'error');
                    } else {
                        // Animation de chargement professionnelle
                        const submitBtn = form.querySelector('button[type="submit"]');
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Enregistrement en cours...';
                        submitBtn.disabled = true;

                        showProfessionalNotification('Enregistrement du service en cours de traitement...', 'info');
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Validations en temps réel professionnelles
    document.getElementById('quantite').addEventListener('input', function() {
        if (this.value < 1) {
            this.setCustomValidity('La capacité opérationnelle doit être supérieure à 0');
        } else if (this.value > 9999) {
            this.setCustomValidity('La capacité opérationnelle ne peut pas dépasser 9999');
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('email_contact').addEventListener('input', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (this.value && !emailRegex.test(this.value)) {
            this.setCustomValidity('Veuillez saisir une adresse email institutionnelle valide');
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('telephone').addEventListener('input', function() {
        const phoneRegex = /^[\d\s\-\+\(\)]{8,}$/;
        if (this.value && !phoneRegex.test(this.value)) {
            this.setCustomValidity('Veuillez saisir un numéro de téléphone valide (minimum 8 caractères)');
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('name').addEventListener('input', function() {
        const nameRegex = /^[a-zA-Z0-9\s\-_àáâãäåæçèéêëìíîïñòóôõöùúûüýÿ'\.]+$/;
        if (this.value && !nameRegex.test(this.value)) {
            this.setCustomValidity('La dénomination ne peut contenir que des lettres, chiffres, espaces et tirets');
        } else if (this.value.length < 5) {
            this.setCustomValidity('La dénomination doit contenir au moins 5 caractères');
        } else {
            this.setCustomValidity('');
        }
    });

    // Fonction de notification professionnelle
    function showProfessionalNotification(message, type = 'info') {
        const notificationContainer = document.createElement('div');
        notificationContainer.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 350px;
            max-width: 500px;
        `;

        const notification = document.createElement('div');
        const alertClass = type === 'error' ? 'alert-danger' :
                          type === 'info' ? 'alert-info' : 'alert-success';
        notification.className = `alert ${alertClass} alert-dismissible fade show shadow-lg border-0`;
        notification.style.cssText = `
            border-radius: 10px;
            border-left: 4px solid var(--uts-${type === 'error' ? 'red' : type === 'info' ? 'yellow-dark' : 'green'}) !important;
            animation: slideInRight 0.4s ease;
            font-weight: 500;
        `;

        const iconClass = type === 'error' ? 'exclamation-triangle-fill' :
                         type === 'info' ? 'info-circle-fill' : 'check-circle-fill';

        notification.innerHTML = `
            <div class="d-flex align-items-start">
                <i class="bi bi-${iconClass} me-3 mt-1" style="font-size: 1.1rem;"></i>
                <div class="flex-grow-1">
                    <strong>${type === 'error' ? 'Erreur de Validation' : type === 'info' ? 'Information' : 'Succès'}</strong>
                    <div class="mt-1">${message}</div>
                </div>
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert"></button>
            </div>
        `;

        notificationContainer.appendChild(notification);
        document.body.appendChild(notificationContainer);

        // Suppression automatique après 6 secondes
        setTimeout(() => {
            if (notificationContainer.parentNode) {
                notificationContainer.remove();
            }
        }, 6000);
    }

    // Raccourcis clavier professionnels
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S pour soumettre
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            const form = document.getElementById('professionalServiceForm');
            const submitEvent = new Event('submit', {
                bubbles: true,
                cancelable: true
            });
            form.dispatchEvent(submitEvent);
        }

        // Ctrl/Cmd + R pour réinitialiser avec confirmation
        if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
            e.preventDefault();
            if (confirm('Êtes-vous certain de vouloir effacer toutes les informations saisies ?')) {
                document.getElementById('professionalServiceForm').reset();
                // Réinitialiser les compteurs
                document.getElementById('name-count').textContent = '0';
                document.getElementById('code-count').textContent = '0';
                document.getElementById('desc-count').textContent = '0';
                showProfessionalNotification('Formulaire réinitialisé avec succès', 'info');
            }
        }
    });

    // Animation d'apparition progressive des sections
    const sections = document.querySelectorAll('.professional-form-section');
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
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
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        sectionObserver.observe(section);
    });

    console.log('🎓 Formulaire professionnel UTS initialisé avec succès');
});

// Styles d'animation professionnels
const professionalStyles = document.createElement('style');
professionalStyles.textContent = `
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

    /* Animation pour les champs valides */
    .form-control:valid:not(:placeholder-shown):not(:focus) {
        border-color: var(--uts-green) !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%232E7D32' d='m2.3 6.73.8.8 3.9-3.9-.8-.8L3 5.65l-1.1-1.1-.8.8z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    /* Responsive pour mobile */
    @media (max-width: 576px) {
        .professional-counter {
            position: static !important;
            display: block;
            text-align: right;
            margin-top: 0.5rem;
            font-size: 0.7rem;
        }

        .form-header-professional {
            padding: 1.5rem;
        }

        .professional-form-section {
            padding: 1.5rem;
        }
    }
`;
document.head.appendChild(professionalStyles);
</script>
@endpush
@endsection
