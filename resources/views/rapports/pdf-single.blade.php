<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $rapport->titre }}</title>
    <style>
        @page {
            margin: 20mm 15mm 25mm 15mm;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #007bff;
            font-size: 24px;
            margin: 0 0 10px 0;
        }

        .header .subtitle {
            color: #666;
            font-size: 12px;
        }

        .meta-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
            border-left: 4px solid #007bff;
        }

        .meta-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .meta-info td {
            padding: 5px 10px;
        }

        .meta-info .label {
            font-weight: bold;
            color: #007bff;
            width: 150px;
        }

        .content {
            margin-top: 30px;
            margin-bottom: 50px;
            text-align: justify;
        }

        .content h2 {
            color: #007bff;
            font-size: 16px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
            margin-top: 30px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #999;
            padding: 10px 0;
            border-top: 1px solid #e9ecef;
            background: white;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $rapport->titre }}</h1>
        <div class="subtitle">Rapport généré le {{ now()->format('d/m/Y à H:i') }}</div>
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td class="label">Référence :</td>
                <td>RAPPORT-{{ str_pad($rapport->id, 6, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="label">Auteur :</td>
                <td>{{ $rapport->auteur->name ?? 'Non défini' }}</td>
            </tr>
            <tr>
                <td class="label">Date du rapport :</td>
                <td>{{ $rapport->date_rapport ? $rapport->date_rapport->format('d/m/Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Créé le :</td>
                <td>{{ $rapport->created_at ? $rapport->created_at->format('d/m/Y à H:i') : '-' }}</td>
            </tr>
            @if($rapport->updated_at && $rapport->updated_at != $rapport->created_at)
            <tr>
                <td class="label">Dernière modification :</td>
                <td>{{ $rapport->updated_at->format('d/m/Y à H:i') }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="content">
        <h2>Contenu du rapport</h2>
        {!! nl2br(e($rapport->contenu)) !!}
    </div>

    <div class="footer">
        <div>Université Thomas Sankara - Système de Gestion</div>
        <div >Page <span class="page-number"></span></div>
    </div>
</body>
</html>
