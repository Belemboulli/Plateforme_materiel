<?php

namespace App\Http\Controllers;

use App\Models\HistoriqueConnexion;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HistoriqueConnexionController extends Controller
{
    public function __construct()
    {
        // Protection par middleware (auth + autorisations via policies)
        $this->middleware('auth');
    }

    /**
     * Liste paginée des historiques de connexion
     */
    public function index(): View
    {
        $historiques = HistoriqueConnexion::with('user')
            ->latest('connecte_le')
            ->paginate(10);

        return view('historiques_connexion.index', compact('historiques'));
    }

    /**
     * Supprimer un historique de connexion
     */
    public function destroy(HistoriqueConnexion $historiqueConnexion): RedirectResponse
    {
        $this->authorize('delete', $historiqueConnexion);

        $historiqueConnexion->delete();

        return redirect()
            ->route('historiques_connexion.index')
            ->with('success', 'Historique supprimé avec succès.');
    }

    /**
     * Exporter les historiques au format CSV
     */
    public function export(): StreamedResponse
    {
        $fileName = 'historiques_connexion_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            // Entête CSV
            fputcsv($handle, ['ID', 'Utilisateur', 'IP', 'Navigateur', 'OS', 'État', 'Connecté le']);

            // Chunk pour éviter surcharge mémoire
            HistoriqueConnexion::with('user')->chunk(100, function ($historiques) use ($handle) {
                foreach ($historiques as $h) {
                    fputcsv($handle, [
                        $h->id,
                        $h->user->name ?? 'N/A',
                        $h->ip_address,
                        $h->navigateur,
                        $h->os,
                        ucfirst($h->etat),
                        $h->connecte_le->format('d/m/Y H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Supprimer les historiques plus vieux que 6 mois
     */
    public function clean(): RedirectResponse
    {
        $deleted = HistoriqueConnexion::where('connecte_le', '<', now()->subMonths(6))->delete();

        return redirect()
            ->route('historiques_connexion.index')
            ->with('success', "$deleted historiques supprimés.");
    }

    /**
     * Enregistrer une nouvelle connexion utilisateur
     */
    public static function logConnexion(
        int $userId,
        string $ip,
        string $navigateur,
        string $os,
        string $etat = 'succès'
    ): void {
        HistoriqueConnexion::create([
            'user_id'    => $userId,
            'ip_address' => $ip,
            'navigateur' => $navigateur,
            'os'         => $os,
            'etat'       => strtolower($etat),
            'connecte_le'=> now(),
        ]);
    }
}
