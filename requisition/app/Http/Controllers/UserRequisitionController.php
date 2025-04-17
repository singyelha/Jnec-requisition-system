<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // To get the logged-in user
use App\Models\Requisition;     // <-- Import your Requisition model (adjust name if needed)
use Illuminate\Support\Facades\Log;   // Optional: for logging/debugging

class UserRequisitionController extends Controller

{
    /**
     * Store a newly created requisition in storage.
     * This method handles the request from the route named 'user.requisitions.store'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // --- 1. Validate the incoming data ---
        // Add rules for all your form fields
        $validatedData = $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:1000',
            // Add other fields like 'department_id', 'priority', etc. as needed
            // 'department_id' => 'required|exists:departments,id',
        ]);

        // --- 2. Create and Save the Requisition ---
        try {
            // Example using Eloquent Model (adjust field names as needed)
            $requisition = new Requisition();
            $requisition->user_id = Auth::id(); // Get ID of the currently logged-in user
            $requisition->item_name = $validatedData['item_name'];
            $requisition->quantity = $validatedData['quantity'];
            $requisition->reason = $validatedData['reason'];
            $requisition->status = 'pending'; // Set a default status
            

            $requisition->save(); // Save the new requisition to the database

            // --- 3. Redirect with a Success Message ---
            return redirect()->route('dashboard') // Or maybe a requisitions index page
                             ->with('success', 'Requisition submitted successfully!');

        } catch (\Exception $e) {
            // --- Optional: Handle Errors ---
            Log::error('Error storing requisition: ' . $e->getMessage()); // Log the error

            // Redirect back with an error message and the input data
            return back()->withInput()
                         ->with('error', 'There was a problem submitting your requisition. Please try again.');
        }
    }


}

