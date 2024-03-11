<?php

namespace App\Http\Controllers;

use App\Models\condition;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
    public function getConditions(){
        $getCondition = condition::all();
        return $getCondition;
    }
    public function submitCondition(Request $request)
    {
        $validatedData = $request->validate([
            'condition' => 'required|string|max:255',
        ]);
    
        $newcondition = new condition();
        $newcondition->condition = $request->condition;
        $res = $newcondition->save();
    
        return response()->json(['Condition Created Successfully' => $res]);
    }
}
