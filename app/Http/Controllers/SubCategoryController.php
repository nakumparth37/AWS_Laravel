<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    public function getSubcategory()
    {
        $subCategories = SubCategory::all();
        return response()->json([
            'subCategories' => $subCategories
        ],200);
        
    }


    public function getSubcategoryOfParentCategory(Category $categoryId)
    {

        $subCategories = SubCategory::select('*')->where('category_id',$categoryId->id)->get();
        return response()->json([
            'subCategories' => $subCategories
        ],200);
        
    }
}
