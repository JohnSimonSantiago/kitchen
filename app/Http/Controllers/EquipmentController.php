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
    public function getEquipment(Request $request){
   
        if(equipment::where('id', $request->edit_id)->exists()){
            return equipment::find($request->edit_id);
        }
        else{
            return $data = (object)[
                "id"=>0,
                "equipmentName"=> "",
                "description"=>"",
                "quantity"=>"",
                "barcode"=>"",
    
            ];
        }
    }
}
