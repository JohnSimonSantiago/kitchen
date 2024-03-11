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

    function addDisposeEquipment()
    {
        $equipment = equipment::all();
        foreach ($equipment as $item) {
            $condition = condition::where('condition_name', $item->condition)->first();

            DB::table('equipment_status')->insert([
                'equipmentid' => $item->id,
                'conditionid' => $condition->id,
                'quantity' => $item->quantity,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    
        return "Equipment disposed successfully.";
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

    public function submitEquipmentOrder(Request $request){
        $newReservationDetail = new reservation_details();
        $validatedData = $request->validate([
            'equipment_id' => 'required|exists:equipments,equipment_id',
            'quantity' => 'required|integer|min:0',
            'condition_id' => 'required|exists:condition_table,id',
        ]);
        $newReservationDetail->reservationNumber = $request->reservationNumber;
        $newReservationDetail->equipment_id = $request->equipment_id;
        $newReservationDetail->condition_id = $request->condition_id;
        $newReservationDetail->quantity = $request->quantity;

        $res = $newReservationDetail->save();

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


}
