@extends('layouts.app')

@section('title', 'Gestion des Matériels')

@section('content')
<div class="materiels-container">
    <!-- Breadcrumb moderne -->
    <nav aria-label="breadcrumb" class="breadcrumb-section">
        <ol class="breadcrumb-modern">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">
                    <i class="fas fa-home"></i>
                    <span>Accueil</span>
                </a>
            </li>
            <li class="breadcrumb-item active">Matériels</li>
        </ol>
    </nav>

    <!-- En-tête professionnel -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-icon-wrapper">
                <div class="header-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="icon-pulse"></div>
            </div>
            <div class="header-text">
                <h1 class="page-title">Gestion des Matériels</h1>
                <p class="page-subtitle">Gérez efficacement l'inventaire de vos équipements et matériels</p>
            </div>
        </div>

        <div class="header-actions">
            <button class="btn-action secondary" onclick="window.print()">
                <i class="fas fa-print"></i>
                <span>Imprimer</span>
            </button>
            <a href="{{ route('materiels.create') }}" class="btn-action primary">
                <i class="fas fa-plus-circle"></i>
                <span>Nouveau Matériel</span>
            </a>
        </div>
    </div>

    <!-- Messages de succès -->
    @if(session('success'))
        <div class="alert-container">
            <div class="alert alert-success">
                <div class="alert-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-content">
                    <h6>Opération réussie!</h6>
                    <p>{{ session('success') }}</p>
                </div>
                <button type="button" class="alert-close" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Statistiques dashboard -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-icon">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $materiels->count() }}</h3>
                <p class="stat-label">Total Matériels</p>
            </div>
        </div>

        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $materiels->groupBy('categorie.nom')->count() }}</h3>
                <p class="stat-label">Catégories</p>
            </div>
        </div>

        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $materiels->where('created_at', '>=', now()->subWeek())->count() }}</h3>
                <p class="stat-label">Cette semaine</p>
            </div>
        </div>

        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ round($materiels->count() / max($materiels->groupBy('categorie.nom')->count(), 1), 1) }}</h3>
                <p class="stat-label">Moy. par catégorie</p>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    @if($materiels->isEmpty())
        <!-- État vide moderne -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-box-open"></i>
            </div>
            <h2 class="empty-title">Aucun matériel disponible</h2>
            <p class="empty-description">
                Commencez par ajouter votre premier matériel à l'inventaire pour organiser
                efficacement vos équipements et suivre leur utilisation.
            </p>
            <a href="{{ route('materiels.create') }}" class="btn-empty-action">
                <i class="fas fa-plus-circle"></i>
                <span>Créer mon premier matériel</span>
            </a>
        </div>
    @else
        <!-- Table moderne des matériels -->
        <div class="data-table-container">
            <!-- En-tête de table -->
            <div class="table-header">
                <div class="table-title">
                    <i class="fas fa-list"></i>
                    <span>Liste des Matériels</span>
                    <div class="results-badge">{{ $materiels->count() }} matériel(s)</div>
                </div>

                <div class="table-controls">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Rechercher un matériel..." id="searchInput">
                    </div>

                    <div class="filter-controls">
                        <select class="filter-select" id="categoryFilter">
                            <option value="">Toutes les catégories</option>
                            @foreach($materiels->groupBy('categorie.nom') as $categorieName => $items)
                                <option value="{{ $categorieName }}">{{ $categorieName }} ({{ $items->count() }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="view-controls">
                        <button class="view-btn active" data-view="table">
                            <i class="fas fa-table"></i>
                        </button>
                        <button class="view-btn" data-view="cards">
                            <i class="fas fa-th-large"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Vue tableau -->
            <div class="table-view active" id="tableView">
                <div class="table-responsive">
                    <table class="modern-table" id="materielsTable">
                        <thead>
                            <tr>
                                <th class="col-id">
                                    <i class="fas fa-hashtag"></i>
                                    <span>ID</span>
                                </th>
                                <th class="col-materiel">
                                    <i class="fas fa-box"></i>
                                    <span>Matériel</span>
                                </th>
                                <th class="col-category d-none d-md-table-cell">
                                    <i class="fas fa-tag"></i>
                                    <span>Catégorie</span>
                                </th>
                                <th class="col-description d-none d-lg-table-cell">
                                    <i class="fas fa-file-text"></i>
                                    <span>Description</span>
                                </th>
                                <th class="col-status d-none d-xl-table-cell">
                                    <i class="fas fa-circle"></i>
                                    <span>Statut</span>
                                </th>
                                <th class="col-actions">
                                    <i class="fas fa-cog"></i>
                                    <span>Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materiels as $materiel)
                                <tr class="table-row materiel-row"
                                    data-id="{{ $materiel->id }}"
                                    data-name="{{ strtolower($materiel->nom) }}"
                                    data-category="{{ strtolower($materiel->categorie->nom ?? '') }}">
                                    <td class="cell-id">
                                        <div class="id-badge">
                                            #{{ str_pad($materiel->id, 3, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </td>
                                    <td class="cell-materiel">
                                        <div class="materiel-info">
                                            <div class="materiel-avatar">
                                                <i class="fas fa-cube"></i>
                                            </div>
                                            <div class="materiel-details">
                                                <h6 class="materiel-name">{{ $materiel->nom }}</h6>
                                                <span class="materiel-type">Équipement</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cell-category d-none d-md-table-cell">
                                        <div class="category-badge">
                                            <i class="fas fa-folder-open"></i>
                                            <span>{{ $materiel->categorie->nom ?? 'Sans catégorie' }}</span>
                                        </div>
                                    </td>
                                    <td class="cell-description d-none d-lg-table-cell">
                                        <div class="description-text">
                                            {{ $materiel->description ? Str::limit($materiel->description, 60) : 'Aucune description disponible' }}
                                        </div>
                                    </td>
                                    <td class="cell-status d-none d-xl-table-cell">
                                        <div class="status-badge available">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Disponible</span>
                                        </div>
                                    </td>
                                    <td class="cell-actions">
                                        <div class="action-buttons">
                                            <a href="{{ route('materiels.show', $materiel->id) }}"
                                               class="action-btn view"
                                               title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('materiels.edit', $materiel->id) }}"
                                               class="action-btn edit"
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <button type="button"
                                                    class="action-btn delete"
                                                    title="Supprimer"
                                                    onclick="openDeleteModal({{ $materiel->id }}, '{{ addslashes($materiel->nom) }}', '{{ addslashes($materiel->categorie->nom ?? '') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Vue cartes -->
            <div class="cards-view" id="cardsView">
                <div class="cards-grid">
                    @foreach ($materiels as $materiel)
                        <div class="materiel-card"
                             data-name="{{ strtolower($materiel->nom) }}"
                             data-category="{{ strtolower($materiel->categorie->nom ?? '') }}">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="fas fa-cube"></i>
                                </div>
                                <div class="card-id">#{{ str_pad($materiel->id, 3, '0', STR_PAD_LEFT) }}</div>
                            </div>

                            <div class="card-content">
                                <h5 class="card-title">{{ $materiel->nom }}</h5>
                                <div class="card-category">
                                    <i class="fas fa-tag"></i>
                                    <span>{{ $materiel->categorie->nom ?? 'Sans catégorie' }}</span>
                                </div>
                                <p class="card-description">
                                    {{ $materiel->description ? Str::limit($materiel->description, 120) : 'Aucune description disponible' }}
                                </p>
                                <div class="card-meta">
                                    <div class="card-status available">
                                        <i class="fas fa-circle"></i>
                                        <span>Disponible</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card-actions">
                                <a href="{{ route('materiels.show', $materiel->id) }}" class="card-btn primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('materiels.edit', $materiel->id) }}" class="card-btn secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        class="card-btn danger"
                                        onclick="openDeleteModal({{ $materiel->id }}, '{{ addslashes($materiel->nom) }}', '{{ addslashes($materiel->categorie->nom ?? '') }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal de suppression moderne -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h4 class="modal-title">Confirmer la suppression</h4>
        </div>

        <div class="modal-body">
            <p>Êtes-vous certain de vouloir supprimer ce matériel ?</p>
            <div class="deletion-preview">
                <strong id="materielNamePreview"></strong>
                <p id="materielCategoryPreview"></p>
            </div>
            <div class="warning-note">
                <i class="fas fa-info-circle"></i>
                <span>Cette action est irréversible</span>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="modal-btn secondary" onclick="closeDeleteModal()">
                Annuler
            </button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="modal-btn danger">
                    <i class="fas fa-trash"></i>
                    <span>Supprimer définitivement</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
