@extends('layouts.app')

@section('title', 'Ajouter une Catégorie')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Breadcrumb moderne -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item">
                <a href="{{ route('categories.index') }}" class="text-warning text-decoration-none fw-medium">
                    <i class="fas fa-folder-open me-2"></i>Catégories
                </a>
            </li>
            <li class="breadcrumb-item active text-muted" aria-current="page">Nouvelle catégorie</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <!-- En-tête avec design UTS -->
            <div class="text-center mb-5">
                <div class="logo-container mb-3">
                    <div class="main-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div class="icon-pulse"></div>
                </div>
                <h1 class="display-6 fw-bold text-dark mb-2">Créer une nouvelle catégorie</h1>
                <p class="lead text-muted">Organisez efficacement vos matériels avec une catégorie personnalisée</p>
            </div>

            <!-- Formulaire principal -->
            <div class="main-card">
                <!-- En-tête coloré UTS -->
                <div class="card-header-uts">
                    <div class="d-flex align-items-center">
                        <div class="header-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="header-content">
                            <h4 class="mb-0 fw-bold">Informations de la catégorie</h4>
                            <p class="mb-0 opacity-90">Remplissez les champs ci-dessous avec attention</p>
                        </div>
                    </div>
                </div>

                <!-- Corps du formulaire -->
                <div class="card-body p-5">
                    <form action="{{ route('categories.store') }}" method="POST" class="category-form">
                        @csrf

                        <!-- Champ Nom avec design moderne -->
                        <div class="form-group">
                            <label for="nom" class="form-label">
                                <i class="fas fa-signature text-warning me-2"></i>
                                Nom de la catégorie
                                <span class="required">*</span>
                            </label>
                            <div class="input-container">
                                <div class="input-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <input type="text"
                                       class="form-control @error('nom') is-invalid @enderror"
                                       id="nom"
                                       name="nom"
                                       value="{{ old('nom') }}"
                                       placeholder="Ex: Informatique, Mobilier, Électronique..."
                                       required>
                                @error('nom')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @else
                                    <div class="form-help">Le nom doit être unique et descriptif</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Champ Description -->
                        <div class="form-group">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left text-warning me-2"></i>
                                Description
                                <span class="optional">(optionnel)</span>
                            </label>
                            <div class="input-container">
                                <div class="input-icon textarea-icon">
                                    <i class="fas fa-comment-alt"></i>
                                </div>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="4"
                                          placeholder="Décrivez brièvement cette catégorie et son utilisation...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @else
                                    <div class="form-help">Une description claire aide à mieux organiser vos matériels</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Aperçu en temps réel amélioré -->
                        <div class="preview-section">
                            <h6 class="preview-title">
                                <i class="fas fa-eye me-2"></i>Aperçu de la catégorie
                            </h6>
                            <div class="preview-card">
                                <div class="preview-icon">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <div class="preview-content">
                                    <h6 class="preview-name" id="preview-nom">Nom de la catégorie</h6>
                                    <p class="preview-description" id="preview-description">Description de la catégorie</p>
                                    <div class="preview-meta">
                                        <span class="badge bg-success">0 matériels</span>
                                        <small class="text-muted ms-2">Créé aujourd'hui</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="action-buttons">
                            <button type="submit" class="btn-primary">
                                <span class="btn-content">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Créer la catégorie
                                </span>
                                <div class="btn-loading">
                                    <i class="fas fa-spinner fa-spin me-2"></i>
                                    Création...
                                </div>
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Retour à la liste
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Section conseils améliorée -->
            <div class="tips-section">
                <h5 class="tips-title">
                    <i class="fas fa-lightbulb text-warning me-2"></i>
                    Conseils pour créer une bonne catégorie
                </h5>
                <div class="tips-grid">
                    <div class="tip-card green">
                        <div class="tip-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h6>Soyez précis</h6>
                        <p>Utilisez des noms clairs et explicites qui reflètent le contenu</p>
                    </div>
                    <div class="tip-card blue">
                        <div class="tip-icon">
                            <i class="fas fa-recycle"></i>
                        </div>
                        <h6>Pensez réutilisable</h6>
                        <p>Créez des catégories qui pourront accueillir différents matériels similaires</p>
                    </div>
                    <div class="tip-card red">
                        <div class="tip-icon">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <h6>Restez cohérent</h6>
                        <p>Maintenez une logique de nommage uniforme dans tout le système</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Design général UTS */
.main-card {
    background: white;
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

/* Logo avec animation */
.logo-container {
    position: relative;
    display: inline-block;
}

.main-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ffc107, #ff8f00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #000;
    box-shadow: 0 8px 25px rgba(255, 193, 7, 0.3);
    position: relative;
    z-index: 2;
    animation: float 3s ease-in-out infinite;
}

.icon-pulse {
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    border: 2px solid rgba(255, 193, 7, 0.3);
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
}

