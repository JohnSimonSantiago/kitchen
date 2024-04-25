<?php

namespace App\Http\Controllers;

use DB;
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
    public function AddandDisposeEquipmentStock(Request $request)
    {
        $validatedData = $request->validate([
            'equipment_id' => 'required|exists:equipments,equipment_id',
            'quantity' => 'required|integer|min:0',
        ]);
    
        $equipment_id = $request->equipment_id;
        $condition_id = $request->condition_id;
        $quantity = $request->quantity;
    
        $existingEquipmentStock = equipment_status::where('equipment_id', $equipment_id)
            ->where('condition_id', $condition_id)
            ->first();
    
        if ($existingEquipmentStock) {

            $existingEquipmentStock->quantity += $quantity;
            $existingEquipmentStock->save();
        } else {

            $newEquipmentStock = new equipment_status();
            $newEquipmentStock->equipment_id = $equipment_id;
            $newEquipmentStock->condition_id = $condition_id;
            $newEquipmentStock->quantity = $quantity;
            $newEquipmentStock->save();
        }
    
        return response()->json(['success' => true]);
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

public function getEquipmentCondition(){
    $conditionTable = condition::all(['id', 'condition']);
    return $conditionTable;
}

public function getEquipmentCategory(){
    $categoryTable = category::all(['categoryID', 'category']);
    return $categoryTable;
}

public function getEquipmentNameAndImage()
{
    $statusTable = equipment::all(['equipment_id', 'equipmentName', 'image']);

    return $statusTable;
}

public function getEquipmentStatusQuantity(Request $request)
    {
        $equipmentId = $request->query('equipment_id');
        $conditionId = $request->query('condition_id');

        $equipmentStatus = equipment_status::where('equipment_id', $equipmentId)
            ->where('condition_id', $conditionId)
            ->first();

        if ($equipmentStatus) {
            return response()->json(['quantity' => $equipmentStatus->quantity]);
        } else {
            return response()->json(['error' => 'Equipment status not found'], 404);
        }
    }

public function getMaxPossibleOrder(Request $request)
{
    $reservationNumber = $request->reservationNumber;

    // Fetch reservation details for the given reservation number
    $reservationDetails = reservation_details::where('reservationNumber', $reservationNumber)->get();

    // Calculate total quantity of equipment needed based on the reservation details
    $totalQuantity = $reservationDetails->sum('quantity');

    // Retrieve equipment quantities from the equipment_status table
    $getEquipmentQuantities = equipment_status::where('condition_id', 1)
        ->pluck('quantity', 'equipment_id');

    // Check available stock for each equipment and calculate the maximum possible order
    $maxPossibleOrder = [];
    foreach ($getEquipmentQuantities as $equipmentId => $availableStock) {
        $maxPossibleOrder[$equipmentId] = floor($availableStock / $totalQuantity);
    }

    return response()->json(['maxPossibleOrder' => $maxPossibleOrder]);
}

}
