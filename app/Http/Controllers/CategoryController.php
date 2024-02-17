<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories(){
        $getCategory = category::all();
        return $getCategory;
    }

    
    public function submitCategory(Request $request){
        $newCategory = new category();
           
            $newCategory->category = $request->category;
            $res = $newCategory->save();
            return $res;

        }
    
}
