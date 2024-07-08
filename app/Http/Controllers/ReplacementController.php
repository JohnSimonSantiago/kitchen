<?php

namespace App\Http\Controllers;

use App\Models\replacement_details;
use Illuminate\Http\Request;

class ReplacementController extends Controller
{
    public function submitReplacementDetails(Request $request)
    {
        $data = $request->validate([
            'replacementDetails' => 'required|array',  // Validate replacementDetails as a required array
        ]);
    
        $validatedData = [];
        foreach ($data['replacementDetails'] as $replacementDetail) {
            $validated = Validator::make($replacementDetail, [
                'reservationNumber' => 'required|integer',
                'equipment_id' => 'required|integer',
                'quantity' => 'required|integer|min:1',
            ]);
    
            if ($validated->fails()) {
                return response()->json($validated->errors(), 422); // Unprocessable Entity
            }
    
            // Assuming you are adding reservationNumber to each detail
            $replacementDetail['reservationNumber'] = $request->input('reservationNumber');
    
            $validatedData[] = $replacementDetail;
        }
    
        try {
            // Example: Insert validated data into the database using Eloquent or Query Builder
            foreach ($validatedData as $detail) {
                // Assuming you have a Replacement model to handle replacement details
                Replacement::create([
                    'reservation_number' => $detail['reservationNumber'],
                    'equipment_id' => $detail['equipment_id'],
                    'quantity' => $detail['quantity'],
                ]);
            }
    
            return response()->json(['message' => 'Replacement details submitted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to submit replacement details.'], 500);
        }
    }
    
    
}
