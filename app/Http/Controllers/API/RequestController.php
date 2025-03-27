<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\RequestType;
use App\Models\RequestToken;
use Illuminate\Support\Str;
use App\Mail\RequestFormLink;
use Illuminate\Support\Facades\Mail;


class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function initiateRequest(Request $request, School $school)
    {
        $request->validate([
            'request_type_slug' => 'required|exists:request_types,slug',
            'email' => 'required|email'
        ]);

        // Find request type by slug
        $requestType = RequestType::where('slug', $request->request_type_slug)->first();

        // Generate token (expires in 30 mins)
        $token = RequestToken::create([
            'token' => Str::random(60),
            'school_id' => $school->id,
            'request_type_id' => $requestType->id,
            'email' => $request->email,
            'expires_at' => now()->addMinutes(config('request.token_expiry', 30)),
        ]);

        // Send email
        Mail::to($request->email)->send(new RequestFormLink($token));

        return response()->json([
            'message' => 'A secure link has been sent to your email.'
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