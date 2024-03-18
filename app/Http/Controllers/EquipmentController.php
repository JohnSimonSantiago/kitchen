<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\condition;
use App\Models\equipment;
use App\Models\reservation;
use Illuminate\Http\Request;
use App\Models\equipment_status;
use App\Models\reservation_details;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function submitEquipment(Request $request){
    $newEquipment = new equipment();
    $validatedCategoryData = $request->validate([
        'categoryID' => 'required|exists:category_table,categoryID',
    ]);
        $newEquipment->equipmentName = $request->equipmentName;
        $newEquipment->description = $request->description;
        $newEquipment->barcode = $request->barcode;
        $newEquipment->price = $request->price;
        $newEquipment->location = $request->location;
        $newEquipment->categoryID = $request->categoryID;
        
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move(public_path('/uploads'), $filename);
            $newEquipment->image = $filename;
        }

        $res = $newEquipment->save();

        return $res;
    }

    public function getMaxStock(){
        $getEquipmentStock = equipment::pluck('quantity');
        return $getEquipmentStock;
    }

    public function getEquipments(){
        $getEquipment = equipment::all();
        return $getEquipment;
    }
    public function getEquipment(Request $request){
        $getEquipment=equipment::find($request->edit_id);
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
        $updatedInfo->categoryID = $data['categoryID'];
        $updatedInfo->condition = $data['condition'];
        $res = $updatedInfo->save();
    
        return $res;
    }



    public function deleteEquipment(Request $request){
        $deleteEquipment = equipment::find($request->ID);
        $res = $deleteEquipment->delete();
        return $res;
    }

    public function submitEquipmentOrder(Request $request)
    {
        $validatedData = $request->validate([
            'equipment_id' => 'required|exists:equipments,equipment_id',
            'quantity' => 'required|integer|min:0',
        ]);
    
        $reservationNumber = $request->reservationNumber;
        $equipment_id = $request->equipment_id;
        $quantity = $request->quantity;
    
        
        $existingReservationDetail = reservation_details::where('equipment_id', $equipment_id)
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
    public function AddEquipmentStock(Request $request){
        $newEquipmentStock = new equipment_status();
        $validatedData = $request->validate([
            'equipment_id' => 'required|exists:equipments,equipment_id',
            'condition_id' => 'required|exists:condition_table,condition_id',
            'quantity' => 'required|integer|min:0',
        ]);
        $newEquipmentStock->equipment_id = $request->equipment_id;
        $newEquipmentStock->condition_id = $request->condition_id;
        $newEquipmentStock->quantity = $request->quantity;
        $res = $newEquipmentStock->save();

        return $res;
    }

    public function returnMissingEquipment(Request $request)
{
    
    $validatedData = $request->validate([
        'equipmentID' => 'required|exists:equipment,equipmentID',
        'missingQuantity' => 'required|numeric|min:1',
    ]);

    $equipment = Equipment::findOrFail($validatedData['equipmentID']);
    $newQuantity = $equipment->quantity - $validatedData['missingQuantity'];
    $newQuantity = max(0, $newQuantity);

    $equipment->quantity = $newQuantity;
    $equipment->save();

    return response()->json(['message' => 'Missing equipment updated successfully.']);
}


public function getAllEquipmentStatus(){
    $getEquipment = equipment_status::all();
    return $getEquipment;
}

public function getEquipmentNameAndImage()
{
    $statusTable = equipment::all(['equipment_id', 'equipmentName', 'image']);

    return $statusTable;
}


}