/* Variables CSS pour les couleurs UTS */
:root {
    --primary-color: #ffc107;
    --primary-dark: #e0a800;
    --success-color: #28a745;
    --success-dark: #1e7e34;
    --warning-color: #fd7e14;
    --warning-dark: #e8590c;
    --danger-color: #dc3545;
    --danger-dark: #c82333;
    --info-color: #007bff;
    --info-dark: #0056b3;
    --light-bg: #f8f9fa;
    --white: #ffffff;
    --dark: #343a40;
    --muted: #6c757d;
    --border-color: #e9ecef;
    --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.15);
}

/* Container principal */
.materiels-container {
    padding: 1.5rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Breadcrumb moderne */
.breadcrumb-section {
    margin-bottom: 2rem;
}

.breadcrumb-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0;
    margin: 0;
    background: transparent;
    list-style: none;
}

.breadcrumb-modern .breadcrumb-item {
    display: flex;
    align-items: center;
}

.breadcrumb-modern .breadcrumb-item:not(:last-child)::after {
    content: "›";
    color: var(--primary-color);
    font-weight: bold;
    margin: 0 0.5rem;
}

.breadcrumb-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-link:hover {
    color: var(--primary-dark);
}

.breadcrumb-modern .breadcrumb-item.active {
    color: var(--muted);
}

