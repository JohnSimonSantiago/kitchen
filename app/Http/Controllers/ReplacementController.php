<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Models\replacement_details;

class ReplacementController extends Controller
{

    public function submitReplacementDetails(Request $request)
    {

        $validated = $request->validate([
            'replacementDetails' => 'required|array',
            'replacementDetails.*.reservationNumber' => 'required|integer',
            'replacementDetails.*.equipment_id' => 'required|integer',
            'replacementDetails.*.quantity' => 'required|integer|min:1',
        ]);
    
        // If validation passes, insert each replacement detail into the database
        foreach ($validated['replacementDetails'] as $detail) {
            DB::table('replacement_details')->insert([
                'reservationNumber' => $detail['reservationNumber'],
                'equipment_id' => $detail['equipment_id'],
                'quantity' => $detail['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return response()->json(['message' => 'Replacement details submitted successfully'], 200);
    }
    
    



    public function getReplacementDetails(Request $request) {
        $getReplacementDetails = replacement_details::all();
        return $getReplacementDetails; 
    }
    
}
