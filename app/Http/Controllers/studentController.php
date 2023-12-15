<?php

namespace App\Http\Controllers;

use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class studentController extends Controller
{
    //
    public function createStudent(Request $request){
        $newStudent = new student();
       
        $newStudent->userId = Auth::id();
        $newStudent->name = $request->name;
        $newStudent->course = $request->course;

        $res = $newStudent->save();

        return $res;
    }
    public function getStudents(){
      
        return student::select()->where('userId', Auth::id())->get();
    }

public function getStudent(Request $request){
   
    if(student::where('id', $request->edit_id)->exists()){
        return student::find($request->edit_id);
    }
    else{
        return $data = (object)[
            "id"=>0,
            "name"=> "",
            "course"=>""

        ];
    }
}
public function updateStudent(Request $request){
    // dd($request->data); 
    $data = $request->data;
    $updatedInfo = student::find($data['id']);
    
    $updatedInfo->name = $data['name'];
    $updatedInfo->course = $data['course'];

    $res = $updatedInfo->save();

    return $res;
}

public function deleteStudent(Request $request){
    // dd($request->studentId);
    $deleteStudent = student::find($request->Id);
   

    $res = $deleteStudent->delete();

    return $res;
}
}