/* En-tête de page */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon-wrapper {
    position: relative;
}

.header-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-color), var(--warning-color));
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--dark);
    box-shadow: var(--shadow);
    animation: float 3s ease-in-out infinite;
}

.icon-pulse {
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    border: 2px solid rgba(255, 193, 7, 0.3);
    border-radius: 20px;
    animation: pulse 2s ease-in-out infinite;
}

.header-text h1.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0 0 0.25rem 0;
}

.page-subtitle {
    color: var(--muted);
    margin: 0;
    font-size: 1rem;
}

.header-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-action {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-action.primary {
    background: linear-gradient(135deg, var(--primary-color), var(--warning-color));
    color: var(--dark);
}

.btn-action.primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: var(--dark);
}

.btn-action.secondary {
    background: var(--light-bg);
    color: var(--muted);
    border: 1px solid var(--border-color);
}

.btn-action.secondary:hover {
    background: var(--white);
    color: var(--dark);
    transform: translateY(-2px);
}

/* Alerts */
.alert-container {
    margin-bottom: 2rem;
}

.alert {
    background: var(--white);
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    box-shadow: var(--shadow);
    border-left: 4px solid var(--success-color);
}

.alert-icon {
    width: 40px;
    height: 40px;
    background: rgba(40, 167, 69, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--success-color);
}

.alert-content {
    flex: 1;
}

.alert-content h6 {
    margin: 0 0 0.25rem 0;
    font-weight: 600;
    color: var(--dark);
}

.alert-content p {
    margin: 0;
    color: var(--muted);
    font-size: 0.9rem;
}

