<?php

namespace App\Http\Controllers\API;

use DataTables;
use App\Models\Product;
use App\Models\User;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function getAllProducts(){
        $products = Product::all() ? Product::all() : [];
        return response()->json([
            'success' => true,
            'Products' => $products
        ], 200);
    }

    public function addNewProduct(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'discountPercentage' => 'required',
            'stock' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'subCategory' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,webp,png',
            'images' => 'required',
            'images *' => 'mimes:jpg,jpeg,webp,png',
            'seller' => 'required|email',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 401);
        }

        $category = Category::where('category_Name',$request->category)->first();
        $subCategory = SubCategory::where('Sub_category_Name',$request->subCategory)->first();
        $seller = User::where('email',$request->seller)->first();
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Enter the valid category',
            ], 401);
        }
        if (!$subCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Enter the valid sub category',
            ], 401);
        }
        if ($subCategory->category_id !== $category->id){
            return response()->json([
                'success' => false,
                'message' => "$request->subCategory is not $request->category's sub category!",
            ], 401);
        }
        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Seller is not Found',
            ], 404);
        }
        if ($seller->role_id !== 2){
            return response()->json([
                'success' => false,
                'message' => "$request->seller is not seller",
            ], 401);
        }

        product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'discountPercentage' => $request->discountPercentage,
            'stock' => $request->stock,
            'brand' => $request->brand,
            'categoryId' => $subCategory->id,
            'sellerId' => $seller->id
        ]);

        $productId = DB::table('products')->orderby('id', 'DESC')->first()->id;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = $thumbnail->getClientOriginalName();
            $thumbnailPath = $thumbnail->storeAs("Product/Product_$productId/thumbnail", $thumbnailName, 'public');
            $urlThumbnailFile = url("public/uploads/$thumbnailPath");
        }

        $AllImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $image->getClientOriginalName();
                $imagePath = $image->storeAs("Product/Product_$productId", $imageName, 'public');
                $images[] = url("public/uploads/$imagePath");
            }
            $AllImages = implode(',',$images);
        }

        product::where('id', '=', $productId)->update([
            'thumbnail' => $urlThumbnailFile,
            'images' => $AllImages
        ]);
        $product = product::where('id', '=', $productId)->first();
        if ($product) {
            return response()->json([
                'status' => true,
                'Product' => $product,
                'Message' => "$request->title ,product has been added successfully",
            ], 200);
            return redirect()->route('products.index')->with('success',"$request->title ,product has been added successfully");
        }
    }


    public function updateProduct(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'nullable|string',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric|min:0',
                'discountPercentage' => 'nullable|numeric',
                'stock' => 'nullable|integer|min:0',
                'brand' => 'nullable|string',
                'category' => 'nullable',
                'subCategory' => 'nullable',
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png',
                'images.*' => 'nullable|image|mimes:jpg,jpeg,png',
                'seller' => 'nullable|email',
            ]);
            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors(),
                ], 422);
            }
            $category = Category::where('category_Name',$request->category)->first();
            $subCategory = SubCategory::where('Sub_category_Name',$request->subCategory)->first();
            $seller = User::where('email',$request->seller)->first();
            if (!$category && $request->category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Enter the valid category',
                ], 401);
            }
            if (!$subCategory && $request->subCategory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Enter the valid sub category',
                ], 401);
            }
            if ($request->subCategory && $request->category && $subCategory->category_id !== $category->id){
                return response()->json([
                    'success' => false,
                    'message' => "$request->subCategory is not $request->category's sub category!",
                ], 401);
            }
            if (!$seller && $request->seller) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seller is not Found',
                ], 404);
            }
            if ($request->seller && $seller->role_id !== 2 ){
                return response()->json([
                    'success' => false,
                    'message' => "$request->seller is not seller",
                ], 401);
            }


            // Find the product by ID
            $product = Product::findOrFail($id);
            if ($request->hasFile('thumbnail')) {
                if ($product->thumbnail) {
                    $product->deleteProductThumbnail();
                }
                $product->thumbnail = $product->saveProductThumbnail($request->file('thumbnail'));
            }

            // Handle images upload
            if ($request->hasFile('images')) {
                if ($request->images) {
                    $product->deleteProductImages();
                }
                $product->images = implode(',',$product->saveProductImages($request->file('images')));
            }

            $product->update($request->except(['thumbnail', 'images']));

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product
            ],200);

        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'Error' =>  $ex->getMessage(),
            ], 500);
        }
    }


    public function deleteProductData(Product $product, $id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                if ($product->thumbnail) {
                    $product->deleteProductThumbnail();
                }
                if ($product->images) {
                    $product->deleteProductImages();
                }
                $product->delete();
                return response()->json([
                    'message' => 'Product deleted successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error' =>  'Product not found',
                ], 404);
            }

        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' =>  $ex->getMessage(),
            ], 500);
        }
    }

    public function deleteFolderAndFiles(Request $request) {
        $folderPath = $request->dirname;
        if (File::isDirectory($folderPath)) {
            $files = File::allFiles($folderPath);
            foreach ($files as $file) {
                File::delete($file);
            }
            File::deleteDirectory($folderPath);
            return response()->json([
                'status' => false,
                'Messages' =>  "Folders deleted successfully",
            ], 200);
            return true;
        } else {
            return false;
        }
    }
}
