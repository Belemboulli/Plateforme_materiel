<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Affiche la liste des notifications avec pagination.
     */
    public function index()
    {
        $notifications = Notification::latest()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Affiche le formulaire de création d'une notification.
     */
    public function create()
    {
        return view('notifications.create');
    }

    /**
     * Enregistre une nouvelle notification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'type'    => 'nullable|string',
        ]);

        Notification::create($request->all());

        return redirect()->route('notifications.index')
                         ->with('success', 'Notification créée avec succès ✅');
    }

    /**
     * Affiche une notification spécifique.
     */
    public function show(Notification $notification)
    {
        return view('notifications.show', compact('notification'));
    }

    /**
     * Affiche le formulaire d'édition d'une notification.
     */
    public function edit(Notification $notification)
    {
        return view('notifications.edit', compact('notification'));
    }

    /**
     * Met à jour une notification existante.
     */
    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'type'    => 'nullable|string',
        ]);

        $notification->update($request->all());

        return redirect()->route('notifications.index')
                         ->with('success', 'Notification mise à jour ✏️');
    }

    /**
     * Supprime une notification.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('notifications.index')
                         ->with('success', 'Notification supprimée ❌');
    }
}