.alert-close {
    background: none;
    border: none;
    color: var(--muted);
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.alert-close:hover {
    background: rgba(0, 0, 0, 0.05);
    color: var(--dark);
}

/* Grille de statistiques */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: var(--white);
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.3s ease;
    border-left: 4px solid;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-card.primary {
    border-left-color: var(--primary-color);
}

.stat-card.success {
    border-left-color: var(--success-color);
}

.stat-card.warning {
    border-left-color: var(--warning-color);
}

.stat-card.info {
    border-left-color: var(--info-color);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: var(--white);
}

.stat-card.primary .stat-icon {
    background: linear-gradient(135deg, var(--primary-color), var(--warning-color));
    color: var(--dark);
}

.stat-card.success .stat-icon {
    background: linear-gradient(135deg, var(--success-color), #20c997);
}

.stat-card.warning .stat-icon {
    background: linear-gradient(135deg, var(--warning-color), #fd7e14);
}

.stat-card.info .stat-icon {
    background: linear-gradient(135deg, var(--info-color), var(--info-dark));
}

.stat-content h3.stat-number {
    margin: 0 0 0.25rem 0;
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
}

.stat-label {
    margin: 0;
    color: var(--muted);
    font-size: 0.9rem;
    font-weight: 500;
}

/* État vide */
.empty-state {
    background: var(--white);
    border-radius: 20px;
    padding: 4rem 2rem;
    text-align: center;
    box-shadow: var(--shadow);
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--primary-color), var(--warning-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    font-size: 3rem;
    color: var(--dark);
}

.empty-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 1rem;
}

.empty-description {
    color: var(--muted);
    font-size: 1.1rem;
    line-height: 1.6;
    max-width: 500px;
    margin: 0 auto 2rem;
}

.btn-empty-action {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, var(--primary-color), var(--warning-color));
    color: var(--dark);
    padding: 1rem 2rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.btn-empty-action:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    color: var(--dark);
}

/* Container de table */
.data-table-container {
    background: var(--white);
    border-radius: 20px;
    box-shadow: var(--shadow);
    overflow: hidden;
}

.table-header {
    background: var(--light-bg);
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.table-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
}

.results-badge {
    background: var(--primary-color);
    color: var(--dark);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.table-controls {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.search-container {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
}

.search-input {
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    width: 250px;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
}

.filter-controls {
    position: relative;
}

.filter-select {
    padding: 0.75rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    font-size: 0.9rem;
    background: var(--white);
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 180px;
}

.filter-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
}

.view-controls {
    display: flex;
    gap: 0.25rem;
}

.view-btn {
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 8px;
    background: var(--white);
    color: var(--muted);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.view-btn:hover,
.view-btn.active {
    background: var(--primary-color);
    color: var(--dark);
}

/* Vue tableau */
.table-view {
    display: none;
}

.table-view.active {
    display: block;
}

.table-responsive {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
}

.modern-table thead th {
    background: var(--light-bg);
    padding: 1rem;
    font-weight: 600;
    color: var(--dark);
    border-bottom: 2px solid var(--border-color);
    font-size: 0.9rem;
}

.modern-table thead th i {
    margin-right: 0.5rem;
    color: var(--primary-color);
}

.modern-table tbody .table-row {
    transition: all 0.3s ease;
    border-bottom: 1px solid var(--border-color);
}

.modern-table tbody .table-row:hover {
    background: rgba(255, 193, 7, 0.05);
    transform: translateY(-1px);
}

.modern-table td {
    padding: 1rem;
    vertical-align: middle;
}

.id-badge {
    background: var(--light-bg);
    color: var(--dark);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.materiel-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.materiel-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary-color), var(--warning-color));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dark);
}

.materiel-name {
    margin: 0;
    font-weight: 600;
    color: var(--dark);
    font-size: 1rem;
}

.materiel-type {
    color: var(--muted);
    font-size: 0.85rem;
}

.category-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(0, 123, 255, 0.1);
    color: var(--info-color);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.description-text {
    color: var(--muted);
    font-size: 0.9rem;
    line-height: 1.4;
}

.status-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.status-badge.available {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
}

.status-badge.unavailable {
    background: rgba(220, 53, 69, 0.1);
    color: var(--danger-color);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.action-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 0.9rem;
}

.action-btn.view {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
}

.action-btn.view:hover {
    background: var(--success-color);
    color: var(--white);
    transform: translateY(-2px);
}

.action-btn.edit {
    background: rgba(255, 193, 7, 0.1);
    color: var(--primary-color);
}

.action-btn.edit:hover {
    background: var(--primary-color);
    color: var(--dark);
    transform: translateY(-2px);
}

.action-btn.delete {
    background: rgba(220, 53, 69, 0.1);
    color: var(--danger-color);
}

.action-btn.delete:hover {
    background: var(--danger-color);
    color: var(--white);
    transform: translateY(-2px);
}

/* Vue cartes */
.cards-view {
    display: none;
    padding: 1.5rem;
}

.cards-view.active {
    display: block;
}

.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.materiel-card {
    background: var(--white);
    border: 1px solid var(--border-color);
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: var(--shadow);
}

.materiel-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-color);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.card-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, var(--primary-color), var(--warning-color));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dark);
    font-size: 1.25rem;
}

.card-id {
    background: var(--light-bg);
    color: var(--dark);
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 600;
}

.card-content {
    margin-bottom: 1.5rem;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.75rem;
}

