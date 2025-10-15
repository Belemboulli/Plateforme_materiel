@extends('layouts.app')

@section('title', 'Créer un nouveau rapport')

@push('styles')
<style>
    .page-wrapper {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px 15px 0 0;
        margin-bottom: 0;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(30px, -30px);
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .page-subtitle {
        opacity: 0.9;
        margin-top: 0.5rem;
        font-size: 1rem;
    }

    .breadcrumb-custom {
        background: rgba(255,255,255,0.1);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        backdrop-filter: blur(10px);
    }

    .breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: rgba(255,255,255,0.7);
    }

    .breadcrumb-custom .breadcrumb-item a {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
    }

    .breadcrumb-custom .breadcrumb-item.active {
        color: white;
        font-weight: 500;
    }

    .form-container {
        background: white;
        border-radius: 0 0 15px 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        border: none;
    }

    .form-section {
        padding: 2rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #667eea;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
        background: white;
        transform: translateY(-1px);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background: #fef5f5;
    }

    .form-control.is-valid {
        border-color: #28a745;
        background: #f5fef5;
    }

    .input-icon {
        color: #667eea;
        width: 20px;
    }

    .alert-custom {
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        border-left: 4px solid #dc3545;
        background: linear-gradient(45deg, #fff5f5, #fef2f2);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.1);
    }

    .alert-custom .alert-icon {
        color: #dc3545;
        font-size: 1.2rem;
    }

    .checkbox-custom {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 1rem;
        transition: all 0.3s ease;
    }

    .checkbox-custom:hover {
        background: #f8f9ff;
        border-color: #667eea;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .btn-group-custom {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 0 0 15px 15px;
        border-top: 1px solid #e9ecef;
    }

    .btn-custom {
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        text-transform: none;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-outline-custom {
        background: white;
        color: #6c757d;
        border-color: #dee2e6;
    }

    .btn-outline-custom:hover {
        background: #f8f9fa;
        color: #495057;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .btn-warning-custom {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
        color: white;
        border-color: transparent;
    }

    .btn-warning-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 193, 7, 0.3);
        color: white;
    }

    .progress-bar-custom {
        height: 4px;
        background: #e9ecef;
        border-radius: 2px;
        margin-top: 1rem;
        position: relative;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 2px;
        transition: width 0.3s ease;
    }

    .character-counter {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

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

    .animate-slide-up {
        animation: slideInUp 0.6s ease-out;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .form-section {
            padding: 1.5rem;
        }

        .btn-group-custom {
            padding: 1rem;
        }

        .btn-group-custom .d-flex {
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-custom {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-9">

                <div class="page-header animate-slide-up">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <h1 class="page-title">
                                <i class="fas fa-file-plus me-3"></i>
                                Créer un nouveau rapport
                            </h1>
                            <p class="page-subtitle mb-0">Remplissez les informations ci-dessous pour générer votre rapport</p>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-custom mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">
                                        <i class="fas fa-home me-1"></i>Accueil
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('rapports.index') }}">Rapports</a>
                                </li>
                                <li class="breadcrumb-item active">Nouveau</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-custom animate-slide-up" style="animation-delay: 0.2s;">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-exclamation-triangle alert-icon me-3 mt-1"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-2 fw-bold">Erreurs de validation</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li class="mb-1">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="form-container animate-slide-up" style="animation-delay: 0.3s;">
                    <form action="{{ route('rapports.store') }}" method="POST" id="rapportForm" class="needs-validation" novalidate>
                        @csrf

                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-info-circle input-icon me-2"></i>
                                Informations générales
                            </h3>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="titre" class="form-label">
                                            <i class="fas fa-heading input-icon"></i>
                                            Titre du rapport *
                                        </label>
                                        <input type="text"
                                               name="titre"
                                               id="titre"
                                               class="form-control @error('titre') is-invalid @enderror"
                                               value="{{ old('titre') }}"
                                               maxlength="255"
                                               required
                                               placeholder="Entrez le titre du rapport">
                                        <div class="character-counter">
                                            <span id="titre-count">0</span>/255 caractères
                                        </div>
                                        @error('titre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date_rapport" class="form-label">
                                            <i class="fas fa-calendar-alt input-icon"></i>
                                            Date du rapport *
                                        </label>
                                        <input type="date"
                                               name="date_rapport"
                                               id="date_rapport"
                                               class="form-control @error('date_rapport') is-invalid @enderror"
                                               value="{{ old('date_rapport', date('Y-m-d')) }}"
                                               required>
                                        @error('date_rapport')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-align-left input-icon me-2"></i>
                                Contenu du rapport
                            </h3>

                            <div class="form-group">
                                <label for="contenu" class="form-label">
                                    <i class="fas fa-file-text input-icon"></i>
                                    Contenu détaillé *
                                </label>
                                <textarea name="contenu"
                                          id="contenu"
                                          class="form-control @error('contenu') is-invalid @enderror"
                                          rows="8"
                                          maxlength="5000"
                                          required
                                          placeholder="Décrivez le contenu détaillé de votre rapport...">{{ old('contenu') }}</textarea>
                                <div class="character-counter">
                                    <span id="contenu-count">0</span>/5000 caractères
                                </div>
                                @error('contenu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-cog input-icon me-2"></i>
                                Options et notifications
                            </h3>

                            <div class="checkbox-custom">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="envoyer_notification"
                                           id="envoyer_notification"
                                           value="1"
                                           {{ old('envoyer_notification', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="envoyer_notification">
                                        <i class="fas fa-envelope me-2 text-primary"></i>
                                        Envoyer une notification par email
                                        <small class="d-block text-muted mt-1">Une notification sera envoyée aux administrateurs</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="auteur_id" value="{{ Auth::id() }}">

                        <div class="btn-group-custom">
                            <div class="d-flex justify-content-end gap-3 align-items-center">
                                <div class="progress-bar-custom d-none" id="formProgress">
                                    <div class="progress-fill" style="width: 0%"></div>
                                </div>

                                <a href="{{ route('rapports.index') }}" class="btn btn-outline-custom btn-custom">
                                    <i class="fas fa-arrow-left"></i>
                                    Retour
                                </a>

                                <button type="button" class="btn btn-warning-custom btn-custom" onclick="resetForm()">
                                    <i class="fas fa-undo"></i>
                                    Réinitialiser
                                </button>

                                <button type="submit" class="btn btn-primary-custom btn-custom" id="submitBtn">
                                    <i class="fas fa-save"></i>
                                    <span>Créer le rapport</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('rapportForm');
    const submitBtn = document.getElementById('submitBtn');
    const progressBar = document.getElementById('formProgress');

    setupCharacterCounters();
    setupFormValidation();
    setupSubmitAnimation();

    function setupCharacterCounters() {
        const fields = [
            { input: 'titre', counter: 'titre-count', max: 255 },
            { input: 'contenu', counter: 'contenu-count', max: 5000 }
        ];

        fields.forEach(field => {
            const input = document.getElementById(field.input);
            const counter = document.getElementById(field.counter);

            if (input && counter) {
                function updateCounter() {
                    const count = input.value.length;
                    counter.textContent = count;
                    counter.style.color = count > field.max * 0.9 ? '#dc3545' : '#6c757d';
                }

                input.addEventListener('input', updateCounter);
                updateCounter();
            }
        });
    }

    function setupFormValidation() {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                form.classList.add('shake');
                setTimeout(() => form.classList.remove('shake'), 500);

                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
            form.classList.add('was-validated');
        });

        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
        });
    }

    function setupSubmitAnimation() {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity()) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Création en cours...';
                progressBar.classList.remove('d-none');

                let width = 0;
                const interval = setInterval(() => {
                    width += 10;
                    progressBar.querySelector('.progress-fill').style.width = width + '%';
                    if (width >= 90) clearInterval(interval);
                }, 100);
            }
        });
    }

    window.resetForm = function() {
        if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ?')) {
            form.reset();
            form.classList.remove('was-validated');

            document.getElementById('titre-count').textContent = '0';
            document.getElementById('contenu-count').textContent = '0';

            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.classList.remove('is-valid', 'is-invalid');
            });

            document.getElementById('titre').focus();
        }
    };
});

const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .shake { animation: shake 0.5s; }
`;
document.head.appendChild(style);
</script>
@endpush
