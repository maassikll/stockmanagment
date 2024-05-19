<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Client;
use App\Models\Facture;
use App\Models\Product;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $factures = Facture::query()
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
            ->orWhere('id', 'like', "%{$search}%");
            })
        ->paginate(10);

        return Inertia::render('Factures/Index', [
            'factures' => $factures, 
            'search' => $search
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function facture()
    {
        $clients = Client::all();
        $products = Product::all();
        return Inertia::render('Factures/Facture',[
            'clients' => $clients,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Facture $facture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facture $facture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facture $facture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facture $facture)
    {
        //
    }


    
}
