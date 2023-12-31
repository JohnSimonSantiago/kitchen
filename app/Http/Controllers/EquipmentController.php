<?php

namespace App\Http\Controllers;

use App\Models\equipment;
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
        $res = $newEquipment->save();

        return $res;
    }
    public function getEquipments(){
       return equipment::all();
    }

    public function getEquipment(Request $request){
   
        if(equipment::where('id', $request->edit_id)->exists()){
            return equipment::find($request->edit_id);
        }
        else{
            return $data = (object)[
                "id"=>0,
                "equipmentName"=> "",
                "quantity"=>"",
                "description"=>"",
                "barcode"=>"",  
    
            ];
        }
    }
    public function editEquipment (Request $request){
        $data = $request->data;
        $updatedInfo = equipment::find($data['id']);

        $updatedInfo->equipmentName=$data['equipmentName'];
        $updatedInfo->quantity=$data['quantity'];
        $updatedInfo->descption=$data['description'];
        $updatedInfo->barcode=$data['barcode'];

        $res = $updatedInfor->save();
        return $res;

    }
}