.card-category {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--info-color);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.card-description {
    color: var(--muted);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.card-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    font-weight: 500;
}

.card-status.available {
    color: var(--success-color);
}

.card-status.unavailable {
    color: var(--danger-color);
}

.card-actions {
    display: flex;
    gap: 0.5rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.card-btn {
    flex: 1;
    padding: 0.75rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.card-btn.primary {
    background: rgba(40, 167, 69, 0.1);
    color: var(--success-color);
}

.card-btn.primary:hover {
    background: var(--success-color);
    color: var(--white);
}

.card-btn.secondary {
    background: rgba(255, 193, 7, 0.1);
    color: var(--primary-color);
}

.card-btn.secondary:hover {
    background: var(--primary-color);
    color: var(--dark);
}

.card-btn.danger {
    background: rgba(220, 53, 69, 0.1);
    color: var(--danger-color);
}

.card-btn.danger:hover {
    background: var(--danger-color);
    color: var(--white);
}

/* Modal moderne */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-container {
    background: var(--white);
    border-radius: 20px;
    max-width: 500px;
    width: 90%;
    box-shadow: var(--shadow-lg);
    transform: scale(0.9);
    transition: transform 0.3s ease;
}

.modal-overlay.active .modal-container {
    transform: scale(1);
}

.modal-header {
    padding: 2rem 2rem 1rem;
    text-align: center;
}

.modal-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 193, 7, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    color: var(--warning-color);
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0;
}

.modal-body {
    padding: 0 2rem 1rem;
    text-align: center;
}

.modal-body p {
    color: var(--muted);
    font-size: 1rem;
    margin-bottom: 1.5rem;
}

.deletion-preview {
    background: var(--light-bg);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    text-align: left;
}

.deletion-preview strong {
    color: var(--dark);
    font-size: 1.1rem;
}

.deletion-preview p {
    color: var(--muted);
    font-size: 0.9rem;
    margin: 0.5rem 0 0;
}

.warning-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: var(--warning-color);
    font-size: 0.9rem;
    font-weight: 500;
}

.modal-footer {
    padding: 1rem 2rem 2rem;
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.modal-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modal-btn.secondary {
    background: var(--light-bg);
    color: var(--muted);
}

.modal-btn.secondary:hover {
    background: var(--border-color);
    color: var(--dark);
}

.modal-btn.danger {
    background: var(--danger-color);
    color: var(--white);
}

.modal-btn.danger:hover {
    background: var(--danger-dark);
    transform: translateY(-1px);
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

/* Responsive Design */
@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    }

    .table-controls {
        flex-wrap: wrap;
        gap: 0.75rem;
    }
}

@media (max-width: 992px) {
    .page-header {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
    }

    .header-content {
        justify-content: center;
        margin-bottom: 1rem;
    }

    .table-header {
        flex-direction: column;
        gap: 1rem;
    }

    .table-controls {
        width: 100%;
        justify-content: center;
    }

    .search-input {
        width: 200px;
    }

    .filter-select {
        min-width: 160px;
    }
}

@media (max-width: 768px) {
    .materiels-container {
        padding: 1rem;
    }

    .page-header h1.page-title {
        font-size: 1.5rem;
    }

    .header-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
    }

    .stat-card {
        padding: 1rem;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .stat-content h3.stat-number {
        font-size: 1.5rem;
    }

    .cards-grid {
        grid-template-columns: 1fr;
    }

    .modal-container {
        width: 95%;
    }

    .modal-header {
        padding: 1.5rem 1.5rem 1rem;
    }

    .modal-body {
        padding: 0 1.5rem 1rem;
    }

    .modal-footer {
        padding: 1rem 1.5rem 1.5rem;
        flex-direction: column;
    }
}

@media (max-width: 576px) {
    .breadcrumb-modern {
        flex-wrap: wrap;
    }

    .header-actions {
        flex-direction: column;
        width: 100%;
    }

    .btn-action {
        justify-content: center;
    }

    .search-input {
        width: 100%;
    }

    .filter-select {
        width: 100%;
    }

    .table-controls {
        flex-direction: column;
        align-items: stretch;
    }

    .view-controls {
        justify-content: center;
        margin-top: 1rem;
    }

    .action-buttons {
        flex-wrap: wrap;
    }

    .modal-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }

    .modal-title {
        font-size: 1.25rem;
    }
}

