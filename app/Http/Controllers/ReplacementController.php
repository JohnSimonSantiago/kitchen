<?php

namespace App\Http\Controllers;

use App\Models\reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\replacement_details;
use Illuminate\Support\Facades\Validator;

class ReplacementController extends Controller
{

    public function submitReplacementDetails(Request $request)
    {
        $requestParameters = $request->all();
        for ($counter = 0; $counter < count($requestParameters); $counter++) {
            // Validate each item in the requestParameters array
            $validator = Validator::make($requestParameters[$counter], [
                'reservationNumber' => 'required|integer',
                'equipment_id' => 'required|integer',
                'quantity' => 'required|integer|min:1',
            ]);
    
            if ($validator->fails()) {
                // Handle validation failure
                echo "Validation failed for item $counter:<br>";
                print_r($validator->errors());
            } else {
                // Validation passed, insert into the database
                DB::table('replacement_details')->insert([
                    'reservationNumber' => $requestParameters[$counter]['reservationNumber'],
                    'equipment_id' => $requestParameters[$counter]['equipment_id'],
                    'quantity' => $requestParameters[$counter]['quantity'],
                    'created_at' => now(), 
                    'updated_at' => now(), 
                ]);
                echo "Inserted item $counter into the database.<br>";
            }
        }
    
        // Update the reservation statusID after processing all replacement details
        $reservationNumber = $requestParameters[0]['reservationNumber']; // Assuming all requestParameters have the same reservationNumber
        $submitReplaceReservation = Reservation::where('reservationNumber', $reservationNumber)->first();
    
        if ($submitReplaceReservation) {
            $submitReplaceReservation->statusID = 6;
            $res = $submitReplaceReservation->save();
    
            if ($res) {
                return response()->json(['message' => 'Reservation replaced successfully.'], 200);
            } else {
                return response()->json(['message' => 'Failed to update reservation status.'], 500);
            }
        } else {
            return response()->json(['message' => 'Reservation not found.'], 404);
        }
    }
    
    public function getReplacementDetails(Request $request) {
        $getReplacementDetails = replacement_details::all();
        return $getReplacementDetails; 
    }
    
}
