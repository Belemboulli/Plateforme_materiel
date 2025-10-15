@extends('layouts.app')

@section('content')
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

    .bg-uts-rouge { background-color: var(--uts-red) !important; }
    .bg-uts-jaune { background-color: var(--uts-yellow) !important; }
    .bg-uts-vert { background-color: var(--uts-green) !important; }
    .bg-uts-orange { background-color: var(--uts-yellow-dark) !important; }

    .btn-uts-rouge {
        background: linear-gradient(45deg, var(--uts-red), #EF4444);
        border: 2px solid var(--uts-yellow);
        color: white;
        transition: all 0.3s ease;
    }
    .btn-uts-rouge:hover {
        background: linear-gradient(45deg, #B91C1C, var(--uts-red));
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(211, 47, 47, 0.4);
        color: white;
    }

    .btn-uts-vert {
        background: linear-gradient(45deg, var(--uts-green), var(--uts-green-light));
        border: 2px solid var(--uts-yellow);
        color: white;
        transition: all 0.3s ease;
    }
    .btn-uts-vert:hover {
        background: linear-gradient(45deg, var(--uts-green-dark), var(--uts-green));
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(46, 125, 50, 0.4);
        color: white;
    }

    .btn-uts-orange {
        background: linear-gradient(45deg, var(--uts-yellow-dark), #FB923C);
        border: 2px solid var(--uts-green);
        color: white;
        transition: all 0.3s ease;
    }
    .btn-uts-orange:hover {
        background: linear-gradient(45deg, #C2410C, var(--uts-yellow-dark));
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        color: white;
    }

    .btn-uts-jaune {
        background: linear-gradient(45deg, var(--uts-yellow), var(--uts-yellow-dark));
        border: 2px solid var(--uts-green);
        color: var(--uts-dark);
        transition: all 0.3s ease;
    }
    .btn-uts-jaune:hover {
        background: linear-gradient(45deg, var(--uts-yellow-dark), var(--uts-yellow));
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
        color: var(--uts-dark);
    }

    .rapport-container {
        background: linear-gradient(135deg, var(--uts-cream) 0%, var(--uts-warm) 100%);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(46, 125, 50, 0.1);
        overflow: hidden;
        animation: slideInUp 0.6s ease-out;
        border: 3px solid var(--uts-yellow);
    }

    .rapport-header {
        background: linear-gradient(135deg, var(--uts-green) 0%, var(--uts-green-light) 50%, var(--uts-yellow) 100%);
        color: white;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .rapport-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        position: relative;
        z-index: 1;
    }

    .rapport-meta {
        background: var(--uts-warm);
        padding: 2rem;
        margin: -1rem 2rem 2rem 2rem;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(46, 125, 50, 0.1);
        position: relative;
        z-index: 2;
        border: 2px solid var(--uts-sage);
    }

    .meta-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        padding: 0.8rem;
        background: var(--uts-sage);
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 1px solid var(--uts-yellow);
    }

    .meta-item:hover {
        background: var(--uts-cream);
        transform: translateX(5px);
        border-color: var(--uts-green);
    }

    .meta-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
        font-size: 1.2rem;
    }

    .meta-content {
        flex: 1;
    }

    .meta-label {
        font-weight: 600;
        color: var(--uts-dark);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .meta-value {
        color: var(--uts-green);
        font-size: 1.1rem;
        margin-top: 2px;
        font-weight: 500;
    }

    .rapport-content {
        padding: 2.5rem;
        background: var(--uts-cream);
        margin: 0 2rem 2rem 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(46, 125, 50, 0.08);
        line-height: 1.8;
        font-size: 1.1rem;
        color: var(--uts-dark);
        border: 2px solid var(--uts-sage);
    }

    .action-bar {
        padding: 2rem;
        background: linear-gradient(135deg, var(--uts-sage) 0%, var(--uts-warm) 100%);
        border-top: 3px solid var(--uts-green);
    }

    .breadcrumb-custom {
        background: var(--uts-sage);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 0.8rem 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(46, 125, 50, 0.1);
        border: 2px solid var(--uts-yellow);
    }

    .breadcrumb-custom a {
        color: var(--uts-green);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-custom a:hover {
        color: var(--uts-yellow-dark);
    }

    .floating-actions {
        position: fixed;
        right: 30px;
        bottom: 30px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        z-index: 1000;
    }

    .floating-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 2px solid white;
        color: white;
        font-size: 1.3rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
    }

    .floating-btn:hover {
        transform: scale(1.1) translateY(-3px);
        color: white;
        box-shadow: 0 12px 35px rgba(0,0,0,0.4);
    }

    .word-count {
        background: linear-gradient(45deg, var(--uts-green), var(--uts-green-light));
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        margin-bottom: 1rem;
        border: 2px solid white;
    }

    .reading-time {
        background: linear-gradient(45deg, var(--uts-yellow-dark), #FB923C);
        color: var(--uts-dark);
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        margin-left: 10px;
        border: 2px solid white;
    }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(50px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .rapport-title { font-size: 1.8rem; }
        .rapport-header { padding: 2rem 1.5rem; }
        .rapport-meta, .rapport-content { margin: 0 1rem 1.5rem 1rem; padding: 1.5rem; }
        .floating-actions { right: 20px; bottom: 20px; }
        .floating-btn { width: 50px; height: 50px; font-size: 1.1rem; }
    }

    @media print {
        .print-hide { display: none !important; }
        .rapport-container { box-shadow: none; border: 1px solid #ddd; }
    }
</style>

<div class="container-fluid py-4">
    <nav aria-label="breadcrumb" class="print-hide">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home me-1"></i>Accueil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('rapports.index') }}"><i class="fas fa-file-alt me-1"></i>Rapports</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($rapport->titre, 30) }}</li>
        </ol>
    </nav>

    <div class="rapport-container">
        <div class="rapport-header">
            <h1 class="rapport-title"><i class="fas fa-file-text me-3"></i>{{ $rapport->titre }}</h1>
            <div class="d-flex align-items-center">
                <div class="word-count"><i class="fas fa-font me-1"></i>{{ str_word_count($rapport->contenu) }} mots</div>
                <div class="reading-time"><i class="fas fa-clock me-1"></i>{{ ceil(str_word_count($rapport->contenu) / 200) }} min de lecture</div>
            </div>
        </div>

        <div class="rapport-meta">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="meta-item">
                        <div class="meta-icon bg-uts-vert"><i class="fas fa-user"></i></div>
                        <div class="meta-content">
                            <div class="meta-label">Auteur</div>
                            <div class="meta-value">{{ $rapport->auteur->name ?? 'Utilisateur Anonyme' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="meta-item">
                        <div class="meta-icon bg-uts-orange"><i class="fas fa-calendar-alt"></i></div>
                        <div class="meta-content">
                            <div class="meta-label">Date de création</div>
                            <div class="meta-value">
                                {{ \Carbon\Carbon::parse($rapport->date_rapport)->format('d F Y') }}
                                <small class="text-muted d-block">{{ \Carbon\Carbon::parse($rapport->date_rapport)->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="meta-item">
                        <div class="meta-icon bg-uts-rouge"><i class="fas fa-hashtag"></i></div>
                        <div class="meta-content">
                            <div class="meta-label">Référence</div>
                            <div class="meta-value">RPT-{{ str_pad($rapport->id, 6, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="meta-item">
                        <div class="meta-icon bg-uts-jaune"><i class="fas fa-clock"></i></div>
                        <div class="meta-content">
                            <div class="meta-label">Créé le</div>
                            <div class="meta-value">{{ $rapport->created_at ? $rapport->created_at->format('d/m/Y à H:i') : '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rapport-content">
            <h3 class="text-uts-rouge mb-4"><i class="fas fa-file-text me-2"></i>Contenu du Rapport</h3>
            <div class="rapport-text">{!! nl2br(e($rapport->contenu)) !!}</div>
        </div>

        <div class="action-bar print-hide">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <a href="{{ route('rapports.index') }}" class="btn btn-outline-secondary btn-lg me-3" style="border: 2px solid var(--uts-green); color: var(--uts-green);">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                    </a>
                    <a href="{{ route('rapports.edit', $rapport) }}" class="btn btn-uts-jaune btn-lg">
                        <i class="fas fa-edit me-2"></i>Modifier
                    </a>
                </div>
                <div class="col-md-6 text-end">
                    <small style="color: var(--uts-green);"><i class="fas fa-eye me-1"></i>Dernière consultation : {{ now()->format('d/m/Y à H:i') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="floating-actions print-hide">
    <button onclick="window.print()" class="floating-btn bg-uts-rouge" title="Imprimer"><i class="fas fa-print"></i></button>
    <button onclick="shareReport()" class="floating-btn bg-uts-vert" title="Partager"><i class="fas fa-share-alt"></i></button>
    <a href="{{ route('rapports.pdf', $rapport->id) }}" class="floating-btn bg-uts-orange" title="Télécharger PDF"><i class="fas fa-download"></i></a>
    <button onclick="toggleFavorite({{ $rapport->id }})" class="floating-btn bg-uts-jaune" title="Favoris" id="favoriteBtn"><i class="far fa-heart"></i></button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() { checkFavoriteStatus({{ $rapport->id }}); });

function shareReport() {
    if (navigator.share) {
        navigator.share({ title: '{{ $rapport->titre }}', text: 'Consultez ce rapport', url: window.location.href }).catch(() => copyToClipboard());
    } else {
        copyToClipboard();
    }
}

function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(() => showNotification('Lien copié!', 'success'));
}

function toggleFavorite(rapportId) {
    const btn = document.getElementById('favoriteBtn');
    const icon = btn.querySelector('i');
    let favorites = JSON.parse(localStorage.getItem('rapport_favorites') || '[]');

    if (favorites.includes(rapportId)) {
        favorites = favorites.filter(id => id !== rapportId);
        icon.classList.remove('fas'); icon.classList.add('far');
        showNotification('Retiré des favoris', 'info');
    } else {
        favorites.push(rapportId);
        icon.classList.remove('far'); icon.classList.add('fas');
        showNotification('Ajouté aux favoris', 'success');
    }
    localStorage.setItem('rapport_favorites', JSON.stringify(favorites));
}

function checkFavoriteStatus(rapportId) {
    const favorites = JSON.parse(localStorage.getItem('rapport_favorites') || '[]');
    const btn = document.getElementById('favoriteBtn');
    const icon = btn.querySelector('i');
    if (favorites.includes(rapportId)) { icon.classList.remove('far'); icon.classList.add('fas'); }
}

function showNotification(message, type = 'info') {
    const colors = { success: 'var(--uts-green)', error: 'var(--uts-red)', info: 'var(--uts-yellow-dark)' };
    const notification = document.createElement('div');
    notification.style.cssText = `position: fixed; top: 20px; right: 20px; background: ${colors[type]}; color: white; padding: 1rem 1.5rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index: 9999; font-weight: 600; border: 2px solid white;`;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>
@endsection
