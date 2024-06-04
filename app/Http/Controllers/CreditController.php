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
            ->select('client_id', DB::raw('SUM(credit) as total_credit')) 
            ->when($search, function ($query, $search) {
                return $query->where('id', 'like', "%{$search}%")
                            ->orWhereHas('client', function ($query) use ($search) {
                                $query->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%");
                            });
            })
            ->groupBy('client_id')
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
    public function edit(Credit $credit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Credit $credit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Credit $credit)
    {
        //
    }
}
