<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Device;

class Usercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolUsers = User::role('School')->count();
        $techUsers = User::role('Technician')->count();
        $staffUsers = User::role('RTB-Staff')->count();
        $adminUsers = User::role('Admin')->count();
       $deviceslaptop = Device::where('category', 'Laptop')->count();
       $devicesdesktop = Device::where('category', 'Desktop')->count();
       $devicesProjector= Device::where('category', 'Projector')->count();

        return response()->json([
            'staffUsers' => $staffUsers,
            'adminUsers' => $adminUsers,
            'techUsers' => $techUsers,
            'schoolUsers' => $schoolUsers,
            'deviceslaptop' => $deviceslaptop,
            'devicesdesktop' => $devicesdesktop,
            'totalDevices' => $deviceslaptop + $devicesdesktop,
            'devicesProjector' => $devicesProjector,
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
    public function show(string $id)
    {
        //
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