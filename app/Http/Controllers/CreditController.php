<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Credit;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $search = $request->input('search');
        $factures = Facture::with('client:id,first_name,last_name')
            ->select('id','client_id','status', DB::raw('SUM(credit) as total_credit')) 
            ->when($search, function ($query, $search) {
                return $query->where('id', 'like', "%{$search}%")
                            ->orWhereHas('client', function ($query) use ($search) {
                                $query->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%")
                                    ->orWhere('status','like',"%{$search}%");
                            });
            })
            ->groupBy('client_id','status','id')
            ->paginate(10);

        return Inertia::render('Credits/Index', [
            'factures' => $factures,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //hell yeah
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
    public function show(Credit $credit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $credit = Facture::find($id);
        return Inertia::render('Credits/Edit',[
            'credit' => [
                'id' => $credit->id,
                'client_id' => $credit->client_id,
                'name' => $credit->name,
                'credit' => $credit->credit,
                'status' => $credit->status,
            ],
        ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        
        $credit = Facture::findOrFail($id);
          
          $validated = $request->validate([
            'status' => 'required|string',
            'credit' => 'nullable|string',
        ]);

        if ($request->input('status') === 'payer') {
            
            $credit->credit = 0;
            
            $credit->update([
            'status' => $request->input('status'),
            'credit' => $credit->credit,
            
        ]);
        }else{
            
            $credit->update([
            'status' => $request->input('status'),
            'credit' => $request->input('credit'),
            
        ]);
        }

        

        

        // Redirect to the index route
        return redirect()->route('credits.index');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Credit $credit)
    {
        //
    }
}
