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

class ReservationController extends Controller
{
    public function submitReservation(Request $request){
        $request->validate([
            'customerName' => 'required',
            'customerNumber' => 'required|numeric|digits:9',
            'dateStart' => 'required',
            'dateEnd' => 'required',
        ]);
    
        $newReservation = new Reservation();

        $newReservation->user_id = $request->user_id;
        $newReservation->customerName = $request->customerName;
        $newReservation->customerNumber = $request->customerNumber;
        $newReservation->dateStart = Carbon::parse($request->dateStart)->toDateTimeString();
        $newReservation->dateEnd = Carbon::parse($request->dateEnd)->toDateTimeString();
        $newReservation->statusID = 1;
    
        $res = $newReservation->save();
    
        return $res;
    }
    
        public function getReservations(){
            $getReservation = reservation::all();
            return $getReservation;
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
            ->select('reservation_details.quantity', 'reservation_details.equipment_id',)
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
                ->select('reservation_details.quantity', 'reservation_details.equipment_id',)
                ->where('reservations.reservationNumber', $approvedReservation->reservationNumber)
                ->get();
     
                $approvedReservationQuantities = $approvedReservationDetails;
            }

            $getEquipmentQuantities = equipment_status::where('condition_id', 1)->pluck('quantity', 'equipment_id');
            $totalQuantities = [];
            
            foreach ($getReservationQuantities as $reservationQuantity) {
                $equipmentId = $reservationQuantity->equipment_id;
                $quantity = $reservationQuantity->quantity;
                if (!isset($totalQuantities[$equipmentId])) {
                    $totalQuantities[$equipmentId] = 0;
                }
                $totalQuantities[$equipmentId] += $quantity;
            }
            
            foreach ($approvedReservationQuantities as $approvedReservationQuantity) {
                $equipmentId_ = $approvedReservationQuantity->equipment_id;
                $quantity = $approvedReservationQuantity->quantity;
                if (!isset($totalQuantities[$equipmentId_])) {
                    $totalQuantities[$equipmentId_] = 0;
                }
                $totalQuantities[$equipmentId_] += $quantity;
            }
            
            foreach ($totalQuantities as $equipmentId => $totalQuantity) {
                $availableStock = isset($getEquipmentQuantities[$equipmentId]) ? $getEquipmentQuantities[$equipmentId] : 0;
                if ($totalQuantity > $availableStock) {
                    die("Error: Not enough stock for equipment_id $equipmentId.");
                }
            }

            $selectedReservation->statusID = 2;
            $res = $selectedReservation->save();
            return response()->json(['message' => 'Reservation approved successfully.']);
        }

        public function receiveReservation(Request $request)
        {   
            $receiveReservation = reservation::find($request->ID);
            $receiveReservation->statusID = 3;
            $res = $receiveReservation->save();
            return response()->json(['message' => 'Reservation returned successfully.']);
        }



        public function returnReservation(Request $request)
        {   
            $returnReservation = reservation::find($request->ID);
            $returnReservation->statusID = 4;
            $res = $returnReservation->save();
            return response()->json(['message' => 'Reservation returned successfully.']);
        }
        
        public function rejectReservation(Request $request)
        {   
            $rejectReservation = reservation::find($request->ID);
            $rejectReservation->statusID = 5;
            $res = $rejectReservation->save();
            return response()->json(['message' => 'Reservation rejected successfully.']);
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
