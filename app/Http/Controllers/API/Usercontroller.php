<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
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
     * 
     * 
     */

     //get all users or fileters by role
public function getAllUsers(Request $request)
{
    $usersQuery = User::query();

    // Filter by role using Spatie
    if ($request->has('role')) {
        $roleName = $request->input('role');
        $usersQuery->whereHas('roles', function ($query) use ($roleName) {
            $query->where('name', $roleName);
        });
    }

    $users = $usersQuery->get();

    // Attach role(s) to each user in the response
    $usersWithRoles = $users->map(function ($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'role' => $user->getRoleNames()->first(), // Get single role name (you can use ->toArray() for all roles)
        ];
    });

    return response()->json($usersWithRoles);
}
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