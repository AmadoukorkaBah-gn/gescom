<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index(Request $request)
    {
        $ownerId = Auth::user()->getOwnerId();
        $query = Client::where('user_id', $ownerId);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom_client', 'like', "%{$search}%")
                  ->orWhere('contact_client', 'like', "%{$search}%");
            });
        }

        $clients = $query->paginate(10);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created client.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_client' => 'required|string|max:255',
            'adresse_client' => 'nullable|string|max:255',
            'contact_client' => 'nullable|string|max:20',
        ]);

        $data['user_id'] = Auth::user()->getOwnerId();
        Client::create($data);

        return redirect()->route('clients.index')
                         ->with('success', 'Client créé avec succès.');
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified client.
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'nom_client' => 'required|string|max:255',
            'adresse_client' => 'nullable|string|max:255',
            'contact_client' => 'nullable|string|max:20',
        ]);

        $client->update($data);

        return redirect()->route('clients.index')
                         ->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Remove the specified client.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
                         ->with('success', 'Client supprimé.');
    }

    /**
     * Export clients as CSV.
     */
    public function exportCsv()
    {
        $filename = 'clients-' . date('YmdHis') . '.csv';
        $clients = Client::where('user_id', Auth::user()->getOwnerId())->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($clients) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nom', 'Contact', 'Adresse']);

            foreach ($clients as $client) {
                fputcsv($file, [
                    $client->nom_client,
                    $client->contact_client,
                    $client->adresse_client,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Print clients list.
     */
    public function print()
    {
        $clients = Client::where('user_id', Auth::user()->getOwnerId())->get();
        return view('clients.print', compact('clients'));
    }
}
