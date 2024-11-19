<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategory()
    {
        
        $subCategories = Category::all();
        return response()->json([
            'categories' => $subCategories
        ],200);
        
    }
}
