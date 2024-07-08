<?php

namespace App\Http\Controllers;

use App\Models\replacement_details;
use Illuminate\Http\Request;

class ReplacementController extends Controller
{
    public function submitReplacementDetails(Request $request)
    {
        $validatedData = $request->validate([
            'equipment_id' => 'required|exists:equipments,equipment_id',
            'quantity' => 'required|integer|min:0',
        ]);
    
        $reservationNumber = $request->reservationNumber;
        $equipment_id = $request->equipment_id;
        $quantity = $request->quantity;
    
        
        $existingReservationDetail = replacement_details::where('equipment_id', $equipment_id)
            ->where('reservationNumber', $reservationNumber)
            ->first();
    
        if ($existingReservationDetail) {
            
            $existingReservationDetail->quantity += $quantity;
            $existingReservationDetail->save();
        } else {

            $newReservationDetail = new reservation_details();
            $newReservationDetail->reservationNumber = $reservationNumber;
            $newReservationDetail->equipment_id = $equipment_id;
            $newReservationDetail->quantity = $quantity;
            $newReservationDetail->save();
        }
    
        return response()->json(['success' => true]);
    }
    public function getReplacementDetails(Request $request) {
        $getReplacementDetails = replacement_details::all();
        return $getReplacementDetails; 
    }
    
}
