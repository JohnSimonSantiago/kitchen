<?php

namespace App\Http\Controllers;

use App\Models\reservation;
use App\Models\transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function receiveReservation(Request $request)
    {   
        $newTransaction = new Transaction();
        


        $receiveReservation = reservation::find($request->ID);
        $receiveReservation->statusID = 3;
        $res = $receiveReservation->save();
        return response()->json(['message' => 'Reservation returned successfully.']);
        
    }

    public function submitReservation(Request $request){
        $request->validate([
            'customerName' => 'required',
            'customerNumber' => 'required|numeric|digits:9',
            'dateStart' => 'required',
            'dateEnd' => 'required',
        ]);
    
        $newReservation = new Reservation();

        $newReservation->user_id = $request->user_id;
        $newReservation->customerName = $request->customerName;
        $newReservation->customerNumber = $request->customerNumber;
        $newReservation->dateStart = Carbon::parse($request->dateStart)->toDateTimeString();
        $newReservation->dateEnd = Carbon::parse($request->dateEnd)->toDateTimeString();
        $newReservation->statusID = 1;
    
        $res = $newReservation->save();
    
        return $res;
    }

}
