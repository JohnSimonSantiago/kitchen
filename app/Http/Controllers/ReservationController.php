<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Status;
use App\Models\equipment;
use App\Models\reservation;
use Illuminate\Http\Request;
use App\Models\equipment_status;
use Illuminate\Support\Facades\DB;
use App\Models\reservation_details;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function submitReservation(Request $request)
    {
        $request->validate([
            'customerName' => 'required',
            'customerNumber' => 'required|numeric|digits:9',
            'email' => 'required|email',
            'dateStart' => 'required|date',
            'dateEnd' => 'required|date|after_or_equal:dateStart',
        ]);

        $newReservation = new Reservation();
        
        // Use the authenticated user's ID
        $newReservation->user_id = Auth::id();
        
        $newReservation->customerName = $request->customerName;
        $newReservation->customerNumber = $request->customerNumber;
        $newReservation->email = $request->email;
        $newReservation->dateStart = Carbon::parse($request->dateStart)->toDateTimeString();
        $newReservation->dateEnd = Carbon::parse($request->dateEnd)->toDateTimeString();
        $newReservation->statusID = 1;

        $res = $newReservation->save();

        return response()->json([
            'success' => $res,
            'message' => $res ? 'Reservation created successfully' : 'Failed to create reservation'
        ], $res ? 201 : 500);
    }


    public function getReservations(Request $request) {
        $getReservation = reservation::all();
        return $getReservation;
    }

    public function getUserReservations()
    {
        $user = Auth::user();
        
        $reservations = Reservation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($reservations);
    }
    
    public function getReservationDetails(Request $request)
    {
        $reservationNumber = $request->reservationNumber;
    
        $getReservationDetails = DB::table('reservations')
            ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
            ->select(
                'reservations.reservationNumber',
                'reservations.dateStart',
                'reservations.dateEnd',
                'reservations.customerName',
                
                
            )
            ->where('reservations.reservationNumber', $reservationNumber)
            ->first();
    
        return $getReservationDetails;
    }
        public function getReservationOrder(Request $request){
            $reservationNumber = $request->reservationNumber;
        
            $getReservationOrder = DB::table('reservations')
                ->join('reservation_details', 'reservations.reservationNumber', '=', 'reservation_details.reservationNumber')
                ->join('equipments', 'reservation_details.equipment_id', '=', 'equipments.equipment_id')
                ->select('reservation_details.*', 'equipments.equipmentName', 'reservations.reservationNumber')
                ->where('reservation_details.reservationNumber', $reservationNumber)
                ->get();
        
            return $getReservationOrder;
        }


        public function deleteReservation(Request $request){
            $deleteReservation = reservation::find($request->ID);
           
            $res = $deleteReservation->delete();
        
            return $res;
        }
        
        public function approveReservation(Request $request)
{
    $selectedReservation = reservation::find($request->ID);
    $getReservationQuantities = DB::table('reservations')
        ->join('reservation_details', 'reservations.reservationNumber', '=', 'reservation_details.reservationNumber')
        ->select('reservation_details.quantity', 'reservation_details.equipment_id')
        ->where('reservations.reservationNumber', $selectedReservation->reservationNumber)
        ->get();
    
    $selectedReservationDateRange = [
        'dateStart' => $selectedReservation->dateStart,
        'dateEnd' => $selectedReservation->dateEnd
    ];
    $approvedReservations = reservation::where('statusID', 2)
        ->where('dateEnd', '>=', $selectedReservationDateRange['dateStart'])
        ->where('dateStart', '<=', $selectedReservationDateRange['dateEnd'])
        ->get();
    
    $approvedReservationQuantities = [];
    foreach ($approvedReservations as $approvedReservation) {
        $approvedReservationDetails = DB::table('reservations')
            ->join('reservation_details', 'reservations.reservationNumber', '=', 'reservation_details.reservationNumber')
            ->select('reservation_details.quantity', 'reservation_details.equipment_id')
            ->where('reservations.reservationNumber', $approvedReservation->reservationNumber)
            ->get();
        
        foreach ($approvedReservationDetails as $detail) {
            if (!isset($approvedReservationQuantities[$detail->equipment_id])) {
                $approvedReservationQuantities[$detail->equipment_id] = 0;
            }
            $approvedReservationQuantities[$detail->equipment_id] += $detail->quantity;
        }
    }
    
    $getEquipmentQuantities = DB::table('equipment_status')
        ->join('equipments', 'equipment_status.equipment_id', '=', 'equipments.equipment_id')
        ->where('equipment_status.condition_id', 1)
        ->select('equipment_status.equipment_id', 'equipment_status.quantity', 'equipments.equipmentName')
        ->get()
        ->keyBy('equipment_id');
    
    $totalQuantities = [];
    
    foreach ($getReservationQuantities as $reservationQuantity) {
        $equipmentId = $reservationQuantity->equipment_id;
        $quantity = $reservationQuantity->quantity;
        if (!isset($totalQuantities[$equipmentId])) {
            $totalQuantities[$equipmentId] = 0;
        }
        $totalQuantities[$equipmentId] += $quantity;
    }
    
    foreach ($approvedReservationQuantities as $equipmentId_ => $quantity) {
        if (!isset($totalQuantities[$equipmentId_])) {
            $totalQuantities[$equipmentId_] = 0;
        }
        $totalQuantities[$equipmentId_] += $quantity;
    }
    
    $errors = [];
    foreach ($totalQuantities as $equipmentId => $totalQuantity) {
        if (isset($getEquipmentQuantities[$equipmentId])) {
            $equipmentData = $getEquipmentQuantities[$equipmentId];
            $availableStock = $equipmentData->quantity;
            $equipmentName = $equipmentData->equipmentName;
            if ($totalQuantity > $availableStock) {
                $shortageAmount = $totalQuantity - $availableStock;
                $errors[] = "Not enough stock for equipment: $equipmentName  " .
                            "Shortage: $shortageAmount units. " .
                            "Available: $availableStock, ";
            }
        } else {
            $errors[] = "Equipment with ID $equipmentId not found.";
        }
    }
    
    if (!empty($errors)) {
        return response()->json(['errors' => $errors], 400);
    }
    
    $selectedReservation->statusID = 2;
    $selectedReservation->save();
    
    $maxReservationNumber = DB::table('transactions_table')->max('reservation_number');
    $ReservationNumber = $maxReservationNumber ? $maxReservationNumber + 1 : 1;
    
    foreach ($getReservationQuantities as $reservationQuantity) {
        DB::table('transactions_table')->insert([
            'transaction_type' => 1,
            'equipment_id' => $reservationQuantity->equipment_id,
            'condition_id' => 1,
            'quantity' => $reservationQuantity->quantity,
            'reservation_number' => $ReservationNumber,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    
    return response()->json(['message' => 'Reservation Approved Successfully!'], 200);
}

        
        

        public function receiveReservation(Request $request)
        {   
            $receiveReservation = reservation::find($request->ID);
            $receiveReservation->statusID = 3;
            $res = $receiveReservation->save();
        
            // Fetch the reservation details for the given reservation
            $reservationDetails = DB::table('reservation_details')
                ->where('reservationNumber', $receiveReservation->reservationNumber)
                ->get();
        
            // Use a database transaction to ensure atomicity
            DB::transaction(function () use ($reservationDetails) {
                // Get the current maximum transaction number from the transactions_table
                $maxReservationNumber = DB::table('transactions_table')->max('reservation_number');
                $reservationNumber = $maxReservationNumber ? $maxReservationNumber + 1 : 1;
        
                foreach ($reservationDetails as $reservationDetail) {
                    DB::table('transactions_table')->insert([
                        'transaction_type' => 2,
                        'equipment_id' => $reservationDetail->equipment_id,
                        'condition_id' => 1, // Assuming the condition_id is 1, change as needed
                        'quantity' => $reservationDetail->quantity,
                        'reservation_number' => $reservationNumber,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
        
            return response()->json(['message' => 'Reservation Received successfully.']);
        }


      
        public function receiveReservationIncomplete(Request $request)
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
                    // Validation passed, update the database
                    DB::table('reservation_details')
                        ->where('reservationNumber', $requestParameters[$counter]['reservationNumber'])
                        ->where('equipment_id', $requestParameters[$counter]['equipment_id'])
                        ->update([
                            'quantity' => $requestParameters[$counter]['quantity'],
                            'updated_at' => now(),
                        ]);
                    echo "Updated item $counter in the database.<br>";
                }
            }
        
            // Update the reservation statusID after processing all reservation details
            $reservationNumber = $requestParameters[0]['reservationNumber']; // Assuming all requestParameters have the same reservationNumber
            $receiveIncompleteReservation = Reservation::where('reservationNumber', $reservationNumber)->first();
        
            if ($receiveIncompleteReservation) {
                $receiveIncompleteReservation->statusID = 3; 
                $res = $receiveIncompleteReservation->save();
        
                if ($res) {
                    return response()->json(['message' => 'Reservation details updated successfully.'], 200);
                } else {
                    return response()->json(['message' => 'Failed to update reservation status.'], 500);
                }
            } else {
                return response()->json(['message' => 'Reservation not found.'], 404);
            }
        }
        
        public function returnReservation(Request $request)
        {
            // Validate the incoming request to ensure 'ID' and 'remarks' are provided
            $request->validate([
                'ID' => 'required|integer',
                'remarks' => 'required|string',
            ]);
        
            // Find the reservation by the provided ID
            $returnReservation = reservation::find($request->ID);
        
            if (!$returnReservation) {
                return response()->json(['message' => 'Reservation not found.'], 404);
            }
        
            // Update the statusID and remarks
            $returnReservation->statusID = 4;
            $returnReservation->remarks = $request->remarks;
            $res = $returnReservation->save();
        
            // Fetch the reservation details for the given reservation
            $reservationDetails = DB::table('reservation_details')
                ->where('reservationNumber', $returnReservation->reservationNumber)
                ->get();
        
            // Use a database transaction to ensure atomicity
            DB::transaction(function () use ($reservationDetails) {
                // Get the current maximum transaction number from the transactions_table
                $maxReservationNumber = DB::table('transactions_table')->max('reservation_number');
                $ReservationNumber = $maxReservationNumber ? $maxReservationNumber + 1 : 1;
        
                foreach ($reservationDetails as $reservationDetail) {
                    DB::table('transactions_table')->insert([
                        'transaction_type' => 4, 
                        'equipment_id' => $reservationDetail->equipment_id,
                        'condition_id' => 1, 
                        'quantity' => $reservationDetail->quantity,
                        'reservation_number' => $ReservationNumber,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
        
            return response()->json(['message' => 'Reservation returned successfully.']);
        }
        
       
        public function rejectReservation(Request $request)
        {
            // Validate the incoming request to ensure 'ID' and 'remarks' are provided
            $request->validate([
                'ID' => 'required|integer',
                'remarks' => 'required|string',
            ]);
        
            // Find the reservation by the provided ID
            $rejectReservation = reservation::find($request->ID);
        
            if (!$rejectReservation) {
                return response()->json(['message' => 'Reservation not found.'], 404);
            }
        
            // Update the statusID and remarks
            $rejectReservation->statusID = 5;
            $rejectReservation->remarks = $request->remarks;
            $res = $rejectReservation->save();
        
            // Fetch the reservation details for the given reservation
            $reservationDetails = DB::table('reservation_details')
                ->where('reservationNumber', $rejectReservation->reservationNumber)
                ->get();
        
            // Use a database transaction to ensure atomicity
            DB::transaction(function () use ($reservationDetails) {
                // Get the current maximum transaction number from the transactions_table
                $maxReservationNumber = DB::table('transactions_table')->max('reservation_number');
                $ReservationNumber = $maxReservationNumber ? $maxReservationNumber + 1 : 1;
        
                foreach ($reservationDetails as $reservationDetail) {
                    DB::table('transactions_table')->insert([
                        'transaction_type' => 3,
                        'equipment_id' => $reservationDetail->equipment_id,
                        'condition_id' => 1, // Assuming the condition_id is 1, change as needed
                        'quantity' => $reservationDetail->quantity,
                        'reservation_number' => $ReservationNumber,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
        
            return response()->json(['message' => 'Reservation rejected successfully.']);
        }
        

        public function SubmitReplacementReservation(Request $request)
        {
            DB::beginTransaction();
        
            try {
                $submitReplaceReservation = Reservation::find($request->ID);
                $submitReplaceReservation->statusID = 4;
                $submitReplaceReservation->save();
        
                // Get the current maximum reservation number from the transactions_table
                $maxReservationNumber = DB::table('transactions_table')->max('reservation_number');
                $newReservationNumber = $maxReservationNumber ? $maxReservationNumber + 1 : 1;
        
                // Process the replacement quantities
                foreach ($request->replacements as $replacement) {
                    $equipmentId = $replacement['equipment_id'];
                    $leftQuantity = $replacement['quantity'];
                    $rightQuantity = $replacement['right_quantity'];
                    $totalAmount = $replacement['total_amount'];
        
                    // Update the equipment_status table
                    $equipmentStatus = DB::table('equipment_status')
                        ->where('equipment_id', $equipmentId)
                        ->where('condition_id', 1)
                        ->first();
        
                    if ($equipmentStatus) {
                        DB::table('equipment_status')
                            ->where('equipment_id', $equipmentId)
                            ->where('condition_id', 1)
                            ->update([
                                'quantity' => $equipmentStatus->quantity + $leftQuantity,
                                'updated_at' => now(),
                            ]);
                    } else {
                        DB::table('equipment_status')->insert([
                            'equipment_id' => $equipmentId,
                            'condition_id' => 1,
                            'quantity' => $leftQuantity,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
        
                    // Update the status in replacement_details table
                    DB::table('replacement_details')
                        ->where('reservationNumber', $request->ID)
                        ->where('equipment_id', $equipmentId)
                        ->update([
                            'status' => 1,
                            'updated_at' => now(),
                        ]);
        
                    // Insert into cash_logs table
                    DB::table('cash_logs')->insert([
                        'reservation_number' => $request->ID,
                        'equipment_id' => $equipmentId,
                        'quantity' => $rightQuantity,
                        'cashAmount' => $totalAmount,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
        
                    // Insert into transactions_table
                    DB::table('transactions_table')->insert([
                        'transaction_type' => 5,
                        'equipment_id' => $equipmentId,
                        'condition_id' => 1, // Assuming the condition_id is 1, change as needed
                        'quantity' => $leftQuantity,
                        'reservation_number' => $newReservationNumber,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
        
                DB::commit();
                return response()->json(['message' => 'Replacement reservation submitted successfully'], 200);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['message' => 'Error submitting replacement reservation: ' . $e->getMessage()], 500);
            }
        }
        public function showReservationOrder(){
            return reservation_details::all();
        }


        public function getStatusTable()
        {
            $statusTable = Status::all(['id', 'status']);
        
            return $statusTable;
        }

        




        
        
}