/* En-tête de carte UTS */
.card-header-uts {
    background: linear-gradient(135deg, #ffc107, #ff8f00);
    color: #000;
    padding: 1.5rem 2rem;
    border: none;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-right: 1rem;
}

.header-content h4 {
    color: #000;
    font-weight: 700;
}

.header-content p {
    color: rgba(0, 0, 0, 0.8);
    font-size: 0.9rem;
    margin: 0;
}

/* Formulaire moderne */
.category-form {
    max-width: none;
}

.form-group {
    margin-bottom: 2rem;
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
}

.required {
    color: #dc3545;
    margin-left: 4px;
}

.optional {
    color: #6c757d;
    font-size: 0.875rem;
    margin-left: 8px;
}

.input-container {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 10;
    transition: color 0.3s ease;
}

.textarea-icon {
    top: 20px;
    transform: none;
}

.form-control {
    height: 50px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding-left: 50px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
}

.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
    background: white;
}

.form-control:focus + .input-icon {
    color: #ffc107;
}

textarea.form-control {
    height: auto;
    padding-top: 15px;
    padding-left: 50px;
    resize: vertical;
}

.form-help {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* Aperçu amélioré */
.preview-section {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border-left: 4px solid #ffc107;
}

.preview-title {
    color: #333;
    font-weight: 600;
    margin-bottom: 1rem;
}

.preview-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    display: flex;
    align-items: flex-start;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.preview-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #ffc107, #ff8f00);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
    margin-right: 1rem;
    flex-shrink: 0;
}

.preview-content {
    flex: 1;
}

.preview-name {
    font-weight: 700;
    color: #333;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.preview-description {
    color: #6c757d;
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
}

.preview-meta {
    display: flex;
    align-items: center;
}

/* Boutons d'action */
.action-buttons {
    display: flex;
    gap: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
    flex-wrap: wrap;
}

.btn-primary {
    background: linear-gradient(135deg, #ffc107, #ff8f00);
    border: none;
    border-radius: 12px;
    color: #000;
    font-weight: 700;
    padding: 0.75rem 2rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    flex: 1;
    min-width: 200px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
    color: #000;
}

.btn-secondary {
    background: linear-gradient(135deg, #6c757d, #495057);
    border: none;
    border-radius: 12px;
    color: white;
    font-weight: 600;
    padding: 0.75rem 2rem;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 1;
    min-width: 180px;
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
    color: white;
}

.btn-content, .btn-loading {
    transition: opacity 0.3s ease;
}

.btn-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
}

.btn-primary.loading .btn-content {
    opacity: 0;
}

.btn-primary.loading .btn-loading {
    opacity: 1;
}

/* Section conseils */
.tips-section {
    margin-top: 3rem;
}

.tips-title {
    color: #333;
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-align: center;
}

.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.tip-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease;
    border-top: 4px solid;
}

.tip-card:hover {
    transform: translateY(-5px);
}

.tip-card.green {
    border-top-color: #28a745;
}

.tip-card.blue {
    border-top-color: #007bff;
}

.tip-card.red {
    border-top-color: #dc3545;
}

.tip-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.2rem;
    color: white;
}

.tip-card.green .tip-icon {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.tip-card.blue .tip-icon {
    background: linear-gradient(135deg, #007bff, #0056b3);
}

.tip-card.red .tip-icon {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

.tip-card h6 {
    font-weight: 700;
    color: #333;
    margin-bottom: 0.75rem;
}

.tip-card p {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

/* Breadcrumb */
.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #ffc107;
    font-weight: bold;
}

.breadcrumb-item a:hover {
    color: #e0a800 !important;
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.3;
    }
    50% {
        transform: scale(1.05);
        opacity: 0.1;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }

    .main-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }

    .card-header-uts {
        padding: 1rem 1.5rem;
    }

    .card-body {
        padding: 1.5rem !important;
    }

    .action-buttons {
        flex-direction: column;
    }

    .tips-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .form-control {
        padding-left: 45px;
    }

    .input-icon {
        left: 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du formulaire
    const nomInput = document.getElementById('nom');
    const descriptionInput = document.getElementById('description');
    const previewNom = document.getElementById('preview-nom');
    const previewDescription = document.getElementById('preview-description');
    const form = document.querySelector('.category-form');
    const submitBtn = form.querySelector('.btn-primary');

    // Aperçu en temps réel
    nomInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewNom.textContent = value || 'Nom de la catégorie';

        // Validation visuelle en temps réel
        if (value.length > 0) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-valid');
        }
    });

    descriptionInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewDescription.textContent = value || 'Description de la catégorie';
    });

    // Gestion de la soumission
    form.addEventListener('submit', function(e) {
        // Validation
        const nomValue = nomInput.value.trim();

        if (!nomValue) {
            e.preventDefault();
            nomInput.classList.add('is-invalid');
            nomInput.focus();
            return;
        }

        // Animation de loading
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;

        // Simuler un délai de soumission
        setTimeout(() => {
            // Le formulaire sera soumis naturellement
        }, 300);
    });

    // Animation des champs au focus
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });

        // Vérifier si le champ a déjà une valeur
        if (input.value) {
            input.parentElement.classList.add('focused');
        }
    });

    // Auto-focus sur le premier champ
    setTimeout(() => {
        nomInput.focus();
    }, 500);
});
</script>
@endsection
