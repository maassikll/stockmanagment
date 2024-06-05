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
        
        
        $factures = Facture::with('client:id,first_name,last_name')
            ->select('id', 'name', 'client_id', 'credit','status', 'created_at', 'updated_at') 
            ->when($search, function ($query, $search) {
                return $query->whereHas('client', function ($query) use ($search) {
                                $query->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%");
                            });
            })
            ->paginate(10);

            

        return Inertia::render('Factures/Index', [
            'factures' => $factures,
            'search' => $search,
            
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
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id|max:255',
            'name' => 'nullable|string|min:5|max:255',
            'pdf_data' => 'required|file|mimes:pdf',
            'credit' => 'nullable|string|min:1|max:10',
        ]);

    
        
        
        $invoice = new Facture();
        $invoice->client_id = $request->input('client_id');
        $invoice->name = $request->input('name');
        $invoice->pdf_data = file_get_contents($request->file('pdf_data'));
        $invoice->credit = $request->input('credit');
            

           
        if ($invoice->credit <= 0) {
            $invoice->status = 'payer';
        } else {
            $invoice->status = 'non_payer';
        }
            
        
        $invoice->save();

        
        
        return redirect()->route('factures.facture');
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
        public function edit($id)
        {
            $facture = Facture::find($id);
           
            return Inertia::render('Factures/Edit',[
                'facture' => [
                    'id' => $facture->id,
                    'client_id' => $facture->client_id,
                    'name' => $facture->name,
                    'credit' => $facture->credit,
                    'status' => $facture->status,
                ],
            ]);
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {       
        $facture = Facture::findOrFail($id);
          
          $validated = $request->validate([
            'status' => 'required|string',
            'credit' => 'nullable|string',
        ]);

        
        $facture->update([
            'status' => $request->input('status'),
            
        ]);

        if($facture->status == 'payer'){
            $facture->credit=0;
        }

        $facture->update();

        
        return redirect()->route('factures.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facture $facture)
    {
        //
    }


    
}
