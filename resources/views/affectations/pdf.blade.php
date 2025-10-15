<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Affectations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-primary { background-color: #007bff; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>📋 Liste des Affectations de Matériel</h1>
    <p style="text-align: center; color: #666;">
        Généré le {{ now()->format('d/m/Y à H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Matériel</th>
                <th>Utilisateur</th>
                <th>Service</th>
                <th>Date Affectation</th>
                <th>Date Retour</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($affectations as $affectation)
            <tr>
                <td>{{ $affectation->numero_affectation }}</td>
                <td>{{ $affectation->materiel->nom ?? $affectation->materiel->name ?? '-' }}</td>
                <td>{{ $affectation->user->name ?? '-' }}</td>
                <td>{{ $affectation->service->nom ?? $affectation->service->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($affectation->date_affectation)->format('d/m/Y') }}</td>
                <td>{{ $affectation->date_retour ? \Carbon\Carbon::parse($affectation->date_retour)->format('d/m/Y') : '-' }}</td>
                <td>
                    <span class="badge badge-{{ $affectation->statut_badge }}">
                        {{ ucfirst($affectation->statut) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total : {{ count($affectations) }} affectation(s)</p>
        <p>© {{ date('Y') }} - Système de Gestion de Matériel</p>
    </div>
</body>
</html>
