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

    
    public function submitCategory(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required|string|max:255',
        ]);
    
        $newCategory = new category();
        $newCategory->category = $request->category;
        $res = $newCategory->save();
    
        return response()->json(['Category Created Successfully' => $res]);
    }

    public function updateCategory(Request $request)
{
    $validatedData = $request->validate([
        'id' => 'required|integer',
        'category' => 'required|string|max:255',
    ]);

    $category = Category::findOrFail($validatedData['id']);
    $category->category = $validatedData['category'];
    $result = $category->save();

    return response()->json(['Category Updated Successfully' => $result]);
}
    
    
}
