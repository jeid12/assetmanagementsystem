<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Services\DeviceNameTagService;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $devices = Device::all();
            return response()->json([
                'success' => true,
                'data' => $devices
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching devices: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve devices'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name_tag' => 'nullable|unique:devices',
                'category' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'serial_number' => 'required|unique:devices|string|max:255',
                'brand' => 'required|string|max:255',
                'specifications' => 'nullable|json',
                'purchase_date' => 'nullable|date',
                'warranty_expiry' => 'nullable|date|after_or_equal:purchase_date',
                'current_status' => 'nullable|string|in:available,in_use,maintenance,retired',
                'current_school_id' => 'nullable|exists:schools,id',
                'purchase_cost' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string',
            ]);
          
            $device = Device::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Device created successfully',
                'data' => $device
            ], Response::HTTP_CREATED);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            Log::error('Error creating device: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create device'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $device = Device::with('school')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $device
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error('Error fetching device: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve device'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get devices by school ID
     */
    public function getDevicesBySchool($schoolId)
    {
        try {
            $devices = Device::where('current_school_id', $schoolId)
                            ->with('school')
                            ->get();

            return response()->json([
                'success' => true,
                'data' => $devices
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching devices by school: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve devices for school'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $device = Device::findOrFail($id);

            $validated = $request->validate([
                'name_tag' => 'nullable|unique:devices',
                'category' => 'sometimes|string|max:255',
                'model' => 'sometimes|string|max:255',
                'serial_number' => 'sometimes|unique:devices,serial_number,'.$id,
                'brand' => 'sometimes|string|max:255',
                'specifications' => 'nullable|json',
                'purchase_date' => 'nullable|date',
                'warranty_expiry' => 'nullable|date|after_or_equal:purchase_date',
                'current_status' => 'sometimes|string|in:available,in_use,maintenance,retired',
                'current_school_id' => 'nullable|exists:schools,id',
                'purchase_cost' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string',
            ]);
            // Auto-generate name_tag if not provided
if (empty($validated['name_tag'])) {
    $prefix = 'DEFAULT';
    $i = 1;

    do {
        $generatedNameTag = $prefix . $i;
        $exists = Device::where('name_tag', $generatedNameTag)->exists();
        $i++;
    } while ($exists);

    $validated['name_tag'] = $generatedNameTag;
}

            $device->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Device updated successfully',
                'data' => $device
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error('Error updating device: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update device'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $device = Device::findOrFail($id);
            $device->delete();

            return response()->json([
                'success' => true,
                'message' => 'Device deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error('Error deleting device: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete device'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function searchDevice(Request $request, $schoolId)
    {
        /**
         * Search for devices by name_tag, serial_number, category
         * and that belong to the school with ID = $schoolId
         */
    
        $query = Device::where('current_school_id', $schoolId);
    
        if ($request->filled('name_tag')) {
            $query->where('name_tag', 'like', '%' . $request->name_tag . '%');
        }
    
        if ($request->filled('serial_number')) {
            $query->where('serial_number', 'like', '%' . $request->serial_number . '%');
        }
    
        if ($request->filled('category')) {
            $query->where('category', 'like', '%' . $request->category . '%');
        }
    
        $devices = $query->get();
    
        return response()->json([
            'success' => true,
            'data' => $devices
        ]);
    }

    /**
 * Assign a name tag to a device based on its category and school code.
 *
 * @param int $id
 * @return \Illuminate\Http\JsonResponse
 */
    
 public function assignNameTag($id, DeviceNameTagService $nameTagService)
{
    try {
        $device = Device::with('school')->findOrFail($id);

        // Check if school and category exist
        if (!$device->school || !$device->category) {
            return response()->json([
                'success' => false,
                'message' => 'School or category information is missing'
            ], Response::HTTP_BAD_REQUEST);
        }

        // Only assign if name_tag is null or starts with 'DEFAULT'
        if (empty($device->name_tag) || str_starts_with($device->name_tag, 'DEFAULT')) {
            $nameTag = $nameTagService->generate($device->category, $device->current_school_id);

            $device->name_tag = $nameTag;
            $device->save();

            return response()->json([
                'success' => true,
                'message' => 'Name tag assigned successfully',
                'data' => $device
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Device already has a valid name tag',
            'data' => $device
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Device not found'
        ], Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
        Log::error('Error assigning name tag: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to assign name tag'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

    
}