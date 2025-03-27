<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequestToken;
use App\Models\SchoolRequest;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function submitRequest(Request $request)
     {
         $request->validate([
             'token' => 'required',
             'requester_name' => 'required',
             'details' => 'required',
         ]);
 
         // Find valid token
         $token = RequestToken::where('token', $request->token)
             ->where('is_used', false)
             ->where('expires_at', '>', now())
             ->firstOrFail();
 
         // Create request
         $schoolRequest = SchoolRequest::create([
             'school_id' => $token->school_id,
             'request_type_id' => $token->request_type_id,
             'token_id' => $token->id,
             'requester_name' => $request->requester_name,
             'requester_email' => $token->email,
             'details' => $request->details,
         ]);
 
         // Mark token as used
         $token->update(['is_used' => true]);
 
         return response()->json([
             'message' => 'Request submitted successfully!',
             'request_id' => $schoolRequest->id,
         ]);
     }
    public function index()
    {
        //
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