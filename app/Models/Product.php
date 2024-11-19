<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'price',
        'discountPercentage',
        'stock',
        'brand',
        'categoryId',
        'sub_categoryId',
        'thumbnail',
        'images',
        'sellerId',
    ];

    public function saveProductThumbnail($thumbnail)
    {
        /*
        Upload file and store files into the sever itself
        $thumbnailName = $thumbnail->getClientOriginalName();
        $thumbnailPath = $thumbnail->storeAs("Product/Product_$this->id/thumbnail", $thumbnailName, 'public');
        $thumbnailUrl =  url("public/uploads/$thumbnailPath");
        return $thumbnailUrl;
        */

        //Upload file and Store files into AWS S3 bucket
        $thumbnailName = $thumbnail->getClientOriginalName();
        $path = "Product/Product_$this->id/thumbnail/$thumbnailName";
        Storage::disk('s3')->put($path, file_get_contents($thumbnail), 'public');
        $thumbnailUrl = Storage::disk('s3')->url($path);
        return $thumbnailUrl;
    }

    public function saveProductImages($uploadedImages)
    {
        /*
        Upload file and store files into the sever itself
        $images = [];
        foreach ($uploadedImages as $image) {
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->storeAs("Product/Product_$this->id", $imageName, 'public');
            $images[] = url("public/uploads/$imagePath");
        }
        return $images;
        */

        //Upload file and Store files into AWS S3 bucket
        $images = [];
        foreach ($uploadedImages as $image) {
            $imageName = $image->getClientOriginalName();
            $path = "Product/Product_$this->id/$imageName";
            Storage::disk('s3')->put($path, file_get_contents($image), 'public');
            $images[] = Storage::disk('s3')->url($path);;
        }
        return $images;
    }

    public function deleteProductThumbnail()
    {
        /*
        Delete files form the sever
        $baseFileName = basename($this->thumbnail);
        Storage::disk('public')->delete("Product/Product_$this->id/thumbnail/{$baseFileName}");
        File::deleteDirectory("uploads/Product/Product_$this->id/thumbnail");
        */

        //Delete file from the AWS S3 bucket
        if (!$this->thumbnail) {
            return; // No image to delete
        }
        $filePath = parse_url($this->thumbnail, PHP_URL_PATH);
        $filePath = ltrim($filePath, '/');
        Storage::disk('s3')->delete($filePath);
    }

    public function deleteProductImages()
    {
        /*
        Delete files form the sever
        $allImages = explode(',', $this->images);
        foreach ($allImages as $key => $image) {
            $imageName = basename($image);
            Storage::disk('public')->delete("Product/Product_$this->id/{$imageName}");
        }
        if (!File::isDirectory("uploads/Product/Product_$this->id/thumbnail")) {
            File::deleteDirectory("uploads/Product/Product_$this->id");
        }
        */

        //Delete file from the AWS S3 bucket
        if (!$this->images) {
            return; // No image to delete
        }
        $allImages = explode(',', $this->images);
        foreach ($allImages as $key => $image) {
            $filePath = parse_url($image, PHP_URL_PATH);
            $filePath = ltrim($filePath, '/');
            Storage::disk('s3')->delete($filePath);
        }
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reduceStock($quantity)
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            $this->save();
            return true;
        }
        return false; // Not enough stock
    }

}
