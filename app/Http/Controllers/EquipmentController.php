<?php

namespace App\Http\Controllers;

use App\Models\equipment;
use App\Models\reservation;
use App\Models\reservation_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function submitEquipment(Request $request){
    $newEquipment = new equipment();
       
        $newEquipment->equipmentName = $request->equipmentName;
        $newEquipment->quantity = $request->quantity;
        $newEquipment->description = $request->description;
        $newEquipment->barcode = $request->barcode;
        $newEquipment->price = $request->price;
        $newEquipment->location = $request->location;
        $newEquipment->category = $request->category;
        $newEquipment->condition = $request->condition;
        $res = $newEquipment->save();

        return $res;
    }
    public function getEquipments(){
        $getEquipment = equipment::all();
        return $getEquipment;
    }
    public function getEquipment(Request $request){
        $getEquipment=equipment::find($request->edit_id);
        // dd($getEquipment);
            // dd($request->data); 
        return $getEquipment;

    }
    public function updateEquipment(Request $request){
       
        $data = $request->data;
        $updatedInfo = equipment::find($data['id']);
        
        $updatedInfo->equipmentName = $data['equipmentName'];
    
        $updatedInfo->quantity = $data['quantity'];
        $updatedInfo->description = $data['description'];
        $updatedInfo->barcode = $data['barcode'];
        $updatedInfo->price = $data['price'];
        $updatedInfo->category = $data['category'];
        $updatedInfo->category = $data['condition'];
    
        $res = $updatedInfo->save();
    
        return $res;
    }
    public function deleteEquipment(Request $request){
        $deleteEquipment = equipment::find($request->ID);

        $res = $deleteEquipment->delete();
    
        return $res;
    }

    public function submitEquipmentOrder(Request $request){
        $newReservationDetail = new reservation_details();
        $validatedData = $request->validate([
            'equipment_id' => 'required|exists:equipments,equipment_id',
            'quantity' => 'required|integer|min:0',
        ]);
        $newReservationDetail->reservationNumber = $request->reservationNumber;
        $newReservationDetail->equipment_id = $request->equipment_id;
        $newReservationDetail->quantity = $request->quantity;

        $res = $newReservationDetail->save();

        return $res;
    }
}
