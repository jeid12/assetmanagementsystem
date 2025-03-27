<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = School::query();

        // Filter by search term (name/province/district/sector)
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('province', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%")
                  ->orWhere('sector', 'like', "%{$search}%");
            });
        }

        // Optional: Filter by province/district
        if ($request->has('province')) {
            $query->where('province', $request->province);
        }
        if ($request->has('district')) {
            $query->where('district', $request->district);
        }

        // Paginate results (10 per page)
        $schools = $query->paginate(10);

        return response()->json($schools);
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
    public function show(School $school)
{
    return response()->json([
        'school' => $school,
        'request_types' => \App\Models\RequestType::all()
    ]);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}