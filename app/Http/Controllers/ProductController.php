<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Product;
use App\Models\User;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function showAddProductForm(){
        return view('admin.Product.AddNewProduct');
    }
    public function showSellerAddProductForm(){
        return view('seller.Product.AddNewProduct');
    }

    public function showUpdateProductForm(Product $productDetails){
        $productDetails->images = explode(',', $productDetails->images);
        $categories = Category::all();
        $subCategories = SubCategory::where('category_id', $productDetails->categoryId)->get();
        $sellers = User::where('role_id', 2)->get();
        // dd($sellers);
        return view('admin.Product.UpdateProduct',compact('productDetails', 'categories', 'subCategories', 'sellers'));
    }

    //show the use listing in data table
    public function index(Request $request)
    {
        if ($request->ajax() ) {
            $products = Product::select('id','title','price','discountPercentage','rating','stock','brand','categoryId','sellerId')->get()->toArray();
            foreach ($products as $key => $product) {
                $sellerName = User::select('name')->where('id',$product['sellerId'])->first();
                $subCategoryName = SubCategory::select('Sub_category_Name','category_id')->where('id',$product['categoryId'])->first();
                $categoryName = Category::select('*')->where('id',$subCategoryName->category_id)->first();
                $products[$key]['sellerId'] = $sellerName->name;
                $products[$key]['categoryId'] = $categoryName->category_Name;
                $products[$key]['Subcategory'] = $subCategoryName->Sub_category_Name;
            }
            return Datatables::of($products)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = "
                            <a href = '". url("/admin/product/update-" . $row['id'] . "") ."' class='edit btn  btn-sm m-1' ><i class='fa-solid fa-pen text-warning'></i>
                            </a><button class='edit btn btn-sm m-1 deleteProduct'  id='". $row['id'] ."'><i class='fa-solid fa-trash text-danger deleteProduct'></i></button>
                        ";
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.Product.ProductListing');
    }

    public function addNewProduct(Request $request){

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'discountPercentage' => 'required',
            'stock' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'subCategory' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,webp,png|max:2048',
            'images' => 'required',
            'images *' => 'mimes:jpg,jpeg,webp,png|max:2048',
            'seller' => 'required',
        ]);

        $product = product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'discountPercentage' => $request->discountPercentage,
            'stock' => $request->stock,
            'brand' => $request->brand,
            'categoryId' => $request->category,
            'sellerId' => $request->seller,
        ]);
        // Create the product

        /*
        Upload file and store files into the sever itself
        $thumbnailFile = $request->thumbnail;
        $productId = DB::table('products')->orderby('id', 'DESC')->first()->id;
        $thumbnailName = trim($thumbnailFile->getClientOriginalName(), '"');
        $thumbnailFile->move(public_path("uploads/Product/Product_$productId/thumbnail"), $thumbnailName);
        $urlThumbnailFile = url("/public/uploads/Product/Product_$productId/thumbnail/$thumbnailName");
        */

        //Upload file and Store files into AWS S3 bucket
        if ($request->hasFile('thumbnail') && $product) {
            $urlThumbnailFile = $product->saveProductThumbnail($request->file('thumbnail'));
        }


        /*
        Upload file and store files into the sever itself
        $productImg = $request->images;
        $imgs = [];
        foreach ($productImg as $key => $image) {
            $single_image = $image->getClientOriginalName();
            $url = url("/public/uploads/Product/Product_$productId/$single_image");
            $image->move(public_path("uploads/Product/Product_$productId"), trim($single_image, '"'));
            array_push($imgs, $url);
        }
        $AllImages = implode(",", $imgs);
        */

        //Upload file and Store files into AWS S3 bucket
        if ($request->hasFile('images')) {
            if ($request->images) {
                $product->deleteProductImages();
            }
            $AllImages = implode(',',$product->saveProductImages($request->file('images')));
        }

        $updateProduct = product::where('id', '=', $product->id)->update([
            'sub_categoryId' => $request->subCategory,
            'thumbnail' => $urlThumbnailFile,
            'images' => $AllImages
        ]);

        if ($updateProduct) {
            return redirect()->route('products.index')->with('success',"$request->title ,product has been added successfully");
        }
        return back()->OnlyInput('title','description','price','stock','brand','category'.'subCategory'.'seller');
    }

    public function deleteProductData(Product $product)
    {

        try {
            $productID = $product->id;
            $product = Product::findOrFail($productID);
            if ($product->thumbnail) {
                $product->deleteProductThumbnail();
            }
            if ($product->images) {
                $product->deleteProductImages();
            }
            if ($product) {
                $product->delete();
                return response()->json([
                    'status' => true,
                    'Message' => "$product->title product is Deleted Successfully",
                ], 200);
            }
            return response()->json([
                'Message' => "$product->title product is not exits",
            ], 403);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' =>  $ex->getMessage(),
            ], 500);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        try{

        $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'discountPercentage' => 'required|numeric',
                'stock' => 'required|integer|min:0',
                'brand' => 'required|string',
                'category' => 'required',
                'subCategory' => 'required',
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,webp,png',
                'images.*' => 'nullable|image|mimes:jpg,jpeg,webp,png',
                'seller' => 'required|numeric',
            ]);

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
            $product->sellerId = $request->seller;
            $product->categoryId = $request->category;
            $product->sub_categoryId = $request->subCategory;
            $updateProduct = $product->update($request->except(['thumbnail', 'images']));
            if ($updateProduct) {
                return redirect()->back()->with('success',"$request->title ,product has been Updated successfully");
            }
            return redirect()->back()->with('error',"Some thing want wrong please try agin");

        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'Error' =>  $ex->getMessage(),
            ], 500);
        }
    }

    public function getProductBySeller(Request $request)
    {
        if ($request->ajax() ) {
            $products = Product::select('id','title','price','discountPercentage','rating','stock','brand','categoryId','sellerId')->where('sellerId', Auth::user()->id)->get()->toArray();
            foreach ($products as $key => $product) {
                $sellerName = User::select('name')->where('id',$product['sellerId'])->first();
                $subCategoryName = SubCategory::select('Sub_category_Name','category_id')->where('id',$product['categoryId'])->first();
                $categoryName = Category::select('*')->where('id',$subCategoryName->category_id)->first();
                $products[$key]['sellerId'] = $sellerName->name;
                $products[$key]['categoryId'] = $categoryName->category_Name;
                $products[$key]['Subcategory'] = $subCategoryName->Sub_category_Name;
            }
            return Datatables::of($products)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = "
                            <a href = '". url("/seller/product/update-" . $row['id'] . "") ."' class='edit btn  btn-sm m-1' ><i class='fa-solid fa-pen text-warning'></i>
                            </a><button class='edit btn btn-sm m-1 deleteProduct'  id='". $row['id'] ."'><i class='fa-solid fa-trash text-danger deleteProduct'></i></button>
                        ";
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('seller.Product.ProductListing');
    }

    public function showUpdateSellerProductForm(Product $productDetails){
        $productDetails->images = explode(',', $productDetails->images);
        return view('seller.Product.UpdateProduct',compact('productDetails'));
    }

    public function getProductByID($id)
    {
        $product = Product::findOrFail($id);
        $product->images = explode(',', $product->images);
        return view('Products.productDetails',compact('product'));
    }

    public function getProductForHome()
    {
        $products = Product::inRandomOrder()->take(12)->get();
        return view('Products.productList',compact('products'));
    }
}
