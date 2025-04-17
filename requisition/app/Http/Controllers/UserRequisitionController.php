<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Models\RequisitionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import DB facade for transactions
use Illuminate\Support\Facades\Log; // Optional: for logging errors

class UserRequisitionController extends Controller
{
    // Method to show the dashboard form (assuming it's needed)
    public function index()
    {
        // You might fetch existing requisitions here for the 'Form Status' tab later
        return view('dashboard'); // Or your specific dashboard view name
    }

    // Method to store the submitted requisition
    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'requisition_date' => 'required|date',
            'department' => 'required|string|max:255',
            'requester_name' => 'required|string|max:255',
            'requester_designation' => 'required|string|max:255',
            // Validate the arrays of items
            'item_name' => 'required|array|min:1', // At least one item is required
            'item_name.*' => 'required|string|max:255', // Each item name is required
            'item_description' => 'nullable|array',
            'item_description.*' => 'nullable|string',
            'item_quantity' => 'required|array|min:1',
            'item_quantity.*' => 'required|string|max:255', // Validate each quantity
            'item_remarks' => 'nullable|array',
            'item_remarks.*' => 'nullable|string',
        ], [
            // Custom error messages
            'item_name.required' => 'Please add at least one item to the requisition.',
            'item_name.*.required' => 'Please enter a name for all items.',
            'item_quantity.required' => 'Please add at least one item to the requisition.',
            'item_quantity.*.required' => 'Please enter a quantity for all items.',
        ]);

        // Use a database transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // 2. Create the main Requisition record
            $requisition = Requisition::create([
                'user_id' => Auth::id(), // Link to logged-in user
                'requisition_date' => $validated['requisition_date'],
                'department' => $validated['department'],
                'requester_name' => $validated['requester_name'],
                'requester_designation' => $validated['requester_designation'],
                'status' => 'Pending', // Default status
            ]);

            // 3. Create Requisition Items
            // Loop through one of the required item arrays (e.g., item_name)
            foreach ($validated['item_name'] as $index => $itemName) {
                // Make sure the index exists in other arrays before accessing
                // (Validation should ensure required ones like quantity exist)
                RequisitionItem::create([
                    'requisition_id' => $requisition->id, // Link to the parent requisition
                    'item_name' => $itemName,
                    'item_description' => $validated['item_description'][$index] ?? null,
                    'quantity' => $validated['item_quantity'][$index], // Required based on validation
                    'remarks' => $validated['item_remarks'][$index] ?? null,
                ]);
            }

            // 4. Commit Transaction if successful
            DB::commit();

            // 5. Redirect with Success Message
            return redirect()->route('dashboard') // Or back(), or a status page route
                             ->with('success', 'Requisition submitted successfully!');

        } catch (\Exception $e) {
            // 6. Rollback Transaction on error
            DB::rollBack();

            // Optional: Log the error
            Log::error('Requisition submission failed: ' . $e->getMessage());

            // 7. Redirect back with error message and input
            return redirect()->back()
                             ->with('error', 'Failed to submit requisition. Please try again. Error: ' . $e->getMessage()) // Show generic or specific error
                             ->withInput(); // Repopulate form with old input
        }
    }
}