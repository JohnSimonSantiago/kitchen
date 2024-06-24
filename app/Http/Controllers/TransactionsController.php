<?php

namespace App\Http\Controllers;

use App\Models\reservation;
use App\Models\transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    
    public function getTransactions(Request $request) {
        $getTransactions = transaction::all();
        return $getTransactions; 
    }
    

}
