@extends('layouts.app')

@section('title', 'Détail du rôle - ' . $role->name)

@push('styles')
<style>
    .uts-primary { color: #2E7D32; }
    .uts-warning { color: #FFA000; }
    .bg-uts-primary { background-color: #2E7D32; }
    .bg-uts-warning { background-color: #FFA000; }
    .bg-uts-gradient { background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%); }
    .bg-warning-gradient { background: linear-gradient(135deg, #FFA000 0%, #FFB74D 100%); }

    .role-header {
        background: linear-gradient(135deg, var(--role-color, #2E7D32) 0%, var(--role-color-light, #4CAF50) 100%);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        color: white;
    }

    .role-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.08'%3E%3Ccircle cx='7' cy='7' r='2'/%3E%3Ccircle cx='27' cy='7' r='2'/%3E%3Ccircle cx='47' cy='7' r='2'/%3E%3Ccircle cx='7' cy='27' r='2'/%3E%3Ccircle cx='27' cy='27' r='2'/%3E%3Ccircle cx='47' cy='27' r='2'/%3E%3Ccircle cx='7' cy='47' r='2'/%3E%3Ccircle cx='27' cy='47' r='2'/%3E%3Ccircle cx='47' cy='47' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
    }

    .role-icon {
        width: 90px;
        height: 90px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        backdrop-filter: blur(10px);
        border: 3px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .info-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 6px 25px rgba(46, 125, 50, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(46, 125, 50, 0.15);
    }

    .info-card .card-header {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.1), rgba(255, 160, 0, 0.1));
        border-bottom: 2px solid rgba(46, 125, 50, 0.1);
    }

    .permission-item {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.05), rgba(46, 125, 50, 0.02));
        border: 1px solid rgba(46, 125, 50, 0.1);
        border-radius: 10px;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .permission-item:hover {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.1), rgba(46, 125, 50, 0.05));
        border-color: #2E7D32;
        transform: translateY(-1px);
    }

    .user-item {
        background: white;
        border: 2px solid rgba(46, 125, 50, 0.1);
        border-radius: 12px;
        padding: 15px;
        transition: all 0.3s ease;
    }

    .user-item:hover {
        border-color: #2E7D32;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.15);
        transform: translateY(-2px);
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #2E7D32, #4CAF50);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        box-shadow: 0 3px 10px rgba(46, 125, 50, 0.3);
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .priority-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .btn-uts-primary {
        background: linear-gradient(45deg, #2E7D32, #4CAF50);
        border: none;
        color: white;
        border-radius: 10px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-uts-primary:hover {
        background: linear-gradient(45deg, #1B5E20, #2E7D32);
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-uts-warning {
        background: linear-gradient(45deg, #FFA000, #FFB74D);
        border: none;
        color: white;
        border-radius: 10px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-uts-warning:hover {
        background: linear-gradient(45deg, #FF8F00, #FFA000);
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .color-display {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        border: 3px solid #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .empty-state {
        background: linear-gradient(135deg, rgba(46, 125, 50, 0.05), rgba(255, 160, 0, 0.05));
        border-radius: 15px;
        padding: 3rem;
        border: 2px dashed rgba(46, 125, 50, 0.2);
    }

    .dropdown-menu {
        border: 1px solid rgba(46, 125, 50, 0.15);
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.1);
        border-radius: 10px;
    }

    .dropdown-item:hover {
        background-color: rgba(46, 125, 50, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <!-- En-tête du rôle -->
            <div class="role-header p-5 mb-5 text-center"
                 style="--role-color: #2E7D32; --role-color-light: #4CAF50;">
                <div class="position-relative">
                    <div class="role-icon">
                        <i class="fas fa-user-shield fa-3x text-white"></i>
                    </div>
                    <h1 class="fw-bold mb-3">{{ $role->name }}</h1>
                    <div class="d-flex justify-content-center align-items-center flex-wrap gap-3">
                        @if($role->is_active ?? true)
                            <span class="status-badge bg-success">
                                <i class="fas fa-check-circle me-2"></i>Actif
                            </span>
                        @else
                            <span class="status-badge bg-secondary">
                                <i class="fas fa-pause-circle me-2"></i>Inactif
                            </span>
                        @endif

                        @if(isset($role->priority_level))
                            @php
                                // Suppression complète du bleu - utilisation des couleurs UTS uniquement
                                $priorityData = match($role->priority_level) {
                                    1 => ['class' => 'danger', 'label' => 'Très élevé', 'icon' => 'fas fa-exclamation-circle'],
                                    2 => ['class' => 'warning', 'label' => 'Élevé', 'icon' => 'fas fa-exclamation-triangle'],
                                    3 => ['class' => 'success', 'label' => 'Moyen', 'icon' => 'fas fa-info-circle'], // Vert au lieu de bleu
                                    4 => ['class' => 'secondary', 'label' => 'Faible', 'icon' => 'fas fa-minus-circle'],
                                    5 => ['class' => 'light text-dark', 'label' => 'Très faible', 'icon' => 'fas fa-circle'],
                                    default => ['class' => 'secondary', 'label' => 'Non défini', 'icon' => 'fas fa-question-circle']
                                };
                            @endphp
                            <span class="priority-badge bg-{{ $priorityData['class'] }}">
                                <i class="{{ $priorityData['icon'] }} me-2"></i>{{ $priorityData['label'] }}
                            </span>
                        @endif
                    </div>
                    <p class="mt-3 mb-0 opacity-90 fs-5">Université Thomas Sankara - Système de gestion</p>
                </div>
            </div>

            <!-- Messages de succès/erreur -->
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-3 mb-4">
                    <i class="fas fa-check-circle uts-primary me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 rounded-3 mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <!-- Informations détaillées -->
            <div class="card info-card mb-4">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold uts-primary">
                        <i class="fas fa-info-circle me-2"></i>Informations détaillées
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <!-- Description -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="fw-bold uts-primary mb-2 d-block">
                                    <i class="fas fa-align-left me-2"></i>Description
                                </label>
                                <div class="p-3 bg-light rounded-3 border-start border-4 border-success">
                                    {{ $role->description ?? 'Aucune description fournie pour ce rôle.' }}
                                </div>
                            </div>
                        </div>

                        <!-- Métadonnées -->
                        <div class="col-md-6">
                            <label class="fw-bold uts-primary mb-2 d-block">
                                <i class="fas fa-hashtag me-2"></i>Identifiant
                            </label>
                            <span class="badge bg-light text-dark fs-6 px-3 py-2">#{{ $role->id }}</span>
                        </div>

                        @if(isset($role->users_count))
                        <div class="col-md-6">
                            <label class="fw-bold uts-primary mb-2 d-block">
                                <i class="fas fa-users me-2"></i>Utilisateurs assignés
                            </label>
                            <span class="badge bg-uts-warning text-white fs-6 px-3 py-2">{{ $role->users_count }} utilisateur(s)</span>
                        </div>
                        @endif

                        <div class="col-md-6">
                            <label class="fw-bold uts-primary mb-2 d-block">
                                <i class="fas fa-calendar-plus me-2"></i>Date de création
                            </label>
                            <div class="text-dark">{{ $role->created_at ? $role->created_at->format('d/m/Y à H:i') : 'Non disponible' }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold uts-primary mb-2 d-block">
                                <i class="fas fa-calendar-edit me-2"></i>Dernière modification
                            </label>
                            <div class="text-dark">{{ $role->updated_at ? $role->updated_at->format('d/m/Y à H:i') : 'Non disponible' }}</div>
                        </div>

                        @if(isset($role->color))
                        <div class="col-12">
                            <label class="fw-bold uts-primary mb-3 d-block">
                                <i class="fas fa-palette me-2"></i>Couleur d'identification
                            </label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="color-display" style="background-color: {{ $role->color }};"></div>
                                <div>
                                    <code class="bg-light px-3 py-2 rounded-3 fs-6">{{ $role->color }}</code>
                                    <div class="small text-muted mt-1">Couleur utilisée pour identifier visuellement ce rôle</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            @if(isset($role->permissions) && $role->permissions->count() > 0)
            <div class="card info-card mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold uts-warning">
                        <i class="fas fa-key me-2"></i>Permissions accordées
                    </h5>
                    <span class="badge bg-uts-warning text-white px-3 py-2">{{ $role->permissions->count() }} permission(s)</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($role->permissions as $permission)
                        <div class="col-lg-4 col-md-6">
                            <div class="permission-item d-flex align-items-center">
                                <i class="fas fa-shield-alt uts-primary me-3 fa-lg"></i>
                                <div>
                                    <div class="fw-semibold">{{ $permission->name }}</div>
                                    @if($permission->description)
                                        <small class="text-muted">{{ Str::limit($permission->description, 30) }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <div class="card info-card mb-4">
                <div class="card-header py-3">
                    <h5 class="mb-0 fw-bold text-muted">
                        <i class="fas fa-key me-2"></i>Permissions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="empty-state text-center">
                        <i class="fas fa-lock fa-3x uts-primary opacity-50 mb-3"></i>
                        <h6 class="uts-primary">Aucune permission spécifique</h6>
                        <p class="text-muted mb-0">Ce rôle n'a pas de permissions spécifiques accordées.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Utilisateurs avec ce rôle -->
            @if(isset($role->users) && $role->users->count() > 0)
            <div class="card info-card mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold uts-primary">
                        <i class="fas fa-users me-2"></i>Utilisateurs avec ce rôle
                    </h5>
                    <span class="badge bg-uts-primary text-white px-3 py-2">{{ $role->users->count() }} utilisateur(s)</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($role->users->take(6) as $user)
                        <div class="col-lg-4 col-md-6">
                            <div class="user-item d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @if($role->users->count() > 6)
                        <div class="col-12 text-center mt-4">
                            <button class="btn btn-outline-secondary px-4" onclick="showAllUsers()">
                                <i class="fas fa-plus me-2"></i>
                                Voir {{ $role->users->count() - 6 }} autre(s) utilisateur(s)
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Boutons d'action -->
            <div class="card info-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                        </a>

                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-uts-warning px-4">
                                <i class="fas fa-edit me-2"></i>Modifier
                            </a>

                            <a href="#" class="btn btn-uts-primary px-4" onclick="managePermissions()">
                                <i class="fas fa-key me-2"></i>Gérer permissions
                            </a>

                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-h me-2"></i>Actions
                                </button>
                                <ul class="dropdown-menu shadow">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="duplicateRole()">
                                            <i class="fas fa-copy me-2 uts-primary"></i>Dupliquer ce rôle
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="exportRole()">
                                            <i class="fas fa-download me-2 uts-warning"></i>Exporter les détails
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="window.print()">
                                            <i class="fas fa-print me-2 uts-warning"></i>Imprimer
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" onclick="deleteRole()">
                                            <i class="fas fa-trash me-2"></i>Supprimer le rôle
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée pour les cartes
    const cards = document.querySelectorAll('.info-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });
});

// Fonction pour gérer les permissions
function managePermissions() {
    alert('Fonctionnalité de gestion des permissions.\n\nCette fonction permettra de :\n- Ajouter/retirer des permissions\n- Modifier les niveaux d\'accès\n- Configurer les restrictions\n\nEn cours de développement...');
}

// Fonction pour dupliquer le rôle
function duplicateRole() {
    if (confirm('Dupliquer le rôle "{{ $role->name }}" ?\n\nCela créera une copie avec le même nom suivi de "(Copie)".')) {
        // Redirection vers la route de duplication si elle existe
        @if(Route::has('roles.duplicate'))
            window.location.href = '{{ route('roles.duplicate', $role) }}';
        @else
            alert('Fonctionnalité de duplication en cours de développement...');
        @endif
    }
}

// Fonction pour exporter le rôle
function exportRole() {
    const roleData = {
        nom: '{{ $role->name }}',
        description: '{{ $role->description ?? "Aucune description" }}',
        priorite: '{{ $role->priority_level ?? "Non définie" }}',
        statut: '{{ $role->is_active ? "Actif" : "Inactif" }}',
        couleur: '{{ $role->color ?? "Non définie" }}',
        utilisateurs: {{ $role->users_count ?? 0 }},
        permissions: {{ isset($role->permissions) ? $role->permissions->count() : 0 }}
    };

    const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(roleData, null, 2));
    const downloadAnchorNode = document.createElement('a');
    downloadAnchorNode.setAttribute("href", dataStr);
    downloadAnchorNode.setAttribute("download", "role_{{ $role->name }}_export.json");
    document.body.appendChild(downloadAnchorNode);
    downloadAnchorNode.click();
    downloadAnchorNode.remove();
}

// Fonction pour supprimer le rôle
function deleteRole() {
    if (confirm('ATTENTION : Suppression définitive du rôle "{{ $role->name }}"\n\nCette action supprimera :\n✗ Le rôle lui-même\n✗ Toutes les associations utilisateurs\n✗ Toutes les permissions liées\n\nCette action est IRRÉVERSIBLE !\n\nConfirmer la suppression ?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('roles.destroy', $role) }}';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        form.appendChild(csrfToken);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Fonction pour afficher tous les utilisateurs
function showAllUsers() {
    alert('Affichage de tous les utilisateurs avec ce rôle.\n\nCette fonction ouvrira une vue détaillée avec :\n- Liste complète des utilisateurs\n- Possibilité de retirer le rôle\n- Statistiques d\'utilisation\n\nEn cours de développement...');
}
</script>
@endpush
