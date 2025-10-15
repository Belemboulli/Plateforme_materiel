<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Exception;

class ServiceController extends Controller
{
    /**
     * Afficher la liste des services
     */
    public function index(Request $request)
    {
        $query = Service::query();

        // Filtres de recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code_service', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('responsable', 'LIKE', "%{$search}%");
            });
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par priorité
        if ($request->filled('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        // Filtre par stock
        if ($request->filled('stock')) {
            switch ($request->stock) {
                case 'faible':
                    $query->stockFaible();
                    break;
                case 'eleve':
                    $query->stockEleve();
                    break;
            }
        }

        // Tri
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $services = $query->paginate(12)->withQueryString();

        // Statistiques pour le dashboard
        $stats = [
            'total' => Service::count(),
            'actifs' => Service::actifs()->count(),
            'stock_faible' => Service::stockFaible()->count(),
            'priorite_haute' => Service::prioriteHaute()->count(),
        ];

        return view('services.index', compact('services', 'stats'));
    }

    /**
     * Afficher le formulaire de création d'un service
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Enregistrer un nouveau service
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'unique:services,name',
                'regex:/^[a-zA-Z0-9\s\-_àáâãäåæçèéêëìíîïñòóôõöùúûüýÿ]+$/'
            ],
            'code_service' => [
                'nullable',
                'string',
                'max:10',
                'unique:services,code_service',
                'regex:/^[A-Z0-9]+$/'
            ],
            'description' => 'nullable|string|max:500',
            'quantite' => 'required|integer|min:1|max:9999',
            'statut' => 'nullable|in:actif,inactif,maintenance',
            'priorite' => 'nullable|in:haute,moyenne,basse',
            'responsable' => 'nullable|string|max:100',
            'email_contact' => 'nullable|email|max:255',
            'telephone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\d\s\-\+\(\)]{8,}$/'
            ],
            'localisation' => 'nullable|string|max:150',
        ], [
            'name.required' => 'Le nom du service est obligatoire.',
            'name.min' => 'Le nom doit contenir au moins 3 caractères.',
            'name.unique' => 'Un service avec ce nom existe déjà.',
            'name.regex' => 'Le nom ne peut contenir que des lettres, chiffres, espaces et tirets.',
            'code_service.unique' => 'Ce code service est déjà utilisé.',
            'code_service.regex' => 'Le code service ne peut contenir que des lettres majuscules et des chiffres.',
            'quantite.required' => 'La capacité est obligatoire.',
            'quantite.min' => 'La capacité doit être d\'au moins 1.',
            'quantite.max' => 'La capacité ne peut pas dépasser 9999.',
            'email_contact.email' => 'L\'adresse email n\'est pas valide.',
            'telephone.regex' => 'Le numéro de téléphone n\'est pas valide.',
        ]);

        try {
            DB::beginTransaction();

            // Valeurs par défaut
            $validated['statut'] = $validated['statut'] ?? 'actif';
            $validated['priorite'] = $validated['priorite'] ?? 'moyenne';

            $service = Service::create($validated);

            DB::commit();

            return redirect()->route('services.index')
                           ->with('success', 'Service "' . $service->name . '" créé avec succès.');

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la création du service : ' . $e->getMessage());
        }
    }

    /**
     * Afficher les détails d'un service
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Afficher le formulaire d'édition d'un service
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Mettre à jour un service
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('services', 'name')->ignore($service->id),
                'regex:/^[a-zA-Z0-9\s\-_àáâãäåæçèéêëìíîïñòóôõöùúûüýÿ]+$/'
            ],
            'code_service' => [
                'nullable',
                'string',
                'max:10',
                Rule::unique('services', 'code_service')->ignore($service->id),
                'regex:/^[A-Z0-9]+$/'
            ],
            'description' => 'nullable|string|max:500',
            'quantite' => 'required|integer|min:1|max:9999',
            'statut' => 'required|in:actif,inactif,maintenance',
            'priorite' => 'required|in:haute,moyenne,basse',
            'responsable' => 'nullable|string|max:100',
            'email_contact' => 'nullable|email|max:255',
            'telephone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\d\s\-\+\(\)]{8,}$/'
            ],
            'localisation' => 'nullable|string|max:150',
        ], [
            'name.required' => 'Le nom du service est obligatoire.',
            'name.min' => 'Le nom doit contenir au moins 3 caractères.',
            'name.unique' => 'Un service avec ce nom existe déjà.',
            'name.regex' => 'Le nom ne peut contenir que des lettres, chiffres, espaces et tirets.',
            'code_service.unique' => 'Ce code service est déjà utilisé.',
            'code_service.regex' => 'Le code service ne peut contenir que des lettres majuscules et des chiffres.',
            'quantite.required' => 'La capacité est obligatoire.',
            'quantite.min' => 'La capacité doit être d\'au moins 1.',
            'quantite.max' => 'La capacité ne peut pas dépasser 9999.',
            'statut.required' => 'Le statut est obligatoire.',
            'priorite.required' => 'La priorité est obligatoire.',
            'email_contact.email' => 'L\'adresse email n\'est pas valide.',
            'telephone.regex' => 'Le numéro de téléphone n\'est pas valide.',
        ]);

        try {
            DB::beginTransaction();

            $service->update($validated);

            DB::commit();

            return redirect()->route('services.index')
                           ->with('success', 'Service "' . $service->name . '" modifié avec succès.');

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Erreur lors de la modification du service : ' . $e->getMessage());
        }
    }

    /**
     * Supprimer un service
     */
    public function destroy(Service $service)
    {
        try {
            DB::beginTransaction();

            $serviceName = $service->name;
            $service->delete();

            DB::commit();

            return redirect()->route('services.index')
                           ->with('success', 'Service "' . $serviceName . '" supprimé avec succès.');

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('services.index')
                           ->with('error', 'Erreur lors de la suppression du service : ' . $e->getMessage());
        }
    }

    /**
     * Activer/Désactiver un service
     */
    public function toggleStatus(Service $service)
    {
        try {
            $newStatus = $service->statut === 'actif' ? 'inactif' : 'actif';
            $service->update(['statut' => $newStatus]);

            return redirect()->back()
                           ->with('success', 'Statut du service modifié avec succès.');

        } catch (Exception $e) {
            return redirect()->back()
                           ->with('error', 'Erreur lors du changement de statut : ' . $e->getMessage());
        }
    }

    /**
     * Exporter les services
     */
    public function export(Request $request)
    {
        $services = Service::all();

        $filename = 'services_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($services) {
            $handle = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($handle, [
                'ID', 'Nom', 'Code Service', 'Description', 'Capacité',
                'Statut', 'Priorité', 'Responsable', 'Email', 'Téléphone',
                'Localisation', 'Créé le', 'Modifié le'
            ]);

            // Données
            foreach ($services as $service) {
                fputcsv($handle, [
                    $service->id,
                    $service->name,
                    $service->code_service,
                    $service->description,
                    $service->quantite,
                    ucfirst($service->statut),
                    ucfirst($service->priorite),
                    $service->responsable,
                    $service->email_contact,
                    $service->telephone,
                    $service->localisation,
                    $service->created_at->format('d/m/Y H:i'),
                    $service->updated_at->format('d/m/Y H:i')
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * API: Recherche de services
     */
    public function search(Request $request)
    {
        $query = Service::query();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code_service', 'LIKE', "%{$search}%");
            });
        }

        $services = $query->limit(10)->get(['id', 'name', 'code_service']);

        return response()->json($services);
    }
}