/* Print Styles */
@media print {
    .btn-action,
    .search-container,
    .filter-controls,
    .view-controls,
    .action-buttons,
    .modal-overlay {
        display: none !important;
    }

    .materiels-container {
        padding: 0;
    }

    .data-table-container {
        box-shadow: none;
        border: 1px solid #000;
    }

    .table-header {
        background: #f8f9fa;
        border-bottom: 2px solid #000;
    }

    .modern-table {
        font-size: 12pt;
    }

    .materiel-card {
        border: 1px solid #000;
        margin-bottom: 1rem;
        break-inside: avoid;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du DOM
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const tableView = document.getElementById('tableView');
    const cardsView = document.getElementById('cardsView');
    const viewButtons = document.querySelectorAll('.view-btn');
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');

    // Fonction de recherche et filtrage
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value.toLowerCase();

        // Recherche dans la vue tableau
        const tableRows = document.querySelectorAll('.materiel-row');
        let visibleCount = 0;

        tableRows.forEach(row => {
            const materielName = row.dataset.name;
            const materielCategory = row.dataset.category;

            const matchesSearch = materielName.includes(searchTerm) || searchTerm === '';
            const matchesCategory = materielCategory.includes(selectedCategory) || selectedCategory === '';

            const isVisible = matchesSearch && matchesCategory;
            row.style.display = isVisible ? '' : 'none';

            if (isVisible) visibleCount++;
        });

        // Recherche dans la vue cartes
        const materielCards = document.querySelectorAll('.materiel-card');
        materielCards.forEach(card => {
            const materielName = card.dataset.name;
            const materielCategory = card.dataset.category;

            const matchesSearch = materielName.includes(searchTerm) || searchTerm === '';
            const matchesCategory = materielCategory.includes(selectedCategory) || selectedCategory === '';

            const isVisible = matchesSearch && matchesCategory;
            card.style.display = isVisible ? '' : 'none';
        });

        // Mettre à jour le badge de résultats
        const resultsBadge = document.querySelector('.results-badge');
        if (resultsBadge) {
            resultsBadge.textContent = `${visibleCount} matériel(s)`;
        }
    }

    // Event listeners pour la recherche et le filtrage
    if (searchInput) {
        searchInput.addEventListener('input', performSearch);
        searchInput.addEventListener('keyup', performSearch);
    }

    if (categoryFilter) {
        categoryFilter.addEventListener('change', performSearch);
    }

    // Gestion des vues (tableau/cartes)
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const viewType = this.dataset.view;

            // Mettre à jour les boutons actifs
            viewButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Basculer les vues
            if (viewType === 'table') {
                tableView.classList.add('active');
                cardsView.classList.remove('active');
            } else {
                tableView.classList.remove('active');
                cardsView.classList.add('active');
            }
        });
    });

    // Fonction pour ouvrir le modal de suppression
    window.openDeleteModal = function(id, name, category) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const namePreview = document.getElementById('materielNamePreview');
        const categoryPreview = document.getElementById('materielCategoryPreview');

        // Mettre à jour le contenu du modal
        if (namePreview) namePreview.textContent = name;
        if (categoryPreview) {
            categoryPreview.textContent = category ? `Catégorie : ${category}` : 'Sans catégorie';
        }

        // Mettre à jour l'action du formulaire
        if (form) {
            form.action = `/materiels/${id}`;
        }

        // Afficher le modal
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };

    // Fonction pour fermer le modal de suppression
    window.closeDeleteModal = function() {
        const modal = document.getElementById('deleteModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    // Fermer le modal en cliquant sur l'overlay
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    }

    // Fermer le modal avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Animation d'entrée pour les cartes statistiques
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Auto-dismiss pour les alertes
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentElement) {
                alert.style.transition = 'all 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    if (alert.parentElement) {
                        alert.parentElement.remove();
                    }
                }, 500);
            }
        }, 5000);
    });

    // Gestion du focus pour l'accessibilité
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-navigation');
        }
    });

    document.addEventListener('mousedown', function() {
        document.body.classList.remove('keyboard-navigation');
    });

    // Initialisation de la recherche au chargement
    performSearch();
});

// Fonction utilitaire pour debounce la recherche
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
</script>
@endsection
