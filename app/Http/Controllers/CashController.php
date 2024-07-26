<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use Illuminate\Http\Request;

class CashController extends Controller
{
    public function getCashLogs(Request $request) {
        $getCashLogs = Cash::all();
        return $getCashLogs; 
    }
    
}
