<?php

namespace App\Http\Controllers;

use App\Models\equipment;
use App\Models\reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\replacement_details;
use App\Models\equipment_status;
use Illuminate\Support\Facades\Validator;

class ReplacementController extends Controller
{

    public function submitReplacementDetails(Request $request)
{
    $requestParameters = $request->all();
    
    DB::beginTransaction();
    
    try {
        // Get the current maximum reservation number from the transactions_table
        $maxReservationNumber = DB::table('transactions_table')->max('reservation_number');
        $newReservationNumber = $maxReservationNumber ? $maxReservationNumber + 1 : 1;

        for ($counter = 0; $counter < count($requestParameters); $counter++) {
            // Validate each item in the requestParameters array
            $validator = Validator::make($requestParameters[$counter], [
                'reservationNumber' => 'required|integer',
                'equipment_id' => 'required|integer',
                'quantity' => 'required|integer|min:1',
            ]);
            
            if ($validator->fails()) {
                throw new \Exception("Validation failed for item $counter: " . json_encode($validator->errors()));
            } else {
                $reservationNumber = $requestParameters[$counter]['reservationNumber'];
                $equipmentId = $requestParameters[$counter]['equipment_id'];
                $replacementQuantity = $requestParameters[$counter]['quantity'];

                // Get the current quantity from reservation_details
                $currentReservationDetail = DB::table('reservation_details')
                    ->where('reservationNumber', $reservationNumber)
                    ->where('equipment_id', $equipmentId)
                    ->first();

                if (!$currentReservationDetail) {
                    throw new \Exception("Reservation detail not found for reservationNumber: {$reservationNumber} and equipment_id: {$equipmentId}");
                }

                $currentQuantity = $currentReservationDetail->quantity;
                $remainingQuantity = $currentQuantity - $replacementQuantity;

                if ($remainingQuantity < 0) {
                    throw new \Exception("Not enough quantity available in the reservation for equipment_id: {$equipmentId}");
                }

                // Insert into replacement_details
                DB::table('replacement_details')->insert([
                    'reservationNumber' => $reservationNumber,
                    'equipment_id' => $equipmentId,
                    'quantity' => $replacementQuantity,
                    'status' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Update reservation_details table
                DB::table('reservation_details')
                    ->where('reservationNumber', $reservationNumber)
                    ->where('equipment_id', $equipmentId)
                    ->update(['quantity' => $remainingQuantity]);

                // Update equipment_status table
                DB::table('equipment_status')
                    ->where('equipment_id', $equipmentId)
                    ->where('condition_id', 1)
                    ->decrement('quantity', $replacementQuantity);

                // Insert into transactions_table
                DB::table('transactions_table')->insert([
                    'transaction_type' => 4,
                    'equipment_id' => $equipmentId,
                    'condition_id' => 1,
                    'quantity' => $remainingQuantity,
                    'reservation_number' => $newReservationNumber,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // Update the reservation statusID
        $reservationNumber = $requestParameters[0]['reservationNumber'];
        $submitReplaceReservation = Reservation::where('reservationNumber', $reservationNumber)->first();
        
        if ($submitReplaceReservation) {
            $submitReplaceReservation->statusID = 6;
            $res = $submitReplaceReservation->save();
            
            if (!$res) {
                throw new \Exception('Failed to update reservation status.');
            }
        } else {
            throw new \Exception('Reservation not found.');
        }
        
        DB::commit();
        return response()->json(['message' => 'Reservation replaced successfully, details updated, and transaction recorded.'], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
    }
}
    

    public function getReplacementDetails(Request $request)
{
    $reservationNumber = $request->reservationNumber;
    
    $getReservationOrder = DB::table('reservations')
        ->join('replacement_details', 'reservations.reservationNumber', '=', 'replacement_details.reservationNumber')
        ->join('equipments', 'replacement_details.equipment_id', '=', 'equipments.equipment_id')
        ->select('replacement_details.*', 'equipments.equipmentName', 'reservations.reservationNumber')
        ->where('replacement_details.reservationNumber', $reservationNumber)
        ->get();
    
    return $getReservationOrder;
}

public function getReplacementAll(Request $request) {
    $getReservation = replacement_details::all();
    return $getReservation;
}
}
