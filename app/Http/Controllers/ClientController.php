<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $clients = Client::query()
        ->when($search, function ($query, $search){
            return $query->where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('phone','like',"%{$search}%")
            ->orWhere('description','like',"%{$search}%");
        })
        ->paginate(10);
        return Inertia::render('Clients/Index',[
            'clients' => $clients,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'string',
            'description' => 'string',
        ]);
        $clientData = $request->all();
        $client = new Client($clientData);
        $client->save();

        return redirect()->route('clients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Client::find($id);
        return Inertia::render('Clients/Show',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $client = Client::find($id);
        return Inertia::render('Clients/Edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'string',
            'last_name' => 'string',
            'phone' => 'string',
            'description' => 'string',
        ]);

        $clientData = $request->all();
        $client = Client::find($id);
        $client->update($clientData);

        return redirect()->route('clients.index');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();
        return redirect()->route('clients.index');
    }

    public function restore()
    {
        $restoreClients = Client::onlyTrashed()->paginate(10);
        return Inertia::render('Clients/Restore',[
            'restoreClients' => $restoreClients,
        ]);
    }

    public function clientRestore($id)
    {
        $restoreClient = Client::onlyTrashed()->orderBy('deleted_at','asc')->findOrFail($id);
        $restoreClient->restore();
        return redirect()->route('clients.index');
    }
}
