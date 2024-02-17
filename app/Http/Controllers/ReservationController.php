<?php

namespace App\Http\Controllers;
use App\Models\equipment;
use App\Models\reservation;
use Illuminate\Http\Request;
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
    
        $newReservation->customerName = $request->customerName;
        $newReservation->customerNumber = $request->customerNumber;
        $newReservation->dateStart = $request->dateStart;
        $newReservation->dateEnd = $request->dateEnd;
        $newReservation->statusID = 1;
    
        $res = $newReservation->save();
    
        return $res;
    }
    
        public function getReservations(){
            $getReservation = reservation::all();
            return $getReservation;
        }
        public function getReservationOrder(){
            $getReservation = DB::table ('reservations')
            ->join('reservation_details', 'reservations.reservationNumber', '=', 'reservation_details.reservationNumber')
            ->join('equipments', 'reservation_details.equipment_id', '=', 'equipments.equipment_id')
            ->select('reservation_details.*', 'equipments.equipmentName', 'reservations.reservationNumber')
            ->get();
            return $getReservation;
        }


        public function deleteReservation(Request $request){
            $deleteReservation = reservation::find($request->ID);
           
            $res = $deleteReservation->delete();
        
            return $res;
        }
        
        public function approveReservation(Request $request)
        {   
            $stockQuantity = equipment::where('equipment_id', $request->id)->first();
            $stockQuantityValue = $stockQuantity->quantity;
            
            $orderQuantity = reservation_details::where('reservationNumber', $request->ID)->first();
            $orderQuantityValue = $orderQuantity->quantity;
            
            $approveReservation = reservation::find($request->ID);
            
            $approveReservation->statusID = 2;
            $res = $approveReservation->save();
            
            $stockQuantity->quantity = $stockQuantityValue - $orderQuantityValue;
            $stockQuantity->save();
        
            return response()->json(['message' => 'Reservation approved successfully.']);
        }
        
        

        
        public function addToReservation(Request $request)
        {
            $equipment_id = $request->input('equipment_id');
            $quantity = $request->input('quantity', 1);
        
            $cartItem = Cart::where('equipment_id', $equipment_id)->first();
        
            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->total = $cartItem->quantity * $cartItem->price;
                $cartItem->save();
            } else {
                Cart::create([
                    'equipment_id' => $equipment_id,
                    'equipmentName' => $request->input('equipmentName'),
                    'price' => $request->input('price'),
                    'total' => $request->input('price') * $quantity,
                    'quantity' => $quantity,
                ]);
            }
        
            return response()->json(['message' => 'Product added to cart']);
        }
        
}
